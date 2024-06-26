@extends('layouts/app')

@section('title-block') Студенты на практику мета информация  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Студенты на практику дополнительная информация
            <div>
                 <a class="btn btn-outline-primary px-5" href="{{route('practices.show', $practice->id)}}"> &larr; Назад</a>
            </div>
        </div>
    </x-page-title>
@endsection

@section('content')
        <div class="container">
            <x-practice.header :practice=$practice></x-practice.header>
            <hr>
            <a target="_blank" class="btn-outline-primary btn" href="{{route('direction.print_all', $practice->id)}}">Направления все</a>
            <hr>
            <div class="row">
                @if ($students->count() > 0)
                    <div class="col-12" >
                        <form action="{{route('pr_student_meta.update', $practice->id)}}" method="post">
                            @method('PUT')
                            @csrf
                        <table class="table  border table-striped mx-y-input-0">
                            <thead style="position: sticky; top: 0; z-index: 100;" class="table-dark">
                            <tr>
                                <th  scope="col">ФИО студента</th>
                                <th scope="col" class="text-center">В качестве кого</th>
                                <th scope="col" class="text-center">Организация</th>
                                <th scope="col" class="text-center">ФИО Ответственный от орг.</th>
                                <th scope="col" class="text-center">ФИО Ответственный от МГТУ.</th>

                                <th> <button class=" btn btn-primary" type="submit">Сохранить</button></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $pr_student)
                                <tr>
                                    <td>
                                        <x-form.input
                                            label=""
                                            hidden
                                            dfvalue="{{$pr_student->id}}"
                                            name="pr_students[{{$pr_student->id}}][id]"/>
                                        {{$pr_student->student->fio()}}
                                    </td>
                                    <td>
                                        <x-form.input
                                            label=""
                                            dfvalue="{{$pr_student->st_type}}"
                                            name="pr_students[{{$pr_student->id}}][st_type]"/>
                                    </td>
                                    <td>
                                        {{$pr_student->company_name}}
                                    </td>
                                    <td>
                                        <x-form.input
                                            label=""
                                            dfvalue="{{$pr_student->org_empl_fio}}"
                                            placeholder="Фамилия И.О."
                                            name="pr_students[{{$pr_student->id}}][org_empl_fio]"/>
                                    </td>

                                    <td>

                                        <x-form.select
                                            :options=$teachers
                                            name="pr_students[{{$pr_student->id}}][teacher_id]"
                                            required
                                            dfvalue="{{$pr_student->teacher_id}}"
                                            label=""
                                        />

                                    </td>

                                    <td>
                                        @if($pr_student->dir_flag)
                                        <a class="btn-outline-primary btn" href="{{route('direction.generate', $pr_student->id)}}">Направление</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                        </form>
                    </div>
                @else
                    <div class="col-12">
                        Упс .. кажется нет студентов. Обратитесь к администратору
                    </div>
                @endif
            </div>
        </div>
@endsection
