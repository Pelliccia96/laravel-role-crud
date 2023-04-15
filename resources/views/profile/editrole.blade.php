@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center pt-2 mt-4">
        <h1 class="text-dark">MODIFICA RUOLO {{ $user->id }}</h1>
    </div>
    @if($errors->any())
    <div>
        <div class="alert alert-danger">I dati inseriti non sono validi:
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div>
        <form action="{{ route('profile.updaterole', $user->id ) }}" method="POST" class="p-5"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label">Ruolo: </label>
                <select name="role_id" class="form-select">
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-3">Modifica</button>
                <a class="btn btn-danger" href="{{ route('dashboard') }}">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection