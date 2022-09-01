@props(['name', 'label'])
<x-form.field>
    <x-form.label name="{{$name}}" label="{{$label}}" required="{{$attributes['required']}}" />
    <textarea
              name="{{$name}}"
              id="{{$name}}"

              rows="7"  class=" form-control" >{{$slot ?? old($name)}}</textarea>
    <x-form.erorr name="{{$name}}" />
</x-form.field>
