<?php


namespace dynamicformssystem;
class Controller_Basesystemlogin extends Controller_Basesystem{ 


    public function before1()
    {   
        
        $lang = \Input::get('language','he');
        parent::before();

        $messages = $this->loginArray;

        if (($key = array_search("listindex", $messages)) !== false) 
            unset($messages[$key]);

        if (($key = array_search("listIndex", $messages)) !== false) 
            unset($messages[$key]);
                
        $request_obj = \Request::active();
        if ($request_obj->controller !== get_class($this) or !in_array($request_obj->action, $messages))
        {
        
                    
                        $num = array();
            $val = \Validation::instance();

            if(!$val){
                
            $val = \Validation::forge();
            }
            
            
            
            if (\Input::method() == 'POST')
        {
            $val->add('email', \Lang::get('Email or Username'))
                ->add_rule('required');
            $val->add('password', \Lang::get('Password'))
                ->add_rule('required');

            if ($val->run())
            {
                \Validation::instance(false);
                $auth = \Auth::instance();
                                
                                
                // check the credentials. This assumes that you have the previous table created
                if ((\Auth::check() or $auth->login(\Input::post('email'), Input::post('password'))) && $this->agentMobileAccess())
                {
                   

                                    //       die();
                    // credentials ok, go right in
                    if (\Config::get('auth.driver', 'Simpleauth') == 'Ormauth')
                    {
                        $current_user = \Model\Auth_User::find_by_username(Auth::get_screen_name());
                    }
                    else
                    {
                        $current_user =\Model_User::find_by_username(Auth::get_screen_name());
                    }
                                        $num['msg'] = "Welcome logon now";
                }
                else
                {
                                    $num['msg'] = "Wrong password";
                                    \Response::redirect("\base\login");    
                }
            }
        }
        if(!\Auth::check() && !in_array($request_obj->action, $messages)){
            \Response::redirect("{$this->loadbase}\base\login");    

        }     
            
    }
        

    }
}
