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


{{--                    <select id="mySelect2">--}}
{{--                        <option value="AL">Alabama</option>--}}
{{--                        ...--}}
{{--                        <option value="WY">Wyoming</option>--}}
{{--                    </select>--}}
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
