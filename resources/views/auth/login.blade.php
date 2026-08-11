@extends('layouts.public')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 p-4">
                <div class="card-body">
                    <h3 class="text-center fw-bold mb-4">Customer Login</h3>
                    
                    <form action="{{ route('login') }}" method="POST" class="no-confirm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Sign In</button>
                        
                        <div class="text-center mt-4">
                            <span class="text-muted">Don't have an account?</span> 
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Register here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
