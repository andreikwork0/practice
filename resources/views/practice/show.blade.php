@extends('layouts/app')

@section('title-block') Практика {{ $practice->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Распределение практики
            <div>
                <a href="{{route('practices.edit', $practice->id)}}" class="btn btn-outline-primary">Редактировать</a>
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
                @if($practice->day)
                    <p class="mx-3">Длительность: {{$practice->day ?? '-'}} дней </p>
                @elseif($practice->week)
                    <p class="mx-3">Длительность:   {{$practice->week ?? '-'}} недель</p>
                @endif
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



            @if(count($practice->dp)>0)
                <div class="row">
                    <div class="col-md-8">
                        <table class="table  border table-striped">
                            <thead>
                            <tr>
                                {{--                <th scope="col">ID</th>--}}
                                <th style="width: 50%" scope="col">Организация</th>
                                <th scope="col" class="text-center">План</th>

                                <th scope="col" class="text-center">Факт</th>

                                <th scope="col" class="text-center">Доп соглашение</th>

                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($practice->dp as $dp)
                                <tr>
                                    <td >
                                        {{$dp->company->name}}
                                    </td>
                                    <td class="text-center">
                                        {{$dp->num_plan}}
                                    </td>
                                    <td  class="text-center">
                                        {{$dp->num_fact ?? '-'}}
                                    </td>
                                    <td  class="text-center">
                                        {{$dp->convention ?  'да': 'нет'}}
                                    </td>
                                    <td class="">
                                        <div class="d-flex justify-content-end">
                                            @if(!$dp->convention)
                                                <x-modal-delete-btn
                                                    text="Распределение будет удалено"
                                                    url="{{route('distribution_practices.destroy', $dp->id)}}"
                                                />
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @endif


    </div>
@endsection

