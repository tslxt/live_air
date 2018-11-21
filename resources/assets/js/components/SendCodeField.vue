<template>
    <div class="form-group">

        <div class="form-group">
            <h2 class="form-group">登录验证</h2>
        </div>

        <div class="form-group" :class="{'has-error': errorPhone}">
            
            <div class="col-md-4">
                <input type="text" class="form-control" name="phone" v-model="phone" placeholder="手机号码" required>

                <span class="help-block" v-show="errorPhone">
                    <strong>{{errorPhone}}</strong>
                </span>
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

        <div class="col-md-4">
            <input type="text" class="form-control" name="code" v-model="code" placeholder="6位验证码" required>
            <span class="help-block" v-show="errorCode">
                <strong>{{errorCode}}</strong>
            </span>
        </div>

        <div class="col-md-4 mb-3">
            <button type="button" 
                class="btn btn-block" 
                @click="verifyCode">
                验证
            </button>
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
                counter: 0
            }
        },
        computed: {
            errorPhone () {
                if (this.phone == null || this.checkPhone(this.phone)) {
                    return false
                }

                return '手机号码不正确！';
            },
            errorCode () {
                if (this.code == null || this.code.length == 4) {
                    return false
                }

                return '6 位验证码'
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
                
                fetch('api/lessons')
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        self.startCount();
                    })
                    .then(error => {
                        console.log(error);
                    })
            },
            verifyCode () {
                // if (this.code == null || thi.phone == null || !this.checkPhone(this.phone)) {
                //     return
                // }
                console.log("正在验证验证码");
                fetch('api/details', { method: 'post' } )
                    .then(data => {
                        console.log(data.status);
                    })
                    .then(error => {
                        console.log(error);
                    });
            },
            checkPhone: function (phone) {
                return !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0678]|18[0-9]|14[57])[0-9]{8}$/)
            }
        }
    }
</script>