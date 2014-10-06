<?php
    /**
     * User: sean
     * Date: 8/13/12
     */

    class Paycheck extends AppModel
    {
        public $name = "Paycheck";

        public $validate = array("total" => array("greater_than_zero" => array("rule" => array('comparison', '>', 0), 'message' => 'please enter the total amount expected (more than $0)')),
                                "date_received" => array(
                                    "date_entered" => array('rule' => array('date'), "message" => "please select a valid date of the income", "last" => true),
                                    "future_date" => array("rule" => array("validate_future_date"), "message" => "please select a future date", "last" => true, "on" => "create")));

        public $hasMany = array('PaycheckExpenses' => array('className'  => 'PaycheckExpense',
                                                            'order' => array("PaycheckExpenses.total" => "DESC")));



        public function validate_future_date($check)
        {
            return (strtotime($check['date_received'] . " 23:59:59") >= time());
        }

        public function beforeSave()
        {
            $this->data['Paycheck']['total'] = round($this->data['Paycheck']['total']);
        }


        function afterFind($paychecks)
        {
            foreach ($paychecks as $paycheck_key => $paycheck)
            {
                //assume the net is the full paycheck.
                $paychecks[$paycheck_key]['Paycheck']['net'] = $paycheck['Paycheck']['total'];

                //determine the net paycheck value.  subtract each expense.  should only be integers
                if (isset($paycheck['PaycheckExpenses']) && count($paycheck['PaycheckExpenses']))
                {
                    foreach($paycheck['PaycheckExpenses'] as $expense_key => $paycheck_expense)
                    {
                        //adjust the total net total to account for this expense
                        $paychecks[$paycheck_key]['Paycheck']['net'] -= $paycheck_expense['total'];

                        //calculate the percentage of the gross income as well
                        $paychecks[$paycheck_key]['PaycheckExpenses'][$expense_key]['percentage_of_gross'] = round($paycheck_expense['total'] / $paycheck['Paycheck']['total'] * 100,1);
                    }
                }

                $paychecks[$paycheck_key]['net_remainder_percentage_of_gross'] = round($paychecks[$paycheck_key]['Paycheck']['net'] / $paycheck['Paycheck']['total'] * 100,1);

                //for the the paychecks date received.
                if (isset($paycheck['Paycheck']['date_received']))
                {
                    $paychecks[$paycheck_key]['Paycheck']['clean_date_received'] = date('m/d/Y', strtotime($paycheck['Paycheck']['date_received']));
                }


            }
            return $paychecks;
        }
    }
?>