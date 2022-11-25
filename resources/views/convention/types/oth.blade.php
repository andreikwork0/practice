@extends('../convention/edit')
@section('c_type')
    <div class="row" >
        <div class="col-md-7">
            <form action="{{route('conventions.update', $convention->id)}}" method="post">
                @method('PUT')
                @csrf
                <x-form.fieldgroup title="Содержание">
                   <x-form.textarea required name="text" label="Пункты доп. соглашения">{!! $convention->text ?? ''  !!}</x-form.textarea>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </x-form.fieldgroup>
            </form>
        </div>
    </div>
@endsection
