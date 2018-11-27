require('./bootstrap');
const Pomelo = require('./PomeloClient');


import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

import App from './components/App'
import Home from './components/Home'
import Navbar from './components/Navbar'
import Live from './components/Live'
import Chat from './components/Chat'
import Login from './components/Login'
import UserInfo from './components/UserInfo'
import ChatBeautiful from 'vue-beautiful-chat'


Vue.use(ChatBeautiful)

import VueCropper  from 'vue-cropper'

Vue.use(VueCropper)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/live/:course_id',
            name: 'live',
            components: {
                default: Live,
                navbar: Navbar,
                chat: Chat
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/userinfo',
            name: 'userinfo',
            component: UserInfo
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    data : {
        user: {

        },
        pomeloState: false,
        hasVerify: false,
        course_id: null
    },
    created: function () {
        var login = this.checkLogin();
        console.log(login);
        console.log(this.$route.path);
        console.log(this.$route.params);
        this.course_id = this.$route.params.course_id;
        if (login) {
            console.log("login success!");
        }else{
            router.push('/login');
        }
    },

    methods:{
        checkLogin(){
            console.log("checkLogin");
            let token = cookies.get('token')
            if (token) {
                // const body = { a: 1 };
                fetch('/api/details', {
                    method: 'post',
                    // body:    JSON.stringify(body),
                    headers: { 'Content-Type': 'application/json',
                            'Accept':'application/json',
                            'Authorization': 'Bearer ' + token,
                        },
                    })
                    .then(this.checkStatus)
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        this.user = data;
                    });
                    return true;
            }else{
                return false;
            }
        },
        checkStatus(res) {
            if (res.ok) { // res.status >= 200 && res.status < 300
                console.log('ok');
                return res;
            } else {
                console.log(res.statusText);
                 this.MyCustomError(res.statusText);
            }
        },
        MyCustomError(text) {
            console.log('thow', text);
            router.push('/login');
        }
    }
});