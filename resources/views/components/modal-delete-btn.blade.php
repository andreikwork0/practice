@props(['text', 'url'])
<a class="p-2 mx-1"  href="#" >
    <button type="button" class="border-0 bg-transparent"
            data-bs-toggle="modal"
            data-bs-target="#deleteModal"
            data-bs-text="{{$text}}"
            data-bs-delete-id="{{$url}}">
        @svg('trash3', 'w-6 h-6 text-dark icon-index')
    </button>
</a>


