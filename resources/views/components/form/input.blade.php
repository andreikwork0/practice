@props(['name', 'label', 'dfvalue' => '' ])
<x-form.field>
    <x-form.label name="{{$name}}" label="{{$label}}" required="{{$attributes['required']}}" />
    <input

        class="border border-gray-200 rounded p-2 w-full focus:outline-none focus:ring form-control"
           name="{{$name}}"
           id="{{$name}}"

        {{ $attributes(['value' => old($name, $dfvalue)] ) }} >
    <x-form.erorr name="{{$name}}" />
</x-form.field>





