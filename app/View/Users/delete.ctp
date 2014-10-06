<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/account">update account</a> <span class="divider">|</span></li>
        <li class="active">delete account</li>
    </ul>

    <?php echo $this->element('error-messaging'); ?>

    <p>are you sure you want to delete your account?  this an irreversable action. all paychecks and associated expenses will also be deleted.</p>

    <form action="/account/delete" id="UserDeleteForm" method="post" accept-charset="utf-8">
        <input type="hidden" name="confirmation" value="true">
        <input type="hidden" name="_method" value="POST">

        <br/>

        <a href="/account" class="btn btn-large btn-primary">cancel</a>

        <button type="submit" class="btn btn-large btn-danger" type="submit">delete</button>
    </form>
</div>