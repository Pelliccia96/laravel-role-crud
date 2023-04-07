@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
    {{-- Tabella Users --}}
    <div class="card my-5">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome utente</th>
                        <th>Email</th>
                        <th>Creato il</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5 mb-3">
        <a href="{{ route('posts.create') }}"><button class="btn btn-secondary fw-semibold mx-3">&plus; Aggiungi Nuovo
                Post</button></a>
    </div>
    {{-- Tabella Post --}}
    <div class="card mb-3">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titolo post</th>
                        <th>Immagine</th>
                        <th>Descrizione post</th>
                        <th>Visibilità</th>
                        <th>Mostra</th>
                        <th>Modifica</th>
                        <th>Elimina</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>
                            <img src="{{ asset('/storage/' . $post['image']) }}" class="w-150">
                        </td>
                        {{-- <td>{{ $post->category ? $post->category->name : '' }}</td> --}}
                        <td>{{ $post->description }}</td>
                        <td>{{ $post->visibility }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-primary">#{{ $post->id }}</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('posts.edit', $post->id) }}"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-info text-white">#{{ $post->id }}</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form">
                                @csrf()
                                @method('delete')
                                <button class="btn btn-danger fw-bold">X</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection