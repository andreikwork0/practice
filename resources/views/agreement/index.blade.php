@extends('layouts/app')

@section('title-block') Договоры @endsection

@section('page-title')
    <x-page-title>Все договоры</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <div class="input-group  w-50">
                <input type="text" class="form-control" placeholder="Поиск ...">
                <button class="btn btn-primary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @svg('search', 'w-16 h-16 text-white')</button>
            </div>
            <a href="{{route('agreements.create')}}"  class="btn btn-primary"> Добавить новый</a>
        </div>
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Организация</th>
                <th scope="col">Номер</th>
                <th scope="col">Дата договора</th>
                <th scope="col">Начало действие</th>
                <th scope="col">Окончание действия</th>
                <th scope="col">Актуальный</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($agreements as $agreement)
                <tr>
                    <td>{{$agreement->id}}</td>
                    <td>{{$agreement->company->name}}</td>
                    <td>{{$agreement->num_agreement}} </td>

                    <td>{{$agreement->date_agreement}}</td>
                    <td>{{$agreement->date_bg}}</td>
                    <td>{{$agreement->date_end}}</td>

                    <td>{{$agreement->is_actual}}</td>

                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a class="p-2 mx-1"  href="{{route('agreements.show', $agreement->id)}}">@svg('eye', 'w-30 h-6 text-dark icon-index')</a>
                            <a  class="p-2 mx-1" href="{{route('agreements.edit', $agreement->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <a class="p-2 mx-1"   >
                                <form action="{{route('agreements.destroy', $agreement->id)}}" method="post">
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
            {{$agreements->links()}}
        </div>

    </div>
@endsection

