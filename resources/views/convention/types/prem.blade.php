@extends('../convention/edit')
@section('c_type')
    <div class="row" >
        <div class="col-md-7">
            <form action="{{route('conventions.update', $convention->id)}}" method="post">
                @method('PUT')
                @csrf
                <x-form.fieldgroup title="Помещения">
                    @foreach($premises as $premise )
                        <x-form.checkbox
                            dfvalue="{{ intval(boolval(in_array($premise->id, $id_arr_convprem)))}}"
                            label="{!! $premise->name  !!}"
                            name="pm[{{$premise->id}}]"/>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </x-form.fieldgroup>
            </form>
        </div>
    </div>
@endsection

