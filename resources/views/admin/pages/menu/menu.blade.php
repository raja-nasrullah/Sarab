@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    
    <!-- Header Section -->
    <div class="menu-page-header">
        <div class="header-title-wrapper">
            <h1>
                <!-- <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg> -->
                Menu Items Management
            </h1>
            <p>Manage your restaurant's delicious menu items</p>
        </div>
        <a href="{{ route('admin.addmenu') }}" class="btn-add-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Menu Item
        </a>
    </div>

    <!-- Menu Grid Section -->
    <div class="menu-grid">
        @foreach($menuItems as $item)
        <div class="menu-card">
            
            <!-- Image Area -->
            <div class="menu-card-img">
                @if($item->image)
                    {{-- ✅ FIX: Automatically detect if it's a URL or local path --}}
                    @if(str_starts_with($item->image, 'http'))
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                    @else
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    @endif
                @else
                    <div class="no-image">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        No Image
                    </div>
                @endif

                <!-- Status Badge -->
                <span class="status-badge-card {{ $item->status == 'Available' ? 'available' : 'unavailable' }}">
                    {{ $item->status }}
                </span>
            </div>

            <!-- Content Area -->
            <div class="menu-card-body">
                <div class="menu-card-header">
                    <h3>{{ $item->name }}</h3>
                    <span class="price">${{ number_format($item->price, 2) }}</span>
                </div>

                <!-- Category -->
                <span class="category-chip">
                    {{ $item->category->name ?? 'Uncategorized' }}
                </span>

                <!-- Action Buttons -->
                <div class="menu-card-actions">
                    <a href="{{ route('admin.editmenu', $item->id) }}" class="btn-edit-card">
                        Edit
                    </a>
                    
                    <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to permanently delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-card">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endforeach
    </div>

</div>
@endsection