@extends('layouts/app')

@section('title-block') Организации @endsection

@section('page-title')
    <x-page-title>Все организации</x-page-title>
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

                        @if(request('search') || request('dp_new'))
                            <a href="{{route('companies.index')}}"  class="btn btn-danger mx-3"> Сбросить</a>
                        @endif
                    </div>

                </form>
            </div>



            @if($dp_new_c)
                <a type="button" class="btn btn-outline-danger position-relative p-2 mx-3" href="{{route('companies.index', ['dp_new' => 'on'])}}" >
                    Входящие
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$dp_new_c}}
                        <span class="visually-hidden">новые заявки</span>
                  </span>

                </a>
            @endif

            <div>
                <a href="{{route('companies.create')}}"  class="btn btn-primary"> Добавить новую</a>
            </div>


            <div>
                <a href="{{route('agreements.export')}}" class="btn btn-outline-primary">Экспорт договоров в Excel</a>
            </div>



        </div>
        @if(count($companies)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">Название
                </th>
                <th scope="col">Юридический Адрес</th>
                <th scope="col">ИНН</th>
                <th scope="col">КПП</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>
                        {{$company->name}}
                    </td>
                    <td>{{$company->legal_adress}}</td>
                    <td>{{$company->inn}}</td>
                    <td>{{$company->kpp}}</td>

                    <td class="">
                        <div class="d-flex justify-content-end">

                            <a type="button" class="btn btn-outline-primary position-relative p-2 mx-3" href="{{route('companies.show', $company->id)}}">
                                Подробнее
                                @if($company->new_dp > 0 )
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{$company->new_dp}}
                                    <span class="visually-hidden">новые заявки</span>
                              </span>
                                @endif
                            </a>

                            <a  class="p-2 mx-1" href="{{route('companies.edit', $company->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <x-modal-delete-btn
                                text="Организация {{$company->name}} будет удалена"
                                url="{{route('companies.destroy', $company->id)}}"
                            />
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

