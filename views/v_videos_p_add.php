<br>Your video was successfully added to the database  on <?=Time::display($add_time);?>;<br>
More information relating to this video (click on thumbnail or video id to play video):<br> <br>
<div id="yt_video_id"> The Video Title is : <?=$title?> <br>
<img id="thumbnail" class="circular" src="<?=$thumbnail_url?>" alt="" width="60" height="60"><br>
<!--<label for='thumbnail'>&nbsp;The youtube video ID is: <?=$yt_video_id?></label><br>-->
The youtube video ID is: <div id='yt-video'><?=$yt_video_id?></div>
<div id="howToVideo" class="hidden"></div>
<!--<script type="application/javascript" src="/js/videos_playYTvideo.js"></script>-->
<script type="application/javascript">
$('#thumbnail').on('click', function() {
 //   playYTvideo(video_id);
    var yt_video_id = '<?=$yt_video_id?>';
    console.log(yt_video_id);
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = false;
    ga.src = 'http://www.youtube.com/player_api';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);

    var done = false;
    var player;
    console.log('line 23');
    function onYouTubePlayerAPIReady() {
        console.log('line 25');
        player = new YT.Player('howToVideo', {
            playerVars:{
                modestbranding:'1',
                autohide: '1'
            },
            height: '440',
            width: '840',
            videoId: yt_video_id,
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange,
                'onError': onPlayerError
            }
        });
   
    }
    function onPlayerReady(evt) {
        console.log('onPlayerReady', evt);
        evt.target.playVideo();
    }
    function onPlayerError(evt) {
        console.log('onError',evt);
        // cleanup...
    }
   
    function stopVideo() {
        console.log('stopVideo');
        player.stopVideo();
    }
    // grab video id of video playing
    function onPlayerStateChange(evt) {
        console.log('onPlayerStateChange', evt);
        if (evt.data == YT.PlayerState.PLAYING) {
            var url = evt.target.getVideoUrl();
            // "http://www.youtube.com/watch?v=gzDS-Kfd5XQ&feature=..."
            var match = url.match(/[?&]v=([^&]+)/);
            // ["?v=gzDS-Kfd5XQ", "gzDS-Kfd5XQ"]
            var videoId = match[1];
            console.log(videoId);
            console.log(url);

        }
    }
});
</script>