@extends('layouts.error')

@section('title', '404 Not Found')

@section('content')
    <h1>404</h1>
    <p>Oops! The page you are looking for could not be found.</p>
    <a href="{{ url('/') }}">Go to Home</a>
@endsection
