 
use Orm\Model;

namespace <?php if(isset($module)) echo $module ?>;

class Controller_Agents extends \Controller_Base{

	public $title = "Agents";    
	public $model = "\\<?php if(isset($module)) echo $module ?>\Model_Agents";
	public $base = "<?php if(isset($module)) echo $module ?>\agents";
	public $modulename = "<?php if(isset($module)) echo $module ?>";
        
            public function before() {
            
            \Module::load('dynamicformssystem');
            $this->template =\View::forge('dynamicformssystem::agents/template',null,false);
            
            parent::before();
        }
        
        public function action_create() {
             
               
            $redirect = $this->base;
            
            $model = $this->model;
            $query = $this->query;
            
            $form = \Fuel\Core\Fieldset::forge('Autofield', array(
    'form_attributes' => array(
        'id' => 'edit_article_form',
        'name' => 'edit_article',
        'enctype'=>"multipart/form-data"
        )));
                $object = new $model();
                $form->add_model($object);
                 
                $object->GenerateAutoFields($form);
                  
                 $form->add('submit', '',array( 'type' => 'submit', 'value' => 'Submit' ,'class'=>'btn btn-primary'));
        
            if (\Input::method() == 'POST')
		{
                        $val =  $form->validation();
                        $stop = false;
			if((property_exists($this,"error") && $this->error == 1))
                                $stop = true;
			if ($val->run())
			{
                            
                            $user_id = $this->createUser();
                            
				$object = $model::forge($form->validation()->input());
                                
                                $object->connect_uid = $user_id;
                                
                                $formsallowed = \Input::post('formsallowed');
                                
                                $object->formsallowed = json_encode($formsallowed);
                                  
				if ( $stop==false and $object and $object->save())
				{
					\Session::set_flash('success', \Lang::get("message.done.caradd").$object->id.'.');

					\Response::redirect($redirect);
				}

				else
				{
                                    if($stop)
                                        \Session::set_flash('error', \Lang::get("message.failed.connect_uid"));
                                    else
					\Session::set_flash('error', \Lang::get("message.failed.caradd"));
                                        
				}
			}
			else
			{
				\Session::set_flash('error', $val->error());
			}
		}
                 $html['formsallowed']=  $this->getFormsList();

                $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
		  
                $this->template->content =  \View::forge('dynamicformssystem::agents/create',null,$html);
              
        }
        
        
        public function action_view($id = null)
	{
                    $model= $this->model;
                    
		is_null($id) and \Response::redirect($this->base);

		if ( ! $data['car'] = $model::find($id))
		{
			\Session::set_flash('error', 'Could not find car #'.$id);
			\Response::redirect($this->base);
		}

		 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
                 $data['model'] = $this->base;
                 $data['base'] = $this->base;    
                 
                  $this->template->content =  \View::forge('dynamicformssystem::agents/view',$data);

	}
        
        public function action_index()
	{ 
            $query = $this->query;
            $data['mode_select'] = $query->get_one();
            $filter = \Input::get('filter');
            $uri = "/{$this->base}/index/?";
            if(is_array($filter))
                foreach($filter as $where => $value)
                    if($value != 0 && !empty($value))
                    {
                        $query->where($where, $value);
                        $uri .="&filter[$where]=$value";
                    }   
    $per_page = \Input::get('per_page');
                    if(!empty($per_page) && intval($per_page)  != 0 )
                    {
                        $per_page = intval($per_page);
                    }
                    else $per_page = 20; //$per_page = 5;
            $config = array(
               'pagination_url' => "$uri",
               'per_page'       => $per_page,
               'uri_segment'    => 'page',
            );
            
            
            // Create a pagination instance named 'mypagination'
            $pagination = \Pagination::forge('mypagination', $config);
            $data['paginate'] = $pagination;
            $pagination->total_items = $query->count() ;
            $data['cars']= $query->rows_limit($pagination->per_page)->rows_offset($pagination->offset);
            $data['page'] = 'mypagination';
            $data['filter'] = $filter;
            $data['cars'] = $query->get();
            
    
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['base'] = $this->base;
           // $this->template->content = \View::forge('cars/userindex', $data);
            $this->template->content =  \View::forge('dynamicformssystem::agents/userindex',$data);

	}
        public function action_edit($id=null) {
            
            $model = $this->model;
            
            $redirect = $this->base;
		is_null($id) and \Response::redirect($redirect);
                  $model = $this->model;
        
           
                 $form = \Fuel\Core\Fieldset::forge('Autofield', array(
                                'form_attributes' => array(
                                    'id' => 'edit_article_form',
                                    'name' => 'edit_article',
                                    'enctype'=>"multipart/form-data"
                                    )));
                $object = new $model();
                $form->add_model($object);
                
                $object->GenerateAutoFields($form);
                
                if ( ! $object = $model::find($id))
		{
			\Session::set_flash('error', 'Could not find car #'.$id);
			\Response::redirect('cars');
		}
                

                
                $form->populate($object);
                $fields = $form->field();

                foreach($fields as $field){
                    if('select' === $field->type)
                    { 
                        $rel = $model::ReturnRelation($field->name);
                        
                        if(empty($rel) or !$rel or !isset($rel) or !is_string($rel))
                            continue;
                        
                        if(is_object($object->$rel)){
                        $arr = array( $object->$rel->id => 
                                            $object->$rel->name);
                        $field->set_options($arr);
                        }
                    }
                }
                
                       $stop = false;
                         if((property_exists($this,"error") && $this->error == 1))
                                $stop = true;
                 $form->add('submit', '',array( 'type' => 'submit', 'value' => 'שמור' ,'class'=>'btn btn-primary'));
		if (\Input::method() == 'POST')
		{
                      
                        $val =  $form->validation();
                        
			
			
			if ($val->run())
			{
                                $user_id = $this->updateUser();
	
                                $object->set($val->input());
                                 $object->connect_uid = $user_id;
                                
                                $formsallowed = \Input::post('formsallowed');
                                
                                $object->formsallowed = json_encode($formsallowed);
                                 
				if ($stop==false and $object and $object->save())
				{
					\Session::set_flash('success', \Lang::get("edit complete for this").$object->id.'.');

					\Response::redirect($redirect);
				}

				else
				{
                                    if($stop)
                                        \Session::set_flash('error', \Lang::get("message.failed.connect_uid"));
                                    else
					\Session::set_flash('error', \Lang::get("message.failed.caradd"));
				}
			}
			else
			{
				\Session::set_flash('error', $val->error());
			}
		}
           
                
		$this->template=\View::forge('dynamicformssystem::agents/template',null,false);
                $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
	 
                 $html['car']=  $object;
                 $html['formsallowed']=  $this->getFormsList();
              
                $this->template->content =  \View::forge('dynamicformssystem::agents/create',$html,false);
              
                
        }

        public function getFormsList(){
            
            $menulist = array();
            
            $module = $this->modulename;
        
            $menu = \dynamicformssystem\Model_Menu::query()->where('modulename', $module)->get_one();

            if(is_object($menu)){

                $menulist = \dynamicformssystem\Model_Menu::query()->where('module_linked_to', $menu->module_linked_to)->get_array();
            }
            
            return $menulist;
        }
         

         
        public function createUser() {
            
            $user_id = '';
            
            if(\Input::method() == 'POST'){
                
                $model = 'Model_User';
                
                if(\Input::post('password') === \Input::post('repeat_password')){
                    
                    $user_id = \Auth::create_user(\Input::post('username'),\Input::post('password'),\Input::post('email'));
                
                    if (isset($user_id) && is_numeric($user_id))
                    {       //$object->id
                            

                        $ob = $model::find($user_id);

                        if(is_object($ob))
                        {
                            $ob->name = \Input::post('name'); 
                            $ob->clearance = \Input::post('clearance');

                            $ob->save();

                            \Session::set_flash('success', 'user created '.$ob->name.'.');
                        }

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
                if(\Input::post('password') !='****' && \Input::post('password') === \Input::post('repeat_password')){
                   
                    $this->changePassword(\Input::post('username'),\Input::post('password'));
                }
                
                \Auth::update_user(
                            $updatedata,
                            \Input::post('username')
                        );
              
                $user = $model::query()->where('username',\Input::post('username'))->get_one();
              
                if(is_object($user)) $user_id = $user->id;
 
                if (isset($user_id) && is_numeric($user_id))
                {       //$object->id


                    $ob = $model::find($user_id);

                    if(is_object($ob))
                    {
                        $ob->name = \Input::post('name'); 
                        $ob->clearance = \Input::post('clearance');

                        $ob->save();

                        \Session::set_flash('success', 'user created '.$ob->name.'.');
                    }

                } 
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