@extends('layouts/app')

@section('title-block') Средства обучения @endsection

@section('page-title')
    <x-page-title>Все Средства обучения</x-page-title>
@endsection

@section('content')
    <div class="container">


        <div class="d-flex justify-content-between  mb-3">

            <div class="input-group  w-50">
                <form method="GET" action="{{route('tools.index')}}" class="w-100">
                    <div class="d-flex">
                        <input
                            name="search"
                            value="{{request('search')}}"
                            width="400px"
                            type="text" class="form-control" placeholder="Поиск ...">
                        <button class="btn btn-primary " type="submit">
                            @svg('search', 'w-16 h-16 text-white')</button>

                        @if(request('search') )
                            <a href="{{route('tools.index')}}"  class="btn btn-danger mx-3"> Сбросить</a>
                        @endif
                    </div>

                </form>
            </div>
            <div class="d-flex">
                <div class="mx-3"><a href="{{route('tools.create')}}"  target="_blank" class="btn btn-primary"> Добавить новое</a></div>
                <div><a href="{{route('tools.export')}}"  class="btn btn-outline-primary"> Export в excel</a></div>
            </div>


        </div>
        @if(count($tools)>0)
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID
                </th>
                <th scope="col">Название</th>

                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tools as $tool)
                <tr>
                    <td>{{$tool->id}}</td>
                    <td>{{$tool->name}}</td>
                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a  class="p-2 mx-1" target="_blank" href="{{route('tools.edit', $tool->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <x-modal-delete-btn
                                text="Средство {{$tool->name}} будет удалено"
                                url="{{route('tools.destroy', $tool->id)}}"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="my-4">
            {{$tools->links()}}
        </div>
        @elseif(request('search'))
            <h2>Ничего не найдно</h2>
            <h3>Условие поиска : {{request('search')}}</h3>
            <p>Нет средств соответствующих условиям поиска. Попробуйте изменить условие поиска</p>
        @else
       <h2>Нет Средст обучения</h2>
        <p>
            Еще не добавлено ни одного средства.
        </p>
        <p>
            Добавьте новое  <a target="_blank" href="{{route('tools.create')}}"  class="btn btn-primary"> Добавить новое</a>
        </p>
        @endif
    </div>
@endsection

