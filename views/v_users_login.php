
<div class="container">
    <form class="form-signin" role="form" method='POST' action='/users/p_login'>
        <span class="error"><?php if (isset($error)) {echo 'Invalid Credentials';}?></span><br>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" name="email" placeholder="Email address" required autofocus>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <input style='display:none;' type='hidden' id ='timezone' name='timezone'> 
        <script>
            $tzone = jstz.determine().name();
            $("input[name='timezone']").val($tzone); 
        </script>
        <br>
        <button class="btn btn-primary" type="submit">Login</button>
        <div id="output"> </div>
    </form>
</div>