@extends('layouts/app')

@section('title-block') Студенты по организациям  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Студенты на практику в {{$dp->company->name}}
            <div>
                 <a class="btn btn-outline-primary px-5" href="{{route('practices.show', $dp->practice->id)}}"> &larr; Назад</a>
            </div>
        </div>
    </x-page-title>
@endsection

@section('content')

        <div class="container">


            <h5 class="mb-3">{{$practice->name}}</h5>
            <h5 class="mb-3">{{$practice->agroup}} -  {{$practice->spec}}</h5>

            <div class="d-flex">
                <p >Контингент: {{$practice->contingent}} </p>
                <p class="mx-3">Курс:   {{$practice->course }}</p>
                <p class="mx-3">Семестр:   {{$practice->semester }}</p>
            </div>
            <div class="d-flex">
                <p>Тип практики: {{$practice->type->name ?? '-'}} </p>

                <p class="mx-3">Дата начала: {{$practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '-'}}</p>
                <p class="mx-3">Дата окончания: {{$practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '-'}}</p>

            </div>


            <hr>

            <div class="my-3">
                <h2> Количество  мест  </h2>
                <div class="d-flex">
                    <div class="">
                        <div><b>Согласовано</b></div>
                        <div class="text-center">{{$dp->num_fact ?? 0}}</div>

                    </div>
                    <div class="mx-3">
                        <div><b>Занято</b></div>
                        <div class="text-center">{{$c_s_dp ?? 0}}</div>
                    </div>
                </div>


            </div>
            <hr>

            <div class="row">
                @if ($col_edit_ss->count() > 0)
                    <div class="col-6">
                        <form action="/">

                            <div class="d-flex  align-content-center mb-1">
                                <h3 class="">Редактируемые</h3>
                            </div>

                            @foreach($col_edit_ss as $ps)
                                <div class="hide_col_3">
                                    <x-form.checkbox
                                        label="{{$ps->student->fio()}}"
                                        dfvalue="{{$ps->distribution_practice_id ? 1 : 0}}"
                                        name="distribution_practice_id[{{$ps->id}}]"/>
                                </div>
                            @endforeach
                            <button class="my-3 btn btn-primary" type="submit">Сохранить</button>
                        </form>
                    </div>
                @endif


                @if ($col_stat_ss->count() > 0)
                    <div class="col-6">



                        <div class="d-flex  align-content-center mb-1">
                            <h3 class="">Нередактируемые</h3>
                        </div>

                        @foreach($col_stat_ss as $ps)
                            <div>{{$ps->student->fio()}} -
                                <a href="{{route('pr_student.edit', $ps->dp->id)}}">         {{$ps->dp->company->name}}</a>

                                <br></div>
                        @endforeach
                    </div>

                @endif

            </div>
            <hr>

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
                                    <td>
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
                                            <a class="btn btn-outline-primary" href="{{route('pr_student.edit', $dp->id)}}">По студентам</a>
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

