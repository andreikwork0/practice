window.$ =  window.jQuery =  require('jquery');
require('./bootstrap');
require('select2')

// In your Javascript (external .js resource or <script> tag)


$(document).ready(function() {


    $('.js-example-basic-single').select2({
        allowClear: true,
        placeholder: "Выберите из списка",
        "language": {
            "noResults": function(){
                return "Ничего не найдено";
            }
        },
    });

    var deleteModal = document.getElementById('deleteModal')
    deleteModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var action      =  button.getAttribute('data-bs-delete-id')
        console.log(action)
        var textModale  =  button.getAttribute('data-bs-text')
        console.log(textModale)
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        var modalBodyForm = deleteModal.querySelector('.modal-content form')
        var modalBodyP = deleteModal.querySelector('.modal-body p')
        modalBodyForm.action = action
        modalBodyP.innerHTML = textModale
    })
});

