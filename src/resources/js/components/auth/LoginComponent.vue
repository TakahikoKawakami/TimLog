<template>
    <div>
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
        }
    },
    methods: {
        login() {
            axios.post('/api/login', {
                email: this.email,
                password: this.password
            }).then(res => {
                const token = res.data.token;
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                state.isLogin = true;
                this.isLogin = true;
                // this.$router.push({path: '/login'});
            }).catch(error => {
                state.isLogin = false;
                this.isLogin = false;
                this.isError = true;
            });
        }
    }
}
</script>
