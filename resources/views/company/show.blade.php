@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection

@section('page-title')
    <x-page-title> {{$company->name}}  </x-page-title>
@endsection

@section('content')

    <div class="container">

        <h2 class="mb-3">{{$company->name_full ?? ''}}</h2>

        <div class="d-flex">
            <p class="mx-3">ИНН:   {{$company->inn }}</p>
            <p class="mx-3">КПП:   {{$company->kpp }}</p>
        </div>

        <div class="d-flex">
            <p class="mx-3"> Руководитель:  {{$company->mng_surname ?? ''}}  {{$company->mng_name ?? ''}}  {{$company->mng_patronymic ?? ''}}</p>
            <p class="mx-3"> Юридический адрес: {{$company->legal_adress ?? '-'}} </p>
        </div>

        <div class="d-flex justify-content-between align-content-center mt-5 mb-3" >
            <h2 class="">Договора</h2>
            <div>
                <a href="{{route('agreements.create', $company->id) }}" class="btn btn-primary d-block">Добавить новый</a>
            </div>
        </div>

        <div>
            <table class="table  border table-striped">
                <thead>
                <tr>

                    <th scope="col">Название</th>
                    <th scope="col">Номер</th>
                    <th scope="col">Дата договора</th>
                    <th scope="col">Начало действие</th>
                    <th scope="col">Окончание действия</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Актуальный</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($company->agreements as $agreement)
                    <tr>


                        <td>{{$agreement->name}} </td>
                        <td>{{$agreement->num_agreement}} </td>

                        <td>{{$agreement->date_agreement}}</td>
                        <td>{{$agreement->date_bg}}</td>
                        <td>{{$agreement->date_end}}</td>
                        <td>{{$agreement->status->name}}</td>

                        <td>{{$agreement->is_actual}}</td>

                        <td class="">
                            <div class="d-flex justify-content-end">

                                <a data-bs-toggle="collapse"
                                   data-bs-target="#collapse_ag_{{$agreement->id}}"
                                   aria-expanded="false"
                                   aria-controls="collapse_ag_{{$agreement->id}}"
                                   class="p-2 mx-1"  href="{{route('agreements.show', $agreement->id)}}">@svg('three-dots', 'w-30 h-6 text-dark icon-index')</a>
                                <a class="p-2 mx-1"  href="{{route('agreements.show', $agreement->id)}}">@svg('download', 'w-30 h-6 text-dark icon-index')</a>
                                <a class="p-2 mx-1"  href="{{route('agreements.show', $agreement->id)}}">@svg('file-earmark-arrow-down', 'w-30 h-6 text-dark icon-index')</a>
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
                    <tr   class="collapse " id="collapse_ag_{{$agreement->id}}">
                        <td>
                            <ul>
                                <li>Доп соглашение 1</li>
                                <li>Доп соглашение 2</li>
                                <li>Доп соглашение 3</li>
                                <li>Доп соглашение 4</li>
                                <li>Доп соглашение 5</li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>



{{--        <p>--}}
{{--            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">--}}
{{--                Toggle width collapse--}}
{{--            </button>--}}
{{--        </p>--}}
{{--        <div style="min-height: 120px;">--}}

{{--        </div>--}}
    </div>




@endsection

