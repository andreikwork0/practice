@extends('layouts/app')
@section('title-block') Добавить роль @endsection

@section('page-title')
    <x-page-title>Добавить роль</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('roles.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <x-form.fieldgroup title="Роль">
                        <x-form.input
                            required
                            label="Название"
                            name="name"/>
                        </x-form.fieldgroup>
                    <button type="submit" class="btn btn-primary">Создать</button>
                    </div>


            </div>
            </form>

        </div>
    @endsection

