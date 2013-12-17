<?php
# class videos_controller will inherit from base_controller and
# will manage adding modifying videos and users relationships
class videos_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            # die("Members only. <a href='/users/login'> Login </a>");
            Router::redirect("/");
        }
        # instance of menus visible for all videos methods
        $this->template->hide_menu = FALSE;
        $this->template->menu = View::instance('v_menu');

    }

    public function add($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_videos_add');
        $this->template->title   = "New video";
        $this->template->content->error = $error;
        # load JS files
        $client_files_body = Array(
            "/js/jquery.form.js",
            "/js/videos_add.js");
        $this->template->client_files_body = Utils::load_client_files($client_files_body);
        # Render template
        echo $this->template;

    }
    public function p_update_playlist($playlist, $user_id) {
        $playlist_id = 0;
        $q = "SELECT playlist_id FROM playlists WHERE user_id = ". $user_id . " AND playlist_name = '" . $playlist . "'";
        $playlist_id = DB::instance(DB_NAME)->select_field($q);
        if ($playlist_id == 0) {
            $data = Array('playlist_name' => $playlist, 'user_id' => $user_id, 'created' => Time::now());
            $playlist_id = DB::instance(DB_NAME)->insert('playlists', $data);
        }
        return $playlist_id;
    }
    public function p_add_to_db($last_played) {
    
        # Associate this video with this user
        $data['user_id']  = $this->user->user_id;
        # insert new playlist into DB or if it exists return the playlist_id
        $data['playlist_id'] = $this->p_update_playlist($_POST['playlist_name'], $data['user_id']);
        
        # get yt_video id from url
        preg_match('/[?&]v=([^&]+)/', $_POST['yt_url'], $ytv_id);
        $data['yt_video_id'] = $ytv_id[1];
        
        # Check to see if this video has already been added by this user
        $wc = "WHERE yt_video_id = '".$data['yt_video_id']."' AND user_id = ".$data['user_id'];
        $q = "SELECT created,yt_title,thumbnail_url FROM videos ".$wc;

        $result = DB::instance(DB_NAME)->select_row($q);
    
        if ($result > 0) {
            // This video was previously added by this user, return time of creation along with thumbnail and id
            $data['created']  = $result['created'];
            $data['yt_title'] = $result['yt_title'];
            $data['thumbnail_url'] = $result['thumbnail_url'];
            if ($last_played > 0) {
                # update database with play time
                $upd_data = Array('last_played'=>$last_played);
                DB::instance(DB_NAME)->update_row('videos', $upd_data, $wc);
            }
        }
        else { // first time add
            # Unix timestamp of when this video was created / modified
            $data['created']  = Time::now();
            $data['last_played'] = $last_played;
            $yt_info = AppUtils::ytv_get_info($data['yt_video_id']);
            # check if Embedded functionality is disabled
            if ($yt_info == NULL)
            {
                return NULL;
            }
            $data['yt_title'] = $yt_info['title'];
            $data['thumbnail_url'] = $yt_info['thumbnail_url'];
            # make sure yt_video_id has not been added by this user already
            # TBD DB Check
            # Insert
            # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
            DB::instance(DB_NAME)->insert('videos', $data);
        }
        return $data;
    }
    public function p_add() {

        # validate input
        $_POST['yt_url'] = AppUtils::test_input($_POST['yt_url']);
        if (empty($_POST['yt_url'])) {
            $error = "emptyVideo";
            # redirect user back to add a video since nothing was entered... 
            # Router::redirect("/videos/add/$error");
            echo "Error: Need to submit a valid URL";
            return;
        }
        if (empty($_POST['playlist_name'])) {
            $_POST['playlist_name'] = "DEFAULT";
        }

        $data = $this->p_add_to_db(0);
        if ($data == NULL) {
            echo "Aborting: Embedded functionality is Disabled for this video. Please try another URL...";
            return;
        }
    
        # Setup view to display results
        $view = View::instance('v_videos_p_add');
        # $view->first_time_add = ($result > 0) ? FALSE : TRUE;
        $view->add_time = $data['created'];
        $view->thumbnail_url = $data['thumbnail_url'];
        $view->title = $data['yt_title'];
        $view->yt_video_id = $data['yt_video_id'];
        $client_files_body = Array("/js/videos_playYTvideo.js");
        $view->client_files_body = Utils::load_client_files($client_files_body);
        # render view
        echo $view;

    }
    # function p_playing() insert into DB the currently playing youtube video by this user
    public function p_playing() {
        # $_POST['yt_video_id'] = 'qRsTNp6iczQ';
        # $_POST['yt_url'] = 'http://www.youtube.com/watch?v=qRsTNp6iczQ';
        $_POST['playlist_name'] = "DEFAULT";

        $data = $this->p_add_to_db(Time::now());
        
    }
    # function index() lists all the videos of members being followed
    # it also list own videos.
    public function index() {
        # Set up the View
        $this->template->content = View::instance('v_videos_index');
        $this->template->title = "Videos";

        # query that will only allow to display videos of folks
        # being followed by logged in user

        $q = 'SELECT
                videos.video_id,
                videos.yt_video_id,
                videos.yt_title,
                videos.thumbnail_url,
                videos.created,
                videos.last_played,
                videos.user_id AS video_user_id,
                users_users.user_id AS follower_id,
                users.first_name,
                users.last_name,
                users.timezone,
                users.avatarUrl
              FROM videos
              INNER JOIN users_users 
                ON videos.user_id = users_users.user_id_followed
              INNER JOIN users
                ON videos.user_id = users.user_id
              WHERE users_users.user_id = '.$this->user->user_id .' ORDER BY video_user_id, videos.last_played DESC';

        # Run this query
        $videos = DB::instance(DB_NAME)->select_rows($q);
        
        # Pass this data to the view
        $this->template->content->videos = $videos;

        # Render this view
        $client_files_body = Array("/js/videos_playYTvideo.js");
        $this->template->client_files_body = Utils::load_client_files($client_files_body);
        echo $this->template;      
    }
    # function users() lists all the users and displays connections to $user
    # i.e where the members are followed or not by this $user
    public function users() {
        # Set up the View
        $this->template->content = View::instance("v_videos_users");
        $this->template->title = "Users";
        # query list of users excluding the current logged in user (always followed by self)... 
        $q = "SELECT * FROM users WHERE users.user_id !=".$this->user->user_id;

        $users = DB::instance(DB_NAME)->select_rows($q);

        # Build query to get all the users from users_users followed by this user
        $q = "SELECT *
            FROM users_users
            WHERE users_users.user_id = ".$this->user->user_id;
        
        # use select_array APi with user_id_followed as index
        # to facilitate view display code
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

        # Pass data to the view
        $this->template->content->users = $users;
        $this->template->content->connections = $connections;
        # Render this view

        echo $this->template;    

    }
    # function follow() updates the DB to reflect desire to follow a user
    public function follow($user_id_followed) {

        # Prepare the data array to be inserted
        $data = Array (
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $user_id_followed);

        # insert array into users_users table
        DB::instance(DB_NAME)->insert('users_users', $data);

        # send back to users view
        Router::redirect("/videos/users");
    }
    public function unfollow($user_id_followed) {
        # Where clause for the delete
        $where_clause = 'WHERE user_id =' .$this->user->user_id.' AND user_id_followed ='.$user_id_followed;

        # delete from DB table
        DB::instance(DB_NAME)->delete('users_users', $where_clause);

        # send them back to /videos/users

        Router::redirect('/videos/users');
    }
    # Delete a video from videos table
    public function delete() {
        # prepare where clause to delete video
        $where_clause = 'WHERE video_id =' .$_POST['yt_video_id'];
        # delete video from DB
        DB::instance(DB_NAME)->delete('videos',$where_clause);
        # Router::redirect("/videos/index");

    }
    # update text of a video
    public function modify($video_id, $error = NULL) {
        # query statement
        $q = 'SELECT content FROM videos WHERE video_id =' .$video_id;
        # delete video from DB
        $video_text = DB::instance(DB_NAME)->select_field($q);
        # Setup view
        $this->template->content = View::instance('v_videos_modify');
        $this->template->title   = "Modify video";
        $this->template->content->video_text = $video_text;
        $this->template->content->video_id = $video_id;
        $this->template->content->error = $error;
        # Render template
        echo $this->template;
    }
    public function p_modify($video_id) {
        # validate that video is not rendered empty
        $_POST['content'] = AppUtils::test_input($_POST['content']);
        if (empty($_POST['content']))
        {
            $error = "videoEmpty";
            Router::redirect("/videos/modify/$video_id/$error");
        }
        
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        # build query statement
        $data = Array (
            "modified" => Time::now(),
            "content" => $_POST['content']);
        
        $where_clause = "WHERE video_id=" .$video_id;
        DB::instance(DB_NAME)->update_row('videos', $data, $where_clause);

        # redirect to list of videos
        Router::redirect('/videos/index');
    }
    # display list of followers of this $user
    public function followers() {
        # Set up the View
        $this->template->content = View::instance("v_videos_followers");
        $this->template->title = "Followers";
        # prepare statement to include followers info (excluding self from the list)
        $q = "SELECT 
                users.first_name,
                users.last_name,
                users.timezone,
                users.avatarUrl,
                users_users.user_id AS follower_id,
                users_users.created AS follower_since
                FROM users
                INNER JOIN users_users
                ON users.user_id = users_users.user_id
                WHERE users_users.user_id != users_users.user_id_followed AND users_users.user_id_followed = ".$this->user->user_id;
      
        $followers = DB::instance(DB_NAME)->select_array($q,'follower_id');
        
        # pass data to view
        $this->template->content->followers = $followers;

        # Render this view
        echo $this->template;


    }
} # End of class
