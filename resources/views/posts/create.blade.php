@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center pt-2 mt-4">
        <h1 class="text-dark">CREA NUOVO POST</h1>
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
        <form action="{{ route('posts.store') }}" method="POST" class="p-5" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="form-label">Titolo: </label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ $errors->has('title') ? '' : old('title') }}">
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

            {{-- <label class="form-label">Type: </label>
            <select name="type_id" class="form-select mb-4">
                @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>

            <div class="mb-3">
                @foreach ($technologies as $technology)
                <div class="form-check form-check-inline @error('technologies') is-invalid @enderror">
                    <input class="form-check-input @error('technologies') is-invalid @enderror" type="checkbox"
                        id="technologyCheckbox_{{ $loop->index }}" value="{{ $technology->id }}" name="technologies[]"
                        {{ in_array( $technology->id, old('technologies', [])) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="technologyCheckbox{{ $loop->index }}">{{ $technology->name
                        }}</label>
                </div>
                @endforeach

                @error('technologies')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div> --}}

            <div class="mb-4">
                <label class="form-label">Descrizione: </label>
                <textarea type="text" name="description"
                    class="form-control @error('description') is-invalid @enderror" rows="3"
                    value="{{ $errors->has('description') ? '' : old('description') }}"></textarea>
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

            <div class="my-5">
                <button type="submit" class="btn btn-primary me-3">Salva</button>
                <a class="btn btn-secondary" href="{{ route('dashboard') }}">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection