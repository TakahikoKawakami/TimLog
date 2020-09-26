<template>
    <div class="wrapper">
        <h2>ログイン</h2>
        <p v-show="isError">認証に失敗しました。</p>
        <!-- <form class="form-horizontal" @submit.prevent="login"> -->
        <form class="form" @submit.prevent="login">
            <div class="form-group">
                <!-- <label class="control-label col-xs-5">メールアドレス</label> -->
                <label class="control-label">ユーザ名</label>
                <!-- <div class="col-xs-5"> -->
                    <input type="hidden" name="email" class="form-control" v-model="email">
                    <input type="name" name="name" class="form-control" v-model="name">
                <!-- </div> -->
            </div>
            <div class="form-group">
                <!-- <label class="control-label col-xs-5">パスワード</label> -->
                <label class="control-label">パスワード</label>
                <!-- <div class="col-xs-5"> -->
                    <input type="password" name="password" class="form-control" v-model="password">
                <!-- </div> -->
            </div>
            <div class="form-group container between-container">
                <!-- <div class="col-xs-offset-2"> -->
                    <button type="submit" class="btn btn-default">ログイン</button>
                    <router-link class="menu-text" to="/register">新規登録はこちら</router-link>
                <!-- </div> -->
            </div>
        </form>
        <!-- <div v-model="isLogin">{{ isLogin }}</div>
        <div v-model="isError">{{ isError }}</div>
        <div v-model="message">{{ message }}</div>
        <div v-model="token">{{ token }}</div> -->
    </div>
</template>

<script>
export default {
    data () {
        return {
            isError: false,
            name: '',
            email: '',
            password: '',
            isLogin: state.isLogin,
            accessToken: '',
            message: '',
            token:'',
        }
    },
    mounted() {
        this.accessToken = window.$cookies.get("access_token") || '';
        if (this.accessToken !== '') {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.accessToken;
            window.state.isLogin = true;
            this.isLogin = true;
            this.$router.push({path: '/ticket'});
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
                    // this.$router.push({path: '/'});
                }).catch(error => {
                    state.isLogin = false;
                    self.isLogin = false;
                    self.isError = true;
                });
        },
        login() {
            let self = this;
            axios.post('/api/login', {
                name: this.name,
                email: this.email,
                password: this.password
            }).then(res => {
                const token = res.data.access_token;
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                $cookies.set("access_token", token, 60 * 60 * 24);
                state.isLogin = true;
                self.isLogin = state.isLogin;
                self.token = $cookies.get("access_token");
                console.log('isLogin : ' + state.isLogin);
                console.log('token : ' + self.token);
                self.$router.push({path: '/ticket'});
            }).catch(error => {
                state.isLogin = false;
                self.isError = true;
                self.message = error;
            });
        }
    }
}
</script>

<style scoped>
    .wrapper {
        margin: auto;
        padding: auto;
        width:50%;
    }
    .container {
        display:flex;
    }
    .between-container {
        justify-content: space-between;
    }
</style>
