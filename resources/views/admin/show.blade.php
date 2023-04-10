@extends('layouts.app')

@section('content')
<div class="container p-5 h-100 rounded-4">
    <div class="row h-100 overflow-auto justify-content-center">
        <div class="d-flex justify-content-between align-items-center my-5">
            <h1 class="text-dark">I TUOI POST!</h1>
            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}"><strong>Torna in Dashboard</strong></a>
        </div>
        @foreach ($posts as $post)
        <div class="col-12 col-md-6 col-lg-4 pb-3 ">
            <div class="py-5 h-100">
                <div class="card shadow mt-4 p-4 h-100 rounded-4">
                    <div class="card-title text-center">
                        <h2> {{ $post->title }} </h2>
                    </div>
                    <div class="card-img-top text-center pb-3">
                        @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid w-100 rounded">
                        @else
                        <img src="https://i.ytimg.com/vi/7NOSDKb0HlU/maxresdefault.jpg" class="img-fluid w-100 rounded">
                        @endif
                    </div>
                    <div class="card-text flex-grow-1">
                        <p><strong>Descrizione:</strong> {{ $post->description }} </p>
                        <p><strong>Categoria:</strong> 
                            @foreach ($post->categories as $category)
                                {{ $category->name }}
                            @endforeach
                        </p>
                        <p><strong>Visibilità:</strong>
                            @if($post->visibility === 0)
                            <span><i>No</i></span>
                            @else
                            <span><i>Si</i></span>
                            @endif
                        </p>
                        <p><strong>Autore:</strong> <i>{{ $post->user->name }}</i> </p>
                    </div>
                    <div class="d-flex gap-2  justify-content-center">
                        <a class="link-show" href={{ route('posts.edit', $post->id) }}>
                            <button class="btn btn-primary text-white me-3">Modifica</button>
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                            class="delete-form d-inline-block">
                            @csrf()
                            @method('delete')
                            <button class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
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