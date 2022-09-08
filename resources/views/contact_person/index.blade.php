@extends('layouts/app')

@section('title-block') Контактные лица @endsection

@section('page-title')
    <x-page-title>Все контактные лица</x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between  mb-3">
            <div class="input-group  w-50">
                <input type="text" class="form-control" placeholder="Поиск ...">
                <button class="btn btn-primary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @svg('search', 'w-16 h-16 text-white')</button>
            </div>
            <a href="{{route('contact_people.create')}}"  class="btn btn-primary"> Добавить нового</a>

        </div>
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Организация</th>
                <th scope="col">ФИО</th>
                <th scope="col">Должность</th>
                <th scope="col">Подразделение</th>
                <th scope="col">Согласование</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($contact_people as $contact_person)
                <tr>
                    <td>{{$contact_person->id}}</td>
                    <td>{{$contact_person->company->name}}</td>
                    <td>{{$contact_person->prs_lname}} {{$contact_person->prs_fname}} {{$contact_person->prs_sname}}</td>
                    <td>{{$contact_person->prs_job}}</td>
                    <td>{{$contact_person->prs_office}}</td>
                    <td>{{$contact_person->is_negotiation}}</td>

                    <td class="">
                        <div class="d-flex justify-content-end">
                            <a class="p-2 mx-1"  href="{{route('contact_people.show', $contact_person->id)}}">@svg('eye', 'w-30 h-6 text-dark icon-index')</a>
                            <a  class="p-2 mx-1" href="{{route('contact_people.edit', $contact_person->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                            <a class="p-2 mx-1"   >
                                <form action="{{route('contact_people.destroy', $contact_person->id)}}" method="post">
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
            {{$contact_people->links()}}
        </div>

    </div>
@endsection

