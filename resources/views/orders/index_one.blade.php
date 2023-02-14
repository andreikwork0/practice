@extends('layouts/app')

@section('title-block') Приказы на практику  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Приказы на практику
            <div class="d-flex">

                <form action="{{route('order.generate', $practice->id)}}" method="post">
                    @csrf
                    <button     class="btn btn-secondary" type="submit">
                        Сформировать приказ</button>
                </form>
                <div class="mx-5">
                    <a class="btn btn-outline-primary px-5" href="{{route('practices.show', $practice->id)}}"> &larr; Назад</a>
                </div>

            </div>
        </div>
    </x-page-title>
@endsection

@section('content')

        <div class="container">
            <x-practice.header :practice=$practice></x-practice.header>
            <hr>
            @if ($orders->count() > 0)
            <div class="d-flex flex-wrap justify-content-between w-75 mb-4">
                @foreach($orders as $order)
                    <div class="card my-2" style="width: 28rem;" >
                        <div class="card-body" >
                            <h5 class="card-title">Приказ № {{$order->num}}</h5>
                            <p class="card-text">Дата: {{date('d.m.Y', strtotime($order->date)) }}
                                <br>
                                Файл:  <span class="text-decoration-underline" > {{$order->file->name}}</span>
                            </p>
                            <div class="d-flex  flex-wrap justify-content-between">
                                <div>
                                    <form action="{{route('file.download', $order->file->id) }}" method="post">
                                        @csrf
                                        <button  class="btn btn-primary">Скачать</button>
                                    </form>
                                </div>
                                <div>
                                    <a href="{{route('orders.edit', $order->id)}}" class="btn btn-success">Редактировать</a>
                                </div>
                                <x-modal-delete-btn
                                    text="Приказ № {{$order->num}} будет удален"
                                    url="{{route('orders.destroy', $order->id)}}"
                                />
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
            @else
                <p>Упс кажется еще нет ни одного приказа</p>
            @endif

            <form action="{{route('orders.store',  $practice->id)}}" method="post"  enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <x-form.fieldgroup title="Прикрепить новый приказ">
                            <x-form.input
                                required
                                label="Номер приказа"
                                name="num"/>
                            <x-form.input
                                required
                                type="date"
                                label="Дата приказа"
                                name="date"/>
                            <x-form.input
                                required
                                type="file"
                                label="Прикрепите файл"
                                name="order_f"/>
                        </x-form.fieldgroup>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Создать</button>
            </form>

        </div>

@endsection
