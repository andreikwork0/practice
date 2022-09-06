@props(['name', 'label', 'dfvalue' => '' ])
<x-form.field>
    <div class="row align-content-center">
        <div class="col-md-3 text-end">
            <x-form.label name="{{$name}}" label="{{$label}}" required="{{$attributes['required']}}" />
        </div>
        <div class="col-md-9">
            <input
                class="border border-gray-200 rounded p-2 w-full focus:outline-none focus:ring form-control"
                name="{{$name}}"
                id="{{$name}}"
                {{ $attributes(['value' => old($name, $dfvalue)] ) }} >
        </div>
    </div>
    <x-form.erorr name="{{$name}}" />
</x-form.field>





