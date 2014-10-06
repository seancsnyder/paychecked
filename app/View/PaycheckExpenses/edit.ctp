<?php $error = $this->Session->flash(); ?>

<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/dashboard">paychecks</a> <span class="divider">|</span></li>
        <li><a href="/income/<?php echo Sanitize::html($paycheck_id); ?>/edit">edit paycheck</a> <span class="divider">|</span></li>
        <li class="active">edit expense</li>
    </ul>

    <?php if (strcmp(strip_tags($error),'')) { ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php } ?>

    <form action="/income/<?php echo Sanitize::html($paycheck_id); ?>/expense/<?php echo Sanitize::html($id); ?>/edit" id="PaycheckExpenseEditForm" method="post" accept-charset="utf-8">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="id" value="<?php echo Sanitize::html($id); ?>">
        <label for="PaycheckExpenseName">name</label>
        <input class="input-medium" name="data[PaycheckExpense][name]" maxlength="128" type="text" id="PaycheckExpenseName" placeholder="bills" value="<?php echo Sanitize::html($name); ?>">

        <label for="appendedPrependedInput">total</label>
        <div class="input-prepend input-append">
          <span class="add-on">$</span><input class="input-medium" name="data[PaycheckExpense][total]" id="appendedPrependedInput" placeholder="50" value="<?php echo Sanitize::html($total); ?>" size="16" type="text"><span class="add-on">.00</span>
        </div>

        <br/>

        <button type="submit" class="btn btn-large btn-primary" type="submit">save</button>

        <a href="/income/<?php echo Sanitize::html($paycheck_id); ?>/expense/<?php echo Sanitize::html($id); ?>/delete" class="btn btn-large btn-danger">delete</a>
    </form>
</div>