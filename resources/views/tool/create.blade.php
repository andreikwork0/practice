@extends('layouts/app')
@section('title-block') Добавить средство обучения @endsection

@section('page-title')
    <x-page-title>Добавить средство обучения</x-page-title>
@endsection

@section('content')

    <div class="container">

        <form action="{{route('tools.store')}}" method="post">
            @csrf
            <div class="row">

                <div class="col-md-7">
                    <x-form.fieldgroup title="Средство">

                        <x-form.input
                            required
                            label="Название"
                            name="name"/>

                        <x-form.select
                            :options=$t_categories
                            name="t_category_id"
                            label="Категория"
                        />
                    </x-form.fieldgroup>


                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>

        </div>
    @endsection

