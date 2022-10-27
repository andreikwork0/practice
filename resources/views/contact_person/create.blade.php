@extends('layouts/app')
@section('title-block') Добавить контакт @endsection

@section('page-title')
    <x-page-title>Добавить контакт для {{$company->name}}</x-page-title>
@endsection

@section('content')

    <div class="container">
        <form action="{{route('contact_people.store', $company->id)}}" method="post"  >
            @csrf
            <div class="row">
                    <div class="col-md-6">
                        <x-form.fieldgroup title="ФИО">
                            <x-form.input
                                required
                                label="Фамилия"
                                name="prs_lname"/>
                            <x-form.input
                                required
                                label="Имя"
                                name="prs_fname"/>

                            <x-form.input
                                label="Отчество"
                                name="prs_sname"/>
                        </x-form.fieldgroup>

                        <x-form.fieldgroup title="Контакты">
                            <x-form.input
                                label="Телефон"
                                name="phone"/>
                            <x-form.input
                                type="email"
                                label="Email"
                                name="email"/>


                        </x-form.fieldgroup>
                    </div>
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Организация">
                            <x-form.input
                                required
                                label="Ответственность"
                                name="prs_rule"/>

                            <x-form.input
                                required
                                label="Должность"
                                name="prs_job"/>

                            <x-form.input
                                label="Подразделение"
                                name="prs_office"/>

                            <x-form.checkbox
                                label="Есть в списке согласования ?"
                                name="is_negotiation"/>

                        </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    @endsection

