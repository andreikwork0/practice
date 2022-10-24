@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between">
            {{$company->name}}
            <div>
                <a class="btn btn-outline-secondary mr-3" href="{{route('companies.index')}}">Все организации</a>
                <a target="_blank" class="btn btn-outline-primary" href="{{route('companies.edit', $company->id)}}">Редактировать</a>
            </div>
        </div>

    </x-page-title>
@endsection

@section('content')

    <div class="container">

        <h2 class="mb-3">{{$company->name_full ?? ''}}</h2>

        <div class="d-flex">
            <p class="mx-3">ИНН:   {{$company->inn }}</p>
            <p class="mx-3">КПП:   {{$company->kpp }}</p>
        </div>

        <div class="d-flex">
            <p class="mx-3"> Руководитель:  {{$company->mng_surname ?? ''}}  {{$company->mng_name ?? ''}}  {{$company->mng_patronymic ?? ''}}</p>
            <p class="mx-3"> Юридический адрес: {{$company->legal_adress ?? '-'}} </p>
        </div>

        <hr>
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link active"
               href="{{route('companies.show', $company->id)}}">
                @svg('file-text', 'w-16 h-16 bi me-2 text-white')
                Договоры
            </a>
            <a class="flex-sm-fill text-sm-center nav-link"
               href="#">
                @svg('people', 'w-16 h-16 bi me-2')
                Контактные лица
            </a>
            <a class="flex-sm-fill text-sm-center nav-link"
               href="#">
                @svg('envelope', 'w-16 h-16 bi me-2')
                Гарантийные письма
            </a>
        </nav>
        <hr>

        @yield('c_tab')

    </div>




@endsection

