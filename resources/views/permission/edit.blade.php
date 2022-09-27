@extends('layouts/app')

@section('title-block') Разрешение {{ $permission->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Редактировать разрешение
        </div>
    </x-page-title>
@endsection
@section('content')
        <div class="container">
            <form action="{{route('permissions.update', $permission->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-7">
                        <x-form.fieldgroup title="Разрешение">
                            <x-form.input
                                required
                                disabled
                                dfvalue="{{$permission->id}}"
                                label="ID"
                                name="id"/>
                            <x-form.input
                                required
                                dfvalue="{{$permission->name}}"
                                label="Название"
                                name="name"/>
                        </x-form.fieldgroup>
                    </div>
                </div>






                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
    </div>
@endsection

