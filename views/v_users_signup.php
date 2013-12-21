
<div class="container">
    <div class="main">
        <form class="form-signin" method='POST' action='/users/p_signup'>

            <div id="results" class="alert alert-error">
                <!-- response/error message will be shown here -->
            </div>
            <h2 class="form-signin-heading">Please sign up</h2>
            <p2> (all fields required)</p2>
            <div class="control-group">  
                <div class="controls">
                    <input type='text' class="form-control" name='first_name' id="first_name" placeholder="First Name" value="<?php if(isset($firstName)) {echo $firstName;} ?>" required autofocus>
                </div>
            </div>
            
            <div class="control-group">    
                <div class="controls">       
                    <input type='text' class="form-control" name='last_name' placeholder="Last Name" value="<?php if(isset($lastName)) {echo $lastName;} ?>" required autofocus>
                </div>
            </div>
  
            <div class="control-group">   
                <div class="controls">     
                    <input type='text' class="form-control" name='email' placeholder="Email" value="<?php if(isset($email)) {echo $email;} ?>" required autofocus>
                </div>
            </div>
          
            <div class="control-group">    
                <div class="controls">
                    <input type='password' class="form-control" name='password' placeholder="Password" required>
            
                </div>
            </div>
    
            <input style='display:none;' type='hidden' id ='timezone' name='timezone'> 
            <script>
                $tzone = jstz.determine().name();
                $("input[name='timezone']").val($tzone); 
            </script>
            <br>
            <div class="controls">
                <button class="btn btn-primary" id="submit" type="submit">Sign up</button>
            </div>
            <br>
            <div id="output"> </div>
           
        </form>
    <div>    
</div>
