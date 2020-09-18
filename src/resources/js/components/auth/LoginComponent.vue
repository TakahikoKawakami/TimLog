<template>
    <div>
        <button v-on:click = 'me()'>ユーザ</button>
        <p v-show="isError">認証に失敗しました。</p>
        <form @submit.prevent="login">
            <h1>ログイン</h1>
            メールアドレス: <input type="email" v-model="email">
            パスワード: <input type="password" v-model="password">
            <span v-model="isLogin">{{ isLogin }}</span>

            <button type="submit" class="btn btn-primary">ログイン</button>
        </form>
    </div>
</template>

<script>
export default {
    data () {
        return {
            isError: false,
            email: '',
            password: '',
            isLogin: state.isLogin,
            accessToken: '',
        }
    },
    mounted() {
        this.accessToken = window.$cookies.get("access_token") || '';
        if (this.accessToken !== '') {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.accessToken;
            state.isLogin = true;
            this.isLogin = true;
            this.$router.push({path: '/'});
        }
    },
    methods: {
        me() {
            axios.post('/api/refresh')
                .then(res => {
                    const token = res.data.access_token;
                    console.log('token : ' + token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                    state.isLogin = true;
                    this.isLogin = true;
                    this.$router.push({path: '/'});
                }).catch(error => {
                    state.isLogin = false;
                    this.isLogin = false;
                    this.isError = true;
                });
        },
        login() {
            axios.post('/api/login', {
                email: this.email,
                password: this.password
            }).then(res => {
                const token = res.data.access_token;
                console.log('token : ' + token);
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                window.$cookies.set("access_token", token, 60 * 60 * 24);
                state.isLogin = true;
                this.isLogin = true;
                this.$router.push({path: '/'});
            }).catch(error => {
                state.isLogin = false;
                this.isLogin = false;
                this.isError = true;
            });
        }
    }
}
</script>
