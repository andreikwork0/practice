@props(['name', 'label', 'required'])

<label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="{{$name}}">{{$label}}
    @if ($required) <span class="text-danger">*</span>  @endif
</label>

