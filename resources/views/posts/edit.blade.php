@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center pt-2 mt-4">
        <h1 class="text-dark">MODIFICA POST #{{ $post->id }}</h1>
    </div>
    {{-- Validazione Dati --}}
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
        <form action="{{ route('posts.update', $post->id ) }}" method="POST" class="p-5"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="mb-4">
                <label class="form-label">Titolo: </label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ $errors->has('title') ? '' : $post->title }}">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Immagine: </label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Categoria: </label>
                <select name="categories" class="form-select">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Descrizione: </label>
                <textarea type="text" name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="3">{{ $errors->has('description') ? '' : $post->description }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="switch" name="visibility"
                    {{ old('visibility', 1) ? 'checked' : '' }} value="1">
                <label class="form-check-label" for="switch">Visibilità </label>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-3">Modifica</button>
                <a class="btn btn-danger" href="{{ route('dashboard') }}">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection