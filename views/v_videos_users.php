<?php if(count($users) == 0): ?>
    <h4> Sorry <?=$user->first_name?>, You are the only member of this site at this time. </h4>
    <h4> Build up your playlist collections and others will join... </h4>
<?php endif; ?> 
<? foreach($users as $user): ?>
    <!-- Print this user's name -->
    <h4>
        <?=$user['first_name']?> <?=$user['last_name']?> <br>
        <?php if(isset($user['avatarUrl'])): ?>
            <img class="circular" src="/uploads/avatars/<?=$user['avatarUrl']?>" 
                alt="" width="100" height="100">
        <?php endif; ?> 
        <br>
        <? if(isset($connections[$user['user_id']])): ?>
            <a class="btn btn-primary" href='/videos/unfollow/<?=$user['user_id']?>'>Unfollow</a>

            <!-- Otherwise, show the follow link -->
        <? else: ?>
            <a class="btn btn-primary" href='/videos/follow/<?=$user['user_id']?>'>Follow</a>
        <? endif; ?>  
    
        <br> <br>
    </h4>    
<? endforeach; ?>   
 
