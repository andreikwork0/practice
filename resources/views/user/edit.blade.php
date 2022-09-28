@extends('layouts/app')

@section('title-block') Пользователь {{ $user->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Редактировать пользователя
        </div>
    </x-page-title>
@endsection

@section('content')
        <div class="container">
            <form action="{{route('users.update', $user->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Пользователь">
                            <x-form.input

                                disabled
                                dfvalue="{{$user->id}}"
                                label="ID"
                                name="id"/>
                            <x-form.input

                                dfvalue="{{$user->name}}"
                                label="Имя пользователя"
                                name="name"/>

                            <x-form.input

                                dfvalue="{{$user->lname}}"
                                label="Фамилия"
                                name="lname"/>

                            <x-form.input

                                dfvalue="{{$user->fname}}"
                                label="Имя"
                                name="fname"/>

                            <x-form.input
                                dfvalue="{{$user->mname}}"
                                label="Отчество"
                                name="mname"/>
                        </x-form.fieldgroup>
                    </div>
                    <div class="col-md-6">
                        <x-form.fieldgroup title="Организация">

                            <x-form.input

                                dfvalue="{{$user->username}}"
                                label="Логин"
                                name="username"/>
                            <x-form.input

                                dfvalue="{{$user->domain}}"
                                label="Домен"
                                name="domain"/>

                            <x-form.select
                                :options=$roles
                                dfvalue="{{$user->role_id}}"
                                name="role_id"
                                label="Роль"
                            />


                            <x-form.select
                                :options=$ed_types
                                dfvalue="{{$user->education_type_id}}"
                                name="education_type_id"
                                label="Тип"
                            />
                            <x-form.select
                                :options=$pulpits
                                name="pulpit_id"
                                dfvalue="{{$user->pulpit_id}}"
                                label="Кафедра"
                            />



                        </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

    </div>
@endsection

