<?php
    /**
     * User: sean
     * Date: 8/25/12
     */

    class PaycheckExpensesController extends AppController
    {
        public $uses = array("Paycheck","PaycheckExpense");

        public function add()
        {
            $this->set('title_for_layout', 'add expense');

            $this->set("name","");
            $this->set("total","");

            //make sure it's an expense that belongs to a paycheck, that belongs to the user.
            $paycheck = $this->Paycheck->find("first",array("conditions" => array('id' => $this->request->params['paycheck_id'])));

            if (!$paycheck)
            {
                $this->redirect("/dashboard");
            }

            $this->set("paycheck_id",$this->request->params['paycheck_id']);

            if ($this->request->is('post'))
            {
                $this->set("name",$this->request->data['PaycheckExpense']['name']);
                $this->set("total",$this->request->data['PaycheckExpense']['total']);

                $this->request->data['PaycheckExpense']['paycheck_id'] = $this->request->params['paycheck_id'];

                if ($this->PaycheckExpense->save($this->request->data))
                {
                    $this->redirect('/dashboard');
                }
                else
                {
                    if (count($this->PaycheckExpense->invalidFields()))
                    {
                        $temp_errors = array();

                        foreach($this->PaycheckExpense->invalidFields() as $validation_error)
                        {
                            array_push($temp_errors,$validation_error[0]);
                        }

                        $this->Session->setFlash(implode("<br/>",$temp_errors));
                    }
                }
            }
        }


        public function edit()
        {
            $this->set('title_for_layout', 'edit expense');

            $this->Session->setFlash("");

            $this->set("name","");
            $this->set("total","");

            if(strcmp($this->request->params['id'],''))
            {
                $this->set("id",$this->request->params['id']);
                $this->set("paycheck_id",$this->request->params['paycheck_id']);

                //make sure it's an expense that belongs to a paycheck, that belongs to the user.
                $expense = $this->PaycheckExpense->find("first",array(
                                                            "conditions" => array('Paycheck.user_id' => $this->Auth->user('id'),
                                                                                'paycheck_id' => $this->request->params['paycheck_id'],
                                                                                'PaycheckExpense.id' => $this->request->params['id'])));

                if ($expense)
                {
                    $this->set("name",$expense['PaycheckExpense']['name']);
                    $this->set("total",$expense['PaycheckExpense']['total']);
                }
                else
                {
                    $this->Session->setFlash("Invalid paycheck expense id.");
                    $this->redirect("/dashboard");
                }


                if ($this->request->is('post'))
                {
                    if (Configure::read("is_test_server")){var_dump($this->request);}

                    $this->PaycheckExpense->id = $this->request->params['id'];
                    $this->request->data['PaycheckExpense']['paycheck_id'] = $this->request->params['paycheck_id'];

                    if (count($this->PaycheckExpense->invalidFields()))
                    {
                        $temp_errors = array();

                        foreach($this->PaycheckExpense->invalidFields() as $validation_error)
                        {
                            array_push($temp_errors,$validation_error[0]);
                        }

                        if (Configure::read("is_test_server")){echo "SET FLASH MESSAGE";}
                        $this->Session->setFlash(implode("<br/>*",$temp_errors));
                    }

                    if ($this->PaycheckExpense->save($this->request->data))
                    {
                        $this->redirect("/dashboard#paycheck_summary_" . $this->request->params['paycheck_id']);
                    }
                }
            }
        }


        public function delete()
        {
            $this->set('title_for_layout', 'delete expense');

            if(strcmp($this->request->params['id'],''))
            {
                $this->set("id",$this->request->params['id']);
                $this->set("paycheck_id",$this->request->params['paycheck_id']);

                $expense = $this->PaycheckExpense->find("first",array(
                                                        "conditions" => array('Paycheck.user_id' => $this->Auth->user('id'),
                                                                            'paycheck_id' => $this->request->params['paycheck_id'],
                                                                            'PaycheckExpense.id' => $this->request->params['id'])));

                if ($expense)
                {
                    if ($this->request->is('post') && !strcmp($this->request->data['confirmation'],'true'))
                    {
                        if ($this->PaycheckExpense->delete($this->request->params['id']))
                        {
                            $this->redirect('/dashboard');
                        }
                    }

                    $this->set("total",$expense['PaycheckExpense']['total']);
                    $this->set("name",$expense['PaycheckExpense']['name']);
                }
                else
                {
                    $this->redirect("/dashboard");
                }
            }
            else
            {
                $this->redirect("/dashboard");
            }

        }
    }
?>