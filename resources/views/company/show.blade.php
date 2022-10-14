@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection

@section('page-title')
    <x-page-title> {{$company->name}}  </x-page-title>
@endsection

@section('content')

    <div class="container">

        <h2 class="mb-3">{{$company->name_full ?? ''}}</h2>

        <div class="d-flex">
            <p class="mx-3"> Руководитель:  {{$company->mng_surname ?? ''}}  {{$company->mng_name ?? ''}}  {{$company->mng_patronymic ?? ''}}</p>
        </div>

        <h3>Реквизиты</h3>
        <div class="d-flex">
            <p class="mx-3">ИНН:   {{$company->inn }}</p>
            <p class="mx-3">КПП:   {{$company->kpp }}</p>
        </div>

        <h3>Адрес</h3>
        <div class="d-flex">
            <p class="mx-3"> Юридический адрес: {{$company->legal_adress ?? '-'}} </p>
            @if($company->fact_adress)
                <p class="mx-3"> Фактический  адрес: {{$company->fact_adress ?? '-'}} </p>
            @endif
        </div>
    </div>



@endsection

