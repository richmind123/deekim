<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\RoomType;
use App\Notifications\BookingConfirmed;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.public')]
class Checkout extends Component
{
    use WithFileUploads;

    public RoomType $roomType;

    public string $check_in;

    public string $check_out;

    public int $guests;

    public ?int $paymentMethodId = null;

    public $proof;

    public function mount(): void
    {
        $roomTypeSlug = request('roomType');
        $this->roomType = RoomType::where('slug', $roomTypeSlug)->firstOrFail();
        $this->check_in = request('check_in', '');
        $this->check_out = request('check_out', '');
        $this->guests = (int) request('guests', 1);
    }

    public function nights(): int
    {
        return Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out));
    }

    public function totalPrice(): float
    {
        return $this->nights() * $this->roomType->base_price;
    }

    public function paymentMethods()
    {
        return PaymentMethod::where('is_active', true)->get();
    }

    public function selectedMethod(): ?PaymentMethod
    {
        return PaymentMethod::find($this->paymentMethodId);
    }

    public function updatedPaymentMethodId(): void
    {
        $this->resetErrorBag('proof');
        $this->proof = null;
    }

    public function confirmBooking(): void
    {
        $this->validate([
            'paymentMethodId' => ['required', 'exists:payment_methods,id'],
            'proof' => [$this->selectedMethod()?->requires_proof ? 'required' : 'nullable', 'image', 'max:2048'],
        ]);

        $booking = DB::transaction(function () {
            $overlapping = Booking::where('room_type_id', $this->roomType->id)
                ->where('status', '!=', 'cancelled')
                ->where('check_in', '<', $this->check_out)
                ->where('check_out', '>', $this->check_in)
                ->lockForUpdate()
                ->count();

            if ($overlapping >= $this->roomType->rooms()->count()) {
                throw ValidationException::withMessages([
                    'dates' => 'Sorry, this room just sold out for those dates.',
                ]);
            }

            $method = $this->selectedMethod();

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_type_id' => $this->roomType->id,
                'reference' => 'DKM-' . strtoupper(Str::random(6)),
                'check_in' => $this->check_in,
                'check_out' => $this->check_out,
                'guests' => $this->guests,
                'status' => $method->requires_proof ? 'pending_payment' : 'confirmed',
                'total_price' => $this->totalPrice(),
            ]);

            $proofPath = null;
            if ($this->proof) {
                $proofPath = Storage::disk('public')->putFile('payment-proofs', $this->proof);
            }

            $booking->payment()->create([
                'amount' => $booking->total_price,
                'payment_method_id' => $method->id,
                'method' => $method->name,
                'proof_path' => $proofPath,
            ]);

            return $booking;
        });

        if ($booking->status === 'confirmed') {
            $booking->user->notify(new BookingConfirmed($booking));
            Flux::toast(variant: 'success', text: __('Booking confirmed!'));
        } else {
            Flux::toast(variant: 'success', text: __('Booking received — awaiting payment verification.'));
        }

        $this->redirectRoute('booking.confirmation', ['booking' => $booking->id], navigate: true);
    }

    public function render()
    {
        return view('livewire.booking.checkout', [
            'paymentMethods' => $this->paymentMethods(),
        ]);
    }
}