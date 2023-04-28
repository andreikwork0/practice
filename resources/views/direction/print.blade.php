@extends('layouts/print')
@section('style')
    <style>

        html, body, .main, .tabs, .tabbed-content { float: none; }
        .l-otr {
            border-bottom: 2px solid black;
            width: 100%;
        }
        body p,  body div, body h2   {
            font-size: 12px !important;
            font-family: "Times New Roman" !important;
        }
        .sm_index
        {
            font-size: 8px !important;
        }
        h2
        {
            font-weight: bold;
        }
        .more {
            display: block;
            page-break-after: always;
            position: relative;
            /*display: inline !important;*/
        }
        @media print{
            @page {
                size: A4 landscape;
            }
            .more {
                display: block;
                page-break-after: always;
                position: relative;
                /*break-after: page;*/

                /*display: inline !important;*/
            }
            #js-print-btn-dir{
                display: none;
            }

        }
    </style>
@endsection
@section('content')



    <button id="js-print-btn-dir" class="btn btn-warning" onclick="window.print()">Печать</button>

    <div class="wrap" style="max-width: 100%">

        <div class="row">
            @php
              $i = 1;
            @endphp
            @foreach ($pr_students as $pr_student)
            <div class="col-6" >
                <h2 class="text-center">НАПРАВЛЕНИЕ *</h2>
                <div>Согласно приказу по ФГБОУ ВО «МГТУ им. Г. И. Носова» №  {{$order_s->num}} от {{$order_s->date}} г.</div>
                <div class="text-center border-bottom">{{$pr_student->student->fio()}}</div>
                <div class="text-center sm_index">(Ф.И.О. обучающегося полностью)</div>
                <div class="d-flex">
                    <div><span>обучающийся</span> </div>
                    <div> &nbsp;  <span class="text-decoration-underline">{{$practice->course}}</span>   курса, группы &nbsp;</div>
                    <div>
                       <div>
                           {{' '}}  <span class="text-decoration-underline">  {{$practice->agroup}} </span>
                       </div>
                        <div class="text-center sm_index">(код группы)</div>
                    </div>

                </div>

                <div></div>
                <div>направление подготовки / специальности <span class="text-decoration-underline">  {{$practice->spec}} </span></div>
                <div>направляется для прохождения практики -  <span class="text-decoration-underline"> {{$practice->name}} </span></div>
                <div> сроком  с  {{$practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '__.__.__'}} г. по {{$practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '__.__.__'}} г. </div>
                <div >на (в) <span class="text-decoration-underline"> {{$pr_student->company_name}} </span></div>
                <div class="sm_index">(наименование предприятия/организации)</div>
                <div class="d-flex">
                    <div style="width: 140px;">
                        Начальник отдела практик
                    </div>
                    <div>
                        ___________________
                        <div class="text-center sm_index">(подпись)</div>
                    </div>
                    <div>
                        ( {{$mng_pr_fio}})
                    </div>

                </div>

                <div class="d-flex" >
                    <div style="width: 140px;">Руководитель практики <br> от МГТУ</div>
                    <div>
                        ___________________
                        <div class="text-center sm_index">
                            (подпись)
                        </div>
                    </div>
                    <div>
                        ({{$pr_student->t_fio}} )
                        <div class="text-center sm_index">
                            (И.О. Фамилия)
                        </div>
                    </div>


                </div>



                <div>
                    М.П.
                </div>
                <div class="sm_index">
                * - Остается в отделе кадров предприятия / организации
                </div>

                <br>

                <div class="l-otr"></div>
                <b> линия отрыва </b>
                <h2 class="text-center ">ПОДТВЕРЖДЕНИЕ **</h2>
                <div class="border-bottom "> Обучающийся  <div class="text-center d-inline-block w-75">{{$pr_student->student->fio()}} </div> </div>
                <div class="text-center sm_index">(Ф.И.О. обучающегося полностью)</div>

                <div class="d-flex">
                    <div>
                        курса &nbsp; <span class="text-decoration-underline">   {{$practice->course}} </span> группы
                    </div>
                    <div>
                        {{' '}} <span class="text-decoration-underline"> &nbsp;  {{$practice->agroup}} </span>
                        <div class="text-center sm_index">(код группы)</div>
                    </div>
                </div>

                <div>направление подготовки /специальности <span class="text-decoration-underline">   {{$practice->spec}} </span></div>
                <div> прибыл на практику  «____» _________ 20 ___ г. </div>
                <div>убыл с практики        «____» _________ 20 ___ г.</div>
                <div>с <span class="text-decoration-underline">  {{$pr_student->company_name}} </span></div>
                <div class="sm_index">(наименование предприятия/организации)</div>

                <div>
                    Руководитель практики от предприятия / организации

                </div>
                <div class="d-flex">

                    <div>
                        ________________________________ &nbsp;
                        <div class="text-center sm_index">(должность ответственного) </div>
                    </div>
                    <div>
                        _________________ &nbsp;
                        <div class="text-center sm_index">(подпись) </div>
                    </div>
                    <div>
                        (______________________)
                        <div class="text-center sm_index">(И.О. Фамилия) </div>
                    </div>
                    <div>

                    </div>
                </div>



            <div>
                М.П.
            </div>
                <div class="sm_index">
                ** - Отдается обучающемуся в день окончания практики, а

                    затем передается им на кафедру вместе с отчетом, проездными авиа- или

                        железнодорожными билетами до места практики и обратно и другой отчетной документацией

                </div>
            </div>
                @if($i %2 == 0)
                    </div>
                        <div>
                            <span class=" more "></span>
                        </div>
                    <div class="row">

                @endif
                @php
                    $i++;
                @endphp
            @endforeach
                    </div>
        </div>
    </div>

@endsection


