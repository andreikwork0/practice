@extends('layouts/app')

@section('title-block') Организации @endsection

@section('page-title')
    <x-page-title>Все организации</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <div class="input-group  w-50">
                <input type="text" class="form-control" placeholder="Поиск ...">
                <button class="btn btn-primary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @svg('search', 'w-16 h-16 text-white')</button>
            </div>
            <a href="{{route('companies.create')}}"  class="btn btn-primary"> Добавить новую  </a>

        </div>
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Адрес</th>
                <th scope="col">ИНН</th>
                <th scope="col">КПП</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{$company->id}}</td>
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

    </div>
@endsection

