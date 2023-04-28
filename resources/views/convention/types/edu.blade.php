@extends('../convention/edit')
@section('c_type')

    <h2 class="mt-4"></h2>



    @php
        $c = ($convention->company->dist_pr_new_vo()->count() ?? 0) ." / ". ($convention->company->dist_pr_new_spo()->count()  ?? 0)
    @endphp

    <x-convention.edu
        :dprs=$dist_prs_new
        :convention=$convention
        badge="{{  $c }}"
        title="Новые">
    </x-convention.edu>

    <x-convention.edu
        :dprs=$dist_prs
        :convention=$convention
        badge="0"
        title="Включенные">
        упс кажется еще нет ни одной включенной образовательной программы
    </x-convention.edu>


@endsection


