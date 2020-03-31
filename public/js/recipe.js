var selectedValues = [];
$(document ).ready(function() {

    $('#add-select-ingredient').click(function () {
        var template = $('#hidden-ingred-tmp').clone();
        template.removeAttr('id');
        template.show();
        $('#toAppend-block').append(template);
    });
    $(document ).delegate( '.del-select-ingred', "click", function() {
        $(this).closest('.select-ingredient').remove();
    });

    $(document ).delegate( '.select-ingredient', "change", function(e) {
        e.preventDefault();
        var select_value_elem = $(this);
        var select_value = $(this).val();
        $( "select.select-ingredient " ).not(this).find('option:selected').each(function() {
            if($(this).val() == select_value) {
                alert('Ингридент уже выбран');
                select_value_elem.val('');
                return false;
            }
            return true;
        });
    });
    $(document ).delegate( '.delete-rel', "click", function(e) {
        e.preventDefault();
        if(confirm('Действительно убрать ингредиет с списка?')) {
            var data_ingr_id =  $(this).attr('data-ingr-id');
            $('form[data-form-id="'+data_ingr_id+'"]').submit();
        }
    })
    $(document ).delegate( '.delete-newRel', "click", function(e) {
        e.preventDefault();
        $(this).closest('.newItm').remove();
    })

    $('#save-ingredient:not(:disabled)').click(function (e) {
        e.preventDefault();
        var form = $('#addIngredForm');
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function (response) {
                if(typeof response.errors !=="undefined") {
                    $.each(response.errors, function(key, value){
                        jQuery('.alert-danger').show();
                        jQuery('.alert-danger').html('<p>'+value+'</p>');
                        setTimeout(function () {
                            jQuery('.alert-danger').hide();
                        }, 1000);
                    });
                }

                if(typeof response.ingredient !=="undefined") {
                    $('#save-ingredient').attr('disabled', true);
                    $('input[name="title"]').keyup(function() {
                        if($(this).val() != '') {
                            $('#save-ingredient').removeAttr('disabled');
                        }
                    });
                    $('<option value="'+response.ingredient.id+'">'+response.ingredient.title+'</option>').insertAfter( $( ".insert_after" ) );
                    // $('.select-ingredient').prepend();
                    $("#addIngredientModal .close").click();
                    $(".alert-success").show();
                    setTimeout(function () {
                        $(".alert-success").hide();
                    }, 2000); // Привет, Джон

                    $(".alert-success").html('Ингридиент '+'"'+ response.ingredient.title +'"' + ' был добавлен');
                }
            }
        });
    });
});
