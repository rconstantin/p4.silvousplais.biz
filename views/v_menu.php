<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul id="nav" class="navbar-nav ">
        <!-- restrict menu for users who not are logged in -->
        <?php if(!$user): ?>
            <li><a href='/'> About </a></li> 
            <li><a href='/users/signup'>Sign up</a></li>
            <li><a href='/users/login'>Log in</a></li>
        <?php else: ?>
            <li><a  href='/'> About </a></li> 
            <li><a  href='/videos/users'>Following</a></li>
            <li><a  href='/videos/followers'>Followers</a></li>
            <li><a  href='/videos/add'>Add Video</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle btn-danger" data-toggle="dropdown" href='#'>View Videos</a>
                <ul id="nav" class="dropdown-menu dropdown-menu-var" <style min-width="inherit">
                    <li><a href='/videos/index/2'>My Videos</a></li>
                    <li><a href='/videos/index/1'>Fellows Top <?=TOP_VIDEOS_PER_FELLOW?></a></li>
                    <li><a href='/videos/index/0'>All Videos</a></li>
                </ul>
            </li>
        <?php endif; ?>    
    </ul>
</div>