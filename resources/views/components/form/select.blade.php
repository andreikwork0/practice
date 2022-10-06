@props(['name', 'label' => '', 'options', 'dfvalue' => '', 'ids' => '' ])
<x-form.field>
    @if($label)
    <div class="row align-content-center">
        <div class="col-md-3 text-end">
            <x-form.label name="{{$name}}" label="{{$label}}" required="{{$attributes['required']}}" />
        </div>
        <div class="col-md-9">
            <select class="custom-select  js-example-basic-single form-control" name="{{$name}}"

                    @if ($ids)
                        id="{{$ids}}" >
                    @else
                        id="{{$name}}" >
                    @endif

                <option></option>
                @php $current = old($name, $dfvalue) @endphp
                @foreach($options as $option)
                    <option @if($option->id == $current) {{'selected="selected"'}} @endif value="{{$option->id}}">{{$option->name}}</option>
                @endforeach
            </select >
        </div>


    </div>
    <x-form.erorr name="{{$name}}" />
    @else
        <select class="custom-select  js-example-basic-single form-control" name="{{$name}}"

                @if ($ids)
                id="{{$ids}}" >
            @else
                id="{{$name}}" >
            @endif

            <option></option>
            @php $current = old($name, $dfvalue) @endphp
            @foreach($options as $option)
                <option @if($option->id == $current) {{'selected="selected"'}} @endif value="{{$option->id}}">{{$option->name}}</option>
            @endforeach
        </select >

        <x-form.erorr name="{{$name}}" />
    @endif

</x-form.field>





