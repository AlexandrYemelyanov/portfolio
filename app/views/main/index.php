<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column" id="raffle">
    <header class="masthead mb-5">
        <div class="inner">
            <div class="masthead-brand">
                <img src="/public/img/logo-main.svg" alt="" width="230" height="42">
            </div>
            <ul class="list-inline nav-masthead mt-2 mb-0">
                <li class="list-inline-item">Здравствуйте, <span class="font-weight-bold">{{user.name}}</span></li>
                <li class="list-inline-item">Баллы: <span class="font-weight-bold">{{user.score}}</span></li>
                <li class="list-inline-item"><a href="/logout/">Выход</a></li>
            </ul>
        </div>
    </header>

    <main role="main" class="inner cover">
        <h1 class="cover-heading mb-4">Розыгрыш призов</h1>
        <p class="lead" v-if="show.message">{{message}}</p>
        <p class="lead pb-4"><span v-if="show.loading || show.prize">Ваш приз:</span>
            <span v-if="show.loading" class="spinner-border" role="status" aria-hidden="true"></span>
            <span v-if="show.prize">{{prize.name}}</span>
            <span v-if="show.actions">
                <br><br>
                <button @click="take()" class="btn btn-success">Забрать</button>
                <button @click="convert()" v-if="prize.type == 'mon'" class="btn btn-warning">Конвертировать</button>
                <button @click="refuse()" class="btn btn-outline-danger">Отказаться</button>
            </span>
        </p>
        <p class="lead">
            <button @click="go()" class="btn btn-lg btn-danger font-weight-bold">Запуск</button>
        </p>
    </main>

</div>

<script src="/public/scripts/axios.min.js" type="text/javascript"></script>
<script src="/public/scripts/qs.js" type="text/javascript"></script>
<script src="/public/scripts/vue.js" type="text/javascript"></script>
<script src="/public/scripts/actions/index.js" type="text/javascript"></script>