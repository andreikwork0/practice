@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection
@section('content')

        <div class="container">

            <div class=" border-bottom d-flex align-content-center justify-content-between pb-3 mb-5">
                <h1 class="font-weight-bold ">Редактировать организацию</h1>
                <a href="{{route('companies.index')}}" class="btn btn-outline-primary h-30">Все организации</a>
            </div>

            <form action="{{route('companies.update', $company->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Организация">
                            <x-form.input
                                required
                                dfvalue="{{$company->id}}"
                                label="ID"
                                name="id"/>

                            <x-form.input
                                required
                                dfvalue="{{$company->name}}"
                                label="Название"
                                name="name"/>

                            <x-form.input
                                required
                                dfvalue="{{$company->legal_adress}}"
                                label="Юридический адресс"
                                name="legal_adress"/>
                        </x-form.fieldgroup>
                    </div>
                    <div class="col-md-6">
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
                        </x-form.fieldgroup>

                    </div>
                </div>

                <x-form.fieldgroup title="Реквизиты">
                    <div class="row" >
                        <div class="col-md-6">
                            <x-form.input
                                required
                                dfvalue="{{$company->inn}}"
                                label="ИНН"
                                name="inn"/>

                            <x-form.input
                                required
                                dfvalue="{{$company->kpp}}"
                                label="КПП"
                                name="kpp"/>

                            <x-form.input
                                required
                                dfvalue="{{$company->bik}}"
                                name="bik"
                                label="БИК" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input
                                required
                                dfvalue="{{$company->ch_account}}"
                                name="ch_account"
                                label="Расчетный счет" />

                            <x-form.input
                                required
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
