<template>
    <div class="wrapper">
        <h2>ユーザー登録</h2>
        <p v-show="isError">{{ message.name }}</p>
        <p v-show="isError">{{ message.password }}</p>
        <form class="form" @submit.prevent="register">
            <div class="form-group">
                <label class="control-label">ユーザーID</label>
                <!-- <div class="col-xs-6"> -->
                    <input type="text" name="name" class="form-control" v-model="name">
                <!-- </div> -->
            </div>
            <div class="form-group">
                <!-- <label class="control-label">メールアドレス</label> -->
                <!-- <div class="col-xs-6"> -->
                    <input type="hidden" name="email" class="form-control" v-model="email">
                <!-- </div> -->
            </div>
            <div class="form-group">
                <label class="control-label">パスワード</label>
                <!-- <div class="col-xs-6"> -->
                    <input type="password" name="password" class="form-control" v-model="password">
                <!-- </div> -->
            </div>
            <div class="form-group">
                <label class="control-label6">パスワード(確認用)</label>
                <!-- <div class="col-xs-6"> -->
                    <input type="password" name="password" class="form-control" v-model="password_confirmation">
                <!-- </div> -->
            </div>
            <div class="form-group container between-container">
                <!-- <div class="col-xs-offset-2"> -->
                    <button type="submit" class="btn btn-default">新規登録</button>
                    <router-link class="menu-text" to="/login">ログインはこちら</router-link>
                <!-- </div> -->
            </div>
        </form>
        <!-- <div v-model="isLogin">{{ isLogin }}</div>
        <div v-model="isError">{{ isError }}</div>
        <div v-model="message">{{ message }}</div>
        <div v-model="token">{{ token }}</div> -->
    </div>
    <!-- <div>
        <p v-show="isError">認証に失敗しました。</p>
        <form @submit.prevent="login">
            <h1>ログイン</h1>
            ユーザー名: <input type="name" v-model="name">
            メールアドレス: <input type="email" v-model="email">
            パスワード: <input type="password" v-model="password">
            もっかい: <input type="password" v-model="password_confirmation">
            <span v-model="isLogin">{{ isLogin }}</span>

            <button type="submit" class="btn btn-primary">ログイン</button>
        </form>
    </div> -->
</template>

<script>
export default {
    data () {
        return {
            isError: false,
            name: '',
            email: 'example' + this.name +'@example.com',
            password: '',
            password_confirmation: '',
            message:{},

            isLogin: state.isLogin,
        }
    },
    methods: {
        register() {
            let self = this;
            this.email = 'example' + this.name +'@example.com';
            axios.post('/api/register', {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            }).then(res => {
                const token = res.data.access_token;
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                $cookies.set("access_token", token, 60 * 60 * 24);
                state.isLogin = true;
                self.isLogin = state.isLogin;
                self.token = $cookies.get("access_token");
                console.log('isLogin : ' + state.isLogin);
                console.log('token : ' + self.token);
                self.$router.push({path: '/login'});
            }).catch(error => {
                state.isLogin = false;
                self.isError = true;
                self.message = error.response.data.error;
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
