@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Редактировать организацию
        </div>
    </x-page-title>
@endsection

@section('content')

        <div class="container">


            <form action="{{route('companies.update', $company->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-7">
                        <x-form.fieldgroup title="Организация">
                            <x-form.input
                                required
                                disabled
                                dfvalue="{{$company->id}}"
                                label="ID"
                                name="id"/>

                            <x-form.input
                                required
                                dfvalue="{!! $company->name !!}"
                                label="Название"
                                name="name"/>


                            <x-form.input
                                dfvalue="{!! $company->name_full !!}"
                                label="Полное название"
                                name="name_full"/>

                            <x-form.input
                                required
                                dfvalue="{{$company->legal_adress}}"
                                label="Юридический адрес"
                                name="legal_adress"/>

                            <x-form.input
                                dfvalue="{{$company->fact_adress}}"
                                label="Фактический  адрес"
                                name="fact_adress"/>

                            <x-form.input
                                dfvalue="{{$company->phone}}"
                                label="Телефон"
                                name="phone"/>

                            <x-form.input
                                type="email"
                                dfvalue="{{$company->email}}"
                                label="Email"
                                name="email"/>


                            <x-form.select
                                :options=$companies
                                dfvalue="{{$company->parent_id}}"
                                name="parent_id"
                                label="Центральная организация"
                            />

                            <x-form.select
                                :options=$countries
                                name="country_id"
                                required
                                dfvalue="{{$company->country_id}}"
                                label="Страна"
                            />

                            <x-form.input
                                dfvalue="{{$company->org_structure_version}}"
                                label="Версия орг структуры"
                                disabled
                                name="org_structure_version"/>
                        </x-form.fieldgroup>
                    </div>
                    <div class="col-md-5">
                        <x-form.fieldgroup title="Руководитель">

                            <x-form.input
                                required
                                dfvalue="{{$company->mng_surname}}"
                                label="Фамилия"
                                name="mng_surname"/>

                            <x-form.input
                                required
                                dfvalue="{{$company->mng_name}}"
                                label="Имя"
                                name="mng_name"/>
                            <x-form.input
                                dfvalue="{{$company->mng_patronymic}}"
                                label="Отчество"
                                name="mng_patronymic"/>

                            <x-form.input
                                dfvalue="{{$company->mng_job}}"
                                label="Пост"
                                name="mng_job"/>

                            <x-form.input
                                dfvalue="{{$company->mng_reason}}"
                                label="Действует на основании"
                                name="mng_reason"/>
                        </x-form.fieldgroup>

                    </div>
                </div>

                <x-form.fieldgroup title="Реквизиты">
                    <div class="row" >
                        <div class="col-md-6">
                            <x-form.input
                                type="number"
                                dfvalue="{{$company->inn}}"
                                label="ИНН"
                                name="inn"/>

                            <x-form.input
                                type="number"
                                dfvalue="{{$company->kpp}}"
                                label="КПП"
                                name="kpp"/>

                            <x-form.input
                                type="number"
                                dfvalue="{{$company->bik}}"
                                name="bik"
                                label="БИК" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input
                                type="number"
                                dfvalue="{{$company->ch_account}}"
                                name="ch_account"
                                label="Расчетный счет" />

                            <x-form.input
                                type="number"
                                dfvalue="{{$company->cr_account}}"
                                name="cr_account"
                                label="К/С" />

                        </div>
                    </div>
                </x-form.fieldgroup>


                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

    </div>
@endsection

