<template>
    <div class="form-group">

        <div class="form-group">
            <h2 class="form-group">登录验证</h2>
        </div>

        <div class="form-group" :class="{'has-error': errorPhone}">
            
            <div class="col-md-4">
                <input id="inputHelpBlock" type="text" class="form-control" aria-describedby="helpBlock" name="phone" v-model="phone" placeholder="手机号码" required>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <button type="button" 
                class="btn btn-block" 
                :class="{disabled: counter !== 0}"
                @click="sendCode">
                发送验证码 
                <span v-show="counter > 0">({{counter}})</span>
            </button>
        </div>

        <div class="col-md-4 mb-3">
            <input type="text" class="form-control" name="code" v-model="code" placeholder="6位验证码" required>
        </div>

        <div class="col-md-4 mb-3">
            <button v-bind:disabled="!canSendCode" type="button" 
                class="btn btn-block" 
                @click="verifyCode">
                验证
            </button>
        </div>

        <div class="col-md-4 mb-3">
            <div v-if="hasVerifyMessage" class="alert alert-warning" role="alert">
            	{{ verifyMessage }}
            </div>
        </div>
        
    </div>
</template>
<script>
    export default{
        name: 'sendCodeField',
        props: [],
        data () {
            return {
                phone: null,
                code: null,
                counter: 0,
                verifyMessage: null,
                hasVerifyMessage: false,
                canSendCode: false,
            }
        },
        computed: {
            errorPhone () {
                if (this.phone == null || this.checkPhone(this.phone)) {
                    this.hasVerifyMessage = false;
                }else{
                	this.hasVerifyMessage = true;
                	this.verifyMessage = '手机号码不正确！';
                }
            }
        },
        methods: {
            startCount (value = 60) {
                this.counter = value

                var self = this
                var clock = setInterval(function () {
                    if (self.counter === 0) {
                        clearInterval(clock)
                        return
                    }
                    self.counter -= 1
                }, 1000)
            },
            sendCode () {
                if (this.phone == null || this.counter > 0 || !this.checkPhone(this.phone)) {
                    return
                }

                var self = this

                const body = { mobile: this.phone };
                
                fetch('/laravel-sms/verify-code', {
                	method: 'post',
                	body:    JSON.stringify(body),
                	headers: { 'Content-Type': 'application/json' },
                	})
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                        	console.log(data.success);
                        	console.log(data.message);
                        	this.hasVerifyMessage = true;
                			this.verifyMessage = data.message;
                			self.startCount();
                			self.canSendCode = true;
                        }else{
                        	this.hasVerifyMessage = true;
                			this.verifyMessage = data.message;
                        }
                    })
                    .then(error => {
                        console.log(error);
                    })
            },
            verifyCode () {
                if (this.code == null || this.code.length != 6) {
                    this.hasVerifyMessage = true;
                	this.verifyMessage = '请检查验证码是不是6位';
                }else{
                	console.log("正在验证验证码");
                	this.hasVerifyMessage = true;
                	this.verifyMessage = '正在验证验证码';
	                var self = this

	                const body = { mobile: this.phone, verifyCode: this.code };

	                console.log(body);
	                
	                fetch('/api/verifysms', {
	                	method: 'post',
	                	body:    JSON.stringify(body),
	                	headers: { 'Content-Type': 'application/json' },
	                	})
	                	.then(this.checkStatus)
	                    .then(res => res.json())
	                    .then(data => {
	                        console.log(data);
	                        cookies.set('token', data);
	                        this.$router.go(-1);
	                    })
	                    .then(error => {
	                        console.log(error);
	                    })
	            }
            },
            checkStatus(res) {
			    if (res.ok) { // res.status >= 200 && res.status < 300
			    	console.log('ok');
			    	this.hasVerifyMessage = true;
	                this.verifyMessage = '验证成功';
			        return res;
			    } else {
			        console.log(res);
			        this.hasVerifyMessage = true;
	                this.verifyMessage = '验证失败';
			    }
			},
            checkPhone: function (phone) {
                return !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0678]|18[0-9]|14[57])[0-9]{8}$/)
            },
        }
    }
</script>