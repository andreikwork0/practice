@extends('layouts/app')

@section('title-block')  Доп соглашение № {{$convention->number}} к договору {{$convention->agreement->num_agreement}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Доп соглашение № {{$convention->number}} к договору {{$convention->agreement->num_agreement}}
            <div>
                <a href="{{route('companies.show', ["company" => $convention->company->id, "agr" => $convention->agreement->id])}}"
                   class="btn btn-outline-primary px-5">
                    &larr; Назад
                </a>
            </div>
        </div>
    </x-page-title>
@endsection

@section('content')



    <div class="container">
        <h3>Организация {{$convention->company->name}}</h3>

        <div class="d-flex my-3">
            @if($convention->path)
                <a class="p-2 mx-1" >
                    <form action="{{route('conventions.download', $convention->id)}}" method="post">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent"> @svg('download', 'w-30 h-6 text-dark icon-index') Скачать прикрепленный файл </button>
                    </form>
                </a>
            @endif

                <a class="p-2 mx-1" >
                    <form action="{{route('conventions.generate', $convention->id)}}" method="post">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent">@svg('file-earmark-arrow-down', 'w-30 h-6 text-dark icon-index')
                            Сгенерировать доп соглашение
                        </button>
                    </form>
                </a>
        </div>

        <form action="{{route('conventions.update.def', $convention->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-7">
                    <x-form.fieldgroup title="Общая информация">

                        Тип соглашения:   {{$convention->type->name}}

                        <x-form.checkbox
                            label="Действующее"
                            dfvalue="{{$convention->is_actual}}"
                            name="is_actual"/>




                        <x-form.input
                            type="file"
                            label="Файл"
                            name="convention_f"/>

                        <button type="submit" class="btn btn-primary">Сохранить</button>
                     </x-form.fieldgroup>
                </div>
            </div>

        </form>
    </div>

    <div class="container">
        @yield('c_type')
    </div>


@endsection

