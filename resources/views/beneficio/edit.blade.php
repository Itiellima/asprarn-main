@extends('layouts.main')

@section('title', 'ASPRARN - Editar Benefício')

@section('content')

<div class="container body-offset">
    
    @include('beneficio.form', ['beneficio' => $beneficio])
</div>


@endsection
