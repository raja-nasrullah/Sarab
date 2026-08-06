@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Menu Item</h1>
        <a href="{{ route('admin.menu') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded transition duration-200">
            &larr; Back to Menu
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        {{-- ✅ ADDED enctype="multipart/form-data" TO ALLOW IMAGE UPLOADS --}}
        <form action="{{ route('admin.editmenu.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Category Dropdown -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    <option value="">Select a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $menuItem->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Item Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $menuItem->name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload & Preview -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Item Image</label>
                
                {{-- Show existing image if available (✅ FIXED FOR URLS AND LOCAL PATHS) --}}
                @if($menuItem->image)
                    <div class="mb-2">
                        @if(str_starts_with($menuItem->image, 'http'))
                            <img src="{{ $menuItem->image }}" alt="{{ $menuItem->name }}" class="h-20 w-20 object-cover rounded shadow-sm border border-gray-200">
                        @else
                            <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="h-20 w-20 object-cover rounded shadow-sm border border-gray-200">
                        @endif
                    </div>
                @endif

                <input type="file" name="image" id="image" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $menuItem->price) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" required>
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    <option value="Available" {{ $menuItem->status == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="unavailable" {{ $menuItem->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded transition duration-200">
                    Update Menu Item
                </button>
            </div>
        </form>
    </div>
</div>
@endsection