<x-layouts::app :title="__('Admin Dashboard')">
    <div class="p-6">
        <h1 class="text-xl font-bold">Admin Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}.</p>
    </div>
</x-layouts::app>