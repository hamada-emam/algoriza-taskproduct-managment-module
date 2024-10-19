@extends('layouts.error')

@section('title', '403 Forbidden')

@section('content')
    <h1>403</h1>
    <p>Sorry, you do not have permission to access this page.</p>
    <a href="{{ url('/') }}">Go to Home</a>
@endsection
