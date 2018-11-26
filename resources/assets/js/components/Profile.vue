<template>
	<div>
		<vueCropper
		        ref="cropper"
		        :img="option.img"
		        :outputSize="option.outputSize"
		        :outputType="option.outpuType"
		        :info="option.info"
		        :full="option.full"
		        :canMove="option.canMove"
		        :canMoveBox="option.canMoveBox"
		        :fixedBox="option.fixedBox"
		        :original="option.original"
		        :autoCrop="option.autoCrop"
		        :autoCropWidth="option.autoCropWidth"
		        :autoCropHeight="option.autoCropHeight"
		        :centerBox="option.centerBox"
		        :high="option.high"
		        :infoTrue="option.infoTrue"
		></vueCropper>
	</div>
</template>

<script>
	export default{
		name: 'Profile',
        props: [],
        data () {
        	return {
        		option: {
                    img : "/storage/appIcons/profile.jpg",
                    outputSize : 1,
                    outputType : "png",
                    info: true,
                    full: true,
                    canMove: true,
                    canMoveBox: true,
                    fixedBox: true,
                    original: true,
                    autoCrop: true,
                    autoCropWidth: 200,
                    autoCropHeight: 200,
                    centerBox: true,
                    high: true,
                    infoTrue: true
                }
        	}
        }
	}
</script>