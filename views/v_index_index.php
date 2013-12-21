<h1>A few things you need to know about this Application: It is free, easy to use and fun.
</h1>

<img class="floatleft" src="/uploads/avatars/yt2.jpg" alt="" width="200" height="150">
<p><?=APP_NAME?> is a web site where you can share embedded youtube videos with other members. First time visitors, need to signup. The email/password fields will be used to login in subsequent visits.</p> 
    
<p>Members can modify their profiles, manage their connections with other members (follow/unfollow), view a list of their followers, create playlists, add youtube videos/clips to playlists, play videos from any playlists. </p>
<br>
<br>
<br>
<p> 
<h4>Goals of this application</h4>
<ul>
    <li>To allow for user-friendly interface for viewing embedded youtube videos by using the youtube embedded player api.</li>
    <li>To allow users to manually add/save URLs of their favorites videos. Currently limited to 100 videos per user.</li>
    <li>To allow users to view info about their saved video and to play them from within the application.</li>
    <li>To allow users to view their friends favorite and most recently played/added videos.</li>
    <li>Additional Videos will be automatically added to the DEFAULT playlist, if the user clicks to play similar videos that are usually displayed by the youtube native application when playback of current video ends.</li>
    <li>No annoying AdSense Ads "to skip in x seconds" by younger users who are mainly interested in their cartoon video to start playing (a free feature due to HTML5 internals).</li>
</ul>
<p>
    Note 1:some youtube videos have their embedded capabability disabled (i.e one can only view them on youtube). Obviously, such video URL will not be accepted by the application and the user will be notified with a message.
<br>
    Note 2: given the above goals and to avoid growing the database indefinitely, a hard-coded limit of 100 videos per user was imposed. When the limit is reached, the oldest (least viewed) video will be removed to make room for the new addition. The owner, will also be presented with an API to delete videos from their list.


</p>

