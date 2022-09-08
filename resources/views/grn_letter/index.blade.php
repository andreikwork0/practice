@extends('layouts/app')

@section('title-block') Гарантийные письма @endsection

@section('page-title')
    <x-page-title>Все гарантийные письма</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <div class="input-group  w-50">
                <input type="text" class="form-control" placeholder="Поиск ...">
                <button class="btn btn-primary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @svg('search', 'w-16 h-16 text-white')</button>
            </div>
            <a href="{{route('grn_letters.create')}}"  class="btn btn-primary"> Добавить нового</a>

        </div>
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Организация</th>
                <th scope="col">Номер</th>
                <th scope="col">Дата</th>
                <th scope="col">Комментарий</th>

                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($grn_letters as $grn_letter)
                <tr>
                    <td>{{$grn_letter->id}}</td>
                    <td>{{$grn_letter->company->name}}</td>
                    <td>{{$grn_letter->num_letter}} </td>
                    <td>{{$grn_letter->date_letter}}</td>
                    <td>{{$grn_letter->note_letter}}</td>


                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a class="p-2 mx-1"  href="{{route('grn_letters.show', $grn_letter->id)}}">@svg('eye', 'w-30 h-6 text-dark icon-index')</a>
                            <a  class="p-2 mx-1" href="{{route('grn_letters.edit', $grn_letter->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <a class="p-2 mx-1"   >
                                <form action="{{route('grn_letters.destroy', $grn_letter->id)}}" method="post">
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
            {{$grn_letters->links()}}
        </div>

    </div>
@endsection

