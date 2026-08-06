@extends('admin.layouts.app')  {{-- Changed from layouts.app --}}

@section('title', 'Sign in | Gentelella 2026 v4')
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
                <div class="brand-icon" style="background:linear-gradient(135deg, #2c3e50, #1a2332);">A</div>
                <div class="brand-name">Admin Panel <small style="font-weight:400;color:var(--text-muted);font-size:13px;margin-left:2px">v4</small></div>
            </div>

            <div class="auth-title">Admin Login</div>
            <div class="auth-subtitle">Sign in to access the admin dashboard.</div>

            {{-- Show messages --}}
            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:16px;padding:10px 14px;border-radius:6px;background:#d4edda;color:#155724;border:1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="margin-bottom:16px;padding:10px 14px;border-radius:6px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom:16px;padding:10px 14px;border-radius:6px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;">
                    @foreach($errors->all() as $error)
                        <p style="margin:0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Admin Email</label>
                    <div class="input-group">
                        <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="12" height="10" rx="1.5"/><path d="M2 5l6 4 6-4"/></svg>
                        <input type="email" id="email" name="email" class="form-control" placeholder="admin@example.com" value="{{ old('email') }}" required>
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

                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:38px;background:linear-gradient(135deg, #2c3e50, #1a2332);border-color:#2c3e50;">
                    Sign in as Admin
                </button>
            </form>

            <div class="auth-divider">or</div>

            <div style="text-align:center;">
                <a href="{{ route('login') }}" style="color:var(--primary);text-decoration:none;font-size:13px;">
                    ← Login as Regular User
                </a>
            </div>

            {{-- Show demo credentials --}}
            <div style="margin-top:16px;padding:12px;background:#f8f9fa;border-radius:6px;font-size:12px;color:#6c757d;border:1px solid #e5e7eb;">
                <strong>Admin Demo Credentials:</strong><br>
                Email: admin@example.com<br>
                Password: password123
            </div>
        </div>
    </div>
@endsection