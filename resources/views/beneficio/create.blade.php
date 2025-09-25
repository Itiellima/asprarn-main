@extends('layouts.main')

@section('title', '')

@section('content')

<div class="container body-offset">
    
    @include('beneficio.form', ['beneficio' => $beneficio])
</div>


@endsection
