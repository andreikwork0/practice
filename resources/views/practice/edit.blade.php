@extends('layouts/app')

@section('title-block') Практика {{ $practice->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Изменение характеристик практики
            <div>
                <a class="btn btn-outline-primary px-5" href="{{route('practices.show', $practice->id)}}"> &larr; Назад</a>
            </div>
        </div>
    </x-page-title>
@endsection

@section('content')


        <div class="container">
            <x-practice.header :practice=$practice></x-practice.header>

            <form action="{{route('practices.update', $practice->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Практика">
                            <x-form.input
                                required
                                dfvalue="{{$practice->date_start}}"
                                label="Дата начала"
                                type="date"

                                name="date_start"/>
                            <x-form.input
                                dfvalue="{{$practice->date_end}}"
                                required
                                type="date"
                                label="Дата окончания"
                                name="date_end"/>
                            <x-form.select
                                :options=$types
                                required
                                dfvalue="{{$practice->practice_type_id}}"
                                name="practice_type_id"
                                label="Тип практики"
                            />

                            <x-form.select
                                :options=$forms
                                required
                                dfvalue="{{$practice->practice_form_id}}"
                                name="practice_form_id"
                                label="Форма проведения"
                            />


                            @if($practice->education_type_id == 2)
                                <x-form.select
                                    :options=$kind_of_activities
                                    dfvalue="{{$practice->kind_of_activity_id}}"
                                    name="kind_of_activity_id"
                                    label="Вид деятельности"
                                />
                            @endif

                        </x-form.fieldgroup>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

    </div>
@endsection

