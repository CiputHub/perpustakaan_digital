@extends('auth.layout')

@section('content')

<div class="container mt-5">
    <div class="col-md-4 mx-auto">
        <div class="card shadow">
            <div class="card-body">

                <h4 class="text-center mb-4">Login</h4>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                     @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100">Login</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('register') }}">Daftar Kepala Perpus</a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
