

var ga = document.createElement('script');
ga.type = 'text/javascript';
ga.async = false;
ga.src = 'http://www.youtube.com/player_api';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(ga, s);

var done = false;
var player;
$('#yt-video-clear').on('click',function() {
    $('#yt-video-clear').addClass('hidden');
    $('#form-view').removeClass('hidden');
    $('.yt-info').removeClass('hidden');
    $('.user-info').removeClass('hidden');
    player.destroy();
    location.reload();
});
$('.yt-info').hover(function() {
    $('.yt-info-full', $(this)).slideToggle(100, 'linear');
});

$('.thumbnail').on('click', function() {
    // Get the yt_video_id from html of yt-video
    // var yt_video_id = $('#yt-video').html();
    var yt_video_id = $(this).attr("name");

    $('#form-view').addClass('hidden');
    $('.yt-info').addClass('hidden');
    $('.user-info').addClass('hidden');
    $('#yt-video-clear').removeClass('hidden');

    player = new YT.Player('ytv', {
        playerVars:{
            modestbranding:'1',
            autohide: '1'
        },
        height: '472.5',
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
    // console.log('onPlayerReady', evt);
    evt.target.playVideo();

}
function onPlayerError(evt) {
    console.log('onError',evt);
    // cleanup...
}

$('#ytv').on('click', function () {
    // console.log('stopVideo');
    player.toggleVideo();
});
// grab video id of video playing
function onPlayerStateChange(evt) {
    // console.log('onPlayerStateChange',evt);
    if (evt.data == YT.PlayerState.PLAYING) {
        var youtube_url = evt.target.getVideoUrl();
       // console.log('Video Playing Calling Ajax to add play time to db', youtube_url);
        $.ajax({
            type: 'POST',
            url: '/videos/p_playing/',
            success: function(response) { 

                // For debugging purposes
                // console.log("SUCCESS!!!");

            },
            data: {
                yt_url: youtube_url,
            },
        });
    }
}
// jquery plugin for dialog window
// $(function() {
//     $( "#dialog" ).dialog();
// });

// Delete Confirmation TBD

$("a.remove").on("click",function(event){
//   if(confirm("Are you sure you want to delete this Video?")) {
        var video_id = $(this).attr("id");
        $.ajax({
            type: 'POST',
            url: '/videos/delete/',
            success: function(response) { 

                alert("Video removed!");
                location.reload();

            },
            data: {
                yt_video_id: video_id,
            },
        });
//   }
   
});

