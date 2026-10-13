@extends('admin.layouts.app')

@section('title', 'Blank page | Sarab 2026 v4')
@section('page', 'plain')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Blank page</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Template</div>
                <h1 class="page-title">Blank page</h1>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding:40px;text-align:center;color:var(--text-muted)">
            <div style="font-size:14px;margin-bottom:6px;color:var(--text)">This page is a starter template.</div>
            <div style="font-size:12.5px">Drop your content into the <code>.card</code> below or replace this whole structure.</div>
        </div>
    </div>
@endsection