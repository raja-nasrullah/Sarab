@extends('admin.layouts.app')

@section('title', 'Sign in | Sarab 2026 v4')
@section('page', 'login')

{{-- Override sidebar for auth page --}}
@section('sidebar')
    {{-- Empty sidebar for auth page --}}
@endsection

{{-- Override header for auth page --}}
@section('header')
    {{-- Empty header for auth page --}}
@endsection

{{-- Override footer for auth page --}}
@section('footer')
    {{-- Empty footer for auth page --}}
@endsection

@section('content')
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-brand">
                <div class="brand-icon">G</div>
                <div class="brand-name">Sarab <small style="font-weight:400;color:var(--text-muted);font-size:13px;margin-left:2px">v4</small></div>
            </div>

            <div class="auth-title">Welcome back</div>
            <div class="auth-subtitle">Sign in to continue to your dashboard.</div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p style="margin:0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-group">
                        <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="12" height="10" rx="1.5"/><path d="M2 5l6 4 6-4"/></svg>
                        <input type="email" id="email" name="email" class="form-control" placeholder="you@company.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="7" width="10" height="7" rx="1.5"/><path d="M5 7V5a3 3 0 016 0v2"/></svg>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="auth-actions">
                    <label class="form-check">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:38px">
                    Sign in
                </button>
            </form>

            <div class="auth-divider">or continue with</div>
<!-- 
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                <button class="btn btn-outline" style="justify-content:center">Google</button>
                <button class="btn btn-outline" style="justify-content:center">GitHub</button>
            </div> -->

            <div class="auth-footer">
                Don't have an account? <a href="{{ route('register') }}">Create one</a>
            </div>
        </div>
    </div>
@endsection