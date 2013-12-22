<br><br>   

<h1>This is <?=$user->first_name?> <?=$user->last_name?>'s  profile:</h1>

<p3> 
    Email: <?= $user->email ?> <br>
    Member Since: <?php $mem = Time::Display($user->created,'',$user->timezone); echo $mem; ?> <br>
    Number of Followers: <?=$stats['followers']?> <br>
    Number of Members <?= $user->first_name ?> is following: <?=$stats['followings']?>  <br><br>


<mark class="green"> Upload/Change your Personal Avatar:</mark> 

</p3>
<br><br>
<img id="avatar" src="/uploads/avatars/<?=$user->avatarUrl?>" 
                alt="" width="100" height="100">

<br><br>
<form method='POST' action='/users/p_profile' enctype="multipart/form-data">
    <span class="error"><?php if (isset($error)) {echo '* Invalid File: Please Enter a Valid file(.jpg, png, svg, etc) and Size less than ' .ini_get('upload_max_filesize');}?> </span>
    <br>
    <input type="file" name="file">
    <br>                  
    <input id='refresh-avatar' type="submit" name="submit" 
           style="background-color: green; color: #ffffff;">
</form>    

 <div id='results'> </div>       
