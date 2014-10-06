

            <?php if (count($paychecks)) { ?>
                <?php foreach($paychecks as $paycheck) { ?>
                    <div id="paycheck_summary_<?php echo $paycheck['Paycheck']['id']; ?>" class="well paycheck_listing">
                        <span class="paycheck_summary"><a href="/income/<?php echo $paycheck['Paycheck']['id']; ?>/edit" class="btn btn-info btn-mini">edit</a> $<?php echo $paycheck['Paycheck']['total']; ?> - <?php echo $paycheck['Paycheck']['clean_date_received']; ?></span>

                        <span style="float:right;" class="duplicate_button"><a href="/income/<?php echo $paycheck['Paycheck']['id']; ?>/duplicate" class="btn btn-info btn-mini">duplicate</a></span>

                        <div id="expenses_<?php echo $paycheck['Paycheck']['id']; ?>" class="expense_overview">
                            <div class="paycheck_expenses">
                                <ul class="nav nav-tabs nav-stacked">
                                    <?php if (count($paycheck['PaycheckExpenses'])) { ?>
                                        <?php foreach($paycheck['PaycheckExpenses'] as $paycheck_expense) { ?>
                                            <li>
                                                <a href="/income/<?php echo Sanitize::html($paycheck_expense['paycheck_id']); ?>/expense/<?php echo Sanitize::html($paycheck_expense['id']); ?>/edit">
                                                    <div class="expense_total">$<?php echo $paycheck_expense['total']; ?></div>
                                                    <div class="expense_name"><?php echo $paycheck_expense['name']; ?></div>
                                                    <div class="remainder_percentage"><?php echo $paycheck_expense['percentage_of_gross']; ?>%</div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <a href="/income/<?php echo $paycheck['Paycheck']['id']; ?>/expense/add">add expense</a>
                                        </li>
                                    <?php } else { ?>
                                        <li><a href="/income/<?php echo $paycheck['Paycheck']['id']; ?>/expense/add">add expense</a></li>
                                    <?php } ?>
                                </ul>
                                <hr class="expenses_net_dividing_line" />
                                <div class="net_income">$<?php echo $paycheck['Paycheck']['net']; ?> net
                                    <span class="remainder_percentage"><?php echo $paycheck['net_remainder_percentage_of_gross']; ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>no income :-(</p>
            <?php } ?>
