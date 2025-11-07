@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Welcome, SuperAdmin!</h1>
    <p>This is your SuperAdmin dashboard.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
