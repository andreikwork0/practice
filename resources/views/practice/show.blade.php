@extends('layouts/app')

@section('title-block') Практика {{ $practice->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Распределение практики
            <div class="d-flex">
                <div class="mx-3">
                    <a href="{{route('practices.edit', $practice->id)}}" class="btn btn-outline-primary">Редактировать</a>
                </div>

{{--                <form action="{{route('order.generate', $practice->id)}}" method="post">--}}
{{--                    @csrf--}}
{{--                    <button     class="btn btn-secondary" type="submit">--}}
{{--                        Сформировать приказ</button>--}}
{{--                </form>--}}

            </div>
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

            <div class="d-flex">
                <p>Тип практики: {{$practice->type->name ?? '-'}} </p>

                <p class="mx-3">Дата начала: {{$practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '-'}}</p>
                <p class="mx-3">Дата окончания: {{$practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '-'}}</p>

            </div>


                <x-form.fieldgroup
                    title="Добавить распределение">
                    <form action="{{route('distribution_practices.store', $practice->id )}}" method="POST">
                        @csrf
                        <div class="d-flex align-content-center">
                            <div class="mx-3">
                                <label for="">Организация</label>
                                <x-form.select
                                    :options=$companies
                                    required
                                    type="number"
                                    name="company_id"
                                    label=""
                                />
                            </div>
                            <div class="mx-3">
                                <label for="">План мест</label>
                                <x-form.input
                                    label=""
                                    required
                                    type="number"
                                    min="0"
                                    name="num_plan"/>
                            </div>
                            <div class="my-auto mx-3">
                                <button type="submit" class="btn btn-primary mt-3 mx-3">Добавить</button>
                            </div>
                        </div>
                    </form>
                </x-form.fieldgroup>




            <x-distpr.list
                contingent="{{$practice->contingent}}"
                :dps="$practice->dp"></x-distpr.list>



    </div>
@endsection

