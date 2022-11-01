@extends('layouts/app')
@section('title-block') Редактировать договор @endsection

@section('page-title')
    <x-page-title>Редактировать договор № {{$agreement->num_agreement}} с {{$agreement->company->name}}</x-page-title>
@endsection

@section('content')



    <div class="container">
        <div class="d-flex my-3">
            @if($agreement->path)
                <a class="p-2 mx-1" >
                    <form action="{{route('agreements.download', $agreement->id)}}" method="post">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent"> @svg('download', 'w-30 h-6 text-dark icon-index') Скачать прикрепленный файл </button>
                    </form>
                </a>
            @endif
        </div>

        <form action="{{route('agreements.update', $agreement->id)}}" method="post"  enctype="multipart/form-data" >
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-form.fieldgroup title="Договор">

                        <x-form.select
                            required
                            :options=$types
                            name="agr_type_id"
                            dfvalue="{{$agreement->agr_type_id}}"
                            label="Тип"
                        />

                        <x-form.checkbox
                            label="Действующий"
                            dfvalue="{{$agreement->is_actual}}"
                            name="is_actual"/>



                        <x-form.input
                            type="file"
                            label="Файл"
                            name="agreement_f"/>

                        <x-form.select
                            required
                            :options=$statuses
                            name="agr_status_id"
                            dfvalue="{{$agreement->agr_status_id}}"
                            label="Статус"
                        />
                    </x-form.fieldgroup>
                    </div>
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Даты">
                            <x-form.input
                                type="date"
                                label="Дата подписания"
                                dfvalue="{{$agreement->date_agreement}}"
                                name="date_agreement"/>

                            <x-form.input
                                type="date"
                                required
                                label="Начало действия"
                                dfvalue="{{$agreement->date_bg}}"
                                name="date_bg"/>

                            <x-form.input
                                type="date"
                                label="Конец действия"
                                dfvalue="{{$agreement->date_end}}"
                                name="date_end"/>
                        </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    @endsection

