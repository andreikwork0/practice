@extends('../company/show')

@section('c_tab')
    <div class="d-flex justify-content-between align-content-center mt-5 mb-3" >
        <h2 class="">Средства обучения</h2>
    </div>


    <form class=" w-100" method="post" action="{{route('list_tool.store', $company->id) }}">
        @csrf
        <x-form.fieldgroup title="Добавить новое средство">
            <div class="d-flex  align-content-center">
                <div class="form-group my-3  w-50">
                    <div class="row align-content-center">
                        <input class="mx-3  p-2 w-full   form-control  " name="name" id="name"  required="required" value="{{old('name')}}">
                        <x-form.erorr name="name" />
                    </div>
                    <div>
                        <x-form.select
                            :options=$t_categories
                            name="t_category_id"
                            label="Категория"
                            />
                    </div>
                </div>
                <div class="mt-3 mx-5">
                    <button  class="btn btn-primary d-block">Добавить </button>
                </div>
            </div>


        </x-form.fieldgroup>

    </form>

    @if(count($list_tools)>0)
        <div>
            <table class="table  border table-striped">
                <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list_tools as $ltool)
                    <tr>
                        <td>{{$ltool->tool->full_name}} </td>
                        <td class="">
                            <div class="d-flex justify-content-end">
                                <a  target="_blank" class="p-2 mx-1" href="{{route('tools.edit', $ltool->tool->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                                <x-modal-delete-btn
                                    text="Средство {{$ltool->tool->name}} будет удалено"
                                    url="{{route('list_tools.destroy', $ltool->id)}}"
                                />
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Упс ... у данной организацией еще нет ни одного средства обучения. Нажмите добавить новое, чтобы создать новое.</p>
    @endif
@endsection
