
<div class="yt-info">
    <span> <img name="<?=$yt_video_id?>" class="thumbnail" src="<?=$thumbnail_url?>" alt="" width="180" height="160" left="300px" !important data-options="{id:<?=$yt_video_id?>}"></span>
    <span class="yt-info-full"> 
            <p4>(click on thumbnail to <font color='red'>play </font>video)<br>
            Added on: <?=Time::display($add_time);?><br>
            <div id="yt_video_id"> Title: <?=$title?>  </p4>
    </span>   

</div>
<!--<div id='yt-video-clear' class='button hidden' >Destroy YTV</div><br>
<div id="ytv"></div>-->
<!--Load the js script here. Loading it in the _v_template would not work since we need the script embedded in this view-->
<?php if(isset($client_files_body)) echo $client_files_body; ?>
