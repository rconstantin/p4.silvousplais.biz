
<h2> Signup Page </h2>
<p><span class="error">* required field.</span></p>

<form method='POST' action='/users/p_signup'>
    <p>First Name 
        <span class="error">* <?php if (isset($error) AND empty($firstName)) {echo 'Enter a Valid First Name';}?></span> <br>
        <input type='text' name='first_name' value="<?php if(isset($firstName)) {echo $firstName;} ?>">
    </p>

    <p>Last Name
        <span class="error">* <?php if (isset($error) AND empty($lastName)) {echo 'Enter a Valid Last Name';}?></span> <br>  
        <input type='text' name='last_name' value="<?php if(isset($lastName)) {echo $lastName;} ?>">
    </p>

    <p>Email
        <span class="error">* <?php if (isset($error) AND empty($email)) {echo 'Please Enter a Valid/Unique Email';}?></span> <br>  
        <input type='text' name='email' value="<?php if(isset($email)) {echo $email;} ?>">
    </p>

    <p>Password
        <span class="error">* <?php if (isset($error) AND $error == 'InvalidPassword') {echo 'Enter a Valid Password';}?></span> <br> 
        <input type='password' name='password'>
    </p>

    <input style='display:none;' type='hidden' id ='timezone' name='timezone'> 
    <script>
        $tzone = jstz.determine().name();
        $("input[name='timezone']").val($tzone); 
    </script>
    <br>
    <input type='submit' style="background-color: green; color: #ffffff;">

</form>


