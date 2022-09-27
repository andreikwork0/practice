@extends('layouts/app')

@section('title-block') Разрешение {{ $permission->name}}  @endsection
@section('content')
    <div style="padding: 50px 0;">
        <div class="container">
        <p>{{$permission->id}}</p>
        <p>{{$permission->name}}</p>
    </div>
@endsection

