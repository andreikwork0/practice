@extends('layouts/app')

@section('title-block') Практика {{ $practice->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Распределение практики
        </div>
    </x-page-title>
@endsection

@section('content')


        <div class="container">
            <h2 class="mb-3">{{$practice->name}}</h2>
            <h5 class="mb-3">{{$practice->agroup}} -  {{$practice->spec}}</h5>



            <div class="d-flex">
                <p >Контингент: {{$practice->contingent}} </p>
                @if($practice->day)
                    <p class="mx-3">Длительность: {{$practice->day ?? '-'}} дней </p>
                @elseif($practice->week)
                    <p class="mx-3">Длительность:   {{$practice->week ?? '-'}} недель</p>
                @endif
                <p class="mx-3">Курс:   {{$practice->course }}</p>
                <p class="mx-3">Семестр:   {{$practice->semester }}</p>
            </div>

            <div class="d-flex">
                <p>Тип практики: {{$practice->type->name}} </p>

                <p class="mx-3">Дата начала: {{$practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '-'}}</p>
                <p class="mx-3">Дата окончания: {{$practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '-'}}</p>

            </div>

            <form action="" method="POST">
                @csrf

                <div class="d-flex">
                    <div>
                        <h5>организация</h5>
                        <x-form.select
                            :options=$companies
                            name="company_id"
                            label=""
                        />
                    </div>
                    <div>
                        <h5>предварительные места</h5>
                        <x-form.input
                            label=""
                            name="num_plan"/>
                    </div>



                    <button class="btn btn-primary">Добавить</button>
                </div>

            </form>






    </div>
@endsection

