<div class="hero-unit">
    <ul class="breadcrumb">
        <li class="active">paychecks</li><span class="divider">|</span></li>
        <li><a href="/dashboard/past">past paychecks</a></li>
        <a href="/income/add" class="btn btn-success btn-mini right">add</a>
    </ul>

    <?php echo $this->element('error-messaging'); ?>

    <?php echo $this->element('paycheck-dashboard'); ?>
</div>