@extends('layouts/app')
@section('title-block') Добавить организацию @endsection

@section('page-title')
    <x-page-title>Добавить организацию</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('companies.store')}}" method="post">
            @csrf
            <div class="row">

                <input id="comp_helper"   class="form-control my-3" type="text" placeholder="Поиск  ... " />



                <div class="col-md-7">
                    <x-form.fieldgroup title="Организация">
                        <x-form.input
                            required
                            label="Название"
                            name="name"/>

                        <x-form.input
                            label="Полное название"
                            name="name_full"/>

                        <x-form.input
                            required
                            label="Юридический адрес"
                            name="legal_adress"/>

                        <x-form.input
                            label="Фактический  адрес"
                            name="fact_adress"/>

                        <x-form.select
                            :options=$companies
                            name="parent_id"
                            label="Центральная организация"
                        />



                        <x-form.input
                            label="Телефон"
                            name="phone"/>

                        <x-form.input
                            type="email"
                            label="Email"
                            name="email"/>

                        <x-form.select
                            :options=$countries
                            name="country_id"
                            required
                            dfvalue="185"
                            label="Страна"
                        />

                    </x-form.fieldgroup>
                    </div>
                    <div class="col-md-5">
                        <x-form.fieldgroup title="Руководитель">
                            <x-form.input
                                required
                                label="Фамилия"
                                name="mng_surname"/>

                            <x-form.input
                                required
                                label="Имя"
                                name="mng_name"/>
                            <x-form.input
                                label="Отчество"
                                name="mng_patronymic"/>

                            <x-form.input
                                dfvalue="директор"
                                label="Пост"
                                name="mng_job"/>

                            <x-form.input
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
                                label="ИНН"
                                name="inn"/>

                            <x-form.input
                                type="number"
                                label="КПП"
                                name="kpp"/>

                            <x-form.input
                                type="number"
                                name="bik"
                                label="БИК" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input
                                type="number"
                                name="ch_account"
                                label="Расчетный счет" />

                            <x-form.input
                                type="number"
                                name="cr_account"
                                label="К/С" />

                        </div>
                    </div>
                </x-form.fieldgroup>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>

        </div>
    @endsection

