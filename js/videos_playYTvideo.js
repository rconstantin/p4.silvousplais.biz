
var yt_video_id = $('#yt-video').html();
console.log(yt_video_id);
var ga = document.createElement('script');
ga.type = 'text/javascript';
ga.async = false;
ga.src = 'http://www.youtube.com/player_api';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(ga, s);

var done = false;
var player;
console.log('line 21');
$('#thumbnail').on('click', function() {
 
    console.log('onYouTubePlayerAPIReady');
    player = new YT.Player('ytv', {
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

});
function onPlayerReady(evt) {
    console.log('onPlayerReady', evt);
    evt.target.playVideo();
}
function onPlayerError(evt) {
    console.log('onError',evt);
    // cleanup...
}

$('#ytv').on('click', function () {
    console.log('stopVideo');
    player.toggleVideo();
});
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

