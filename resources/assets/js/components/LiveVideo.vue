<template>
	<div>
		<video 
			id="live_video" 
			v-bind:src="channel_id"
			controls="controls" 
			x5-video-player-type="h5" 
			x5-video-player-fullscreen="true" 
			autoplay="true" 
			webkit-playsinline playsinline x5-playsinline 
			style="width: 100%; display: block;" 
			x5-video-orientation="landscape|portrait" >
		</video>
	</div>
</template>

<script>
    export default {
		name: 'live-video',
        props: [],
    	data () {
    		return {
    			server: "http://47.93.234.160:8000/live/",
    			channel_id:null,
    		}
    	},
        mounted() {
            console.log(this.$route.params);
            let course_id = this.$route.params.course_id;
            this.channel_id = this.server + course_id + "/index.m3u8";
            
        },
        method: {
        }
    }
</script>
