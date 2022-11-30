@extends('layouts/app')
@section('title-block') Добавить договор @endsection

@section('page-title')
    <x-page-title>Добавить договор для {{$company->name}}</x-page-title>
@endsection

@section('content')

    <div class="container">
        <form action="{{route('agreements.store', $company->id)}}" method="post"  enctype="multipart/form-data" >
            @csrf
            <div class="row">
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Даты">


                            <x-form.input
                                type="text"
                                label="Номер договора"
                                name="num_agreement"/>

                            <x-form.select
                                required
                                :options=$types
                                name="agr_type_id"
                                dfvalue="1"
                                label="Тип"
                            />

                            <x-form.input
                                type="date"
                                label="Дата подписания"
                                name="date_agreement"/>

                            <x-form.input
                                type="date"
                                required
                                label="Начало действия"
                                name="date_bg"/>

                            <x-form.input
                                type="date"
                                label="Конец действия"
                                name="date_end"/>
                        </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    @endsection

