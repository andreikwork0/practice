@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between">
            {{$company->name}}
            <div>
                <a class="btn btn-outline-secondary mr-3" href="{{route('companies.index')}}">Все организации</a>
                <a target="_blank" class="btn btn-outline-primary" href="{{route('companies.edit', $company->id)}}">Редактировать</a>
            </div>
        </div>

    </x-page-title>
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
            <h2 class="">Договоры</h2>
            <div>
                <a href="{{route('agreements.create', $company->id) }}" class="btn btn-primary d-block">Добавить новый</a>
            </div>
        </div>

        @if(count($company->agreements)>0)
        <div>
            <table class="table  border table-striped">
                <thead>
                <tr>


                    <th scope="col">Номер</th>
                    <th scope="col">Дата подписания</th>
                    <th scope="col">Начало действие</th>
                    <th scope="col">Окончание действия</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Действующий</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($company->agreements()->orderBy('id', 'desc')->get() as $agreement)
                    <tr>
                        <td>{{$agreement->num_agreement}} </td>
                        <td> {{$agreement->date_agreement ? date('d.m.Y', strtotime($agreement->date_agreement)) : '-'}}</td>
                        <td> {{$agreement->date_bg ? date('d.m.Y', strtotime($agreement->date_bg)) : '-'}}</td>
                        <td> {{$agreement->date_end ? date('d.m.Y', strtotime($agreement->date_end)) : '-'}}</td>
                        <td>{{$agreement->status->name}}</td>
                        <td>{{ $agreement->is_actual == 1 ? 'Да' : 'Нет'}}</td>
                        <td class="">
                            <div class="d-flex justify-content-end">
                                <a data-bs-toggle="collapse"
                                   data-bs-target="#collapse_ag_{{$agreement->id}}"
                                   aria-expanded="false"
                                   aria-controls="collapse_ag_{{$agreement->id}}"
                                   class="p-2 mx-1"  href="{{route('agreements.show', $agreement->id)}}">@svg('three-dots', 'w-30 h-6 text-dark icon-index')</a>

                                @if($agreement->path)
                                <a class="p-2 mx-1" >
                                    <form action="{{route('agreements.download', $agreement->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent"> @svg('download', 'w-30 h-6 text-dark icon-index') </button>
                                    </form>
                                </a>
                                @endif
                                <a class="p-2 mx-1" >
                                    <form action="{{route('agreements.generate', $agreement->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent">@svg('file-earmark-arrow-down', 'w-30 h-6 text-dark icon-index')</button>
                                    </form>

                                </a>
                                <a  class="p-2 mx-1" href="{{route('agreements.edit', $agreement->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>

                                <x-modal-delete-btn
                                    text="Договор № {{$agreement->num_agreement}} будет удален"
                                    url="{{route('agreements.destroy', $agreement->id)}}"
                                />

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
        @else
            <p>Упс ... с данной организацией еще не заключено ни одного договора. Нажмите добавить новый, чтобы создать новый договор.</p>
        @endif



{{--        <p>--}}
{{--            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">--}}
{{--                Toggle width collapse--}}
{{--            </button>--}}
{{--        </p>--}}
{{--        <div style="min-height: 120px;">--}}

{{--        </div>--}}
    </div>




@endsection

