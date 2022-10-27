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
                    <th scope="col">ФИО</th>
                    <th scope="col">Должность</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Email</th>
                    <th scope="col"> В согласовании</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($company->contact_people()->orderBy('id', 'desc')->get() as $cp)
                    <tr>
                        <td>{{$cp->fio()}}</td>
                        <td>{{$cp->prs_job}} </td>
                        <td>{{$cp->phone ?? '-'}} </td>
                        <td>{{$cp->email ?? '-'}} </td>
                        <td>{{ $cp->is_negotiation == 1 ? 'Да' : 'Нет'}}</td>
                        <td class="">
                            <div class="d-flex justify-content-end">
                                <a  class="p-2 mx-1" href="{{route('contact_people.edit', $cp->id)}}">@svg('pencil-square', 'w-6 h-6 text-dark icon-index')</a>
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
        <p>Упс ... у данной организацией еще нет ни одного контакта. Нажмите добавить новый, чтобы создать новый контакт.</p>
    @endif
@endsection
