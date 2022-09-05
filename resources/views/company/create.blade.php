@extends('layouts/app')

@section('title-block') Добавить организацию @endsection
@section('content')

    <div class="container">
        <h1 class="border-bottom  font-weight-bold pb-3 mb-5">Добавить организацию</h1>
        <form action="{{route('companies.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-form.fieldgroup title="Организация">
                        <x-form.input
                            required
                            label="Название"
                            name="name"/>
                        <x-form.input
                            required
                            label="Юридический адресс"
                            name="legal_adress"/>
                    </x-form.fieldgroup>
                </div>
                <div class="col-md-6">
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
                    </x-form.fieldgroup>
                </div>
            </div>
            <x-form.fieldgroup title="Реквизиты">
                <div class="row" >
                    <div class="col-md-6">
                        <x-form.input
                            required
                            label="ИНН"
                            name="inn"/>

                        <x-form.input
                            required
                            label="КПП"
                            name="kpp"/>

                        <x-form.input
                            required
                            name="bik"
                            label="БИК" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input
                            required
                            name="ch_account"
                            label="Расчетный счет" />

                        <x-form.input
                            required
                            name="cr_account"
                            label="К/С" />

                    </div>
                </div>
            </x-form.fieldgroup>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>

    </div>
@endsection

