@extends('layouts/app')

@section('title-block') Практика {{ $practice->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Редактировать практику
        </div>
    </x-page-title>
@endsection

@section('content')


        <div class="container">
            <h2 class="mb-3">{{$practice->name}}</h2>
            <h5 class="mb-3">{{$practice->agroup}} -  {{$practice->spec}}</h5>



            <div class="d-flex">
                <p >Контингент: {{$practice->contingent}} </p>
{{--                @if($practice->day)--}}
{{--                    <p class="mx-3">Длительность: {{$practice->day ?? '-'}} дней </p>--}}
{{--                @elseif($practice->week)--}}
{{--                    <p class="mx-3">Длительность:   {{$practice->week ?? '-'}} недель</p>--}}
{{--                @endif--}}
                <p class="mx-3">Курс:   {{$practice->course }}</p>
                <p class="mx-3">Семестр:   {{$practice->semester }}</p>
            </div>




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
                        </x-form.fieldgroup>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

    </div>
@endsection

