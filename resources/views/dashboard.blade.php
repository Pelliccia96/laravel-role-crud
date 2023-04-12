@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                @if (Auth::user()->role_id == '1' ? true : Auth::user()->role_id == '2')
                <div class="card-header">{{ __('Admin Dashboard') }}</div>
                @else
                <div class="card-header">{{ __('User Dashboard') }}</div>
                @endif

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
    @if (Auth::user()->role_id == '1' ? true : Auth::user()->role_id == '2')
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        @if(Auth::user()->role_id == '1')
                        <td>
                            <a href="{{ route('profile.editrole', $user->id) }}"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-info text-white"><span class="fw-semibold">
                                    @if($user->role_id === 1)
                                    <i>Super-Admin</i>
                                    @elseif($user->role_id === 2)
                                    <i>Admin</i>
                                    @else
                                    <i>User</i>
                                    @endif
                                </span></button>
                            </a>
                        </td>
                        @else
                        <td>
                            @if($user->role_id === 1)
                            <i>Super-Admin</i>
                            @elseif($user->role_id === 2)
                            <i>Admin</i>
                            @else
                            <i>User</i>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
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
                        @if (Auth::user()->role_id == '1' ? true : Auth::user()->role_id == '2')
                        <th>ID</th>
                        @endif
                        <th>Titolo post</th>
                        <th>Immagine</th>
                        <th>Categoria</th>
                        <th>Descrizione post</th>
                        @if (Auth::user()->role_id == '1' ? true : Auth::user()->role_id == '2')
                        <th>Autore</th>
                        @endif
                        <th>Visibilità</th>
                        <th>Mostra</th>
                        <th>Modifica</th>
                        <th>Elimina</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        @if (Auth::user()->role_id == '1' ? true : Auth::user()->role_id == '2')
                        <td>{{ $post->id }}</td>
                        @endif
                        <td>{{ $post->title }}</td>
                        @if($post->image)
                        <td>
                            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded" style="height:100px; width:100px">
                        </td>
                        @else
                        <td>
                            <img src="https://i.ytimg.com/vi/7NOSDKb0HlU/maxresdefault.jpg" class="img-fluid rounded" style="height:100px; width:100px">
                        </td>
                        @endif
                        <td>
                            @foreach ($post->categories as $category)
                                {{ $category->name }}
                            @endforeach
                        </td>
                        <td>{{ $post->description }}</td>
                        @if (Auth::user()->role_id == '1' ? true : Auth::user()->role_id == '2')
                        <td>{{ $post->user->name }}</td>
                        @endif
                        <td>
                            @if($post->visibility === 0)
                            <span class="fw-semibold"><i>No</i></span>
                            @else
                            <span class="fw-semibold"><i>Si</i></span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-primary"><span class="fw-semibold"><i>i</i></span></button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('posts.edit', $post->id) }}"
                                class="text-decoration-none fw-semibold text-white">
                                <button class="btn btn-info text-white"><span class="fw-semibold"><i>#{{ $post->id }}</i></span></button>
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