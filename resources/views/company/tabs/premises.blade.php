@extends('../company/show')

@section('c_tab')
    <div class="d-flex justify-content-between align-content-center mt-5 mb-3" >
        <h2 class="">Помещения</h2>
    </div>


    <form class=" w-100" method="post" action="{{route('premises.store', $company->id) }}">
        @csrf
        <x-form.fieldgroup title="Добавить новое помещение">
            <div class="d-flex  align-content-center">
                <div class="form-group my-3  w-50">
                    <div class="row align-content-center">
                        <input class="mx-3  p-2 w-full   form-control  " name="name" id="name"  required="required" value="{{old('name')}}">
                        <x-form.erorr name="name" />
                    </div>
                </div>
                <div class="mt-3 mx-5">
                    <button  class="btn btn-primary d-block">Добавить </button>
                </div>
            </div>


        </x-form.fieldgroup>

    </form>

    @if(count($company->premises)>0)
        <div>
            <table class="table  border table-striped">
                <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($company->premises()->orderBy('id', 'desc')->get() as $pm)
                    <tr>
                        <td>{{$pm->name}} </td>
                        <td class="">
                            <div class="d-flex justify-content-end">
                                <a  class="p-2 mx-1" href="{{route('premises.edit', $pm->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                                <x-modal-delete-btn
                                    text="Помещение {{$pm->name}} будет удалено"
                                    url="{{route('premises.destroy', $pm->id)}}"
                                />
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Упс ... у данной организацией еще нет ни одного помещения. Нажмите добавить новое, чтобы создать новое.</p>
    @endif
@endsection
