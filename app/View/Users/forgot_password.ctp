<div class="hero-unit">
    <h3>forgot password</h3>
    <p>if you already have an account and you've forgotten your password, enter your email and we'll send you a password reset email.</p>

    <?php echo $this->element('error-messaging'); ?>

    <form method="POST" action="/forgot-password" accept-charset="UTF-8">
        <input type="hidden" name="_method" value="POST">
        <input type="email" id="username" class="span4" name="data[PasswordReset][email]" placeholder="user@test.com" value="<?php echo Sanitize::html($email); ?>">

        <br/>

        <button type="submit" name="submit" class="btn btn-primary">forgot password</button>
    </form>
</div>
