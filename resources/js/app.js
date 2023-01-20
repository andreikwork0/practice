window.$ =  window.jQuery =  require('jquery');
require('./bootstrap');
require('select2')

require('suggestions-jquery')

// In your Javascript (external .js resource or <script> tag)

//
// import { createApp } from 'vue'
// const app = createApp({})
// import pr_students from './components/PrStudents.vue';
// app.component('pr_students', pr_students)
// app.mount('#app')



$(document).ready(function() {




    // логика для /distribution_practices/{id}/pr_student
    try {

        $("#col_edit_ss input[type='checkbox']").on('change', function (e){

            //console.log(e.target)
           let n_count = $("#col_edit_ss input:checked").length
            let n_fact = $('#dp_num_fact')[0].innerHTML;
           $('#c_s_dp')[0].innerHTML = n_count;
           // if  (n_fact > n_count)
           // console.log(n_fact)
        });

    } catch (e) {
        console.log(e.message)
    }


    //https://select2.org/data-sources/ajax
    try {



        $('#mySelect2').select2({
            ajax: {
                url: '/api/companies/search',
                delay: 250,
                dataType: 'json',
                // templateResult : formatRepo,
                // templateSelection : formatRepoSelection,
                // minimumInputLength: 1,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    // Query parameters will be ?search=[term]&type=public
                    return query;
                }
            }
        });
        //
        // function formatRepo (repo) {
        //     if (repo.loading) {
        //         return repo.text;
        //     }
        //
        //     var $container = $(
        //         "<div class='select2-result-repository clearfix'>" +
        //         "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
        //         "<div class='select2-result-repository__meta'>" +
        //         "<div class='select2-result-repository__title'></div>" +
        //         "<div class='select2-result-repository__description'></div>" +
        //         "<div class='select2-result-repository__statistics'>" +
        //         "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
        //         "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
        //         "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
        //         "</div>" +
        //         "</div>" +
        //         "</div>"
        //     );
        //
        //     $container.find(".select2-result-repository__title").text(repo.full_name);
        //     $container.find(".select2-result-repository__description").text(repo.description);
        //     $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
        //     $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
        //     $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");
        //
        //     console.log('fds')
        //     return $container;
        // }
        //
        // function formatRepoSelection (repo) {
        //     console.log('fds1')
        //     return repo.full_name || repo.text;
        // }
    }
     catch (e) {
        console.log(e.message)
     }



    $('.dp_inc_al').click( function (){

        let checkboxs =  $(this).closest('table').find("input[type='checkbox']")
        checkboxs.each(function (){
            checkbox = $(this);
            checkbox.attr("checked", !checkbox.attr("checked"))
        })
    })



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

    try {

        $('#company_id').on('select2:select', function (e) {

            $('#org_s_wrap').hide()
            var data = e.params.data;
            var orgStuctureSelect =    $('#org_structure_id');
            orgStuctureSelect.val(null).trigger('change');
            $('#org_structure_id option').remove();

            let bui = $('#company_id').val()
            axios({
                method: 'get',
                    url: '/api/org_str/search?company='+bui,
                responseType: 'stream'
            })
                .then(function (response) {
                    //data1 = JSON.parse( response.data)
                    orgs_ss = response.data.results
                    if (orgs_ss.length > 0) {
                        $('#org_s_wrap').show()
                    }
                    orgs_ss.forEach((orgs_s) => {
                        var option = new Option(orgs_s.name, orgs_s.id, false, false);
                        orgStuctureSelect.append(option).trigger('change');
                    });
                    orgStuctureSelect.val(null).trigger('change');
                });
        });
    }
    catch (e) {
        console.log(e.message)
    }
});

