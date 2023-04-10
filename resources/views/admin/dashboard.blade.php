@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Super-admin Dashboard') }}</div>

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
                        <th>Ruolo</th>
                        <th>Modifica</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="#"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-info text-white"><span class="fw-semibold"><i>#{{ $user->id
                                            }}</i></span></button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5 mb-3">
        <a href="{{ route('admin.create') }}"><button class="btn btn-secondary fw-semibold mx-3">&plus; Aggiungi Nuovo
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
                        <th>Categoria</th>
                        <th>Descrizione post</th>
                        <th>Autore</th>
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
                        @if($post->image)
                        <td>
                            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded"
                                style="height:100px; width:100px">
                        </td>
                        @else
                        <td>
                            <img src="https://i.ytimg.com/vi/7NOSDKb0HlU/maxresdefault.jpg" class="img-fluid rounded"
                                style="height:100px; width:100px">
                        </td>
                        @endif
                        {{-- <td>{{ $post->category ? $post->category->name : '' }}</td> --}}
                        <td>
                            @foreach ($post->categories as $category)
                            {{ $category->name }}
                            @endforeach
                        </td>
                        <td>{{ $post->description }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>
                            @if($post->visibility === 0)
                            <span class="fw-semibold"><i>No</i></span>
                            @else
                            <span class="fw-semibold"><i>Si</i></span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.show', $post->id) }}"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-primary"><span class="fw-semibold"><i>i</i></span></button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.edit', $post->id) }}"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-info text-white"><span class="fw-semibold"><i>#{{ $post->id
                                            }}</i></span></button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.destroy', $post->id) }}" method="POST" class="delete-form">
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
<script>
    const forms = document.querySelectorAll(".delete-form");
    forms.forEach((form) => {
        form.addEventListener("submit", function(e) {
        e.preventDefault();
        const conferma = confirm("Sicuro?");
        if (conferma === true) {
            form.submit();
        }
        })
    })
</script>
@endsection