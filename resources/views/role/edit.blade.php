@extends('layouts/app')

@section('title-block') Роль {{ $role->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Редактировать роль
        </div>
    </x-page-title>
@endsection
@section('content')
        <div class="container">
            <form action="{{route('roles.update', $role->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-7">
                        <x-form.fieldgroup title="Роль">
                            <x-form.input
                                required
                                disabled
                                dfvalue="{{$role->id}}"
                                label="ID"
                                name="id"/>
                            <x-form.input
                                required
                                dfvalue="{{$role->name}}"
                                label="Название"
                                name="name"/>
                        </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

    </div>
@endsection

