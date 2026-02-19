@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-box-arrow-in-right"></i> Login</h4>
            </div>
            <div class="card-body">
                <form id="loginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="student@edtech.com" required>
                        <small class="text-muted">Try: student@edtech.com / password</small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               value="password" required>
                        <small class="text-muted">Password: password</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>
                <div class="text-center mt-3">
                    <a href="/register">Don't have an account? Register</a>
                </div>
                <hr>
                <div class="text-center">
                    <h6>Test Credentials:</h6>
                    <p class="mb-1"><strong>Admin:</strong> admin@edtech.com / password</p>
                    <p class="mb-1"><strong>Instructor:</strong> instructor@edtech.com / password</p>
                    <p class="mb-1"><strong>Student:</strong> student@edtech.com / password</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection