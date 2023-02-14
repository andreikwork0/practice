@extends('layouts/app')

@section('title-block') Редактировать приказ  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Редактировать приказ № {{$order->num}}
            <div>
                 <a class="btn btn-outline-primary px-5" href="{{route('orders.index_one', $practice->id)}}"> &larr; Назад</a>
            </div>
        </div>
    </x-page-title>
@endsection

@section('content')
        <div class="container">
            <div class="d-flex align-content-center">
                <div >
                    Файл:  <span class="text-decoration-underline" > {{$order->file->name}}</span>
                </div>

                <form action="{{route('file.download', $order->file->id) }}" method="post" class="mx-3">
                    @csrf
                    <button  class="btn btn-primary">Скачать</button>
                </form>
            </div>


            <form action="{{route('orders.update',  $order->id)}}" class="mt-5" method="post"  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <x-form.fieldgroup title="Изменить приказ">
                            <x-form.input
                                required
                                label="Номер приказа"
                                dfvalue="{{$order->num}}"
                                name="num"/>
                            <x-form.input
                                required
                                type="date"
                                label="Дата приказа"
                                dfvalue="{{$order->date}}"
                                name="date"/>
                            <x-form.input
                                type="file"
                                label="Прикрепите файл"
                                name="order_f"/>
                        </x-form.fieldgroup>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>

        </div>

@endsection
