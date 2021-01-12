jQuery(function ($){
    $('#register-form').on('submit', function (){
        var form = $(this),
            buttonSave = $('.save');

        if (form.find('.form-control:invalid').length == "0") {
            buttonSave.attr("disabled", true).find('span').removeClass('d-none');
            jQuery.ajax({
                data: form.serialize(),
                url: "/api/user/register",
                type: "POST",
                success: function(response){
                    buttonSave.removeAttr("disabled").find('span').addClass('d-none');
                    if (response.status == 'ok') {
                        location.href = '/';
                    } else {
                        if (response.data.message) {
                            $('.main-error').text(response.data.message);
                        }
                        $('.main-error').show();
                    }
                }
            });
        }

        return  false;
    });

    $('#register-form input').on('focus', function () {
        $('.main-error').hide();
    });
});