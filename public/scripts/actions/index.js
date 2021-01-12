let rafflePrizes = new Vue({
    el: "#raffle",
    data: {
        message: 'Для розыгрыша кликните на кнопку Запуск. Количество розыгрышей не ограничено.',
        show: {
            loading: false,
            prize: false,
            actions: false,
            message: true
        },
        user: {
            id: 0,
            name: '',
            score: 0
        },
        prize: {
            type: '',
            name: '',
            value: 0
        }
    },
    created: function() {
        axios.get('/api/user/info').then((response) => {
            this.user = response.data.data;
        });
    },
    methods: {
        go: function () {
            this.setLoading();
            axios.get('/api/raffle/start').then((response) => {
                this.prize = response.data.data;
                this.setPrize();
            });
        },

        take: function () {
            this.setLoading();
            axios.get('/api/raffle/take').then((response) => {
                let data = response.data.data;
                this.user.score = data.score;
                this.message = data.message;
                this.setMessage();
            });
        },

        convert: function () {
            this.setLoading();
            axios.get('/api/raffle/convert').then((response) => {
                let data = response.data.data;
                this.user.score = data.score;
                this.message = data.message;
                this.setMessage();
            });
        },

        refuse: function () {
            this.setLoading();
            axios.get('/api/raffle/refuse').then((response) => {
                let data = response.data.data;
                this.user.score = data.score;
                this.message = data.message;
                this.setMessage();
            });
        },

        setLoading: function () {
            this.show.loading = true;
            this.show.prize = false;
            this.show.actions = false;
            this.show.message = false;
        },

        setPrize: function () {
            this.show.loading = false;
            this.show.prize = true;
            this.show.actions = true;
            this.show.message = false;
        },

        setMessage: function () {
            this.show.loading = false;
            this.show.prize = false;
            this.show.actions = false;
            this.show.message = true;
        }

    }
});