<div id='form-view' class="container">
    <form class="form-signin" role="form" method='POST' action='/videos/p_add'>
        <br><br><br>
        <h2 class="form-signin-heading">Cut&Paste a youtube URL from a youtube player</h2>
        <textarea class="form-control" name='yt_url' id='url' placeholder="Enter youtube URL" required autofocus></textarea>
        <br>
        <div class="playlist-drawer"> 
            <div class="added-to-list"></div>
        </div>
        <input class="new-playlist-title" id='playlist' name="playlist_name" placeholder="Enter playlist (optional)">
        <br><br>
        <input type='submit' id='save-url-info' value='submit' style="background-color: green; color: #ffffff;">
    </form>
</div>
<div id='yt-video-clear' class='btn btn-primary hidden' >Destroy YTV</div><br>
<div id='url-results'></div>
<div id="ytv"></div>