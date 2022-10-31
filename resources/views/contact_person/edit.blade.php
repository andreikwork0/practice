@extends('layouts/app')
@section('title-block') Редактировать контакт @endsection

@section('page-title')
    <x-page-title>Редактировать контакт - {{$cp->company->name}}</x-page-title>
@endsection

@section('content')

    <div class="container">
        <form action="{{route('contact_people.update', $cp->id)}}" method="post"  >
            @csrf
            @method('PUT')
            <div class="row">
                    <div class="col-md-6">
                        <x-form.fieldgroup title="ФИО">
                            <x-form.input
                                required
                                label="Фамилия"
                                dfvalue="{{$cp->prs_lname}}"
                                name="prs_lname"/>
                            <x-form.input
                                required
                                label="Имя"
                                dfvalue="{{$cp->prs_fname}}"
                                name="prs_fname"/>

                            <x-form.input
                                label="Отчество"
                                dfvalue="{{$cp->prs_sname}}"
                                name="prs_sname"/>
                        </x-form.fieldgroup>

                        <x-form.fieldgroup title="Контакты">
                            <x-form.input
                                label="Телефон"
                                dfvalue="{{$cp->phone}}"
                                name="phone"/>
                            <x-form.input
                                type="email"
                                label="Email"
                                dfvalue="{{$cp->email}}"
                                name="email"/>


                        </x-form.fieldgroup>
                    </div>
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Организация">
                            <x-form.input
                                required
                                dfvalue="{{$cp->prs_rule}}"
                                label="Ответственность"
                                name="prs_rule"/>

                            <x-form.input
                                required
                                dfvalue="{{$cp->prs_job}}"
                                label="Должность"
                                name="prs_job"/>

                            <x-form.input
                                label="Подразделение"
                                dfvalue="{{$cp->prs_office}}"
                                name="prs_office"/>

                            <x-form.checkbox
                                label="Есть в списке согласования ?"
                                dfvalue="{{$cp->is_negotiation}}"
                                name="is_negotiation"/>

                        </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    @endsection

