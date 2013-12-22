<!-- check if no posts are active for this user -->
<?php if(count($followers) == 0): ?>
    <h4> Sorry <?=$user->first_name?>, You have no followers at this time. </h4>
    <h4> Build up your playlist collections and others will follow. </h4>
<?php endif; ?>   
<h4>  
    <? foreach($followers as $follower): ?>
        <!-- Print this user's name -->
        <?=$follower['first_name']?> <?=$follower['last_name']?> <br>
        <?php if(isset($follower['avatarUrl'])): ?>
            <img class="circular" src="/uploads/avatars/<?=$follower['avatarUrl']?>" 
                alt="" width="100" height="100">
        <?php endif; ?> <br>
        <font color=green> Follower Since: 
            <?=Time::display($follower['follower_since'],'',$follower['timezone'])?></font>
         
         <br><br>
    <? endforeach; ?>
</h4>