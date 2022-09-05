@if($errors->any())
    <div class="container">
        <div class="alert alert-danger">
            <h2>Ошибки</h2>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


@if(session('success'))
    <div class="container">

        <div class="alert alert-success alert-dismissible fade show">
            @svg('check-circle-fill', 'w-30 h-6 text-dark')
          {{ session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
