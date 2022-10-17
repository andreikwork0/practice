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
                    <x-form.fieldgroup title="Договор">
                        <x-form.input
                            required
                            label="Название"
                            name="name"/>

                        <x-form.input
                            required
                            label="Номер"
                            name="num_agreement"/>
                        <x-form.checkbox
                            label="Актуальность"
                            name="is_actual"/>


                        <x-form.input
                            type="file"
                            label="Файл"
                            name="agreement_f"/>

                        <x-form.select
                            required
                            :options=$statuses
                            name="agr_status_id"
                            dfvalue="1"
                            label="Статус"
                        />
                    </x-form.fieldgroup>
                    </div>
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Даты">
                            <x-form.input
                                type="date"
                                label="Дата договора"
                                name="date_agreement"/>

                            <x-form.input
                                type="date"
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

