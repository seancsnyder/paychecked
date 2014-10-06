<?php $error = $this->Session->flash(); ?>

<div class="hero-unit">
    <ul class="breadcrumb">
        <li><a href="/dashboard">paychecks</a> <span class="divider">|</span></li>
        <li class="active">duplicate paycheck</li>
    </ul>

    <?php if (strcmp(strip_tags($error),'')) { ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php } ?>

    <p>To duplicate this paycheck, just set a new paydate.</p>

    <table>
    <tr><td width="100">Total:</td><td>$<?php echo Sanitize::html($total); ?></td></tr>
    <?php if (count($expenses)) { ?>
    <tr><td>Expenses:</td>
        <?php foreach($expenses as $key => $expense) { ?>
            <?php if ($key > 0) { ?><tr><td>&nbsp;</td><?php } ?>
            <td>$<?php echo $expense['total'] . ' - ' . $expense['name']; ?></td></tr>
        <?php } ?>
    <?php } ?>
    </table>

    <br/>

    <form action="/income/<?php echo Sanitize::html($id); ?>/duplicate" id="PaycheckDuplicateForm" method="post" accept-charset="utf-8">
        <input type="hidden" name="_method" value="POST">


        <label for="IncomeDate">payday</label>
        <div class="input-prepend input-append">
            <input type="text" id="datepicker" class="input-medium" name="data[Paycheck][date_received]" id="IncomeDate" value="<?php echo Sanitize::html($date_received); ?>">
        </div>

        <br/>

        <button type="submit" class="btn btn-large btn-primary" type="submit">save</button>
    </form>
</div>