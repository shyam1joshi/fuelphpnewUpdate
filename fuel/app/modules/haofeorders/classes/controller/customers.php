<?php

namespace haofeorders;

class Controller_Customers extends \Controller_Customers{
    public $model = "\haofeorders\Model_Customers";
    
    public  $username = '';
    public  $email = '';
    public  $password = 'haofe123';


    public function action_createUser($id = null) {
        
        $data =null;
        
//        if(\Input::method() =='POST'){
            
            
               
            $customer = Model_Customers::find($id);

            if (is_object($customer)){

                $this->username = $customer->customer_key;
                $this->email = $customer->customer_key.'@haofe.co.il';
                $userid = $this->createUser();

                 $agent = new \Model_Agents;

                 if(is_object($agent)){

                    $agent->connect_uid = $userid;
                    $agent->name = $customer->customer_key;
                    $agent->allow_web = 1;
                    $agent->allow_mobile = 1;

                    $seq = array('seq_order_start', 'seq_order_end', 'seq_order_current', 'seq_payment_start', 'seq_payment_end', 'seq_payment_current', 'seq_quote_start', 'seq_quote_end', 'seq_quote_current', 'seq_delivery_start', 'seq_delivery_end', 'seq_delivery_current', 'seq_receiptinvoice_start', 'seq_receiptinvoice_end', 'seq_receiptinvoice_current',);

                    foreach ($seq as $s){
                        $agent->$s = 0;
                    }

//                     $agent->name = \Input::post('username');
                     $agent->save();


                     $customer->agent_id = $agent->id;
                     $customer->usercreated = 1;
                     $customer->baseurl = '/quotes/create';

                    $customer->save();
                  }

                 \Response::redirect($this->base);
              }
            
//        }
        
        $this->template->content = \View::forge('users/create',$data);
    }
    
    
    public function action_createNewUser($id = null) {
        
        $data =null;
        
        if(\Input::method() =='POST'){
            
            
               
            $customer = Model_Customers::find($id);

            if (is_object($customer)){

                $this->username = \Input::post('username');
                $this->email =  $this->username.'@haofe.co.il';
                $this->password = \Input::post('password');
                $userid = $this->createUser();

                 $agent = new \Model_Agents;

                 if(is_object($agent)){

                    $agent->connect_uid = $userid;
                    $agent->allow_web = 1;
                    $agent->allow_mobile = 1;

                    $seq = array('seq_order_start', 'seq_order_end', 'seq_order_current', 'seq_payment_start', 'seq_payment_end', 'seq_payment_current', 'seq_quote_start', 'seq_quote_end', 'seq_quote_current', 'seq_delivery_start', 'seq_delivery_end', 'seq_delivery_current', 'seq_receiptinvoice_start', 'seq_receiptinvoice_end', 'seq_receiptinvoice_current',);

                    foreach ($seq as $s){
                        $agent->$s = 0;
                    }

                     $agent->name = \Input::post('username');
                     $agent->save();


                     $customer->agent_id = $agent->id;
                     $customer->usercreated = 1;
                     $customer->baseurl = '/quotes/create';

                    $customer->save();
                  }

                 \Response::redirect($this->base);
              }
            
        }
        
        $this->template->content = \View::forge('users/create',$data);
    }
    
    
    public function action_updateUser($id = null) {
        
        $data = array();
        
        $customer = Model_Customers::find($id);
               
        if (is_object($customer)){
            $agent_id = $customer->agent_id;

            $agent = \Model_Agents::find($agent_id);
            
            if(is_object($agent) && isset($agent->user) && is_object($agent->user)){
                
                $data['username'] = $agent->user->username;
                $data['email'] = $agent->user->email;
                
            }
        }
               
        
        if(\Input::method() =='POST'){
            
            $this->updateUser(); 
            
            \Response::redirect($this->base); 
            
        }
        
        $this->template->content = \View::forge('users/edit',$data);
    }
    
    
     
    public function createUser() {

        $user_id = '';
 
            $model = 'Model_User';
            $username = $this->username;
            $password = $this->password;
            $email = $this->email;
            
          
            
            if(!empty($username) && !empty($password) && !empty($email)){

                $user_id = \Auth::create_user($username,$password,$email);

                if (isset($user_id) && is_numeric($user_id))
                {       //$object->id


                    $ob = $model::find($user_id);

                    if(is_object($ob))
                    {
                        $ob->name = $username; 
                        $ob->clearance = 1;
                        $ob->group = 1;

                        $ob->save();

                        \Session::set_flash('success', 'user created '.$ob->name.'.');
                    }
                    

                }
            } 

        return $user_id;
    }
      
    public function updateUser() {

        $user_id = '';

        if(\Input::method() == 'POST'){

            $model = 'Model_User';

            $updatedata = array(
                            'email'        => \Input::post('email'),  // set a new email address                              

                        );
            
            $password =\Input::post('password');
            if( !empty($password)){

                $this->changePassword(\Input::post('username'),\Input::post('password'));
            }

            \Auth::update_user(
                        $updatedata,
                        \Input::post('username')
                    );

            $user = $model::query()->where('username',\Input::post('username'))->get_one();

            if(is_object($user)) $user_id = $user->id;

        }

        return $user_id;
    }

    public function changePassword($username,$password) {

        $newPassword = \Auth::reset_password($username);

        if(isset($newPassword) && !empty($username))
            $ret = \Auth::change_password($newPassword, $password,$username);

        if(isset($ret) && $ret)  {
            \Session::set_flash('success','Password changed successfully');            
            return true;
        }                        
        else{      

            \Session::set_flash('error','Password not changed');   
            return false;
        }
    }
          
}