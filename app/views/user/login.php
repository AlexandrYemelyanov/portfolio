<form class="form-signin needs-validation" _lpchecked="1" novalidate id="sign-form">
    <img class="mb-4" src="/public/img/logo-main.svg" alt="" width="230" height="42">

    <h1 class="h3 mb-3 font-weight-normal">Вход</h1>

    <div class="mb-2 form-row">
        <label for="inputEmail">E-mail</label>
        <input type="email" name="email" id="inputEmail" class="form-control" required="true" autocomplete="off">
    </div>

    <div class="mb-1 form-row">
        <label for="inputPassword">Пароль</label>
        <input type="password" name="pass" id="inputPassword" class="form-control" required="true" autocomplete="off">
    </div>
    <div class="checkbox mb-3">
        <label class="text-center">
            <a href="/register/">Регистрация</a>
        </label>
    </div>
    <button class="btn btn-lg btn-danger btn-block save" type="submit">Войти <span class="d-none spinner-border spinner-border-sm mb-1" role="status" aria-hidden="true"></span></button>
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

<script src="/public/scripts/actions/login.js" type="text/javascript"></script>