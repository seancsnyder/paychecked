<?php
/**
 * User: sean
 * Date: 8/25/12
 */

    class PaycheckExpense extends AppModel
    {

        public $name = "PaycheckExpense";

        public $validate = array("name" => array("required" => true, "rule" => array('minLength', 2), 'message' => 'please enter the name of the expense (min 2 characters)'),
                                    "total" => array("required" => true, "rule" => array('comparison', '>', 0), 'message' => 'please enter the total expense amount'),);

        public $belongsTo = array(
                'Paycheck' => array(
                    'className'    => 'Paycheck',
                    'foreignKey'   => 'paycheck_id'
                )
            );


        public function beforeSave()
        {
            $this->data['PaycheckExpense']['total'] = round($this->data['PaycheckExpense']['total']);
        }
    }
?>