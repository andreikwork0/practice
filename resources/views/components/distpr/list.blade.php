@props(['dps', 'contingent',  'dpActiveId' => '' ])

@if(count($dps)>0)
    <div class="row">
        <div class="col-md-8">
            <table class="table  border table-striped">
                <thead>
                <tr>
                    <th style="width: 50%" scope="col">Организация</th>
                    <th scope="col" class="text-center">План</th>

                    <th scope="col" class="text-center">Факт</th>

                    <th scope="col" class="text-center">Доп соглашение</th>

                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @php
                    $sums = array();
                    $sums['num_plan'] =0;
                    $sums['num_f_s'] = 0;
                    $sums['num_fact'] =0;
                @endphp
                @foreach($dps as $dp)
                    <tr>
                        <td>
                            @if($dpActiveId  == $dp->id)
                                <b>{{$dp->company->name}}</b>
                                @if($dp->org_structure)
                                    <span>({{$dp->org_structure->name_short}})</span>
                                @endif
                            @else
                                {{$dp->company->name}}
                                @if($dp->org_structure)
                                    <span>({{$dp->org_structure->name_short}})</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            {{$dp->num_plan}}
                            @php
                                $sums['num_plan']+=$dp->num_plan;
                            @endphp
                        </td>
                        <td  class="text-center">
                            {{ ( $dp->pr_students->count() . ' / ' ) ?? ( 0 .  ' / '  )}} {{$dp->num_fact ?? '(?)'}}

                            @php
                                $sums['num_f_s']+=$dp->pr_students->count() ?? 0;
                                $sums['num_fact']+=$dp->num_fact ?? 0;
                            @endphp
                        </td>
                        <td  class="text-center">
                            {{$dp->convention ?  'да': 'нет'}}
                        </td>
                        <td class="">
                            <div class="d-flex justify-content-end">
                                @if(!$dp->convention)
                                    <x-modal-delete-btn
                                        text="Распределение будет удалено"
                                        url="{{route('distribution_practices.destroy', $dp->id)}}"
                                    />
                                @endif
                                @if ($dp->num_fact > 0 && $dpActiveId != $dp->id)
{{--                                    <a class="btn btn-outline-primary" href="{{route('pr_student.edit', $dp->id)}}">По студентам</a>--}}
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        <b>Итого</b>

                    </td>
                    <td class="text-center">
                        {{$sums['num_plan']}}
                    </td>

                    <td class="text-center">
                        {{$sums['num_f_s']. ' / ' . $sums['num_fact'] }}
                    </td>
                    <td>
                    </td>
                    <td>

                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Контингент</b>
                    </td>
                    <td class="text-center">
                        {{$sums['num_plan']. ' / ' . $contingent}}
                    </td>

                    <td class="text-center">
                        {{$sums['num_f_s']. ' / '.  $sums['num_fact'] . ' / ' . $contingent}}
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
