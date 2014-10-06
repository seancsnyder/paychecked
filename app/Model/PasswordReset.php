<?php
    /**
     * User: sean
     * Date: 8/13/12
     */

    class PasswordReset extends AppModel
    {
        public $name = "PasswordReset";

        public function beforeSave()
        {
            $this->data['PasswordReset']['reset_key'] = AuthComponent::password(mt_rand(0,1000) . date("r") . $_SERVER['REMOTE_ADDR']);
            $this->data['PasswordReset']['valid_until'] = date("Y-m-d H:i:s",strtotime("+6 hours"));
            $this->data['PasswordReset']['date_submitted'] = date("Y-m-d H:i:s");
        }
    }

?>