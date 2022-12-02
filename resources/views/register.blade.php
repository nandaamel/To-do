@extends('layout')
@section('content')
    <form method="POST" action="{{ route('register.input') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center mt-5" style="opacity: 75%">
            <div class="card" style="width: 400px;">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mt-2">Welcome Back!</h1>
                    <p>Please to register</p>
                </div>
                <div class="mb-4">
                    <label for="exampleInputNama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" aria-describedby="emailHelp">
                    <div id="emailHelp" class="email-text"></div>
                </div>
                <div class="mb-4">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" aria-describedby="emailHelp">
                    <div id="emailHelp" class="password-text"></div>
                </div>
                <div class="mb-4">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                    <div id="emailHelp" class="password-text"></div>
                </div>
                <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" >Kirim</button>
                </div>
            </div>
    </form>

@endsection
