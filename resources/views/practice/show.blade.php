@extends('layouts/app')

@section('title-block') Практика {{ $practice->name}}  @endsection

@section('page-title')
    <x-page-title>
        <div class="d-flex justify-content-between align-content-center">
            Распределение практики
            <div class="d-flex">
                <div class="mx-3">
                    <a href="{{route('practices.edit', $practice->id)}}" class="btn btn-outline-primary">Редактировать</a>
                </div>

                <form action="{{route('order.generate', $practice->id)}}" method="post">
                    @csrf
                    <button     class="btn btn-secondary" type="submit">
                        Сформировать приказ</button>
                </form>

            </div>
        </div>
    </x-page-title>
@endsection

@section('content')


        <div class="container">
            <x-practice.header :practice=$practice></x-practice.header>

            @php
                $setting = \App\Models\Setting::key_val();
            @endphp

            @if($setting['is_dist_pr'] <> 0)
                <x-form.fieldgroup
                    title="Добавить распределение">

                    <form action="{{route('distribution_practices.store', $practice->id )}}" method="POST">
                        @csrf
                        <div class="d-flex align-content-center">
                            <div class="mx-3">
                                <label for="">Организация</label>
                                <x-form.select
                                    :options=$companies
                                    required
                                    type="number"
                                    name="company_id"
                                    label=""
                                />


                            </div>
                            <div class="mx-3">
                                <label for="">План мест</label>
                                <x-form.input
                                    label=""
                                    required
                                    type="number"
                                    min="0"
                                    name="num_plan"/>
                            </div>
                            <div class="my-auto mx-3">
                                <button type="submit" class="btn btn-primary mt-3 mx-3">Добавить</button>
                            </div>
                        </div>
                        <div
                            v-show="tv_options.length > 0 "
                            id="org_s_wrap">
                            <label for="">Структурное подразделения</label>
                            <treeselect
                                placeholder="Выберите"
                                :options="tv_options"
                                v-model="tv_value"
                                search-nested
                                :show-count="true"
                                :default-expand-level="0"
                                :multiple="false"  >
                                <div slot="value-label" slot-scope="{ node }">@{{ node.raw.id }}</div>
                                <label slot="option-label" slot-scope="{ node, shouldShowCount, count, labelClassName, countClassName }" :class="labelClassName">
                                    @{{ node.isBranch ? 'Branch' : 'Leaf' }}: @{{ node.label }}
                                    <span v-if="shouldShowCount" :class="countClassName">( @{{ count }})</span>
                                </label>
                            </treeselect>
                            <input v-model="tv_value" name="org_structure_id" hidden>
                        </div>
                    </form>
                </x-form.fieldgroup>

                @else
                <div class="alert alert-danger">
                    <h2>В данный момент подача заявок остановлена</h2>
                </div>
                @endif

            <x-distpr.list
                contingent="{{$practice->contingent}}"
                :dps="$practice->dp"></x-distpr.list>

    </div>
@endsection

