@extends('layouts/app')

@section('title-block') Практика {{ $practice->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
                  Распределение контингента студентов <br>
                  по руководителям практики
            <div class="d-flex">
                <div>
                    <a class="btn btn-outline-primary px-5" href="{{route('practices.show', $practice->id)}}"> &larr; Назад</a>
                </div>
            </div>
        </div>
    </x-page-title>
@endsection

@section('content')
        <div class="container">
            <x-practice.header :practice=$practice></x-practice.header>
            @if($teachers->count() > 0)
                <table class="table  border table-striped">
                <thead>
                <tr>
                    <th style="" scope="col">ФИО</th>
                    <th scope="col" class="text-center">Контингет</th>
                    <th scope="col" class="text-center">Должность</th>
                    <th scope="col" class="text-center">Пост</th>
                </tr>
                </thead>
                <tbody>

                @foreach($teachers as $t)
                    <tr>
                        <td>
                          {{$t->fio()}}
                        </td>
                        <td  class="text-center">
                            {{$t->pivot->contingent}}
                        </td>
                        <td class="text-center">
                            {{$t->post}}
                        </td>
                        <td  class="text-center">
                            {{$t->type}}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            @else
                <p>Упс кажется по этой практике нет данных по преподавателям</p>
            @endif
    </div>
@endsection

