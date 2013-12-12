
<ul id="nav">
    <!-- restrict menu for users who not are logged in -->
    <?php if(!$user): ?>
        <li><a href='/users/signup'>Sign up</a></li>
        <li><a href='/users/login'>Log in</a></li>
    <?php else: ?>   
        <li><a href='/'> Home </a></li> 
        <li><a href='/videos/users'>Following</a></li>
        <li><a href='/videos/followers'>Followers</a></li>
        <li><a href='/videos/add'>Add Video</a></li>
        <li><a href='/videos/index'>viewVideos</a></li>
    <?php endif; ?>    
</ul>
