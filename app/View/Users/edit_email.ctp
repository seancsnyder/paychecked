<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/account">update account</a> <span class="divider">|</span></li>
        <li class="active">update email</li>
    </ul>

    <?php echo $this->element('error-messaging'); ?>

    <form action="/account/email" id="UserEditForm" method="post" accept-charset="utf-8">
        <input type="hidden" name="_method" value="POST">

        <label for="UserEmail">email</label>
        <input class="input-medium" name="data[User][email]" maxlength="128" type="text" id="UserEmail" value="<?php echo Sanitize::html($email); ?>">

        <br/>

        <label for="UserEmail">email confirmation</label>
        <input class="input-medium" name="data[User][email_confirmation]" maxlength="128" type="text" id="UserEmailConfirmation" value="">

        <br/>

        <label for="UserEmailPassword">current password</label>
        <input class="input-medium" name="data[User][password]" maxlength="128" type="password" id="UserEmailPassword">

        <br/>

        <button type="submit" class="btn btn-large btn-primary" type="submit">save</button>
    </form>
</div>