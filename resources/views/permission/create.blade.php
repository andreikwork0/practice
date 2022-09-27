@extends('layouts/app')
@section('title-block') Добавить разрешение @endsection

@section('page-title')
    <x-page-title>Добавить разрешение</x-page-title>
@endsection

@section('content')
    <div class="container">
        <form action="{{route('permissions.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <x-form.fieldgroup title="Разрешение">
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

