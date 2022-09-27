@extends('layouts/app')

@section('title-block') Пользователи @endsection

@section('page-title')
    <x-page-title>Все пользователи</x-page-title>
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <div class="input-group  w-50">
                <form method="GET" action="{{route('users.index')}}" class="w-100">
                    <div class="d-flex">
                        <input
                            name="search"
                            value="{{request('search')}}"
                            width="400px"
                            type="text" class="form-control" placeholder="Поиск ...">
                        <button class="btn btn-primary " type="submit">
                            @svg('search', 'w-16 h-16 text-white')</button>
                        @if(request('search'))
                            <a href="{{route('users.index')}}"  class="btn btn-outline-danger mx-3"> Сбросить</a>
                        @endif
                    </div>

                </form>
            </div>
        </div>
        @if(count($users)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Логин</th>
                <th scope="col">Имя пользователя</th>
                <th scope="col">ФИО</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->name}}</td>
                    <td>   {{$user->sname ?? ''}} {{$user->fname}}  {{$user->mname ?? ''}}</td>
                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a  class="p-2 mx-1" href="{{route('users.edit', $user->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <x-modal-delete-btn
                                text="Пользователь {{$user->name}} будет удален"
                                url="{{route('users.destroy', $user->id)}}"
                            />
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="my-4">
            {{$users->links()}}
        </div>
        @elseif(request('search'))
            <h2>Ничего не найдeно</h2>
            <h3>Условие поиска : {{request('search')}}</h3>
            <p>Нет записей соответствующим условиям поиска. Попробуйте изменить условие поиска</p>
        @else
       <h2>Нет Пользователей</h2>
        @endif
    </div>
@endsection

