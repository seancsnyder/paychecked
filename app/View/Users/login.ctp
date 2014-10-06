<div class="hero-unit">
    <h3>login/register</h3>
    <p>already have an account? Simply enter your email/password.<br/>
        new user?  just enter your email address and desired password.  we'll take care of the rest</p>
    <p><a href="/forgot-password">forgot your password</a></p>

    <?php echo $this->element('error-messaging'); ?>

    <form method="POST" action="/login" accept-charset="UTF-8">
        <input type="hidden" name="_method" value="POST">
        <input type="email" id="username" class="span4" name="data[User][email]" placeholder="user@test.com" value="<?php echo Sanitize::html($email); ?>">

        <?php if (isset($confirm_new_user_password) && $confirm_new_user_password) { ?>
            <p>it looks like you're creating a new account.  please confirm your password. if you already have an account,
                please make sure the email address is correct. </p>
            <input type="password" id="password" class="span4" name="data[User][password]" placeholder="password" value="<?php echo Sanitize::html($password); ?>">
            <input type="password" id="password_confirmation" class="span4" name="data[User][password_confirmation]" placeholder="password confirmation">
        <?php } else { ?>
            <input type="password" id="password" class="span4" name="data[User][password]" placeholder="password">
        <?php } ?>

        <label class="checkbox">
            <input type="checkbox" name="data[remember_email]" value="1" <?php echo (!strcmp($remember_email,'1')) ? "CHECKED" : ""; ?>> remember me
        </label>

        <?php if (isset($confirm_new_user_password) && $confirm_new_user_password) { ?>
            <button type="submit" name="submit" class="btn btn-primary">register</button>
        <?php } else { ?>
            <button type="submit" name="submit" class="btn btn-primary">login/register</button>
        <?php } ?>
    </form>
</div>
