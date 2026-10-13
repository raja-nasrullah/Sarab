@extends('admin.layouts.app')
@section('title', 'Products | Sarab 2026 v4')
@section('page', 'ecommerce')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">E-commerce</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Products</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Catalog</div>
                <h1 class="page-title">Products</h1>
            </div>
            <div class="page-actions">
                <button class="btn btn-outline">Categories</button>
                <button class="btn btn-primary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 8h8M8 4v8"/></svg>
                    Add product
                </button>
            </div>
        </div>
    </div>

    <!-- Filter bar -->
    <div class="card" style="margin-bottom:16px">
        <div class="card-body" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;padding:12px 16px">
            <span style="font-size:12px;color:var(--text-muted);font-weight:var(--font-weight-medium)">Filter:</span>
            <span class="chip chip-primary active">Apparel<button type="button" class="chip-close" aria-label="Remove Apparel">×</button></span>
            <span class="chip">Accessories</span>
            <span class="chip">Electronics</span>
            <span class="chip">Home</span>
            <span class="chip">In stock</span>
            <span class="chip chip-yellow active">On sale<button type="button" class="chip-close" aria-label="Remove On sale">×</button></span>
            <span style="margin-left:auto;font-size:12px;color:var(--text-muted)">128 results</span>
            <select class="form-control" style="width:140px;height:32px" aria-label="Sort orders">
                <option>Sort: Newest</option>
                <option>Sort: Price ↑</option>
                <option>Sort: Price ↓</option>
                <option>Sort: Best-selling</option>
            </select>
        </div>
    </div>

    <div class="row col-3" id="products-grid"></div>
@endsection

@section('scripts')
    <script>
        // Static placeholder images
        const productImages = {
            'hoodie': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Aurora Hoodie</div>`,
            'shirt': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Linen Field Shirt</div>`,
            'sneakers': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#4facfe 0%,#00f2fe 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Trail Runner Sneakers</div>`,
            'bag': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#43e97b 0%,#38f9d7 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Canvas Weekend Bag</div>`,
            'earbuds': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#fa709a 0%,#fee140 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Wireless Earbuds</div>`,
            'pourover': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#a18cd1 0%,#fbc2eb 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Pour Over Set</div>`,
            'mat': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#fccb90 0%,#d57eeb 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Standing Desk Mat</div>`,
            'keyboard': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#89f7fe 0%,#66a6ff 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Mechanical Keyboard</div>`,
            'baselayer': `<div style="width:100%;height:180px;background:linear-gradient(135deg,#f6d365 0%,#fda085 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;border-radius:8px 8px 0 0;">Merino Base Layer</div>`
        };

        const products = [
            ['Aurora hoodie',          'Apparel',       49, 65,  'Sale',     'red',    '★★★★☆ 4.6 (128)', 'hoodie'],
            ['Linen field shirt',      'Apparel',       89, null,'New',      'green',  '★★★★★ 4.9 (42)',  'shirt'],
            ['Trail runner sneakers',  'Footwear',      129,159, 'Sale',     'red',    '★★★★☆ 4.4 (231)', 'sneakers'],
            ['Canvas weekend bag',     'Accessories',   79, null,null,       null,     '★★★★☆ 4.5 (76)',  'bag'],
            ['Wireless earbuds Pro',   'Electronics',   149,null,'Hot',      'yellow', '★★★★★ 5.0 (892)', 'earbuds'],
            ['Ceramic pour-over set',  'Home',          54, null,null,       null,     '★★★★☆ 4.7 (61)',  'pourover'],
            ['Standing desk mat',      'Home',          39, 49,  'Sale',     'red',    '★★★★☆ 4.3 (158)', 'mat'],
            ['Mechanical keyboard',    'Electronics',   189,null,'New',      'green',  '★★★★★ 4.8 (304)', 'keyboard'],
            ['Merino base layer',      'Apparel',       69, null,null,       null,     '★★★★☆ 4.6 (97)',  'baselayer']
        ];

        document.addEventListener('DOMContentLoaded', function() {
            const grid = document.getElementById('products-grid');
            
            grid.innerHTML = products.map(([name, cat, price, oldPrice, badge, badgeCls, stars, slug]) => {
                const imageHtml = productImages[slug] || `<div style="width:100%;height:180px;background:#e5e7eb;display:flex;align-items:center;justify-content:center;color:#6b7280;font-size:14px;border-radius:8px 8px 0 0;">${name}</div>`;
                
                return `
                    <a class="product-card" href="#" style="text-decoration:none;color:inherit;display:block;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:var(--radius-lg);overflow:hidden;transition:all 0.2s;cursor:pointer;">
                        <div class="product-thumb" style="position:relative;">
                            ${badge ? `<span class="product-badge" style="position:absolute;top:8px;left:8px;z-index:1;"><span class="chip chip-${badgeCls}" style="background:${badgeCls === 'red' ? '#dc3545' : badgeCls === 'green' ? '#28a745' : '#ffc107'};color:white;padding:4px 12px;border-radius:12px;font-size:11px;font-weight:600;">${badge}</span></span>` : ''}
                            ${imageHtml}
                        </div>
                        <div class="product-info" style="padding:12px 16px;">
                            <div class="name" style="font-weight:600;font-size:15px;color:var(--text);margin-bottom:2px;">${name}</div>
                            <div class="category" style="font-size:12px;color:var(--text-muted);margin-bottom:6px;">${cat}</div>
                            <div class="price-row" style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                                <span class="price" style="font-weight:700;font-size:16px;color:var(--text);">$${price}</span>
                                ${oldPrice ? `<span class="price-old" style="font-size:13px;color:var(--text-muted);text-decoration:line-through;">$${oldPrice}</span>` : ''}
                            </div>
                            <div class="stars" style="font-size:13px;color:#f59e0b;">${stars}</div>
                        </div>
                    </a>
                `;
            }).join('');
        });
    </script>
@endsection

@push('styles')
<style>
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 16px;
        font-size: 12px;
        background: var(--bg-surface-secondary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.2s;
    }
    .chip-primary {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .chip-yellow {
        background: #ffc107;
        color: #212529;
        border-color: #ffc107;
    }
    .chip-close {
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: inherit;
        padding: 0 2px;
        opacity: 0.6;
    }
    .chip-close:hover {
        opacity: 1;
    }
</style>
@endpush