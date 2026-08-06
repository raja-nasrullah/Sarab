@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    
    <!-- Header Section -->
    <div class="menu-page-header">
        <div class="header-title-wrapper">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Purchase History
            </h1>
            <p>Track all inventory restocking purchases</p>
        </div>
        <a href="{{ route('admin.addpurchase') }}" class="btn-add-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Purchase
        </a>
    </div>

    <!-- Table Section -->
    <div class="menu-table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td class="col-id">#{{ $purchase->id }}</td>
                        <td class="col-name">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}</td>
                        <td class="col-price">${{ number_format($purchase->total_amount, 2) }}</td>
                        <td class="col-actions">
                            <a href="javascript:void(0);" onclick="viewPurchaseItems({{ $purchase->id }})" class="action-btn btn-edit">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    </svg>
    View Items
</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
@include('admin.pages.purchases.items')