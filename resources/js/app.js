window.$ =  window.jQuery =  require('jquery');
require('./bootstrap');
require('select2')

require('suggestions-jquery')

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



    try {
        $('#education_type_id').on('select2:select', function (e) {

            var data = e.params.data;
            var pulpitSelect =    $('#pulpit_id');
            pulpitSelect.val(null).trigger('change');
            $('#pulpit_id option').remove();

            axios({
                method: 'get',
                url: '/ajax/pulpitbyedtype/'+data.id,
                responseType: 'stream'
            })
            .then(function (response) {
                pulpits = JSON.parse(response.data.data)
                pulpits.forEach((pulpit) => {
                    var option = new Option(pulpit.name, pulpit.id, false, false);
                    pulpitSelect.append(option).trigger('change');
                });

                 pulpitSelect.val(null).trigger('change');
            });
        });

        // $('#education_type_id').on('select2:clear', function (e) {
        //     $('#pulpit_id').val(null).trigger('change');
        //     $('#pulpit_id option').remove();
        //     var option = new Option('', '', false, false);
        //     $('#pulpit_id option').append(option).trigger('change');
        // })


    } catch (e){
        console.log(e.message)
    }

    try {
        $("#comp_helper").suggestions({
            token: "81018a8838b2fde74d0374b83fc2a0b217fc8ffe",
            type: "PARTY",
            /* Вызывается, когда пользователь выбирает одну из подсказок */
            onSelect: function(suggestion) {
                data = suggestion.data;
                 console.log(data)



                if (data.name){

                    name = data.name.full_with_opf
                    short_with_opf = data.name.short_with_opf


                    if (name) {
                        $('#name_full').val(name);
                    }

                    if (short_with_opf) {
                        $('#name').val(short_with_opf);
                    }

                }


                if (data.address) {
                    address = data.address.unrestricted_value;
                    if (address) {
                        $('#legal_adress').val(address);
                    }
                }



                inn = data.inn;
                kpp = data.kpp;

                if (inn) {
                    $('#inn').val(inn);
                }


                if (kpp){
                    $('#kpp').val(kpp);
                }

                if (data.management){
                    if (data.management.name) {
                        mng_f_name = data.management.name
                        mng_arr = mng_f_name.split(" ")
                        $('#mng_surname').val(mng_arr[0]);
                        $('#mng_name').val(mng_arr[1]);
                        if(mng_arr[2]) {
                            $('#mng_patronymic').val(mng_arr[2]);
                        }
                    }
                    if (data.management.post) {
                        mng_post = data.management.post
                        $('#mng_job').val(mng_post);
                    }
                }


            }
        });
    } catch (e) {
        console.log(e.message)
    }
});

