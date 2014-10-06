<?php
    /**
     * User: sean
     * Date: 8/13/12
     */

    class UsersController extends AppController
    {
        public $uses = array("User","Paycheck","PaycheckExpense","PasswordReset");

        function beforeFilter()
        {
            parent::beforeFilter();
            $this->Auth->allow('login');
            $this->Auth->allow('forgot_password');
            $this->Auth->allow('reset_password');
            $this->Auth->allow('sent_password_reset');
            $this->Auth->allow('reset_password');

            $this->Cookie->path = '/';
            $this->Cookie->domain = $_SERVER['SERVER_NAME'];
            $this->Cookie->secure = false;
            $this->Cookie->httpOnly = false;
        }


        public function logout()
        {
            $this->redirect($this->Auth->logout());
        }


        public function login()
        {
            $this->set('title_for_layout', 'login/register');

            if (!is_null($this->Auth->user()))
            {
                //redirect to dashboard.
                $this->redirect("/dashboard");
            }

            $remember_email = (isset($this->request->data['remember_email'])) ? $this->request->data['remember_email'] : 0;

            $created_new_user = false;

            $this->set("remember_email",$remember_email);

            if ($this->request->is('post'))
            {
                $this->set("email",$this->request->data['User']['email']);
                $this->set("password",$this->request->data['User']['password']);
                $this->set("remember_email",$remember_email);

                $existing_user_id = $this->get_user_id_by_email($this->request->data['User']['email']);

                if ($existing_user_id)
                {
                    $this->request->data['User'] = array_merge($this->request->data['User'], array('id' => $existing_user_id));
                }
                else
                {
                    //not in database.  we're gonna create a new user
                    //make them verify the password before we create the account.
                    $this->set("confirm_new_user_password",true);

                    if (isset($this->request->data['User']['password_confirmation']))
                    {
                        if (!strcmp($this->request->data['User']['password'],$this->request->data['User']['password_confirmation']))
                        {

                            $created_new_user = $this->create_account();

                            if (count($this->User->invalidFields()))
                            {
                                $temp_errors = array();

                                foreach($this->User->invalidFields() as $validation_error)
                                {
                                    array_push($temp_errors,$validation_error[0]);
                                }

                                $this->Session->setFlash(implode("<br/>",$temp_errors));
                            }

                        }
                        else
                        {
                            $this->Session->setFlash("passwords do not match.");
                        }
                    }
                    else
                    {
                        return false;
                    }
                }


                if ($existing_user_id || $created_new_user)
                {
                    if ($this->Auth->login())
                    {
                        if (isset($this->request->data['remember_email']))
                        {
                            $this->Cookie->write('remember_email', $this->request->data['User']['email'], true, "30 days");
                        }

                        return $this->redirect($this->Auth->redirect());
                    }
                    else
                    {
                        //show error message
                        $this->Session->setFlash("invalid password.  please try again.");
                    }
                }
            }
            else
            {
                $remember_email = $this->Cookie->read('remember_email');

                $this->set("email","");

                if (strcmp($remember_email,''))
                {
                    $this->set("email",$remember_email);
                    $this->set("remember_email","1");
                }
            }
        }


        public function create_account()
        {
            if ($this->User->save($this->request->data))
            {
                return true;
            }
        }


        private function get_user_id_by_email($email)
        {
            $user = $this->User->find("first", array("conditions" => array('email' => $email)));

            if (is_array($user) && count($user))
            {
                return $user['User']['id'];
            }

            return 0;
        }


        public function index()
        {

        }


        public function edit_email()
        {
            $this->set('title_for_layout', 'update email');

            $this->User->read(null,$this->Auth->user('id'));

            $this->set("email",$this->User->data["User"]['email']);

            if ($this->request->is('post'))
            {
                $validation_errors = array();

                if (isset($this->request->data['User']['email']) && strcmp($this->request->data['User']['email'],''))
                {
                    //we are trying to update the email address

                    $this->set("email",$this->request->data['User']['email']);

                    //check if email is different then current user's email
                    $no_change_to_email = (!strcmp($this->User->data["User"]['email'],$this->request->data['User']['email_confirmation'])) ? true : false;

                    //check if email is already used by another user.
                    $existing_user = $this->User->find("first", array("conditions" => array('email' => $this->request->data['User']['email'])));

                    //make sure they match
                    if (strcmp($this->request->data['User']['email'],$this->request->data['User']['email_confirmation']))
                    {
                        array_push($validation_errors,"email addresses do not match");
                    }
                    else if (is_array($existing_user) && count($existing_user) && !$no_change_to_email)
                    {
                        array_push($validation_errors,"email addresses already in use by another user");
                    }
                    else if (strcmp(AuthComponent::password($this->request->data['User']['password']), $this->User->data["User"]['password']))
                    {
                        array_push($validation_errors,"current password is incorrect");
                    }
                    else
                    {
                        $this->User->set("email",$this->request->data['User']['email']);
                        $this->User->set("password",$this->request->data['User']['password']);
                        $saved = $this->User->save();

                        if ($saved)
                        {
                            $this->set("success_message","successfully updated email address");
                        }
                        else
                        {
                            array_push($validation_errors,"unable to update email addresses");
                        }
                    }
                }

                if (count($validation_errors))
                {
                    $temp_errors = array();

                    foreach($validation_errors as $validation_error)
                    {
                        array_push($temp_errors,$validation_error);
                    }

                    $this->Session->setFlash(implode("<br/>",$temp_errors));
                }
            }
        }


        public function edit_password()
        {
            $this->set('title_for_layout', 'update password');

            $this->User->read(null,$this->Auth->user('id'));

            if ($this->request->is('post'))
            {
                $validation_errors = array();

                if (isset($this->request->data['User']['new_password']) && strcmp($this->request->data['User']['new_password_confirmation'],''))
                {
                    //updating password

                    $this->set("email",$this->User->data['User']['email']);

                    //make sure they match
                    if (strcmp($this->request->data['User']['new_password'],$this->request->data['User']['new_password_confirmation']))
                    {
                        array_push($validation_errors,"new passwords do not match");
                    }
                    else if (strcmp(AuthComponent::password($this->request->data['User']['password']), $this->User->data["User"]['password']))
                    {
                        array_push($validation_errors,"current password is incorrect");
                    }
                    else
                    {
                        $this->User->set("password",$this->request->data['User']['new_password']);
                        if ($this->User->save())
                        {
                            $this->set("success_message","successfully updated password");
                        }
                        else
                        {
                            $this->Session->setFlash("unable to update password.  unexpected error.");
                        }
                    }
                }


                if (count($validation_errors))
                {
                    $temp_errors = array();

                    foreach($validation_errors as $validation_error)
                    {
                        array_push($temp_errors,$validation_error);
                    }

                    $this->Session->setFlash(implode("<br/>",$temp_errors));
                }
            }
        }



        public function delete()
        {
            $this->set('title_for_layout', 'delete account');

            $this->User->read(null,$this->Auth->user('id'));

            if ($this->request->is('post') && !strcmp($this->request->data['confirmation'],'true'))
            {
                if ($this->User->delete($this->Auth->user('id')))
                {
                    //TODO: delete associated paychecks and expenses.  or let a cron do this

                    $this->Cookie->delete('remember_email');

                    $this->redirect('/logout');
                }
            }
        }


        public function sent_password_reset()
        {
            $this->set("title_for_layout","sent password reset");
        }

        public function forgot_password()
        {
            $this->set('title_for_layout', 'forgot password');
            $this->set('email', '');

            if ($this->request->is('post'))
            {
                $this->set('email', $this->request->data['PasswordReset']['email']);

                $existing_user_id = $this->get_user_id_by_email($this->request->data['PasswordReset']['email']);

                if ($existing_user_id)
                {
                    //create reset key in db
                    if ($this->PasswordReset->save($this->request->data))
                    {
                        $reset_data = $this->PasswordReset->findById($this->PasswordReset->id);

                        if (count($reset_data))
                        {
                            $reset_key = $reset_data['PasswordReset']['reset_key'];
                            $email_subject = 'paychecked.co password reset';

                            //send reset email
                            $email = new CakeEmail();
                            $email->config('smtp');
                            $email->template('reset_password','default');
                            $email->emailFormat('html');
                            $email->to('sean@snyderitis.com');
                            $email->from('help@paychecked.co');
                            $email->subject($email_subject);
                            $email->viewVars(array('reset_key' => $reset_key, "title_for_layout" => $email_subject));
                            $sent = $email->send();

                            $this->redirect("/sent-password-reset");
                        }
                        else
                        {
                            $this->Session->setFlash("unable to generate reset password key.  please try again.");
                        }
                    }
                }
                else
                {
                    $this->Session->setFlash("unable to find account linked to that email address.  please try again.");
                }
            }
        }



        public function reset_password()
        {
            //reset password, check the hash in the query string
            $this->set("successfully_reset_password",false);

            if(strcmp($this->request->params['reset_key'],''))
            {
                $this->set("reset_key",$this->request->params['reset_key']);

                $reset_key_data = $this->PasswordReset->find("first", array("conditions" =>
                                                                                array("reset_key =" => $this->request->params['reset_key'],
                                                                                        "valid_until >=" => date("Y-m-d H:i:s"))));

                if ($reset_key_data)
                {
                    $this->PasswordReset->read(null,$reset_key_data['PasswordReset']['id']);

                    $existing_user_id = $this->get_user_id_by_email($reset_key_data['PasswordReset']['email']);

                    if ($existing_user_id)
                    {
                        $this->User->read(null,$existing_user_id);

                        if ($this->request->is('post'))
                        {
                            $validation_errors = array();

                            if (isset($this->request->data['User']['new_password']) && strcmp($this->request->data['User']['new_password_confirmation'],''))
                            {
                                //make sure they match
                                if (strcmp($this->request->data['User']['new_password'],$this->request->data['User']['new_password_confirmation']))
                                {
                                    array_push($validation_errors,"new passwords do not match");
                                }
                                else
                                {
                                    $this->User->set("password",$this->request->data['User']['new_password']);
                                    if ($this->User->save())
                                    {
                                        $this->set("success_message","successfully updated password");
                                        $this->set("successfully_reset_password",true);

                                        //delete reset key.  don't check return value, key will expire.
                                        $this->PasswordReset->delete($reset_key_data['PasswordReset']['id']);
                                    }
                                    else
                                    {
                                        $this->Session->setFlash("unable to update password.  unexpected error.");
                                    }
                                }
                            }


                            if (count($validation_errors))
                            {
                                $temp_errors = array();

                                foreach($validation_errors as $validation_error)
                                {
                                    array_push($temp_errors,$validation_error);
                                }

                                $this->Session->setFlash(implode("<br/>",$temp_errors));
                            }
                        }
                    }
                    else
                    {
                        $this->Session->setFlash("Invalid/expired reset key. Invalid user.");
                    }
                }
                else
                {
                    $this->Session->setFlash("Invalid/expired reset key.");
                }
            }
            else
            {
                $this->Session->setFlash("Missing reset key.");
            }
        }
    }
?>