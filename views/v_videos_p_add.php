<br>Your video was successfully added to the database  on <?=Time::display($add_time);?>;<br>
More information relating to this video (click on thumbnail or video id to play video):<br> <br>
<div id="yt_video_id"> The Video Title is : <?=$title?> <br>
<img id="thumbnail" class="circular" src="<?=$thumbnail_url?>" alt="" width="60" height="60"><br>
<!--<label for='thumbnail'>&nbsp;The youtube video ID is: <?=$yt_video_id?></label><br>-->
The youtube video ID is: <div id='yt-video'><?=$yt_video_id?></div>
<div id="ytv"></div>
<!--script loaded here to specify type application... template type is set to text-->
<script type="application/javascript" src="/js/videos_playYTvideo.js"></script>
