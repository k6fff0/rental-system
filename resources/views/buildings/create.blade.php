<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Building</h2>
    </x-slot>

    <div class="py-6 px-4">
        <form method="POST" action="{{ route('admin.buildings.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block">Building Name</label>
                <input type="text" name="name" class="w-full border px-2 py-1 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block">Address</label>
                <input type="text" name="address" class="w-full border px-2 py-1 rounded">
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
