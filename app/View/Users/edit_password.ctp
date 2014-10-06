<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/account">update account</a> <span class="divider">|</span></li>
        <li class="active">update password</li>
    </ul>

    <?php echo $this->element('error-messaging'); ?>

    <form action="/account/password" id="UserEditForm" method="post" accept-charset="utf-8">
        <label for="UserPassword">current password</label>
        <input class="input-medium" name="data[User][password]" placeholder="**********" maxlength="128" type="password" id="UserPassword">

        <br/>

        <label for="UserNewPassword">new password</label>
        <input class="input-medium" name="data[User][new_password]" maxlength="128" type="password" id="UserNewPassword">

        <br/>

        <label for="UserNewPasswordConfirmation">password confirmation</label>
        <input class="input-medium" name="data[User][new_password_confirmation]" maxlength="128" type="password" id="UserNewPasswordConfirmation">

        <br/>

        <button type="submit" class="btn btn-large btn-primary" type="submit">save</button>
    </form>
</div>