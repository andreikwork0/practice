@props(['dprs', 'convention', 'title', 'badge'])
@if(count($dprs)> 0)
    <hr class="my-4">
    <h2 class="mt-2 position-relative ">
        <div class="mx-3 mt-3">
            {{$title}}
        </div>
        @if($badge)
            <span style="font-size: 14px" class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                    {{$badge}}
                    <span class="visually-hidden">unread messages</span>
              </span>
        @endif
    </h2>

    <form action="{{route('conventions.update', $convention->id)}}" method="post">
        @method('PUT')
        @csrf
        <table class="table  border table-striped">
            <thead style="position: sticky; top: 0" class="table-dark">
            <tr>
                <th scope="col">
                    <button class="btn btn-success dp_inc_al" type="button">Выбрать все</button>
                </th>
                <th scope="col"> Подразделение</th>
                <th scope="col">Специальность
                </th>
                <th scope="col">Группа</th>
                <th scope="col">Практика</th>
                <th scope="col">График</th>

                <th scope="col">План</th>
                <th scope="col">Факт</th>

                <th scope="col"> <button class="btn btn-primary" type="submit">Сохранить</button></th>
            </tr>
            </thead>
            <tbody>

            @foreach($dprs as  $dpr)
                <tr>
                    <td>
                        <x-form.checkbox
                            label="Включено"
                            dfvalue="{{ intval(boolval($dpr->convention_id == $convention->id))}}"
                            name="dp[{{$dpr->id}}][convention]"/>
                    </td>
                    <td>
                        @if($dpr->org_structure)
                            <span>{{$dpr->org_structure->name_short}}</span>
                        @endif
                    </td>
                    <td style="width: 250px" > {{$dpr->practice->spec}} </td>
                    <td  style="width: 100px"> {{$dpr->practice->agroup}} </td>
                    <td style="width: 250px">
                        <a href="{{route('practices.show', $dpr->practice->id)}}" target="_blank">
                            {{  mb_strimwidth($dpr->practice->name, 0, 45, " ...")   }}
                        </a>
                    </td>
                    <td>
                        c {{$dpr->practice->date_start ? date('d.m.Y', strtotime($dpr->practice->date_start)) : '-'}}
                        <br>
                        по  {{$dpr->practice->date_end ? date('d.m.Y', strtotime($dpr->practice->date_end)) : '-'}}
                    </td>

                    <td>
                        {{$dpr->num_plan}}
                    </td>
                    <td style="width: 100px">
                        <x-form.input
                            label=""
                            type="number"
                            min="0"
                            name="dp[{{$dpr->id}}][num_fact]"
                            dfvalue="{{$dpr->num_fact}}"
                        />
                    </td>
                    <td style="width: 100px">  </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
@endif


