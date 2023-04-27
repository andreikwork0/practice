@extends('layouts/print')
@section('content')
    <style>
        body >  * {
            font-size: 9px !important;
        }
        .more {
            page-break-after: always;
            display: inline !important;
        }
        @media print{
            @page {
                size: A4 landscape;
            }

            .more {
                page-break-after: always;
                display: inline !important;
            }


        }
    </style>


    <div class="wrap" style="max-width: 100%">
        <div class="row">
            @php
              $i = 1;
            @endphp
            @foreach ($pr_students as $pr_student)
            <div class="col-6" >
                <h2 class="text-center">НАПРАВЛЕНИЕ *</h2>
                <div>Согласно приказу по ФГБОУ ВО «МГТУ им. Г. И. Носова» №  {{$order_s->num}} от {{$order_s->date}} г.</div>
                <div class="text-center">{{$pr_student->student->fio()}}</div>
                <div class="text-center">(Ф.И.О. обучающегося полностью)</div>
                <div>обучающийся     {{$practice->course}}    курса, группы   {{$practice->agroup}}</div>
                <div>(код группы)</div>
                <div>направление подготовки / специальности   {{$practice->spec}}</div>
                <div>направляется для прохождения практики -  {{$practice->name}}</div>
                <div> сроком  с  {{$practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '__.__.__'}} г. по {{$practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '__.__.__'}} г. </div>
                <div class="text-center">на (в) {{$pr_student->company_name}}</div>
                <div class="text-center">(наименование предприятия/организации)</div>
                <div>
                Начальник отдела практик     ___________________ ( {{$mng_pr_fio}})
                </div>
                <div>
                                                        (подпись)
                </div>
                <div>
                Руководитель практики
                </div>
                <div>
                от МГТУ                                 ___________________ ({{$pr_student->t_fio}} )
                </div>
                <div>
                                                        (подпись)              (И.О. Фамилия)
                </div>
                <div>
                М. П.
                </div>
                <div>
                * - Остается в отделе кадров предприятия / организации
                </div>

                <br>
                линия отрыва
                <hr>
                <h2 class="text-center">ПОДТВЕРЖДЕНИЕ **</h2>
                <div class="text-center">Обучающийся  {{$pr_student->student->fio()}}</div>
                <div class="text-center">(Ф.И.О. обучающегося полностью)</div>
                <div>курса     {{$practice->course}}     группы       {{$practice->agroup}}</div>
                <div>(код группы)</div>
                <div>направление подготовки /специальности   {{$practice->spec}}</div>
                <div> прибыл на практику  «____» _________ 20 ___ г. </div>
                <div>убыл с практики        «____» _________ 20 ___ г.</div>
                <div>с  {{$pr_student->company_name}}</div>
                <div>(наименование предприятия/организации)</div>
                <div>
                Руководитель практики от предприятия / организации</div>
                <div>
                ________________________________  _________________  (______________________)
                </div>
                <div>
                (должность ответственного)                                               (подпись)                                           (И.О. Фамилия)
                </div>
                <div>
                М.П.
                </div>
                <div>
                ** - Отдается обучающемуся в день окончания практики, а
                    <div>
                    затем передается им на кафедру вместе с отчетом, проездными авиа- или
                    </div>
                    <div>
                        железнодорожными билетами до места практики и обратно и другой отчетной документацией
                    </div>
                </div>
            </div>
                @if($i %2 == 0)
                        <span class=" more ">2</span>
                @endif
                @php
                    $i++;
                @endphp
            @endforeach
        </div>
    </div>

@endsection


