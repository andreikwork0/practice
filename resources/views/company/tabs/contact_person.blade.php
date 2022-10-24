@extends('../company/show')

@section('c_tab')
    <div class="d-flex justify-content-between align-content-center mt-5 mb-3" >
        <h2 class="">Контактные лица</h2>
        <div>
            <a href="{{route('contact_people.create', $company->id) }}" class="btn btn-primary d-block">Добавить контакт</a>
        </div>
    </div>

    @if(count($company->contact_people)>0)
        <div>
            <table class="table  border table-striped">
                <thead>
                <tr>


                    <th scope="col">Номер</th>
                    <th scope="col">Дата подписания</th>
                    <th scope="col">Начало действие</th>
                    <th scope="col">Окончание действия</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Действующий</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($company->contact_people()->orderBy('id', 'desc')->get() as $cp)
                    <tr>
                        <td>{{$agreement->num_agreement}} </td>
                        <td> {{$agreement->date_agreement ? date('d.m.Y', strtotime($agreement->date_agreement)) : '-'}}</td>
                        <td> {{$agreement->date_bg ? date('d.m.Y', strtotime($agreement->date_bg)) : '-'}}</td>
                        <td> {{$agreement->date_end ? date('d.m.Y', strtotime($agreement->date_end)) : '-'}}</td>
                        <td>{{$agreement->status->name}}</td>
                        <td>{{ $agreement->is_actual == 1 ? 'Да' : 'Нет'}}</td>
                        <td class="">
                            <div class="d-flex justify-content-end">
                                <a  class="p-2 mx-1" href="{{route('contact_people.edit', $agreement->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
                                <x-modal-delete-btn
                                    text="Контакт {{$cp->name}} будет удален"
                                    url="{{route('contact_people.destroy', $cp->id)}}"
                                />
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Упс ... с данной организацией еще не заключено ни одного договора. Нажмите добавить новый, чтобы создать новый договор.</p>
    @endif
@endsection
