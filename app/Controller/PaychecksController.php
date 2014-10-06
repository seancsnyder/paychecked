<?php
    /**
     * User: sean
     * Date: 8/13/12
     */

    class PaychecksController extends AppController
    {
        public $uses = array("Paycheck","PaycheckExpense");

        public function index()
        {
            $this->set('title_for_layout', 'dashboard');

            $this->set("paychecks",$this->Paycheck->find("all",array(
                            "conditions" => array('user_id' => $this->Auth->user('id'),
                                                'date_received >=' => date("Y-m-d",strtotime("-5 days"))),
                            'order' => array('Paycheck.date_received ASC'))));
        }

        public function index_past()
        {
            $this->set('title_for_layout', 'dashboard - past paychecks');

            $this->set("paychecks",$this->Paycheck->find("all",array(
                            "conditions" => array('user_id' => $this->Auth->user('id'),
                                                'date_received <' => date("Y-m-d",strtotime("-7 days")),
                                                'date_received >' => date("Y-m-d",strtotime("-45 days"))),
                            'order' => array('Paycheck.date_received ASC'))));
        }

        public function add()
        {
            //add some page specific js/css
            $this->set('page_specific_css_includes',array('bootstrap-datepicker'));
            $this->set('page_specific_js_includes',array('bootstrap-datepicker/bootstrap-datepicker','paycheck-date-functions'));

            $this->set('title_for_layout', 'add paycheck');

            $this->set("total","");
            $this->set("date_received",date("Y-m-d"));

            if ($this->request->is('post'))
            {
                $this->set("total",$this->request->data['Paycheck']['total']);
                $this->set("date_received",$this->request->data['Paycheck']['date_received']);

                $this->request->data['Paycheck']['user_id'] = $this->Auth->user('id');

                if ($this->Paycheck->save($this->request->data))
                {
                    $this->redirect('/dashboard');
                }
                else
                {
                    if (count($this->Paycheck->invalidFields()))
                    {
                        $temp_errors = array();

                        foreach($this->Paycheck->invalidFields() as $validation_error)
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
            //add some page specific js/css
            $this->set('page_specific_css_includes',array('bootstrap-datepicker'));
            $this->set('page_specific_js_includes',array('bootstrap-datepicker/bootstrap-datepicker','paycheck-date-functions'));

            $this->set('title_for_layout', 'edit paycheck');

            $this->set("total","");
            $this->set("date_received","");

            if(strcmp($this->request->params['id'],''))
            {
                $this->set("id",$this->request->params['id']);

                $paycheck = $this->Paycheck->find("first",array(
                                                "conditions" => array('user_id' => $this->Auth->user('id'),
                                                                    'id' => $this->request->params['id'])));

                if ($paycheck)
                {
                    $this->set("total",$paycheck['Paycheck']['total']);
                    $this->set("date_received",$paycheck['Paycheck']['date_received']);
                }
                else
                {
                    $this->Session->setFlash("Invalid paycheck id");
                    $this->redirect("/dashboard");
                }

                if ($this->request->is('post'))
                {
                    $this->Paycheck->id = $this->request->params['id'];
                    $this->request->data['Paycheck']['user_id'] = $this->Auth->user("id");

                    if (count($this->Paycheck->invalidFields()))
                    {
                        $temp_errors = array();

                        foreach($this->Paycheck->invalidFields() as $validation_error)
                        {
                            array_push($temp_errors,$validation_error[0]);
                        }

                        $this->Session->setFlash(implode("<br/>",$temp_errors));
                    }

                    if ($this->Paycheck->save($this->request->data))
                    {
                        $this->redirect('/dashboard#paycheck_summary_' . $this->request->params['id']);
                    }
                }
            }
        }


        public function duplicate()
        {
            //add some page specific js/css
            $this->set('page_specific_css_includes',array('bootstrap-datepicker'));
            $this->set('page_specific_js_includes',array('bootstrap-datepicker/bootstrap-datepicker','paycheck-date-functions'));

            $this->set('title_for_layout', 'duplicate paycheck');

            $this->set("total","");
            $this->set("date_received","");
            $this->set("expenses","");

            if(strcmp($this->request->params['id'],''))
            {
                $this->set("id",$this->request->params['id']);

                $paycheck = $this->Paycheck->find("first",array(
                                                "conditions" => array('user_id' => $this->Auth->user('id'),
                                                                    'id' => $this->request->params['id'])));

                if ($paycheck)
                {
                    $this->set("total",$paycheck['Paycheck']['total']);

                    if (count($paycheck['PaycheckExpenses']))
                    {
                        $this->set("expenses",$paycheck['PaycheckExpenses']);
                    }
                }
                else
                {

                    $this->Session->setFlash("Invalid paycheck id");
                    $this->redirect("/dashboard");
                }


                if ($this->request->is('post'))
                {
                    $this->request->data['Paycheck']['user_id'] = $this->Auth->user('id');
                    $this->request->data['Paycheck']['total'] = $paycheck['Paycheck']['total'];

                    $new_paycheck = $this->Paycheck->save($this->request->data);

                    if ($new_paycheck)
                    {
                        if (count($paycheck['PaycheckExpenses']))
                        {
                            //link up the existing expenses to the new paycheck.
                            foreach($paycheck['PaycheckExpenses'] as $expense)
                            {
                                unset($expense['id']);
                                $expense['paycheck_id'] = $new_paycheck['Paycheck']['id'];

                                $this->PaycheckExpense->create();
                                $new_expense = $this->PaycheckExpense->save($expense);

                                if (!$new_expense)
                                {
                                    $this->Session->setFlash("Unable to link expenses to duplicated paycheck.");
                                }
                            }
                        }

                        $this->redirect('/dashboard');
                    }
                    else
                    {
                        if (count($this->Paycheck->invalidFields()))
                        {
                            $temp_errors = array();

                            foreach($this->Paycheck->invalidFields() as $validation_error)
                            {
                                array_push($temp_errors,$validation_error[0]);
                            }

                            $this->Session->setFlash(implode("<br/>",$temp_errors));
                        }
                    }
                }
            }
        }


        public function delete()
        {
            $this->set('title_for_layout', 'delete paycheck');

            if(strcmp($this->request->params['id'],''))
            {
                $this->set("id",$this->request->params['id']);

                $paycheck = $this->Paycheck->find("first",array(
                                            "conditions" => array('user_id' => $this->Auth->user('id'),
                                                                'id' => $this->request->params['id'])));

                if ($paycheck)
                {
                    if ($this->request->is('post') && !strcmp($this->request->data['confirmation'],'true'))
                    {
                        if ($this->Paycheck->delete($this->request->params['id']))
                        {
                            if (count($paycheck['PaycheckExpenses']))
                            {
                                foreach($paycheck['PaycheckExpenses'] as $expense)
                                {
                                    $this->PaycheckExpense->delete($expense['id']);
                                }
                            }

                            $this->redirect('/dashboard');
                        }
                    }

                    $this->set("total",$paycheck['Paycheck']['total']);
                    $this->set("clean_date_received",$paycheck['Paycheck']['clean_date_received']);
                }
                else
                {
                    $this->Session->setFlash("Invalid paycheck id");
                    $this->redirect("/dashboard");
                }
            }
            else
            {
                $this->Session->setFlash("Invalid paycheck id");
                $this->redirect("/dashboard");
            }
        }
    }
?>