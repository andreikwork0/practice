@props(['name'])

@error($name)
<div class="alert alert-danger my-3 alert-dismissible fade show d-flex">
    @svg('exclamation-circle', 'w-30 h-6 text-danger')
    <div class="mx-3">
        {{$message}}
    </div>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@enderror


