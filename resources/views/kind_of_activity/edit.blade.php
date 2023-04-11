@extends('layouts/app')
@section('title-block') Редактировать вид деятельности  @endsection

@section('page-title')
    <x-page-title>Редактировать вид деятельности</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('kind_of_activities.update', $kind_of_activity->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-md-7">
                    <x-form.fieldgroup title="Вид деятельности">

                        <x-form.select
                            :options=$specs
                            name="spec_id"
                            required
                            dfvalue="{{$kind_of_activity->spec_id}}"
                            label="Специальность"
                        />


                        <x-form.textarea
                            required
                            label="Название"
                            name="name">{{$kind_of_activity->name}}</x-form.textarea>

                        <x-form.input
                            required
                            dfvalue="{{$kind_of_activity->code}}"
                            label="Код"
                            name="code"/>

                    </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </form>

        </div>
    @endsection

