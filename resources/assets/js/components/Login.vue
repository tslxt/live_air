<template>
    <div class="form-group mt-5">

        <div class="form-group">
            <h2 class="form-group text-center">登录验证</h2>
        </div>

        <div class="form-group" :class="{'has-error': errorPhone}">
            
            <div class="col-md-4">
                <input id="inputHelpBlock" type="text" class="form-control" aria-describedby="helpBlock" name="phone" v-model="phone" placeholder="手机号码" required>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <button type="button" 
                class="btn btn-block btn-primary" 
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
                class="btn btn-block btn-primary" 
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
    import {login} from '../helpers/auth';
    import {sendSms} from '../helpers/auth';
    export default{
        name: 'login',
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

                const body = { mobile: this.phone };

                sendSms(body)
                    .then((res) => {
                        this.canSendCode = true;
                        this.hasVerifyMessage = true;
	                    this.verifyMessage = '验证码已经发送，请注意查收';
                    })
                    .catch((error) => {
                        this.$store.commit('loginFailed', {error});
                        this.hasVerifyMessage = true;
	                    this.verifyMessage = '验证码发送失败';
                    });
                
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
                    
                    login(body)
                        .then((res) => {
                            this.$store.commit("loginSuccess", res);
                            this.$router.back();
                        })
                        .catch((error) => {
                            this.$store.commit("loginFailed", {error});
                            this.hasVerifyMessage = true;
	                        this.verifyMessage = '登录验证失败';
                        });
                    
	            }
            },
            checkPhone: function (phone) {
                return !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0678]|18[0-9]|14[57])[0-9]{8}$/)
            },
        }
    }
</script>