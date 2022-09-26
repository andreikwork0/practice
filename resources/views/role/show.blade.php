@extends('layouts/app')

@section('title-block') Роль {{ $role->name}}  @endsection
@section('content')
    <div style="padding: 50px 0;">
        <div class="container">

        <p>{{$role->id}}</p>
        <p>{{$role->name}}</p>

    </div>
@endsection

