@extends('../company/show')

@section('c_tab')
    <div class="d-flex justify-content-between align-content-center mt-5 mb-3" >
        <h2 class="">Договоры</h2>
        <div>
            <a href="{{route('agreements.create', $company->id) }}" class="btn btn-primary d-block">Добавить новый</a>
        </div>
    </div>

    @if(count($company->agreements)>0)
        <div>
            <table class="table  border table-striped">
                <thead>
                <tr>
                    <th scope="col">Номер</th>
                    <th scope="col">Дата подписания</th>
                    <th scope="col">Начало действие</th>
                    <th scope="col">Окончание действия</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Тип</th>
                    <th scope="col">Действующий</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($company->agreements()->orderBy('id', 'desc')->get() as $key => $agreement)
                    <tr>
                        <td>{{$agreement->num_agreement}} </td>
                        <td> {{$agreement->date_agreement ? date('d.m.Y', strtotime($agreement->date_agreement)) : '-'}}</td>
                        <td> {{$agreement->date_bg ? date('d.m.Y', strtotime($agreement->date_bg)) : '-'}}</td>
                        <td> {{$agreement->date_end ? date('d.m.Y', strtotime($agreement->date_end)) : '-'}}</td>
                        <td>{{$agreement->status->name}}</td>
                        <td>{{$agreement->type->name}}</td>
                        <td>{{ $agreement->is_actual == 1 ? 'Да' : 'Нет'}}</td>
                        <td class="">
                            <div class="d-flex justify-content-end">
                                <a data-bs-toggle="collapse"
                                   data-bs-target="#collapse_ag_{{$agreement->id}}"
                                   aria-expanded="false"
                                   aria-controls="collapse_ag_{{$agreement->id}}"
                                   class="p-2 mx-1"  href="{{route('agreements.show', $agreement->id)}}">@svg('three-dots', 'w-30 h-6 text-dark icon-index')</a>

                                @if($agreement->path)
                                    <a class="p-2 mx-1" >
                                        <form action="{{route('agreements.download', $agreement->id)}}" method="post">
                                            @csrf
                                            <button type="submit" class="border-0 bg-transparent"> @svg('download', 'w-30 h-6 text-dark icon-index') </button>
                                        </form>
                                    </a>
                                @endif
                                <a class="p-2 mx-1" >
                                    <form action="{{route('agreements.generate', $agreement->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent">@svg('file-earmark-arrow-down', 'w-30 h-6 text-dark icon-index')</button>
                                    </form>
                                </a>
                                <a  class="p-2 mx-1" href="{{route('agreements.edit', $agreement->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                                <x-modal-delete-btn
                                    text="Договор № {{$agreement->num_agreement}} будет удален"
                                    url="{{route('agreements.destroy', $agreement->id)}}"
                                />
                            </div>

                        </td>
                    </tr>

                    <tr   class="collapse  @if(request()->get('agr') ?  (request()->get('agr')== $agreement->id) : ($key == 0)) {{'show'}} @endif" id="collapse_ag_{{$agreement->id}}">


                        <td></td>
                        @if(count($agreement->conventions)> 0)
                        <td colspan="6">
                            <h4>Доп соглашения</h4>
                            <table class="table  border">
                                <thead>
                                <tr>
                                    <th scope="col">Номер</th>
                                    <th scope="col">Тип</th>
                                    <th scope="col">Действующий</th>
                                    <th scope="col">

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($agreement->conventions as $convention )
                                <tr>
                                    <td>{{$convention->number}}</td>
                                    <td>{{$convention->type->name}}</td>
                                    <td>{{$convention->is_actual ? 'да' : 'нет'}}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">

                                            @if($convention->path)
                                                <a class="p-2 mx-1" >
                                                    <form action="{{route('conventions.download', $convention->id)}}" method="post">
                                                        @csrf
                                                        <button type="submit" class="border-0 bg-transparent"> @svg('download', 'w-30 h-6 text-dark icon-index') </button>
                                                    </form>
                                                </a>
                                            @endif
                                            <a class="p-2 mx-1" >
                                                <form action="{{route('conventions.generate', $convention->id)}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="border-0 bg-transparent">@svg('file-earmark-arrow-down', 'w-30 h-6 text-dark icon-index')</button>
                                                </form>
                                            </a>
                                            <a  class="p-2 mx-1" href="{{route('conventions.edit', $convention->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                                            <x-modal-delete-btn
                                                text="Доп. соглашение № {{$convention->number}} будет удалено"
                                                url="{{route('conventions.destroy', $convention->id)}}"
                                            />
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>

                            </table>

                        </td>
                        @else
                            <td colspan="6">Упс ... кажется у данного договора еще нет ни одного доп соглашения. Нажмите добавить новое, чтобы создать новое</td>
                        @endif
                        <td >
                            <form method="post" action="{{route('conventions.store', $agreement->id)}}" class="mt-3">
                                <x-form.fieldgroup title="Добавить новое соглашение">
                                    @csrf
                                    <div class="d-flex">
                                        <x-form.select
                                            :options=$conv_types
                                            required
                                            name="conv_type_id-{{$agreement->id}}"
                                            label=""
                                        />
                                        <div>
                                            <button type="submit" class="btn btn-primary mt-3">+</button>
                                        </div>
                                    </div>

                                </x-form.fieldgroup>
                            </form>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>


        </div>
    @else
        <p>Упс ... с данной организацией еще не заключено ни одного договора. Нажмите добавить новый, чтобы создать новый договор.</p>
    @endif
@endsection
