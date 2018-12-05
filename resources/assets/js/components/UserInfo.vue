<template>
    <div class="form-group mt-5">

        <div class="btn " @click="back">返回</div>

        <form v-on:submit.prevent="updateUserInfo">
            <div class="form-group">
                <h2 class="form-group text-center">个人信息</h2>
            </div>

            <div class="form-group text-center">
                <img v-bind:src="imageSrc">
            </div>

            <div class="form-group">
                <div class="colmd-4">
                    <label class="exampleForPhone">您的注册手机号码是：{{currentUser.phone}}</label>
                    <input id="inputHelpBlock" type="text" class="form-control" aria-describedby="helpBlock" v-model="username" placeholder="您的名字">
                </div>
                
            </div>

            <div class="form-group">
                <input type="submit" value="更新个人资料" class="btn btn-block btn-primary">
            </div>

            <div class="form-group">
                <div v-if="hasVerifyMessage" class="alert alert-warning" role="alert">
                    {{ verifyMessage }}
                </div>
            </div>
        </form>

        
        
    </div>
</template>
<script>
    export default{
        name: 'UserInfo',
        props: [],
        data () {
            return {
                hasVerifyMessage: false,
                verifyMessage: "您忘记输入您的名字了",
            }
        },
        computed: {
            currentUser() {
				return this.$store.getters.currentUser;
            },
            username: {
                get () {
                    return this.currentUser.name;
                },
                set (value) {
                    this.$store.commit('updateUser', {name: value});
                }
            },
            imageSrc: {
                get () {
                    return this.currentUser.image || "/storage/appIcons/profile.jpg";
                }
            }
        },
        mounted() {
            console.log('userinfo mounted');
        },
        methods: {
            back () {
                this.$router.go(-1);
            },
            updateUserInfo () {
                console.log('更新个人信息！');
                console.log(this.$root.user);
                this.update();

            },
            update () {
                if (this.username == null ) {
                    this.verifyMessage = "您忘记输入您的名字了";
                    this.hasVerifyMessage = true;
                    return
                }

                var self = this

                const body = { name: this.username };
                let token = cookies.get('token');
                let user_id = this.$root.user.id;
                
                fetch('/api/user_update', {
                	method: 'post',
                	body:    JSON.stringify(body),
                	headers: { 'Content-Type': 'application/json',
                            'Accept':'application/json',
                            'Authorization': 'Bearer ' + token,
                        },
                    })
                    .then(this.checkStatus)
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        console.log(data);
                    	console.log(data.name);
                        this.$root.user.name = data.name;
                        this.verifyMessage = "用户信息更新成功";
                        this.hasVerifyMessage.true
                    })
                    .then(error => {
                        console.log(error);
                    })
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
	                this.verifyMessage = '用户信息更新失败';
			    }
			}
        }
    }
</script>

<style type="text/css">
    img {
        border-radius: 100px;
    }
</style>