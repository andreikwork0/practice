@extends('layouts/app')

@section('title-block') Роли @endsection

@section('page-title')
    <x-page-title>Все роли</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <a href="{{route('roles.create')}}"  class="btn btn-primary"> Добавить новую</a>
        </div>
        @if(count($roles)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>

                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>


                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a class="p-2 mx-1"  href="{{route('roles.show', $role->id)}}">@svg('eye', 'w-30 h-6 text-dark icon-index')</a>
                            <a  class="p-2 mx-1" href="{{route('roles.edit', $role->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <x-modal-delete-btn
                                text="Роль {{$role->name}} будет удалена"
                                url="{{route('roles.destroy', $role->id)}}"
                            />

                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="my-4">
            {{$roles->links()}}
        </div>
        @elseif(request('search'))
            <h2>Ничего не найдно</h2>
            <h3>Условие поиска : {{request('search')}}</h3>
            <p>Нет ролей соответствующих условиям поиска. Попробуйте изменить условие поиска</p>
        @else
       <h2>Нет ролей</h2>
        <p>
            Еще недобавлено ни одной роли.
        </p>
        <p>
            Добавьте новую  <a href="{{route('roles.create')}}"  class="btn btn-primary"> Добавить новую</a>
        </p>
        @endif
    </div>


@endsection

