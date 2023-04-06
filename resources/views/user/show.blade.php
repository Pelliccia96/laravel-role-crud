@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    <div>
        <a href="{{ route('dashboard') }}"><button class="btn btn-secondary fw-semibold mx-3">Dashboard</button></a>
    </div>
</div>
@endsection