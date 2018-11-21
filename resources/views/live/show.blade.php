<html lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="monicaqin">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>测试视频test</title>
  
</head>

<body style="
    margin-top: 0px;
    margin-left: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
">
 
<div>
<video id="test_video" src="http://47.93.234.160:8000/live/{{$channel_id}}/index.m3u8" controls="controls" x5-video-player-type="h5" x5-video-player-fullscreen="true" autoplay="true" webkit-playsinline playsinline x5-playsinline style="width: 100%; display: block;" x5-video-orientation="landscape|portrait"></video>
</div>



<script type="text/javascript">
  test_video.style.width = screen.width + "px";
  // test_video.style.height = "100%"; 
  test_video.style["object-position"]= "0px 0px"

</script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
         
 


</body></html>