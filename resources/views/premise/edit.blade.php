@extends('layouts/app')
@section('title-block') Редактировать помещение @endsection

@section('page-title')
    <x-page-title>Редактировать помещение - {{$pm->company->name}}</x-page-title>
@endsection

@section('content')

    <div class="container">
        <form action="{{route('premises.update', $pm->id)}}" method="post"  >
            @csrf
            @method('PUT')
            <div class="row">
                    <div class="col-md-9">
                        <x-form.fieldgroup title="Помещение">
                            <x-form.input
                                required
                                label="Название"
                                dfvalue="{{$pm->name}}"
                                name="name"/>
                        </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    @endsection

