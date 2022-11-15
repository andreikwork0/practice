@extends('layouts/app')
@section('title-block') Редактировать настройку @endsection

@section('page-title')
    <x-page-title>Редактировать настройку</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('settings.update', $setting->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-md-7">
                    <x-form.fieldgroup title="Настройка">

                        <x-form.input
                            required
                            label="Заголовок"
                            dfvalue="{!! $setting->title !!}"
                            name="title"/>


                        <x-form.input
                            disabled=""
                            label="Slug"
                            dfvalue="{{$setting->slug}}"
                            name="slug"/>

                        <x-form.input
                            required
                            label="Значение"
                            dfvalue="{!! $setting->name !!}"
                            name="name"/>
                    </x-form.fieldgroup>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>

    </div>
@endsection

