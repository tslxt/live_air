
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('send-code-field', require('./components/SendCodeField.vue'));

const app = new Vue({
    el: '#app',

    created: function () {
    	var login = this.checkLogin();
    	console.log(login);
    	console.log()
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
    				.then(res => console.log('will not get here...'));
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
