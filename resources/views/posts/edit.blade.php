@extends('layouts.main')

@section('title', '')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container body-offset">

        <div class="meu-container alert alert-light">
            <h1>Alterar publicação</h1>
        </div>

        @include('posts.form', ['post' => $post])
    </div>


@endsection
