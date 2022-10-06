@props(['name', 'label' =>'', 'dfvalue' => '' ])
<x-form.field>
    <div class="row align-content-center">
        @if($label)
        <div class="col-md-3 text-end">
            <x-form.label name="{{$name}}" label="{{$label}}" required="{{$attributes['required']}}" />
        </div>

        <div class="col-md-9">
            <input
                class="  p-2 w-full   form-control  @error($name) is-invalid @enderror"
                name="{{$name}}"
                id="{{$name}}"
                {{ $attributes(['value' => old($name, $dfvalue)] ) }} >
            <x-form.erorr name="{{$name}}" />
        </div>
        @else
            <input
                class="  p-2 w-full   form-control  @error($name) is-invalid @enderror"
                name="{{$name}}"
                id="{{$name}}"
                {{ $attributes(['value' => old($name, $dfvalue)] ) }} >
            <x-form.erorr name="{{$name}}" />
        @endif
    </div>

</x-form.field>





