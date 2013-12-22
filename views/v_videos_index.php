<!-- check if no videos are active for this user -->
<?php if(count($videos) == 0): ?>
    <h4> Sorry <?=$user->first_name?>, You have no saved views to view. </h4>
    <h4> You need to Add Videos and/or Follow other active Members. </h4>
<?php endif; ?>    
<!-- use this variable to display owner name and avatar only once at top of list -->
<?php $prev_videos_user_id = -1; ?>
<!-- common divs to display/destroy ytv-->
<?php $owner = 0; ?>
<?php foreach($videos as $video): ?>
    <div class="user-info">
        <!-- print owner name and display avatar at top of posts by owner. 
                 No need for Avatar if owner is same as logged in user -->
        <h2>         
            <?php if ($video['video_user_id'] != $prev_videos_user_id): ?>
                <br>
                <?php if($video['video_user_id'] != $user->user_id): ?>
                    <!-- Display Name and show Avatar for this member -->
                    <?=$video['first_name']?> <?=$video['last_name']?> added:
                <?php else: ?>
                    Your Saved Videos:  
                    <?php $owner = 1;?>  
                <?php endif; ?>
                <br>
                <img class="floatleft" src="/uploads/avatars/<?=$video['avatarUrl']?>" alt="" width="100" height="100">    
                <?php $prev_videos_user_id = $video['video_user_id'] ?>
                <?php $video_cnt = 0; ?>
            <?php endif; ?>
        </h2>
    </div>    
    <?php if ($video_cnt < $vlimit): ?>
        <?php $video_cnt++ ?>
        <div id='yt-video-clear' class='btn btn-primary hidden' >Destroy YTV</div><br>
        <div id="ytv"></div>
        <div class="yt-info">
            <span> 
                <img name="<?=$video['yt_video_id']?>" class="thumbnail" src="<?=$video['thumbnail_url']?>" alt="" width="100" height="100">
            </span>
            
            <!-- For those videos owned by this user id provide option to delete video-->
            <?php if ($video['video_user_id'] == $user->user_id): ?>
                <span id="nav" style="height:0px;width:0px">
                    <li>
                        <a class="remove" id="<?=$video['yt_video_id']?>" href='#'>&times</a>
                    </li>
                </span>    
            <? endif; ?> 
            <span class="yt-info-full">
                <p4>
                    <?php if ($owner == 1): ?>
                        ((click on <font color='green'>X</font> to <font color='red'>remove </font>video from your list))<br>
                    <?php endif; ?>
                    (click on thumbnail to <font color='red'>play </font>video)<br>
                    <mark class="green"> Video Title: <?=$video['yt_title']?>.</mark><br>
                    <?php if($video['last_played'] != 0): ?>
                        <mark class="green">Last Played on: 
                            <?=Time::display($video['last_played'],'',$video['timezone'])?>.<br>
                        </mark>
                    <?php endif; ?>
                    <mark class="green">Initially added on: 
                        <?=Time::display($video['created'],'',$video['timezone'])?>.<br>
                    </mark>
                </p4>
            </span>
            <br>
        </div>
        <br>
    <?php endif; ?>
<?php endforeach; ?>
<?php if(isset($client_files_body)) echo $client_files_body; ?>
<script> $("#menu").css("padding-bottom","-10px");</script>
