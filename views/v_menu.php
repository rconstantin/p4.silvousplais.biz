
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
        <li>
            <a class='index-view' href='/videos/index/0'>view All Videos</a>
            <ul id="nav">
                <li><a class='index-view-full' href='/videos/index/1'>Fellows Top <?=TOP_VIDEOS_PER_FELLOW?></a></li>
                <li><a class='index-view-full' href='/videos/index/2'>My Videos</a></li>
            </ul>
        </li>
    <?php endif; ?>    
</ul>
