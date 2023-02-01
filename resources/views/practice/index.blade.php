@extends('layouts/app')

@section('title-block') Практики @endsection

@section('page-title')
    <x-page-title>Все практики</x-page-title>
@endsection

@section('content')
    <div class="container">



{{--        window.$vm.data.options = [--}}
{{--        {--}}
{{--        id: '1',--}}
{{--        label: 'Институт х',--}}
{{--        children: [{--}}
{{--        id: '2',--}}
{{--        label: 'Кафедра н'--}}

{{--        }]--}}

{{--        }--}}
{{--        ]--}}
{{--        window.$vm.data.value = null--}}
{{--        не сбросилось--}}
{{--        <input type="hidden" name="organization_id" value="6">--}}

{{--        <div class="result">@{{ value }}</div>--}}
{{--        <treeselect v-model="value" :multiple="false" :options="options"   :show-count="false">--}}
{{--                <label slot="option-label" slot-scope="{ node, shouldShowCount, count, labelClassName, countClassName }" :class="labelClassName">--}}
{{--                    @{{ node.label }} - Description: @{{ node.raw.desc }}--}}
{{--                </label>--}}
{{--        </treeselect>--}}
{{--        <label slot="option-label" slot-scope="{ node, shouldShowCount, count, labelClassName, countClassName }" :class="labelClassName">--}}
{{--            @{{ node.label }} - Description: @{{ node.raw.desc }}--}}
{{--        </label>--}}


        @php
            $setting = \App\Models\Setting::key_val();
        @endphp

        @if($setting['is_dist_pr'] == 0)
            <div class="alert alert-danger">
                <h2>В данный момент подача заявок остановлена</h2>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <x-form.fieldgroup title="Фильтр">
                <form action="{{route('practices.index')}}" method="get">
                    <div class="row">
                        @roleis('umu')
                        <div class="col-md-6">
                            <x-form.select
                                :options=$ed_types
                                ids="education_type_id"
                                dfvalue="{{request('ed_type')}}"
                                name="ed_type"
                                label="Тип"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-form.select
                                :options=$pulpits
                                name="pulpit"
                                ids="pulpit_id"
                                dfvalue="{{request('pulpit')}}"
                                label="Кафедра"
                            />
                        </div>
                        @endroleis('umu')
                        <div class="col-md-6">

                            <x-form.select
                                :options=$semesters
                                dfvalue="{{request('semester')}}"
                                name="semester"
                                label="Семестр"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-form.select
                                :options=$courses
                                dfvalue="{{request('course')}}"
                                name="course"
                                label="Курс"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-form.select
                                :options=$pr_states
                                dfvalue="{{request('pr_state') ?? 'n'}}"
                                name="pr_state"
                                label="Статус"
                            />
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button type="submit" class="btn btn-primary">Применить</button>

                        @if(request('ed_type') ||  request('pulpit') || request('semester') || request('course')  || request('pr_state'))
                            <a href="{{route('practices.index')}}"  class="btn btn-outline-danger mx-3"> Сбросить</a>
                            <a href="{{request()->fullUrl()}}"  class="btn btn-outline-success mx-3"> Обновить</a>
                        @endif
                    </div>
                </form>
                </x-form.fieldgroup>
            </div>
        </div>




        @if(count($practices)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
{{--                <th scope="col">ID</th>--}}
                <th style="width: 50%" scope="col">Название</th>
                <th scope="col">Группа</th>

                <th scope="col">Начало</th>
                <th scope="col">Окончание</th>

                <th scope="col">Курс</th>
                <th scope="col">Семестр</th>
{{--                <th scope="col">Дней</th>--}}
{{--                <th scope="col">Недель</th>--}}
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($practices as $practice)
                <tr>
{{--                    <td>{{$practice->id}}</td>--}}
                    <td style="width: 50%">{{$practice->name}}</td>
                    <td>{{$practice->agroup}}</td>

                    <td>{{$practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '-'}}</td>
                    <td>{{$practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '-'}}</td>

                    <td>{{$practice->course }}</td>
                    <td>{{$practice->semester }}</td>

{{--                    <td>{{$practice->day ?? '-' }}</td>--}}
{{--                    <td>{{$practice->week ?? '-' }}</td>--}}

                    <td class="">
                        <div class="d-flex justify-content-end">

                            @if($practice->date_start)
                                <a class="p-2 mx-1" target="_blank"  href="{{route('pr_teacher.list', $practice->id)}}">@svg('people-fill', 'w-30 h-6 text-dark icon-index')</a>
                            @endif
                            @if($practice->date_start)
                              <a class="p-2 mx-1" target="_blank"  href="{{route('practices.show', $practice->id)}}">@svg('eye', 'w-30 h-6 text-dark icon-index')</a>
                            @endif
                            <a  target="_blank" class="p-2 mx-1" href="{{route('practices.edit', $practice->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
{{--                            <x-modal-delete-btn--}}
{{--                                text="Практика {{$practice->name}} будет удалена"--}}
{{--                                url="{{route('practices.destroy', $practice->id)}}"--}}
{{--                            />--}}
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="my-4">
            {{$practices->links()}}
        </div>

        @else
       <h2>Нет Практик</h2>
        <p>
           Нет практик  соответствующим вашим условиям поиска
        </p>
        @endif
    </div>
@endsection

