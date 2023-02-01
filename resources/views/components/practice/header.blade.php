@props(['practice'])
<h5 class="mb-3">{{$practice->name}}</h5>
<h5 class="mb-3">{{$practice->agroup}} -  {{$practice->spec}}</h5>

<div class="d-flex">
    <p >Контингент: {{$practice->contingent}} </p>
    <p class="mx-3">Курс:   {{$practice->course }}</p>
    <p class="mx-3">Семестр:   {{$practice->semester }}</p>
</div>
<div class="d-flex">
    <p>Тип практики: {{$practice->type->name ?? '-'}} </p>

    <p class="mx-3">Дата начала: {{$practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '-'}}</p>
    <p class="mx-3">Дата окончания: {{$practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '-'}}</p>

</div>


