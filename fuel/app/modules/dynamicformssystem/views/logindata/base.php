 

namespace <?php if(isset($module)) echo $module ?>;

\Module::load('dynamicformssystem'); 
\Module::load('login');
    
class Controller_Base extends  \login\Controller_Base
{
    public $enableWebLog = 0;
    public $loadbase = "<?php if(isset($module)) echo $module ?>";
    public $loginRedirect = '/<?php if(isset($filepath)) echo $filepath ?>/listindex';
    public $loginArray =<?php if(isset($loginEscapeArray)) 
    
        
        
        
        
 
        
        
        echo html_entity_decode ($loginEscapeArray,ENT_QUOTES); 
     
    ?>;
    public $modulename ="<?php if(isset($module)) echo $module ?>";
    public $select_id = "בחר צבע";
   
    public function agentWebAccess(){
        $name = \Auth::get_user_id(); 
        $agent_now = Model_Agents::query()->where(array(
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
        }
        \Auth::logout();
        \Log::warning('Agent is not allowed on Web Admin!');
        return false;

    }
       
    public function agentMobileAccess(){
        $name = \Auth::get_user_id(); 
        $agent_now = Model_Agents::query()->where(array(
                                                   array("connect_uid","=",$name[1]),
                                                   ))->get_one();
        if(is_object($agent_now)){
            if($agent_now->allow_mobile == 0)
            {
                \Auth::logout();
                \Log::warning('Agent is not allowed on Mobile App!');
                return false;
             }else{

        return true;
            }
        }
                \Auth::logout();
                \Log::warning('Agent is not allowed on Mobile App!');

        return false;
    }
        
   
        
        public function action_login()
	{       
            try {

                if(key_exists('HTTP_USER_AGENT',$_SERVER) && preg_match('/(?i)msie [1-11]/',$_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)
                {
                      echo "<h1>Sorry, Internet Explorer not supported!</h1><hr/>".
                            "<h3>Please use some other browser!</h3>";
                    die();
                }
            } catch (Exception $ex) {
                 \Log::warning('exception thrown :'.$ex->getMessage());
            }           
            
             \Lang::load("he");
             $data = null;
           
             $data["login_error"] = null;
		// Already logged in
		if (\Auth::check()){ 
                     \Response::redirect($this->loginRedirect);
                }
     
		$val = \Validation::forge();

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
				if ((\Auth::check() or $auth->login(\Input::post('email'), \Input::post('password'))) )
				{
                                    $this->setRememberMe();
                                    
					// credentials ok, go right in
//                                        if(!$this->agentWebAccess()){ 
                                        if($this->agentWebAccess() == false){ 
                                          
                                              \Session::set_flash('error', \Lang::get('message.noaccess')?\Lang::get('message.noaccess'):'No Access');

                                            \Response::redirect("{$this->loadbase}/base/logout"); 
                                           
                                            $this->template->set_global('login_error', \Lang::get('message.noaccess')?\Lang::get('message.noaccess'):'No Access');
                                            $data["login_error"] = \Lang::get('message.noaccess')?\Lang::get('message.noaccess'):'No Access';
                                          
                                            $this->template->title = \Lang::get('message.'.'Login')?\Lang::get('message.'.'Login'):'Login';
                                            $data['val']=$val;
                                            $this->template->content = \View::forge('login/login', $data, false);
                                            return;
                                        }
					if (\Config::get('auth.driver', 'Simpleauth') == 'Ormauth')
					{
						$current_user = \Model\Auth_User::find_by_username(\Auth::get_screen_name());
					}
					else
					{
						$current_user = \Model_User::find_by_username(\Auth::get_screen_name());
					}
                                        
                                        $this->redirectToNewUrl();
                                        
					\Session::set_flash('success', e('Welcome, '.$current_user->username));
					\Response::redirect($this->loginRedirect); 
				}
				else
				{
                                  
                                            \Session::set_flash('error', \Lang::get('message.error'));

					$this->template->set_global('login_error', \Lang::get('message.error'));
                                        $data["login_error"] =  \Lang::get('message.error');
                                }
			}
		}
                     
                 
                $flagarray = array('showPasswordResetLink');
                $flags = $this->getFlags($flagarray );
                
                foreach ($flags as $flag=>$value){
                    $data[$flag] = $value;
                } 
                
                $logo_link = $this->getSetting('logo');
		$this->template->logo_link = $logo_link;
		$data['logo_link'] = $logo_link;
		$this->template->title = \Lang::get('message.'.'Login');
                $data['val']=$val;
		$this->template = \View::forge('dynamicformssystem::logindata/login', $data, false);
	}     
               
        public function getSetting($flag = null) {

            $flagval = '';

            $modulename = $this->modulename;
\Module::load('dynamicformssystem');
            $form = \dynamicformssystem\Model_Forms::query()->where('name',$modulename)->get_one();

            if(is_object($form) && isset($form->$flag)){ 

               $flagval = $form->$flag;
            }else{
                if(isset($this->$flag))
                    $flagval = $this->$flag;
            } 

            return $flagval;
        }
        
        
	/**
	 * The logout action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_logout()
	{
            $this->setRememberMe();
            \Auth::logout();
            
            \Response::redirect("/{$this->loadbase}/base/login");
	}
        
}