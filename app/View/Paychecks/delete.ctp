<?php $error = $this->Session->flash(); ?>

<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/dashboard">paychecks</a> <span class="divider">|</span></li>
        <li class="active">delete paycheck</li>
    </ul>

    <?php if (strcmp(strip_tags($error),'')) { ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php } ?>

    <p>are you sure you want to delete this income?</p>
    <p><b>$<?php echo Sanitize::html($total); ?> - <?php echo Sanitize::html($clean_date_received); ?></b></p>

    <form action="/income/<?php echo Sanitize::html($id); ?>/delete" id="PaycheckDeleteForm" method="post" accept-charset="utf-8">
        <input type="hidden" name="confirmation" value="true">
        <input type="hidden" name="_method" value="POST">

        <br/>

        <a href="/dashboard" class="btn btn-large btn-primary">cancel</a>

        <button type="submit" class="btn-large btn-danger" type="submit">delete</button>
    </form>
</div>