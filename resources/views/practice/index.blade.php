@extends('layouts/app')

@section('title-block') Практики @endsection

@section('page-title')
    <x-page-title>Все практики</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <div class="input-group  w-50">
                <form method="GET" action="{{route('companies.index')}}" class="w-100">
                    <div class="d-flex">
                        <input
                            name="search"
                            value="{{request('search')}}"
                            width="400px"
                            type="text" class="form-control" placeholder="Поиск ...">
                        <button class="btn btn-primary " type="submit">
                            @svg('search', 'w-16 h-16 text-white')</button>

                        @if(request('search'))
                            <a href="{{route('companies.index')}}"  class="btn btn-outline-danger mx-3"> Сбросить</a>
                        @endif
                    </div>

                </form>
            </div>
            <a href="{{route('companies.create')}}"  class="btn btn-primary"> Добавить новую</a>
        </div>
        @if(count($companies)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
{{--                <th scope="col">ID</th>--}}
                <th scope="col">Название</th>
                <th scope="col">Группа</th>
                <th scope="col">Контингент</th>
                <th scope="col">Дата с</th>
                <th scope="col">Дата по</th>
                <th scope="col">Дней</th>
                <th scope="col">Недель</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
{{--                    <td>{{$company->id}}</td>--}}
                    <td>{{$company->name}}</td>
                    <td>{{$company->legal_adress}}</td>
                    <td>{{$company->inn}}</td>
                    <td>{{$company->kpp}}</td>

                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a class="p-2 mx-1"  href="{{route('companies.show', $company->id)}}">@svg('eye', 'w-30 h-6 text-dark icon-index')</a>
                            <a  class="p-2 mx-1" href="{{route('companies.edit', $company->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <a class="p-2 mx-1"   >
                                <form action="{{route('companies.destroy', $company->id)}}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent"> @svg('trash3', 'w-6 h-6 text-dark icon-index') </button>
                                </form>

                            </a>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="my-4">
            {{$companies->links()}}
        </div>
        @elseif(request('search'))
            <h2>Ничего не найдно</h2>
            <h3>Условие поиска : {{request('search')}}</h3>
            <p>Нет организаций соответствующих условиям поиска. Попробуйте изменить условие поиска</p>
        @else
       <h2>Нет Организаций</h2>
        <p>
            Еще недобавлено ни одной организации.
        </p>
        <p>
            Добавьте новую  <a href="{{route('companies.create')}}"  class="btn btn-primary"> Добавить новую</a>
        </p>
        @endif
    </div>
@endsection

