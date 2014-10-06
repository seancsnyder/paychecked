<div class="hero-unit">
    <ul class="breadcrumb">
        <li class="active">reset password</li>
    </ul>

    <?php echo $this->element('error-messaging'); ?>

    <?php if (!$successfully_reset_password) { ?>
        <form action="/reset-password/<?php echo Sanitize::html($reset_key); ?>" id="UserEditForm" method="post" accept-charset="utf-8">
            <label for="UserNewPassword">new password</label>
            <input class="input-medium" name="data[User][new_password]" maxlength="128" type="password" id="UserNewPassword">
    
            <br/>
    
            <label for="UserNewPasswordConfirmation">password confirmation</label>
            <input class="input-medium" name="data[User][new_password_confirmation]" maxlength="128" type="password" id="UserNewPasswordConfirmation">
    
            <br/>
    
            <button type="submit" class="btn btn-large btn-primary" type="submit">save</button>
        </form>
    <?php } else { ?>
        <a href="/login" class="btn btn-primary">login now</a>
    <?php } ?>
</div>