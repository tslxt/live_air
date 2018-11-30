<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.bootcss.com/flv.js/1.4.0/flv.min.js"></script>

    <title>Live TEST</title>
  </head>
  <body>
    <video class="col-sm bg-primary" id="videoElement"></video>

    <div class="container">
        <div class="control">
            <div class="btn btn-block btn-success" onclick="livePlay()">play</div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        var flvPlayer;
        if ($(document.ready)) {
            if (flvjs.isSupported()) {
                var videoElement = document.getElementById('videoElement');
                flvPlayer = flvjs.createPlayer({
                    type: 'flv',
                    isLive: true,
                    url: 'ws://47.93.234.160:8000/live/STREAM_NAME.flv'
                });
                flvPlayer.attachMediaElement(videoElement);

                // flvPlayer.load();
                // flvPlayer.play();
            }
        }

        function livePlay() {
            // flvPlayer.unload();
            flvPlayer.load();
            flvPlayer.play();
        }
        
    </script>
    <style type="text/css">
        #videoElement {
            width: 100 %
        }
    </style>
  </body>
</html>