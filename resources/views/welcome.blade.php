@extends('layouts.app')
@section('content')

<div class="text-center bg-dark py-5">
    <h1 class="fw-bold text-white"><i>Home</i></h1>
</div>
<div class="jumbotron p-5 mb-4 bg-light rounded-3">
    <div class="container p-5 h-100 rounded-4">
        <div class="row h-100 overflow-auto justify-content-center">
            <div class="d-flex justify-content-between align-items-center my-5">
                <h1 class="text-dark">Post degli Utenti:</h1>
            </div>
            @foreach ($posts as $post)
            {{-- Il post sarà reso pubblico solo se è impostato su visibilità: si --}}
            @if($post->visibility === 1)
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
                            <img src="https://i.ytimg.com/vi/7NOSDKb0HlU/maxresdefault.jpg"
                                class="img-fluid w-100 rounded">
                            @endif
                        </div>
                        <div class="card-text flex-grow-1">
                            <p><strong>Descrizione:</strong> {{ $post->description }} </p>
                            <p><strong>Categoria:</strong>
                                @foreach ($post->categories as $category)
                                {{ $category->name }}
                                @endforeach
                            </p>
                            <p><strong>Autore:</strong> <i>{{ $post->user->name }}</i> </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

<div class="content">
    <div class="container my-5">
        <div class="col-md-4 col-sm-8 ">
            <div class="text-dark"><span class="fw-bold">Boolean Careers </span>&#8226; Classe #79 &#8226; <i><span
                        class="fw-semibold">Made by Francesco Pelliccia</span></i> <br> <small>Copyright 2022/2023
                    &#169; Privacy policy &#174;</small></div>
        </div>
    </div>
</div>
@endsection