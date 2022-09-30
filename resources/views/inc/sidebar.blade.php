<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh;">
    <a href="/" class="d-flex align-items-center justify-content-between mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            @svg('person-workspace', 'w-50 h-10  text-white')
        <span class="fs-4 mx-2 d-inline-block">Практики</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        @roleis('umu')
        <li class="nav-item">
            <a href="{{route('companies.index')}}" class="nav-link text-white     @if(request()->routeIs('companies.*')) {{'active'}} @endif ">

                @svg('building', 'w-16 h-16 bi me-2 text-white')
                Организации
            </a>
        </li>
        @endroleis('umu')

        @roleis('umu', 'kaf')
        <li class="nav-item">
            <a href="{{route('practices.index')}}" class="nav-link text-white     @if(request()->routeIs('practices.*')) {{'active'}} @endif ">

                @svg('file-earmark-spreadsheet', 'w-16 h-16 bi me-2 text-white')
                Практики
            </a>
        </li>
        @endroleis('umu')

{{--        @roleis('kaf')--}}
{{--        <li>--}}
{{--            <a href="{{route('contact_people.index')}}" class="nav-link text-white   @if(request()->routeIs('contact_people.*')) {{'active'}} @endif ">--}}
{{--                @svg('people', 'w-16 h-16 bi me-2 text-white')--}}
{{--                Контактные лица--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        @endroleis('kaf')--}}

{{--        @roleis('umu')--}}
{{--        <li>--}}
{{--            <a href="{{route('agreements.index')}}" class="nav-link text-white @if(request()->routeIs('agreements.*')) {{'active'}} @endif">--}}
{{--                @svg('file-text', 'w-16 h-16 bi me-2 text-white')--}}
{{--                Договоры--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        @endroleis('umu')--}}

{{--        @roleis('kaf')--}}
{{--        <li>--}}
{{--            <a href="{{route('grn_letters.index')}}" class="nav-link text-white @if(request()->routeIs('grn_letters.*')) {{'active'}} @endif">--}}
{{--                @svg('envelope', 'w-16 h-16 bi me-2 text-white')--}}
{{--                Гарантийные письма--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        @endroleis('kaf')--}}

        @roleis('umu')

                <li>
                    <a href="{{route('users.index')}}" class="nav-link text-white @if(request()->routeIs('users.*')) {{'active'}} @endif">
                        @svg('person-lines-fill', 'w-16 h-16 bi me-2 text-white')
                        Пользователи
                    </a>
                </li>
        @endroleis
    </ul>

</div>
