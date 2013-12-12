<form method='POST' action='/videos/p_add'>
    <span class="error"> <?php if (isset($error)) {echo 'Cannot submit an empty URL!';}?></span> 
    <h2><label for='url'>Enter a youtube URL here:</label></h2>
    <textarea name='url' id='url'></textarea>
    <div class="playlist-drawer"> 
        <div class="added-to-list"></div>
    </div>
    <input class="new-playlist-title" name="playlist_id" placeholder="Enter playlist name">
    <br><br>
    <input type='submit' id='save-url-info' value='submit' style="background-color: green; color: #ffffff;">
</form>

<div id='url-results'></div>