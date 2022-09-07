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
});

