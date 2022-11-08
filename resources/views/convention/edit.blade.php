@extends('layouts/app')

@section('title-block')  Доп соглашение № X к договору Y  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Доп соглашение № X к договору Y
        </div>
    </x-page-title>
@endsection

@section('content')

    <div class="container">
        форма с общая для всех дс-й

{{--        <form action="{{route('companies.update', $company->id)}}" method="post">--}}
{{--            @csrf--}}
{{--            @method('PUT')--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-7">--}}
{{--                    <x-form.fieldgroup title="Организация">--}}
{{--                        <x-form.input--}}
{{--                            required--}}
{{--                            disabled--}}
{{--                            dfvalue="{{$company->id}}"--}}
{{--                            label="ID"--}}
{{--                            name="id"/>--}}

{{--                        <x-form.input--}}
{{--                            required--}}
{{--                            dfvalue="{!! $company->name !!}"--}}
{{--                            label="Название"--}}
{{--                            name="name"/>--}}


{{--                        <x-form.input--}}
{{--                            dfvalue="{!! $company->name_full !!}"--}}
{{--                            label="Полное название"--}}
{{--                            name="name_full"/>--}}

{{--                        <x-form.input--}}
{{--                            required--}}
{{--                            dfvalue="{{$company->legal_adress}}"--}}
{{--                            label="Юридический адрес"--}}
{{--                            name="legal_adress"/>--}}

{{--                        <x-form.input--}}
{{--                            dfvalue="{{$company->fact_adress}}"--}}
{{--                            label="Фактический  адрес"--}}
{{--                            name="fact_adress"/>--}}

{{--                        <x-form.input--}}
{{--                            dfvalue="{{$company->phone}}"--}}
{{--                            label="Телефон"--}}
{{--                            name="phone"/>--}}

{{--                        <x-form.input--}}
{{--                            type="email"--}}
{{--                            dfvalue="{{$company->email}}"--}}
{{--                            label="Email"--}}
{{--                            name="email"/>--}}


{{--                        <x-form.select--}}
{{--                            :options=$companies--}}
{{--                            dfvalue="{{$company->parent_id}}"--}}
{{--                            name="parent_id"--}}
{{--                            label="Центральная организация"--}}
{{--                        />--}}

{{--                        <x-form.select--}}
{{--                            :options=$countries--}}
{{--                            name="country_id"--}}
{{--                            required--}}
{{--                            dfvalue="{{$company->country_id}}"--}}
{{--                            label="Страна"--}}
{{--                        />--}}
{{--                    </x-form.fieldgroup>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <button type="submit" class="btn btn-primary">Сохранить</button>--}}
{{--        </form>--}}
    </div>

    <div class="container">
        @yield('c_type')
    </div>


@endsection

