@extends('../convention/edit')
@section('c_type')

    <h2 class="mt-4">Включенные</h2>
    @if($dist_prs)
        @foreach($dist_prs as  $dist_pr)
            {{$dist_pr->practice->name}}
        @endforeach
    @else
        упс кажется еще нет ни одной включенной образовательной программы
    @endif


    @if($dist_prs_new)

        <h2 class="mt-4">Новые</h2>

        <table class="table  border table-striped">
            <thead style="position: sticky; top: 0" class="table-dark">
            <tr>
                <th scope="col"></th>
                <th scope="col">Специальность
                </th>
                <th scope="col">Группа</th>
                <th scope="col">Практика</th>

                <th scope="col">План</th>
                <th scope="col">Факт</th>
                <th scope="col">График</th>
            </tr>
            </thead>
            <tbody>

        @foreach($dist_prs_new as  $dist_pr_new)
           <tr>
               <td>

                   <x-form.checkbox
                       name="convention_id"/>
               </td>
               <td> {{$dist_pr_new->practice->spec}} </td>
               <td> {{$dist_pr_new->practice->agroup}} </td>
               <td>
                   <a href="{{route('practices.show', $dist_pr_new->practice->id)}}" target="_blank">
                       {{$dist_pr_new->practice->name}}
                   </a>

               </td>
               <td> {{$dist_pr_new->num_plan}} </td>
               <td style="width: 100px">
{{--                   <input type="text" class="form-control" width="10">--}}

                       <x-form.input
                           label=""
                           required
                           type="number"
                           name="num_plan_1"/>

{{--                   {{$dist_pr_new->num_fact ?? '-'}}--}}
               </td>

               <td>
                   c {{$dist_pr_new->practice->date_start ? date('d.m.Y', strtotime($dist_pr_new->practice->date_start)) : '-'}}
                   по  {{$dist_pr_new->practice->date_end ? date('d.m.Y', strtotime($dist_pr_new->practice->date_end)) : '-'}}
           </tr>
        @endforeach
            </tbody>
        </table>
    @else
        упс кажется   нет ни одной новой образовательной программы
    @endif

@endsection


