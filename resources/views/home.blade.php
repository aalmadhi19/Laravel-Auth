@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
    </div>
@endsection
