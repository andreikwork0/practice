@props(['title'])

<div class="card mb-4">
    <div class="card-header">{{$title}}</div>
    <div class="card-body">
        {{$slot}}
    </div>
</div>
{{--<h4 class="mb-3">{{$title}}</h4>--}}
{{--<div class="shadow-lg  p-3   mb-4">--}}

{{--</div>--}}
