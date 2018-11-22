require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App'
import Home from './components/Home'
import Live from './components/Live'
import Login from './components/Login'

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
            component: Live
        },
        {
            path: '/login',
            name: 'login',
            component: Login
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
            }
        }
    }
});