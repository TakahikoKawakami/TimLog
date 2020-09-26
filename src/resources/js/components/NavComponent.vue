<template>
<div>
  <slide right v-on:openMenu="getLoginState" :closeOnNavigation="true">
        <router-link v-if="isLogin" class="menu-text" to="/ticket">チケット一覧</router-link>
        <router-link v-if="!isLogin" class="menu-text" to="/login">ログイン</router-link>
        <a v-else class="menu-text" v-on:click='logout()' style="cursor: pointer;">ログアウト</a>
        <router-link class="menu-text" to="/register">登録</router-link>
        <a class="menu-text" href="/">TOPへ戻る</a>
    <!-- <a id="home" href="#">
      <span>Home</span>
    </a>
    <a id="about" href="#">
      <span>About</span>
    </a>
    <a id="contact" href="#">
      <span>Contact</span>
    </a> -->
  </slide>
    <!-- <div id="page-wrap"></div> -->
</div>
</template>

<script>
    export default {
        data () {
            return {
                isLogin: state.isLogin,
            }
        },
        methods: {
            logout() {
                let self = this;
                axios.post('/api/logout').then(res => {
                    axios.defaults.headers.common['Authorization'] = '';
                    state.isLogin = false;
                    $cookies.set("access_token", '');
                    self.$router.push({path: '/login'});
                });
            },
            getLoginState() {
                console.log("login? : " + state.isLogin);
                this.isLogin = state.isLogin;
            },
        }
    }
</script>
<style scoped>
    .menu-text {
        color: #ffffff;
    }
    .bm-burger-button {
        position:unset !important;
        display:inline-block !important;
        width: 12% !important;
        height: 12% !important;
        left: 10% !important;
        top: 0px !important;
    }
</style>
