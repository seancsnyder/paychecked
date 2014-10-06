<?php $error = $this->Session->flash(); ?>

<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/dashboard">paychecks</a> <span class="divider">|</span></li>
        <li class="active">add paycheck</li>
    </ul>

    <?php if (strcmp(strip_tags($error),'')) { ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php } ?>

    <form action="/income/add" id="PaycheckEditForm" method="post" accept-charset="utf-8">
        <input type="hidden" name="_method" value="POST">

        <label for="appendedPrependedInput">total</label>
        <div class="input-prepend input-append">
          <span class="add-on">$</span><input class="input-medium" name="data[Paycheck][total]" id="appendedPrependedInput" placeholder="1000" value="<?php echo Sanitize::html($total); ?>" size="16" type="text"><span class="add-on">.00</span>
        </div>

        <label for="IncomeDate">payday</label>
        <div class="input-prepend input-append">
            <input type="text" id="datepicker" class="input-medium" name="data[Paycheck][date_received]" id="IncomeDate" value="<?php echo Sanitize::html($date_received); ?>">
        </div>

        <br/>

        <button type="submit" class="btn btn-large btn-primary" type="submit">save</button>
    </form>
</div>