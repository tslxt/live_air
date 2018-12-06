<template>
	<div v-if="currentUser">
		<div class="collapse" id="navbarToggleExternalContent">
		    <div class="bg-dark p-4">
		      <div class="card">
						<div class="text-center mt-3">
							<img class="rounded-circle" v-bind:src="currentUser.image||'/storage/appIcons/profile.jpg'">
						</div>
				  
				  <div class="card-body">
						<div v-if="isEditMode">
							<label class="exampleForPhone">您的注册手机号码是：{{currentUser.phone}}</label>
							<input id="inputHelpBlock" type="text" class="form-control" aria-describedby="helpBlock" v-model="username" placeholder="您的名字">
							<div v-if="verifyMessage" class="alert alert-warning" role="alert">
									{{ verifyMessage }}
							</div>
						</div>
						<div v-else>
							<h5 class="card-title">{{currentUser.name || "未注册用户"}}</h5>
							<p class="card-text">{{currentUser.phone}}</p>
						</div>
						<button v-on:click.prevent="changeEditMode" class="btn btn-primary btn-block mt-2">{{editText}}</button>
				    
				  </div>
			</div>
		    </div>
		</div>
		<nav class="navbar navbar-dark bg-dark">
		    <div class="navbar-toggler" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>

		    </div>
		    <span v-show="!currentUser.name" class="badge badge-pill badge-info">完善信息后获得更好体验</span>
		</nav>
	</div>
	
</template>

<script>
	import {updateUserInfo} from '../helpers/auth';
	export default {
		name: 'app-header',
		props: [],
		data () {
			return {
				isEditMode: false,
				editText: '完善个人资料',
				verifyMessage: null,
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
						this.$store.commit('updateUserLocal', {name: value});
				}
			},
		},
		methods: {
			changeEditMode () {
				if (this.isEditMode) {
					const body = { name: this.username };

					updateUserInfo(body)
							.then((res) => {
								this.$store.commit('updateUserRemote', res.data);
								this.verifyMessage = null;
								this.isEditMode = false;
								this.editText = '完善个人资料';
							})
							.catch((error) => {
								this.verifyMessage = '信息更新失败';
							});
				} else {
					this.isEditMode = true;
					this.editText = '更新个人资料';
				}
			},
			inputInfo() {
				this.$router.push('/userinfo');
			},

		}
	}
</script>

<style scoped>

	.navbar-toggler {
	 	border: 0;
	 	border-radius: 0;
	}
	.navbar {
		padding: 0; 
	}
</style>