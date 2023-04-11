@extends('layouts/app')

@section('title-block') Виды деятельности @endsection

@section('page-title')
    <x-page-title>Все Виды деятельности </x-page-title>
@endsection

@section('content')
    <div class="container">


        <div class="d-flex justify-content-between  mb-3">

            <div class="input-group  w-50">
                <form method="GET" action="{{route('kind_of_activities.index')}}" class="w-100">
                    <div class="d-flex">
                        <input
                            name="search"
                            value="{{request('search')}}"
                            width="400px"
                            type="text" class="form-control" placeholder="Поиск ...">
                        <button class="btn btn-primary " type="submit">
                            @svg('search', 'w-16 h-16 text-white')</button>

                        @if(request('search') )
                            <a href="{{route('kind_of_activities.index')}}"  class="btn btn-danger mx-3"> Сбросить</a>
                        @endif
                    </div>

                </form>
            </div>
            <div class="d-flex">
                <div class="mx-3"><a href="{{route('kind_of_activities.create')}}"  target="_blank" class="btn btn-primary"> Добавить новое</a></div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-12">
                <x-form.fieldgroup title="Фильтр">
                    <form action="{{route('kind_of_activities.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.select
                                    :options=$specs
                                    dfvalue="{{request('spec_id')}}"
                                    name="spec_id"
                                    label="Специальность"
                                />
                            </div>
                        </div>
                        <div class="d-flex justify-content-center my-3">
                            <button type="submit" class="btn btn-primary">Применить</button>
                            @if(request('spec_id') )
                                <a href="{{route('kind_of_activities.index')}}"  class="btn btn-outline-danger mx-3"> Сбросить</a>
                                <a href="{{request()->fullUrl()}}"  class="btn btn-outline-success mx-3"> Обновить</a>
                            @endif
                        </div>
                    </form>
                </x-form.fieldgroup>
            </div>
        </div>
        @if(count($kind_of_activities)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID
                </th>
                <th scope="col">Специальность</th>
                <th scope="col">Код</th>
                <th scope="col">Название</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($kind_of_activities as $kind_of_activity)
                <tr>
                    <td>{{$kind_of_activity->id}}</td>
                    <td>{{$kind_of_activity->spec->full_name()}}</td>
                    <td>{{$kind_of_activity->code}}</td>
                    <td>{{ Str::limit($kind_of_activity->name, 125) }}</td>
                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a  class="p-2 mx-1" target="_blank" href="{{route('kind_of_activities.edit', $kind_of_activity->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="my-4">
            {{$kind_of_activities->links()}}
        </div>
        @elseif(request('search'))
            <h2>Ничего не найдно</h2>
            <h3>Условие поиска : {{request('search')}}</h3>
            <p>Нет средств соответствующих условиям поиска. Попробуйте изменить условие поиска</p>
        @else
       <h2>Нет Видов  деятельности</h2>
        <p>
            Еще не добавлено одного ни вида деятельности.
        </p>
        <p>
            Добавьте новое  <a target="_blank" href="{{route('kind_of_activities.create')}}"  class="btn btn-primary"> Добавить новое</a>
        </p>
        @endif
    </div>
@endsection

