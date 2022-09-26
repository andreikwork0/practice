@extends('layouts.app')

@section('title-block') Панель управления @endsection

@section('page-title')
    <x-page-title> Панель управления </x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            {{ Auth::user()->fname }}
                            {{ Auth::user()->lname }}
                            {{ Auth::user()->mname }}
                            {{ Auth::user()->education_type_id }}
                            {{'Выберите кафедру'}}
                            @if(!Auth::user()->code_pulpit)
                                @php $pulplits = \App\Models\Pulpit::where('education_type_id' ,'=' , 1)->get();  @endphp
                                <select name="" id="" class="custom-select js-example-basic-single form-control">
                                    <option value="">Ничего не выбрано</option>
                                    @foreach($pulplits as $pulpit)
                                        <option value="{{$pulpit->code}}">{{$pulpit->name}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary my-3">сохранить</button>
                            @endif
                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
