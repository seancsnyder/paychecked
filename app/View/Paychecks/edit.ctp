<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/dashboard">paychecks</a> <span class="divider">|</span></li>
        <li class="active">edit paycheck</li>
    </ul>

    <?php echo $this->element('error-messaging'); ?>

    <form action="/income/<?php echo Sanitize::html($id); ?>/edit" id="PaycheckEditForm" method="post" accept-charset="utf-8">
        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="id" value="<?php echo Sanitize::html($id); ?>">

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

        <a href="/income/<?php echo Sanitize::html($id); ?>/delete" class="btn btn-large btn-danger">delete</a>
    </form>
</div>