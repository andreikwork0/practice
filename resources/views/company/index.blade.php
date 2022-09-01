@extends('layouts/app')

@section('title-block') Организации @endsection

@section('content')
    <div style="padding: 50px 0;">
    <div class="container">
        <table class="table table-success table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <th scope="row">{{$company->id}}</th>
                    <td>{{$company->name}}</td>
                    <td>{{$company->legal_adress}}</td>
                    <td>{{$company->mng_surname}}</td>
                </tr>

            @endforeach


            </tbody>
        </table>
    </div>

        <div class="d-flex">{{$companies->links()}}</div>
    </div>
@endsection

