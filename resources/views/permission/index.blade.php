@extends('layouts/app')

@section('title-block') Разрешения @endsection

@section('page-title')
    <x-page-title>Все Разрешения</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <a href="{{route('permissions.create')}}"  class="btn btn-primary"> Добавить </a>
        </div>
        @if(count($permissions)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{$permission->id}}</td>
                    <td>{{$permission->name}}</td>


                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a class="p-2 mx-1"  href="{{route('permissions.show', $permission->id)}}">@svg('eye', 'w-30 h-6 text-dark icon-index')</a>
                            <a  class="p-2 mx-1" href="{{route('permissions.edit', $permission->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <x-modal-delete-btn
                                text="Разрешение {{$permission->name}} будет удалено"
                                url="{{route('permissions.destroy', $permission->id)}}"
                            />

                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="my-4">
            {{$permissions->links()}}
        </div>
        @elseif(request('search'))
            <h2>Ничего не найдно</h2>
            <h3>Условие поиска : {{request('search')}}</h3>
            <p>Нет ролей соответствующих условиям поиска. Попробуйте изменить условие поиска</p>
        @else
       <h2>Нет разрешений</h2>
        <p>
            Еще недобавлено ни одного разрешения.
        </p>
        <p>
            Добавьте   <a href="{{route('permissions.create')}}"  class="btn btn-primary"> Добавить </a>
        </p>
        @endif
    </div>


@endsection

