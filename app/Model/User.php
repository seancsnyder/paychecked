<?php
    /**
     * User: sean
     * Date: 8/13/12
     */

    class User extends AppModel
    {
        public $name = "User";

        public $validate = array("email" => array("required" => true, "rule" => array("email","isUnique"), 'message' => 'please enter a valid email address'),
                                "password" => array("required" => true, 'rule' => array('minLength', 2), "message" => "password must be at least 2 characters"));


        public function beforeSave()
        {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
    }

?>