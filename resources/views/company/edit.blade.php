@extends('layouts/app')

@section('title-block') Организации {{ $company->name}}  @endsection
@section('content')
    <div style="padding: 50px 0;">
        <div class="container">

            <form action="{{route('companies.update', $company->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3">Организация</h4>
                        <div class="border border-secondary p-3   mb-4">
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
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-3">Руководитель</h4>
                        <div class="border border-secondary p-3   mb-4">
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
                        </div>






                    </div>
                </div>
                <h4 class="mb-3">Реквизиты</h4>
                <div class="border border-secondary p-3   mb-4">
                    <div class="row ">

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
                </div>



                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

    </div>
@endsection

