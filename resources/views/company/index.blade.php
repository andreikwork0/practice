@extends('layouts/app')

@section('title-block') Организации @endsection
@section('content')
    <div style="padding: 50px 0;">
    <div class="container">
        <table class="table  border table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Адрес</th>
                <th scope="col">ИНН</th>
                <th scope="col">КПП</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{$company->id}}</td>
                    <td>{{$company->name}}</td>
                    <td>{{$company->legal_adress}}</td>
                    <td>{{$company->inn}}</td>
                    <td>{{$company->kpp}}</td>

                    <td class="border border-dark">
                        <div class="d-flex">
                            <a class="p-2 mx-1"  href="{{route('companies.show', $company->id)}}">@svg('eye-fill', 'w-30 h-6 text-dark')</a>
                            <a  class="p-2 mx-1" href="{{route('companies.edit', $company->id)}}">@svg('pencil-square', 'w-6 h-6 text-primary')</a>
                            <a class="p-2 mx-1"   >
                                <form action="{{route('companies.destroy', $company->id)}}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="border-0 "> @svg('trash-fill', 'w-6 h-6 text-danger') </button>
                                </form>

                            </a>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="my-4">
            {{$companies->links()}}
        </div>

    </div>
        <div class="d-flex justify-content-center">

        </div>

    </div>
@endsection

