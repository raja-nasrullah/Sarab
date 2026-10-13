@extends('admin.layouts.app')
@section('title', 'Forgot password | Sarab 2026 v4')
@section('page', 'forgot-password')

{{-- Override sidebar for auth pages --}}
@section('sidebar')
    {{-- Empty sidebar for auth page --}}
@endsection

@section('content')
    <div class="auth-page" style="min-height:80vh;display:flex;align-items:center;justify-content:center;">
        <div class="auth-card">
            <div class="auth-brand">
                <div class="brand-icon">G</div>
                <div class="brand-name">Sarab <small style="font-weight:400;color:var(--text-muted);font-size:13px;margin-left:2px">v4</small></div>
            </div>

            <div class="auth-title">Forgot your password?</div>
            <div class="auth-subtitle">Enter your email and we'll send a reset link.</div>

            <form id="reset-form">
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-group">
                        <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="12" height="10" rx="1.5"/><path d="M2 5l6 4 6-4"/></svg>
                        <input type="email" id="email" class="form-control" placeholder="you@company.com" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:38px">
                    Send reset link
                </button>
            </form>

            <div class="auth-divider">or</div>

            <div style="text-align:center">
                <a href="{{ route('login') }}" class="btn btn-outline" style="display:inline-flex;justify-content:center">
                    ← Back to sign in
                </a>
            </div>

            <div class="auth-success" id="reset-success" hidden>
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/>
                </svg>
                <div class="success-title">Check your email</div>
                <div class="success-desc">We sent a password reset link to <strong id="reset-email"></strong>. The link expires in 30 minutes.</div>
            </div>

            <div class="auth-footer">
                Don't have an account? <a href="{{ route('register') }}">Create one</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        const form = document.getElementById('reset-form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const email = document.getElementById('email').value.trim();
            if (!email) return;
            document.getElementById('reset-email').textContent = email;
            form.hidden = true;
            document.querySelector('.auth-divider').hidden = true;
            document.getElementById('reset-success').hidden = false;
        });
    </script>
@endsection