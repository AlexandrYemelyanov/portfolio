<form class="form-signin form-register needs-validation" _lpchecked="1" id="register-form" novalidate>
   <img class="mb-4" src="/public/img/logo-main.svg" alt="" width="230" height="42">

    <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

    <div class="row form-row">
        <div class="col-6 mb-2">
            <label for="field1">E-mail</label>
            <input type="email" name="email" id="field1" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field2">Банковский счет</label>
            <input type="text" name="bank_account" id="field2" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field3">Имя</label>
            <input type="text" name="name" id="field3" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field4">Фамилия</label>
            <input type="text" name="last_name" id="field4" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field5">Почтовый индекс</label>
            <input type="text" name="zipcode" id="field5" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field6">Страна</label>
            <input type="text" name="country" id="field6" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field7">Область</label>
            <input type="text" name="state" id="field7" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field8">Город</label>
            <input type="text" name="city" id="field8" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field9">Улица</label>
            <input type="text" name="street" id="field9" class="form-control" required="true" autocomplete="off">
        </div>
        <div class="col-6 mb-2">
            <label for="field10">Дом</label>
            <input type="text" name="appartment" id="field10" class="form-control" required="true" autocomplete="off">
        </div>
    </div>

    <div class="checkbox mb-3">
        <label class="text-center">
            <a href="/auth/">Авторизация</a>
        </label>
    </div>
    <button class="btn btn-lg btn-danger btn-block save" type="submit">Отправить <span class="d-none spinner-border spinner-border-sm mb-1" role="status" aria-hidden="true"></span></button>
    <div class="main-error invalid-feedback">
        Произошла ошибка. Попробуйте позже
    </div>
</form>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<script src="/public/scripts/actions/register.js" type="text/javascript"></script>