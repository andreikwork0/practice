@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection
@section('content')
    <div style="padding: 50px 0;">
        <div class="container">

        <p>{{$company->id}}</p>
        <p>{{$company->name}}</p>
        <p>{{$company->legal_adress}}</p>
        <p>{{$company->inn}}</p>
        <p>{{$company->kpp}}</p>
    </div>
@endsection

