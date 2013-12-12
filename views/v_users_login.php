
<h2> login Page </h2>
<p><span class="error">* required field.</span></p>

<form method='POST' action='/users/p_login'>

    <p> Email 
        <span class="error">* <?php if (isset($error) AND $error == 'InvalidEmail') {echo 'Email Field Required: Please Enter a Valid Email';}?></span> <br>
        <input type='text' name='email' value="<?php if(isset($email)) {echo $email;} ?>">
   </p>
    
    <p> Password 
        <span class="error">* <?php if (isset($error) AND $error == 'InvalidPassword') {echo 'Password Field Required: Enter a Valid Password';}?>
                           <?php if (isset($error) AND $error == 'PasswordMismatch') {echo 'Password Mismatch: Enter a Valid Password';}?> </span><br>
        <input type='password' name='password'>
    </p>
    <br>

    <input style='display:none;' type='hidden' id ='timezone' name='timezone'> 
    <script>
        $tzone = jstz.determine().name();
        $("input[name='timezone']").val($tzone); 
    </script>
    <br>
    <input type='submit' value ='Log in' style="background-color: green; color: #ffffff;">

</form>