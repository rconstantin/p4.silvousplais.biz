<?php if ($first_time_add == TRUE): ?>
    <br>Your video was SUCCESSFULLY added to the database  on <?=Time::display($add_time);?><br>
<?php else: ?>
    <br>Your video was PREVIOUSLY added to the database  on <?=Time::display($add_time);?><br>
<?php endif ?>    
<p2>(click on thumbnail to play video)</p2><br>
<div id="yt_video_id"> The Video Title is : <?=$title?> <br>
<img id="thumbnail" src="<?=$thumbnail_url?>" alt="" width="60" height="60">
<div id='yt-video' class='hidden'><?=$yt_video_id?></div>
<div id='yt-video-clear' class='button hidden' >Destroy YTV</div><br>
<div id="ytv"></div>
<!--Load the js script here. Loading it in the _v_template would not work since we need the script embedded in this view-->
<?php if(isset($client_files_body)) echo $client_files_body; ?>
