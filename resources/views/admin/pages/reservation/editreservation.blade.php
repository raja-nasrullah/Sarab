@extends('admin.layouts.app')

@section('title', 'Edit Reservation | Sarab 2026 v4')
@section('page', 'edit-reservation')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Restaurant</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Edit Reservation</span>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Restaurant</div>
                <h1 class="page-title">Edit Reservation #{{ $reservation->id }}</h1>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.reservations') }}" class="btn btn-outline">Cancel</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.editreservation.update', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    {{-- Customer --}}
                    <div class="form-group">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-control">
                            <option value="">Walk-in / Guest</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $reservation->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Table --}}
                    <div class="form-group">
                        <label for="table_id" class="form-label">Table</label>
                        <select name="table_id" id="table_id" class="form-control">
                            <option value="">Select a table</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}" {{ $reservation->table_id == $table->id ? 'selected' : '' }}>
                                    {{ $table->table_number }} (Capacity: {{ $table->capacity }})
                                </option>
                            @endforeach
                        </select>
                        @error('table_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    {{-- Date --}}
                    <div class="form-group">
                        <label for="reservation_date" class="form-label">Reservation Date</label>
                        <input type="date" name="reservation_date" id="reservation_date" class="form-control" value="{{ old('reservation_date', $reservation->reservation_date) }}" required>
                        @error('reservation_date')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Time --}}
                    <div class="form-group">
                        <label for="reservation_time" class="form-label">Reservation Time</label>
                        <input type="time" name="reservation_time" id="reservation_time" class="form-control" value="{{ old('reservation_time', $reservation->reservation_time) }}" required>
                        @error('reservation_time')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    {{-- Guests --}}
                    <div class="form-group">
                        <label for="guests" class="form-label">Number of Guests</label>
                        <input type="number" name="guests" id="guests" class="form-control" min="1" value="{{ old('guests', $reservation->guests) }}" required>
                        @error('guests')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions right">
                    <button type="submit" class="btn btn-primary">Update Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection