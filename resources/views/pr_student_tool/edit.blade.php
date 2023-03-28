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
            <div class="row">
                @if ($students->count() > 0)
                    <div class="col-12" >
                        <form action="{{route('pr_student_tool.update', $practice->id)}}" method="post">
                            @method('POST')
                            @csrf
                        <table class="table  border table-striped mx-y-input-0">
                            <thead style="position: sticky; top: 0; z-index: 10000" class="table-dark">
                            <tr>
                                <th  scope="col">ФИО студента</th>
                                <th scope="col" class="text-center">Организация</th>
                                <th scope="col" class="text-center">Средства</th>
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
                                        {{$pr_student->company_name}}
                                    </td>
                                    <td>


                                        <x-form.selectmulti
                                            :options=$tools
                                            name="pr_students[{{$pr_student->id}}][tool_ar][]"
                                            multiple="multiple"
                                            :dfvalue="$pr_student->tool_arr"
                                            ids="pr_students-{{$pr_student->id}}"
                                            required
                                            label=""/>
                                    </td>

                                    <td></td>
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
