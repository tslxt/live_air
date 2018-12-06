<template>
	<div>
		<LiveVideo/>
		<ChatBox/>
	</div>
</template>

<script>
	import LiveVideo from './LiveVideo';
	import ChatBox from './ChatBox';

    export default {
		name: 'live',
		components: {
			LiveVideo,
            ChatBox
        },
    }
</script>
