@extends('layouts/app')
@section('title-block') Редактировать средство обучения @endsection

@section('page-title')
    <x-page-title>Редактировать средство обучения</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('tools.update', $tool->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-md-7">
                    <x-form.fieldgroup title="Средства">

                        <x-form.input
                            required
                            label="Название"
                            dfvalue="{!! $tool->name !!}"
                            name="name"/>

                    </x-form.fieldgroup>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>

    </div>
@endsection

