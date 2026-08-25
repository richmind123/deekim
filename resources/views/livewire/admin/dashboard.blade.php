<div class="space-y-6">
    <flux:heading size="xl">Admin Dashboard</flux:heading>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <flux:card>
            <flux:subheading>Today's Bookings</flux:subheading>
            <flux:heading size="lg">{{ $todaysBookings }}</flux:heading>
        </flux:card>

        <flux:card>
            <flux:subheading>This Month's Revenue</flux:subheading>
            <flux:heading size="lg">${{ number_format($monthRevenue, 2) }}</flux:heading>
        </flux:card>
    </div>

    <flux:card>
        <flux:subheading class="mb-4">Occupancy — Last 30 Days</flux:subheading>
        <div class="h-64">
            <canvas wire:ignore id="occupancyChart" x-data x-init="
                    const ctx = $el.getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @js($occupancy->pluck('date')),
                            datasets: [
                                {
                                    label: 'Bookings',
                                    data: @js($occupancy->pluck('bookings')),
                                    yAxisID: 'yBookings',
                                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                },
                                {
                                    type: 'line',
                                    label: 'Revenue',
                                    data: @js($occupancy->pluck('revenue')),
                                    yAxisID: 'yRevenue',
                                    borderColor: 'rgb(234, 88, 12)',
                                    tension: 0.3,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' }
                            },
                            scales: {
                                yBookings: {
                                    type: 'linear',
                                    position: 'left',
                                    title: { display: true, text: 'Bookings' },
                                    ticks: { precision: 0 },
                                },
                                yRevenue: {
                                    type: 'linear',
                                    position: 'right',
                                    title: { display: true, text: 'Revenue ($)' },
                                    grid: { drawOnChartArea: false },
                                },
                            },
                        },
                    });
                "></canvas>
        </div>
    </flux:card>
</div>