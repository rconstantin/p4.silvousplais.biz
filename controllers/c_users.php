<?php

class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
                # add Menu
        $this->template->hide_menu = FALSE;
        $this->template->menu = View::instance('v_menu');
    } 

    public function index() {
        # redirect to main page
        Router::redirect("/");
    }

    public function signup($firstName = NULL, $lastName = NULL, $email = NULL, $error = NULL) {
        # View Setup
        $this->template->content = View::instance('v_users_signup');
        $this->template->content->error = $error;
        $this->template->content->firstName = $firstName;
        $this->template->content->lastName = $lastName;
        $this->template->content->email = $email;
        $this->template->title = "Sign Up to " . APP_NAME;
        #load JS 
        $client_files_head = Array("/js/jquery-2.0.0.js", "/js/jstz-1.0.4.min.js");
        $this->template->client_files_head = Utils::load_client_files($client_files_head);

        # Render template
        echo $this->template;
    }

    public function p_signup() {
        # Validate that all required signup fields are not empty
        # for simplicity of logic and to use single error code - set
        # error to missing field.
        
        $error = '';
        if (empty($_POST['first_name'])) 
        {
            $error = 'InvalidFirstName';
        }
        else {
            $_POST['first_name'] = AppUtils::test_input($_POST['first_name']);
        }
        if (empty($_POST['last_name'])) {
            $error = 'InvalidLastName';
        }
        else {
            $_POST['last_name'] = AppUtils::test_input($_POST['last_name']);
        }
        if (empty($_POST['email'])) {
            $error = 'InvalidEmail';
        }
        else {
            $_POST['email'] = AppUtils::test_input($_POST['email']);
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$_POST['email']))
            {
                $error = "InvalidEmail";
                $_POST['email'] = '';
            }

        }
        if (empty($_POST['password'])) {
            $error = 'InvalidPassword';
        }
        else {
            $_POST['password'] = AppUtils::test_input($_POST['password']);
        }
        # DB Validation that new user email is not already in use
        if (!$error) {
           # NEED NEW API to return count...  
           # $result = DB::instance(DB_NAME)->queryCount($q);
           # $q = "SELECT COUNT(*) FROM users WHERE email = '".$_POST['email']."'";

            $q = "SELECT COUNT(*) FROM users WHERE email = '".$_POST['email']."'";
            $result = DB::instance(DB_NAME)->select_field($q);
          
            if ($result > 0) {
                $error = 'InvalidEmail';
                $_POST['email'] = '';
            }
        }
        
        # prepare signup params to pass back
        $lastName = $_POST['last_name'];
        $firstName = $_POST['first_name'];
        $email = $_POST['email'];
        if ($error != '') {
            # send back to signup page
            Router::redirect("/users/signup/$firstName/$lastName/$email/$error");
        }
        else {
            # validate email domain and if valid send signup email
            $result = $this->p_signup_email();
            if ($result == false) {
                # reset email sent back to signup 
                $error = 'InvalidEmail';
                $email = '';
                # send back to signup page
                Router::redirect("/users/signup/$firstName/$lastName/$email/$error");
            }
            /* replace by core signup util function
            # insert time (timestamp) of creation and last modify with user
            $_POST['created'] = Time::now();
            $_POST['modified'] = Time::now();
            # default AvatarUrl to streamline code and avoid extra checking down the road
            $_POST['avatarUrl'] = DEFAULT_AVATAR_URL;

            #Encrypt Password
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
            # create an encripted Token based on the email address and a random string
            $_POST['token'] = sha1(TOKEN_SALT.$_POST['email']).Utils::generate_random_string();
            # insert row into DB
            $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

            # insert a row in users_users table for always following self
            $data = Array (
            "created" => Time::now(),
            "user_id" => $user_id,
            "user_id_followed" => $user_id);

            # insert array into users_users table
            DB::instance(DB_NAME)->insert('users_users', $data); 
            */
            $_POST['avatarUrl'] = DEFAULT_AVATAR_URL;
            $user = $this->userObj->signup($_POST);
            if ($user == false) {
                $error = 'failedSignup';
                Router::redirect("/users/signup/$firstName/$lastName/$email/$error");
            }
            else {
                # insert a row in users_users table for always following self
                $data = Array (
                    "created" => Time::now(),
                    "user_id" => $user['user_id'],
                    "user_id_followed" => $user['user_id']);

                # insert array into users_users table
                DB::instance(DB_NAME)->insert('users_users', $data); 
                # redirect to profile page not requiring additional step to login
                # $this->p_common_login($user['token']);
                $token = $this->userObj->login($_POST['email'], $_POST['password'], $_POST['timezone']);
                # redirect new user to profile page
                Router::redirect("/users/profile");
            }
        }
    }
    public function p_signup_email()
    {
        # the email to validate
        $email = $_POST['email'];
        # an optional sender
        $sender = APP_EMAIL;
        # validate that the domain in email is a valid... if so, most likely email is good
        $domain = explode( "@", $email ); # get the domain name
        if (!(@fsockopen ($domain[1],80,$errno,$errstr,3)))
        {
            # if the connection can be established, the email address is probably valid
            return false;
        } 
 
        # Build a multi-dimension array of recipients of this email
        $name = $_POST['first_name'] . " " . $_POST['last_name'];

        $to[] = Array("name" => $name, "email" => $_POST['email']);

        # Build a single-dimension array of who this email is coming from
        # note it's using the constants we set in the configuration file)
        $from = Array("name" => APP_NAME, "email" => APP_EMAIL);

        # Subject
        $subject = "Welcome to " . APP_NAME;

        # You can set the body as just a string of text
        $body = "Hi " . $name .", this is just a message to confirm your registration at " . APP_NAME;

        # placeholders for now.
        $cc  = "";
        $bcc = "";

        # With everything set, send the email
        $email = Email::send($to, $from, $subject, $body, true, $cc, $bcc);
        if ($email == false)
        {
            # die("Invalid Email Address. <a href='/users/signup'> Sign up </a>");
            return false;
        }
        return true;
    }

    public function login($email = NULL, $error = NULL) {
        # Setup View
        $this->template->title = "Login";
        $this->template->content = View::instance('v_users_login');
        $this->template->content->email = $email;
        $this->template->content->error = $error;
        #load JS 
        $client_files_head = Array("/js/jquery-2.0.0.js", "/js/jstz-1.0.4.min.js");
        $this->template->client_files_head = Utils::load_client_files($client_files_head);
        # Render template
        echo $this->template;
    }

    public function p_login()
    {
        
        $error = '';

        # Validate input parameter
        if (empty($_POST['email'])) {
            $error = 'InvalidEmail';
        }
        else {
            $_POST['email'] = AppUtils::test_input($_POST['email']);
        }
        if (empty($_POST['password'])) {
            $error = 'InvalidPassword';
        }
        else {
            $_POST['password'] = AppUtils::test_input($_POST['password']);
        }
        if ($error!= '')
        {
            if ($error != 'InvalidEmail') {
                $email = $_POST['email'];
            }
            else {
                $email = '';
            }
            # send back to login page, return email and error
            Router::redirect("/users/login/$email/$error");
        }
        /*
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token 
            FROM users 
            WHERE email = '".$_POST['email']."' 
            AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q);
        $email = $_POST['email'];
        # If we didn't find a matching token in the database, it means login failed
        if(!$token) {
            $error = "PasswordMismatch";
            # Send them back to the login page
            Router::redirect("/users/login/$email/$error");
        }
        else {
            $this->p_common_login($token);
            # Since we found a token, login successfull redirect to menu page
            Router::redirect("/");
        }
        */
        # use core login API - updates timezone is updated here:
        $token = $this->userObj->login($_POST['email'], $_POST['password'], $_POST['timezone']);
        if ($token == false) {
            $error = 'InvalidPassword';
            $email = $_POST['email'];
            Router::redirect("/users/login/$email/$error");
        }
        else {
            # Since we found a token, login successfull redirect to menu page
            Router::redirect("/");
        }
    }
    # common login processing funtion used in the login and signup process
    public function p_common_login($token)
    {
        # set cookie based on token with 1 year expiry and entire domain access priviliges
        setcookie("token", $token, strtotime('+1 year'), '/');
        # Update the DB field that indicates the last login time
        $last_login = Time::now();
        $data['last_login'] = $last_login;
        $where_cond = "WHERE token = '".$token."'";
        DB::instance(DB_NAME)->Update_row('users',$data, $where_cond);
 
    }

    public function logout() {
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        $where_clause = "WHERE token = '".$this->user->token."'";
        DB::instance(DB_NAME)->update("users", $data, $where_clause);

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");
    }

    public function profile($error = NULL) 
    {
        # use the global user to determine whether logged in or not
        if (!$this->user) {
            # not logged in redirect to login page
            Router::redirect('/users/login');
        }
        # Create a View Instance and assign to template content
        $this->template->content = View::instance('v_users_profile');
        $this->template->content->error = $error;
      
        # Pass information to the view specific content
        $this->template->title = "Profile of ".$this->user->first_name;
        $stats = $this->p_user_stats();
        $this->template->content->stats = $stats;

        # load JS files
        $client_files_body = Array(
            "/js/jquery.form.js",
            "/js/users_profile.js");
        $this->template->client_files_body = Utils::load_client_files($client_files_body);
        # Render View
        echo $this->template;
    }
    public function p_profile() {

        # case someone submits with no file chosen. This should be protected 
        # against in the Upload class.. but it is not. so will do it here
        #  ini_get('upload_max_filesize') in Mbytes
        if(($_FILES['file']['name'] == '') OR ($_FILES['file']['size'] > 1000000*ini_get('upload_max_filesize')))
        {
            $error = 'InvalidFileType';
            Router::redirect("/users/profile/$error");
        }
        # first upload file to /uploads/avatars
        $avatarUrl = Upload::upload($_FILES,"/uploads/avatars/",
                                array("jpg", "jpeg", "gif", "png", "avi", "svg", "psd",
                                "JPG", "JPEG", "GIF", "PNG", "AVI", "SVG","PSD"), $this->user->user_id);
        if ($avatarUrl != 'Invalid file type.')
        {
            # remove old avatarUrl if name is different... no point in keeping in upload dit

            $this->user->avatarUrl = $avatarUrl;
            
            # update avatarUrl in the database
            $data = Array("avatarUrl"=>$this->user->avatarUrl);
            $where_clause = "WHERE user_id = '".$this->user->user_id."'";
            DB::instance(DB_NAME)->update("users", $data, $where_clause);

            # Setup view to display success of upload
            $view = View::instance('v_users_p_profile');
            $view->upload_time = Time::now();
            $view->avatarUrl = $avatarUrl;

            # render view
            echo $view;

            #$js_data['upload_time'] = Time::now();
            #$js_data['avatar_url'] = $avatarUrl;
            # send back json results to the JS, formatted in JSON
            #json_encode($js_data);

            # echo $view;
        }
        else {
            $error = 'InvalidFileType';
            Router::redirect("/users/profile/$error");
        }
        # Don't Send them back to the main index.
        # Router::redirect("/");

    }
    public function p_user_stats() {
        # get number of members this logged in user is following (-1 to exclude self)
        $q = "SELECT COUNT(*) FROM users_users WHERE users_users.user_id = ".$this->user->user_id;
        $numFollowing = DB::instance(DB_NAME)->select_field($q) - 1;

        $q = "SELECT COUNT(*) FROM users_users WHERE users_users.user_id_followed = ".$this->user->user_id;
        $numFollowers = DB::instance(DB_NAME)->select_field($q) - 1;
  
        return (array("followings"=>$numFollowing, "followers"=>$numFollowers));
    }
    # following function will remove current user from APP site
    public function unsubscribe($error = NULL) {
       # Setup View
        $this->template->title = "unsubscribe";
        $this->template->content = View::instance('v_users_unsubscribe');
        $this->template->content->error = $error;
        # Render template
        echo $this->template;
    }
    public function p_unsubscribe() {
        $error = '';
        if ($_POST['password'] != $_POST['conf_password']) {
            $error = 'InvalidPassword';
        }
        else {
            # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
            $_POST = DB::instance(DB_NAME)->sanitize($_POST);

            # Hash submitted password so we can compare it against one in the db
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

            # Search the db for this email and password
            # Retrieve the token if it's available
            $q = "SELECT token 
                FROM users 
                WHERE email = '".$this->user->email."' 
                AND password = '".$_POST['password']."'";

            $token = DB::instance(DB_NAME)->select_field($q);
            if (!$token) {
                $error = 'InvalidPassword';
            }
            else {
                # all checks passed, now cleanup the DB from this user
                # only need to delete the user and rely on the FK cascade
                # to delete the playlists and connection to other users (users_users)
                $w = 'WHERE user_id = '.$this->user->user_id;
                DB::instance(DB_NAME)->delete('users', $w);
            }
        }
        if ($error != '') {
            Router::redirect("/users/unsubscribe/$error");
        }
        else {
            Router::redirect("/");
        }
    }
} # end of the class
