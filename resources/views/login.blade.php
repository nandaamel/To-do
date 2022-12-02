@extends('layout')
@section('content')
<form method="POST" action="{{route('login.auth')}}">
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
@if (Session::get('notALLowed'))
<div class="alert alert-danger">
  {{Session::get('notALLowed') }}
  Berhasil Register, Silahkan Login
</div>
@endif
  <div class="row justify-content-center mt-5" style="opacity: 75%">       
    <div class="card" style="width: 35rem;">
      <div class="text-center">
        <h1 class="h4 text-gray-900">Welcome Back!</h1>
        <p>Please Login</p>
        @if(session('success'))
        <div class="alert alert-success">
          Berhasil Register, Silahkan Login
        </div>
        @endif
        @if (Session::get('successAdd'))
        <div class="alert-alert-success">
          {{Session::get('succesAdd')}}
      </div>
      @endif
    <div class="mb-2">
        <label for="exampleInputEmail1" class="form-label">Username</label>
        <input style="width:200px; margin-left:32% " type="username" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="text" class="password-text" name="username"></div>
      </div>
    <div class="mb-2">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input style="width:200px; margin-left:32%" type="password" class="form-control" id="exampleInputPassword1" name="password">
    </div>
    <button type="submit" class="btn btn-primary" style="width: 45%">Submit
    </button>
    <p>Tidak punya akun ? <a href="register"> Register </a></p>
  </form>

@endsection