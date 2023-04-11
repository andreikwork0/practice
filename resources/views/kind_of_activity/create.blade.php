@extends('layouts/app')
@section('title-block') Добавить вид деятельности  @endsection

@section('page-title')
    <x-page-title>Добавить вид деятельности</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('kind_of_activities.store')}}" method="post">
            @csrf
            <div class="row">

                <div class="col-md-7">
                    <x-form.fieldgroup title="Вид деятельности">

                        <x-form.select
                            :options=$specs
                            name="spec_id"
                            required
                            label="Специальность"
                        />


                        <x-form.textarea
                            required
                            label="Название"
                            name="name"/>

                        <x-form.input
                            required
                            label="Код"
                            name="code"/>

                    </x-form.fieldgroup>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>

        </div>
    @endsection

