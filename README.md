p4.silvousplais.biz
===================

Application name: EmbedUrTube

EmbedUrTube is a web site where you can share embedded youtube videos with other members. First time visitors, need to signup. The email/password fields will be used to login in subsequent visits.

Members can modify their profiles, manage their connections with other members (follow/unfollow), view a list of 
their followers, create playlists, add youtube videos/clips to playlists, play videos from any playlists.

Goals of this application:
===========================
    1 - To allow for user-friendly interface for viewing embedded youtube videos by using the youtube embedded player api.
    2 - To allow users to manually add/save URLs of their favorites videos. Currently limited to 100 videos per user.
    3 - To allow users to view info about their saved video and to play them from within the application.
    4 - To allow users to view their friends favorite and most recently played/added videos.
    5 - Additional Videos will be automatically added to the DEFAULT playlist, if the user clicks to play similar videos 
        that are usually displayed by the youtube native application when playback of current video ends.
    6 - No annoying AdSense Ads "to skip in x seconds" by younger users who are mainly interested in their cartoon video to start 
        playing (a free feature due to HTML5 internals).
    7 - Youtube logo removed and access to youtube and video title links hidden on normal screen size. Full screen option exposes 
         the youtube and title links at the top of the page.

    Note 1: some youtube videos have their embedded capabability disabled (i.e one can only view them on youtube). 
            Obviously, such video URL will not be accepted by the application and the user will be notified with a message.

    Note 2: given the above goals and to avoid growing the database indefinitely, a hard-coded limit of 100 videos per user was imposed. 
            When the limit is reached, the oldest (least viewed) video will be removed to make room for the new addition. The owner, will
            also be presented with an API to delete videos from their list.

    Note 3: Occasionally saved videos become no longer available and will be automatically removed (either if a user clicks to play or 
            when "view videos" menu is click and video retrieval generates a 404 'Not Found' error)

High level Description:
=======================
    0 - Bootstrap plugin is used to make the site look more professional: navigation buttons and input form layout.
    1 - signup/login/password functionality is improved from project 2 by utilizing the "core" APIs. 
    2 - profile update functionality was modified to use javascript and the AJAX form plugin.
    3 - email notification to newly signed up users is the same as in Project 2 (+1 Rubric).
    4 - user's Unsubscribe, Follow/unFollow functionality same as in Project 2 (+1 Rubric).
    5 - Add a youtube video URL (with optional playlist name) capability. The "Add Video" uses javascript and the AJAX form plugin 
        and if the video is allowed to be embedded, the Add will succeed and thumbnail URL will be displayed on the same page. 
        On hover, more information about the video is displayed (title, creation time). The user could choose to play the video there by 
        clicking on the thumbnail as indicated. While the video is playing, all other divs are hidden from page using jquery techniques 
        to hide distractions (input text area, submit button, etc).
    6 - While playing, the embedded video player will be overlayed with a Destroy button. If clicked the embedded player will be destroyed
        and original view will re-appear. This is common in the Add Video as well as the View Videos pages.
    6 - Users can also follow/unfollow other users. By doing so, they can list those users video collection and click to play any of them. 
    7 - Users can also remove older or unwanted videos from their list.

JAVASCRIPT/AJAX/JQUERY:
=======================
    1 - Users Side: The Signup, Login and Profile are using the AJAX form plugin for sending POST data to the server and display results.
    2 - Videos Side: The Add Video Page is using the AJAX form plugin for URL input and display results on same page.
    3 - Videos Viewing: uses AJAX form plugin to delete obsolete or disabled videos. It also uses javascript and the youtube player API to 
        play videos and extract information about said videos.
    4 - Video Viewing: Jquery-ui selectors are also used to display info about videos upon hover over the thumbnails.
    5 - Various event handlers are used to play the embedded videos and to destroy the player when playback is stopped and the user to 
        view other videos or navigate into other parts of the site.
