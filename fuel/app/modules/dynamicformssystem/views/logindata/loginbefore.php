
            
    public function before()
    {   
        
        

        $lang = \Input::get('language','he');
        parent::before();

        \Log::warning(time().' '.json_encode(\Input::post()));
        \Log::warning("URL post Data  : ".json_encode(\Input::post()));
        \Log::warning("URL get Data  : ". json_encode(\Input::get()));
        \Lang::load($lang);
        $primary_key_holder = print_r(\Input::put(),true);
         \Log::warning("primary key holder $primary_key_holder");
         
        if(isset($this->enableAuthentication) && $this->enableAuthentication == 0 ){
        
            return true; 
        }
              
                $request_obj = \Request::active();
             
                $controllerObj = strtolower($request_obj->controller);
                $classObj = strtolower(get_class($this));
               
		if ($controllerObj !== $classObj or !in_array($request_obj->action, $this->loginArray))
		{ 
                  
                   
                 
                     $num = array();
                     $val = \Validation::instance();

            if(!$val){
                
            $val = \Validation::forge();
            }
            
             $this->agentWebAccess();
           if (\Input::method() == 'POST')
		{
			$val->add('email', \Lang::get('Email or Username'))
			    ->add_rule('required');
			$val->add('password', \Lang::get('Password'))
			    ->add_rule('required');

                        
                    
			if ($val->run())
			{
				$auth = \Auth::instance();
                                
                               
				// check the credentials. This assumes that you have the previous table created
				if ((\Auth::check() or $auth->login(\Input::post('email'), \Input::post('password'))))
				{
                          
					// credentials ok, go right in
					if (\Config::get('auth.driver', 'Simpleauth') == 'Ormauth')
					{
						$current_user = \Model\Auth_User::find_by_username(\Auth::get_screen_name());
                                                  
					}
					else
					{
						$current_user = \Model_User::find_by_username(\Auth::get_screen_name());
					}
					#Session::set_flash('success', e('Welcome, '.$current_user->username));
					\Response::redirect($this->loginRedirect);
                                        $num['msg'] = "Welcome logon now";
				}
				else
				{
                                  $num['msg'] = "Wrong password";
					
				}
			}
		}
               
                                
                    
               $test = \Auth::check(); 
		}

            if(property_exists($this, 'model'))
            {
                $model = $this->model;
                $this->query = $model::query();
            }
         
	}
          
    public function agentWebAccess(){
        $name = \Auth::get_user_id();
        $loadbase = $this->loadbase; 
        $model = '\\'.$loadbase.'\Model_Agents';
        if(class_exists($model)){
            $agent_now = $model::query()->where(array(
                                                       array("connect_uid","=",$name[1]),
                                                       ))->get_one();

            if(is_object($agent_now)){ 


                if($agent_now->allow_web == 0)
                {
                    \Auth::logout();
                    \Log::warning('Agent is not allowed on Web Admin!');
                    return false;
                }else{

                    return true;
                }
            }else{

    //        \Auth::logout();
            \Log::warning('Agent  not available on Web Admin!');    
            \Response::redirect("{$this->loadbase}/base/logout");
            return false;
            }
        }
    }
     
     
    
 /*   public function action_index() {
        
        die();
    }  
  */          
            
            