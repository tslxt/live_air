<template>
	<div>
		<div class="collapse" id="navbarToggleExternalContent">
		    <div class="bg-dark p-4">
		      <div class="card">
				  <img class="card-img-top rounded " :src="profileImageUrl" alt="Card image cap">
				  <div class="card-body">
				    <h5 class="card-title">{{$root.user.name || "未注册用户"}}</h5>
				    <p class="card-text">{{$root.user.phone}}</p>
				    <button @click="inputInfo" class="btn btn-primary btn-block">完善个人信息</button>
				  </div>
			</div>
		    </div>
		</div>
		<nav class="navbar navbar-dark bg-dark">
		    <div class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>

		    </div>
		    <span v-show="!this.$root.user.name" class="badge badge-pill badge-info">完善信息后获得更好体验</span>
		</nav>
	</div>
	
</template>

<script>
	export default {
		name: "Navbar",
		props: [],
		data () {
			return {
				profileImageUrl: "/storage/appIcons/profile.jpg",
				username: "未注册用户",
				phone: this.$root.user.phone,
			}
		},
		mounted() {
	        // console.log('navbar', this.$root.user);
	    },
		methods: {
			inputInfo() {
				this.$router.push('/userinfo');
			},

		}
	}
</script>