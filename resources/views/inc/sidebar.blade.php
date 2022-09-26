<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh;">
    <a href="/" class="d-flex align-items-center justify-content-between mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            @svg('person-workspace', 'w-50 h-10  text-white')
        <span class="fs-4 mx-2 d-inline-block">Практики</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link  "  >
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                Home
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('companies.index')}}" class="nav-link text-white     @if(request()->routeIs('companies.*')) {{'active'}} @endif ">

                @svg('building', 'w-16 h-16 bi me-2 text-white')
                Организации
            </a>
        </li>
        <li>
            <a href="{{route('contact_people.index')}}" class="nav-link text-white   @if(request()->routeIs('contact_people.*')) {{'active'}} @endif ">
                @svg('people', 'w-16 h-16 bi me-2 text-white')
                Контактные лица
            </a>
        </li>

        <li>
            <a href="{{route('agreements.index')}}" class="nav-link text-white @if(request()->routeIs('agreements.*')) {{'active'}} @endif">
                @svg('file-text', 'w-16 h-16 bi me-2 text-white')
                Договоры
            </a>
        </li>
        <li>
            <a href="{{route('grn_letters.index')}}" class="nav-link text-white @if(request()->routeIs('grn_letters.*')) {{'active'}} @endif">
                @svg('envelope', 'w-16 h-16 bi me-2 text-white')
                Гарантийные письма
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1" style="">


            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        {{__('Logout')}}
                    </button>
                </form>

            </li>
        </ul>
    </div>
</div>
