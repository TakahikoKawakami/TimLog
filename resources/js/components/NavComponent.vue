<template>
    <nav id="nav-drawer">
        <input id="nav-input" type="checkbox" class="nav-unshown">
        <label id="nav-open" for="nav-input"><span></span></label><span class="title">TicketTimer {{ ticketNum }}</span>
        <label id="nav-close" for="nav-input">close</label>
        <div id="nav-content">
            <ul class="main-nav">
                <li><a href="#">home</a></li>
                <li><a href="#">setting</a></li>
                <li><a href="#">how to use</a></li>
                <li><a href="#">logout</a></li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                ticketNum: 'test'
            }
        },
    }
</script>
<style scoped>
        /*--ハンバーガーメニュー--*/
        #nav-drawer  {
            position: relative;
        }
        .nav-unshown {
            display: none;
        }
        #nav-open {
            display: inline-block;
            width: 30px;
            height: 22px;
            vertical-align: middle;
        }
        #nav-open span, #nav-open span:before, #nav-open span:after {
            position: absolute;
            height: 3px;
            width: 25px;
            border-radius: 3px;
            background: #555;
            display: block;
            content: '';
            cursor: pointer;
        }
        #nav-open span:before {
            bottom: -8px;
        }
        #nav-open span:after {
            bottom: -16px;
        }
        #nav-close {
            display: none;
            position: fixed;
            z-index: 99;
            top:  0;
            width: 30%;
            right: 0%;
            height: 100%;
            background: black;
            opacity: 0;
            transition: .3s ease-in-out;
        }
        #nav-content {
            overflow: auto;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;/*最前面に*/
            width: 70%;/*右側に隙間を作る（閉じるカバーを表示）*/
            max-width: 330px;/*最大幅（調整してください）*/
            height: 100%;
            background: #fff;/*背景色*/
            transition: .3s ease-in-out;/*滑らかに表示*/
            -webkit-transform: translateX(-105%);
            transform: translateX(-105%);/*左に隠しておく*/
        }
        /*チェックが入ったらもろもろ表示*/
        #nav-input:checked ~ #nav-close {
            display: block;/*カバーを表示*/
            opacity: .5;
        } 
        #nav-input:checked ~ #nav-content {
            -webkit-transform: translateX(0%);
            transform: translateX(0%);/*中身を表示（右へスライド）*/
            box-shadow: 6px 0 25px rgba(0,0,0,.15);
        }
</style>
