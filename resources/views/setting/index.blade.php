@extends('layouts/app')

@section('title-block') Настройки @endsection

@section('page-title')
    <x-page-title>Все Настройки</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <a href="{{route('settings.create')}}"  class="btn btn-primary"> Добавить новую</a>
        </div>
        @if(count($settings)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID
                </th>
                <th scope="col">Название</th>
                <th scope="col">Значение</th>
                <th scope="col">Slug</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($settings as $setting)
                <tr>
                    <td>{{$setting->id}}</td>
                    <td>{{$setting->title}}</td>
                    <td>
                        {{$setting->name}}
                    </td>
                    <td>{{$setting->slug}}</td>
                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a  class="p-2 mx-1" href="{{route('settings.edit', $setting->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <x-modal-delete-btn
                                text="Настройка {{$setting->name}} будет удалена"
                                url="{{route('settings.destroy', $setting->id)}}"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="my-4">
            {{$settings->links()}}
        </div>

        @else
       <h2>Нет Настроек</h2>
        <p>
            Еще не добавлено ни одной настройки.
        </p>
        <p>
            Добавьте новую  <a href="{{route('settings.create')}}"  class="btn btn-primary"> Добавить новую</a>
        </p>
        @endif
    </div>
@endsection

