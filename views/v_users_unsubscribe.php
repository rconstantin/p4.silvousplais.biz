
<h2> Unsubscribe: this will delete all information about this account </h2>
<p><span class="error">* required field.</span></p>

<form method='POST' action='/users/p_unsubscribe'>

    <p> Password 
        <span class="error">* <?php if (isset($error) AND $error == 'InvalidPassword') {echo 'Password Field Required: Enter a Valid Password';}?>
                           <?php if (isset($error) AND $error == 'PasswordMismatch') {echo 'Password Mismatch: Enter a Valid Password';}?> </span><br>
        <input type='password' name='password'>
    </p>
    <p> Confirm Password 
        <span class="error">* <?php if (isset($error) AND $error == 'InvalidPassword') {echo 'Password Field Required: Enter a Valid Password';}?>
                           <?php if (isset($error) AND $error == 'PasswordMismatch') {echo 'Password Mismatch: Enter a Valid Password';}?> </span><br>
        <input type='password' name='conf_password'>
    </p>
    <br>
    <input type='submit' value ='Unsubscribe' style="background-color: red; color: #ffffff;">

</form>