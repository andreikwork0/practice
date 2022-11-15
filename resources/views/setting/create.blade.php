@extends('layouts/app')
@section('title-block') Добавить настройку @endsection

@section('page-title')
    <x-page-title>Добавить настройку</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('settings.store')}}" method="post">
            @csrf
            <div class="row">

                <div class="col-md-7">
                    <x-form.fieldgroup title="Настройка">

                        <x-form.input
                            required
                            label="Заголовок"
                            name="title"/>
                        <x-form.input
                            required
                            label="Slug"
                            name="slug"/>

                        <x-form.input
                            required
                            label="Значение"
                            name="name"/>

                    </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>

        </div>
    @endsection

