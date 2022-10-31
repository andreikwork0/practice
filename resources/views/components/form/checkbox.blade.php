@props(['name', 'label' =>'', 'dfvalue' => false ])

    <div class="row align-content-center">
        <div class="col-md-3 text-end">
        </div>
        <div class="col-md-9">
            <div class="form-check">
                <input
                    class="form-check-input @error($name) is-invalid @enderror" type="checkbox"
                    name="{{$name}}"
                    id="{{$name}}"

                    @if ((old($name, $dfvalue)) == 'on' ||  (old($name, $dfvalue)) == '1')
                        {{'checked'}}
                    @endif
                     >
                <label class="form-check-label" for="{{$name}}">
                    {{$label}}
                </label>
                <x-form.erorr name="{{$name}}" />
            </div>
        </div>
    </div>








