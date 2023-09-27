<?php

namespace dynamicformssystem;

class Controller_Base extends \Controller_Hybrid{ 
       
    public $interval = 6;
    public $filepath = '';
    public $modulename = '';
    public $pdfpath = '';
    public $from = 'test_dummy@parikrama-tech.in';
    public $subject = 'New Mail';
    public $formtype = 'Simple';
    public $shorten_url = 0;
    public $bity_api_key =  '3f7449c5256c20b01d07fd39083b7dfbba20a056';
    public $xy_pdf =  0;
    public $auto_numbering =  0; 

    public function action_create() {
            
            $redirect = $this->base;
            
           $model = $this->model; 
           
                $form = \Fuel\Core\Fieldset::forge('Autofield', array(
    'form_attributes' => array(
        'id' => 'edit_article_form',
        'name' => 'edit_article',
        'enctype'=>"multipart/form-data"
        )));
                $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
                $flagarray = array('enableIndividualEmail', 'setCentralEmail','enableCentralEmail');

                if(is_object($info)){
                    $info_val = json_decode($info->value, true);
                    foreach ($flagarray as $flag)                   
                        if(key_exists("$flag", $info_val)){
                                $data["$flag"] = $info_val["$flag"]; 
                                $$flag  = $info_val["$flag"]; 
                            }
                }  
                
                $object = new $model();
                $form->add_model($object);
                 
//                $object->GenerateAutoFields($form);
                  
                 $form->add('submit', '',array( 'type' => 'submit', 'value' => 'Submit' ,'class'=>'btn btn-primary'));
		if (\Input::method() == 'POST')
		{                  
                        $val =  $form->validation();
                        $stop = false;
			if((property_exists($this,"error") && $this->error == 1))
                                $stop = true;
			if ($val->run())
			{
                            $values = $this->getFormattedInputValues($val->input());
                            
                            $object->set($values);
                            
				$object = $model::forge($form->validation()->input());
                                
                                
                                foreach ($object as $field => $val){
                                    
                                    if(is_array($val))
                                        $object->$field = implode (',', $val);
                                }
                                
                                $has_many_relations = $object->GetHasMany();
//                                
//                                
                                
              
                                if(is_array($has_many_relations)){
                                    foreach ($has_many_relations as $key=>$relation){
                                        
                                        $line_data  =\Input::post($key);
            
                                        $model = $relation['model_to'];
                                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                                            foreach ( $line_data as $line  ){
//                                            
                                                $objline  = new $model;
                                                $objline->set($line);
                                           
                                                $object->{$key}[] = $objline;
                                            }
                                        }
                                    }
                                }
            
                                $object->flow = 1;
                               
//                                if($this->auto_numbering == 1)
//                                   $object->name = $this->assignNumber();
            
				if ( $stop==false and $object and $object->save())
				{
                                        $this->uploadFiles($object); 
//                                        $emails = \Input::post('email',0);
//                                        if( isset($enableIndividualEmail) && $enableIndividualEmail == 1)
//                                            $this->sendPDFMail($object->id,$emails); 
                                      
                                        if( isset($enableCentralEmail) && $enableCentralEmail == 1 && isset($setCentralEmail) && !empty($setCentralEmail)){
            
       
                                            $this->sendPDFMail($object->id,$setCentralEmail); 
                                        }
                                        
                                        \Session::set_flash('success', \Lang::get("message.done.caradd").$object->id.'.');
            
                                        if(isset($this->shorten_url) && $this->shorten_url == 1){
                                        
                                            
                                            \Response::redirect($redirect."/linktocopyurl/{$object->id}");
                                 
                                        }else
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

            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $html = array();
            $this->template->formdata = $this->getFormData();
            
            $this->template->enableIndividualEmail = isset($enableIndividualEmail)?$enableIndividualEmail:'0';
           
            $name = $this->filepath; 
            $html['base'] = $this->base;
            $html['filepath'] = $this->filepath;
            $html['folder'] = $this->modulename;
              
            $this->template->content =  \View::forge($name.'/create',$html,false);
	}
        
        
        public function action_triggercreate(){
            
          $this->action_index();
          $this->template->triggerform = 1;
            
        }
        
        
        public function getFormData() {
            
           $name = $this->base;
           
           $data = $this->getModule($name);
           $json_data = '';
           
           if(!empty($data)){
               
               $dataarr = json_decode($data,true);
               
               if(is_array($dataarr) && key_exists('json_data', $dataarr)){
                    $json_data = $dataarr['json_data'];
                   
               }               
           }
            
           return $json_data;
        }
        /**
        * 
        * @param type $flagarray
        * @return type
        */
       public function getModule($module = '' ) {
           
           $info = \Model_Systemconfig::query()->where("name",$module)->get_one();

           $return = '';

           if(is_object($info)) {
               
               $return = $info->value;    
           }

           return $return;
       }
    
        
        public function action_edit($id = null)
	{
            $redirect = $this->base;
		is_null($id) and Response::redirect($redirect);
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
                 $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
                $flagarray = array('enableIndividualEmail', 'setCentralEmail','enableCentralEmail');

                if(is_object($info)){
                    $info_val = json_decode($info->value, true);
                    foreach ($flagarray as $flag)                   
                        if(key_exists("$flag", $info_val)){
                                $data["$flag"] = $info_val["$flag"]; 
                                $$flag  = $info_val["$flag"]; 
                            }
                } 

                
                $form->populate($object);
                
                //print_r(array_key_exists('images',$object->relations()));
                //die();
                       $stop = false;
                         if((property_exists($this,"error") && $this->error == 1))
                                $stop = true;
                 $form->add('submit', '',array( 'type' => 'submit', 'value' => \Lang::get('message.save')?\Lang::get('message.save'):'שמור' ,'class'=>'btn btn-primary'));
		if (\Input::method() == 'POST')
		{
                      
                        $val =  $form->validation();
                        
			
			
			if ($val->run())
			{ 
                            $values = $this->getFormattedInputValues($val->input());
                            
                            $object->set($values);
 
                                $object->flow = 2;
				if ($stop==false and $object and $object->save())
				{
                                    $this->uploadFiles($object); 
                                    
//                                    $emails = \Input::post('email',0);
//                                    $this->sendPDFMail($object->id,$emails); 
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
            else {$form->populate($object);}

		 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
		 $this->template->enableIndividualEmail = '0';
           
            $html['order'] = $object;
//            $formdata = $this->getFormData($object);
//            $this->template->formdata = $this->mapObject($formdata, $object);
               $html['base'] = $this->base;
        $html['filepath'] = $this->filepath;
        $html['folder'] = $this->modulename;
            $name = $this->filepath;
            $this->template->content =  \View::forge($name.'/edit',$html,false);
        }

    public function uploadFiles($object = null ) {
        
        if(is_object($object)){ 
            $files = \Input::file();
            
            if(is_array($files))
                foreach ($files as $key => $file){
                    $field = $object->$key;
                    
                    if(strpos($field, ',') != false){
                        $ids = explode(',', $field);
                    }else{
                       $ids = array($field); 
                    }
                    
                    foreach ($ids as $id)
                        $this->updateImage ($id,$object->id);
                }
                 
        }
     
    }
    
    public function updateImage($id = null, $objid = null ) {
       
        if(!is_null($id)){
            $img = \Model_Image::find($id);

            if(is_object($img)){
                $img->model_id = $objid;
                $img->save();
            }
        }
    }
   public function post_createImagex() {
       
       try{ 
             
          if(\Input::file()){
        $config = array(
                    'randomize' => true,
                    'max_size' => 1000000, 
                    );
        \Upload::process($config);
        $key = key(\Upload::get_files());  
        }

        
                \Upload::save(DOCROOT.'Model_Products',$key);


                $files = \Upload::get_files();
                 
                
                    if(key_exists($key, $files)){
                        $image = new \Model_Image();
                    $image->model_to = 'Model_Products';
                        $image->name = $files[$key]['saved_as'];
                       
                        $image->save();
                        
                        $data = array('id' => $image->id, 'name' => $image->name );
                    echo json_encode($data); 
                    } 
                    die();
                    
         }catch(\Exception $ex){
             echo $ex->getMessage();
         }
                    die();
 }

    public function mapObject($formdata = null, $object = null) {
        
        $data = json_decode($formdata, true);
   
        $ret_data = array();
        if(is_array($data)){
            foreach ($data as $key => $d){
                if(key_exists('name',$d)){
                    $name = $d['name'];
                if(isset($object->$name))
                    $d['value'] = $object->$name;
                }
                $ret_data[] = $d;
            }
        }
        
        return json_encode($ret_data);
    }

    public function action_view($id = null) {

        $model= $this->model;

        is_null($id) and \Response::redirect($this->base);

        if ( ! $data['order'] = $model::find($id)) {
            
            \Session::set_flash('error', 'Could not find car #'.$id);
            \Response::redirect($this->base);
        }

        $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
        $data['model'] = $this->base;
        $data['base'] = $this->base;    
        $name = $this->filepath;
        $this->template->content = \View::forge($name.'/view', $data);

    }

    public function getFormattedInputValues($inputs = array()) {
        
        $temp = array();
        if(is_array($inputs)){
            foreach ($inputs as $key => $input){
                if(is_array($input)){
                    $input = implode(',',$input);
                }

                $temp[$key] = $input;
            }
        }
        
        return $temp;
	
    }

    public function get_pdfArray() {
        
        $this->format="text";
        $this->response->set_header('Content-Type', 'text');
        $this->format="text";
        $string = \View::forge($this->pdfpath.'/pdfview', $html = null);
        return  $this->response($string);
    }
    
    public function action_exportDocumentToPdf($id = null) {
            
        $model= $this->model;
//
        is_null($id) and \Response::redirect($this->base);
        
        try{
            if ( ! $data['order'] = $model::find($id)) {
                
                
                print_r($data['order']);
                die();
                \Session::set_flash('error', 'Could not find car #'.$id);
                \Response::redirect($this->base);
            }
                     
            \Package::load('attachment');
            $infox['view'] = $this->pdfpath.'/pdfview';
            $infox['filename'] = $this->filepath;
            $infox['option'] = 'I';
            $infox['isRTL']=true;
            
            \Config::load($this->modulename.'::pdfview', true);
            $filedata = \Config::get($this->modulename.'::pdfview.defaults');
           
            if($this->xy_pdf == 1){
                
                $obj = new $model;
                $properties = $obj->GetProps();
                $properties = array_merge($properties,$filedata);
            
                $data['properties'] = $properties;
                \Attachment::indexXY($data,$infox,true);
            }else{
                
                \Attachment::index($data,$infox,true);
            }
            
            die();
            
        }catch(\Exception $ex){
            
            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
            \Response::redirect($this->base);
        }
            
    }
    
    
    public function action_sendMail($id = null) {
        
        $this->sendPDFMail($id);
        
        \Response::redirect($this->base);
    }
    
    
    public function sendPDFMail($id = null,$emails =  '') {
        
        
        $model= $this->model;

        is_null($id) and \Response::redirect($this->base);
            
        if(empty($emails))            return;
        
        if(strpos($emails, ',') != false) $emails = explode (',', $emails);
        else $emails =  array($emails);
        
        if ( ! $data['order'] = $model::find($id)) {

           \Session::set_flash('error', 'Could not find car #'.$id);
           \Response::redirect($this->base);
       }
       
            

       \Package::load('attachment');
       $info['view'] = $this->pdfpath.'/pdfview';
       $info['filename'] = $this->filepath;
       $info['option'] = 'S';
       $info['isRTL']=true;
            
        if(is_array($emails) && count($emails) > 0){
            foreach ($emails as $email){
                
                try {

                    $mail = \Email::forge();
                      \Log::warning("Email TO :" .$email); 
                    $mail->to($email);
                    $mail->from($this->from);


                    $mail->subject($this->subject);

                    $mail->string_attach((\Attachment::index($data,$info)), 'file.pdf');
                    $mail->send();
                    $msg="Email Sent Successfully";
                    \Session::set_flash('success', $msg);
                    
                    $status = 1;

                }
                catch(\Exception $e) {

                        $msg =$e->getMessage();
                        $status = 0;
                }
                \Log::warning("Email Status :" .$msg);             
            }
        }
    }
      

    public function action_index() {
        
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
        else $per_page = 20;
        $config = array(
           'pagination_url' => "$uri",
           'per_page'       => $per_page,
           'uri_segment'    => 'page',
        );
        $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
                $flagarray = array('enableIndividualEmail', 'setCentralEmail','enableCentralEmail');

                if(is_object($info)){
                    $info_val = json_decode($info->value, true);
                    foreach ($flagarray as $flag)                   
                        if(key_exists("$flag", $info_val)){
                                $data["$flag"] = $info_val["$flag"]; 
                                $$flag  = $info_val["$flag"]; 
                            }
                }  

//            $query->related('order');
//            $query->where('order.id','1');
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
        $data['filepath'] = $this->filepath;
        $data['folder'] = $this->modulename;
         $this->template->enableIndividualEmail = isset($enableIndividualEmail)?$enableIndividualEmail:'0';
            
        $formview =  $this->getCreateForm();
        $this->template->content = \View::forge($formview, $data);

    }    
    
    public function before()
    {   
        parent::before();
	 \Log::warning(time().' '.json_encode(\Input::post()));
        $lang = \Input::get('language','he');
        \Lang::load($lang);
        if(property_exists($this, 'model'))
        {
            $model = $this->model;
            $this->query = $model::query();
        }
    }
        public function get_viewx($id = null){
               // $id = is_null($id) or \Input::get('id');
                $model= $this->model;
                //if(!is_numeric($id)) $id=null;
                
                
                is_null($id) and Response::redirect($this->base);
                
                $rel_get = \Input::get('relation_get');
            
                
		if ( !$data['car'] = $model::find($id))
		{
                        
                    $error = array("error"=>"Cound not find $id");
                    $error = json_encode($error);
                    echo $error;
                    die();
		}
                $this->query->where('id',"=",$id);
                $car = $this->query->get_one();
                
                $listview = $car->GetViewRelations(); 
                $data['car'] = $this->query->get_one_array();
                
                foreach($listview as $column => $properties) {
                        
                        if(key_exists('relation', $properties)){
                            $rel_mod = $properties['relation'];

                            if(is_object($car->$rel_mod) &&
                                    empty($rel_get) && isset($car->$rel_mod->name))
                            $data['car'][$column] = $car->$rel_mod->name;
                             else{  $related = $car->$rel_mod;
                                    if(is_object($related) && property_exists($related, "alternates") 
                                            && is_array($related::$alternates)&& 
                                            key_exists("name", $related::$alternates))
                                    {
                                        $fetch = $related::$alternates["name"];
                                        $data['car'][$column] = $related->$fetch;   
                                    }
                                }
                            if(array_key_exists('image', $properties)){
                                if(is_object($car->$rel_mod))
                                   $data['car'][$column]= "<img src=/{$car->$rel_mod->model_to}/{$car->$column} class='img-polaroid' style='width:116px;height: 100px;'>";
                            }
                            }
                 }
                
                 $data['model'] = $this->base;
                 $data['base'] = $this->base;     
                 echo json_encode($data);
                 die();
        }
        
   
        public function post_listx(){
            $this->get_listx();
        }
        
    public function get_listx()
	{
        \Log::warning('entered customers llistx');
        
            $query = $this->query;
        
            $data['mode_select'] = $query->get_one();
            $props = array();
            
            if(is_object($data['mode_select']))
            $props = $data['mode_select']->properties();
            $filter = \Input::get('filter');
            $text_filter = \Input::get('text_filter');
            $uri = "/{$this->base}/index/?";
            if(is_array($filter))
                foreach($filter as $where => $value)
                    if($value != 0 && !empty($value))
                    {
                        $query->where($where, $value);
                        $uri .="&filter[$where]=$value";
                    }   
                    
             if(is_array($text_filter))
                foreach($text_filter as $where => $value)
                    if(isset($value) && !empty($value) && array_key_exists( $where,$props))
                    {
                        
                        $query->where($where,'like', "%$value%");
                        $uri .="&text_filter[$where]=$value";
                        
                    }

                    $per_page = \Input::get('per_page');
                    if(!empty($per_page) && intval($per_page)  != 0 )
                    {
                        $per_page = intval($per_page);
                    }
                    else $per_page = 5;
            $config = array(
               'pagination_url' => "$uri",
               'per_page'       => $per_page,
               'uri_segment'    => 'page',
            );
            
            $model = $this->model;
            $order_by =\Input::get('order_by');
            if(isset($order_by) && is_numeric($order_by) && $order_by > 1)
                $query->order_by('id','ASC');
            else 
                $query->order_by('id','DESC');
            
            $pagination = \Pagination::forge('mypagination', $config);
            $data['paginate'] = $pagination;
            $data['alternate']= property_exists($model, 'alternates')? $model::$alternates: null;
            $data['model'] = \Lang::get("menu.".strtolower($this->base) )?\Lang::get("menu.".strtolower($this->base)):$this->base;
            $pagination->total_items = $query->count();
            $data['cars']= $query->rows_limit($pagination->per_page)->rows_offset($pagination->offset);
            $data['cars'] = $query->get_array();    
            
           $rel_get = \Input::get('relation_get');
            if(!empty($rel_get) && intval($rel_get)  == 1  )
           foreach($data['mode_select']->GetHasOne() as $relation => $keys){
               foreach($data['cars'] as $key => $items)
               {
                      $model_to = $keys['model_to'];
                      $query_to = $model_to::query();
                      $query_to->where($keys['key_to'],$data['cars'][$key][$keys['key_from']]);
                      $dataarray = $query_to->get_array();
                      if(is_array($dataarray) && array_key_exists(0,$dataarray) &&
                                    is_array($dataarray[0]) && !empty($dataarray[0]))
                        $data['cars'][$key][$keys['key_from']] = $dataarray[0]['name'];
                      //print_r($dataarray);
               }
            }
            $data['page']= $pagination->current_page;
            $data['total_items']=$pagination->total_items;
            $data['pages']=\Pagination::instance('mypagination')->total_pages;
            $echos = json_encode($data);
            
            echo  $echos;
            die();
	}
        
        public  function get_translation(){

            $translation = \Lang::get('label.'.$this->base)?\Lang::get('label.'.$this->base):false;            
            echo json_encode($translation);
            die();
        }

    public function getCreateForm() {
        
        switch ($this->formtype){        
            case '1' : $view = 'dynamicformssystem::base/index';
                            break;
            case '2' : $view = 'dynamicformssystem::base/indexpopup'; //popup
                            break;        
            default : $view = 'dynamicformssystem::base/index';
                            break;
        }
        
        return $view;
    }
            

    public function get_sinatureJS() {
        
        $this->format="jsonp";
        $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
        $this->format="jsonpx";
        $string = \View::forge('dynamicformssystem::js/signaturejs', $html = null);
        return  $this->response($string);
    }
    function get_formbuilderjs(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/formbuilder', $html = null);
            return  $this->response($string);
    }        
    function get_formbuildersystemjs(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/formbuildersystem', $html = null);
            return  $this->response($string);
    }        
    function get_formbuildercss(){
    
            $this->format="css";
            $this->response->set_header('Content-Type', 'css');
            
            $string = \View::forge('dynamicformssystem::css/formcss', $html = null);
            return  $this->response($string);
    }        
    
    public function action_linktocopyurl($id) {

        $url = \Uri::base(false)."{$this->base}/viewandsign/{$id}";


        $newurl = $this->storeLink($id, $url);

        $data['newurl'] = $newurl;

        $flow= 0;

        if(empty($newurl)) $flow = 1;

        $data['flow'] = $flow;

        $data['id'] = $id;

        $data['base'] = $this->base;   
         $this->template->content =  \View::forge('dynamicformssystem::cars/url',$data); 

    }

    public function action_tryagain($id) {

        $url = \Uri::base(false)."{$this->base}/viewandsign/{$id}";


        $newurl = $this->storeLink($id, $url);

        $data['newurl'] = $newurl;

        $flow= 0;


        $data['flow'] = $flow;

        $data['id'] = $id; 
        $data['base'] = $this->base;   
        $this->template->content =  \View::forge('dynamicformssystem::cars/url',$data); 
    }
    
 
        
    public function action_viewandsign($id = null) { 
            
            $model= $this->model;

             $object=$model::find($id);
            
            
            is_null($id) and \Response::redirect($this->base);

            if ( !is_object($object) || $object->flow == 2) {
                \Session::set_flash('error', 'Could not find car #'.$id);
                \Response::redirect("https://www.google.com");
            }
            
             $form = \Fuel\Core\Fieldset::forge('Autofield', array(
                    'form_attributes' => array(
                        'id' => 'edit_article_form',
                        'name' => 'edit_article',
                        'enctype'=>"multipart/form-data"
                        )));
 
          
         
            $form->add_model($object);
     
         $form->populate($object);
        

        $object->GenerateAutoFields($form);
            if(\Input::method() == 'POST'){
                
             
               
             
                $post_data = \Input::post();
                
            
                $created_at = $object->created_at;
                
            
                if(is_array($post_data) && count($post_data) > 0){
                    
                    foreach ($post_data as $key=>$fielddata){
                        $object->$key = $fielddata;
                    }
                }
                   $object->created_at = $created_at;
                     $object->flow = 2; 
                     
                    if($object->save()){
                        
//                        $this->action_sendFormMail($object->id);
                        \Session::set_flash('success', 'הטופס נשלח בהצלחה');
                        
                        \Response::redirect($this->base."/viewmessage/{$object->id}");
                        \Response::redirect("https://www.google.com");
                    }                              
                                
            }

             
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = $this->base;
            $data['base'] = $this->base;   
            $name = $this->filepath;
            
                
                
            $data['order']=$object;
              
             $this->template->content = \View::forge($name.'/edit', $data);             
    }  


    public function action_viewmessage($id = null) {

        $this->template->redirectInFive = 1;

         $this->template->content =  \View::forge('dynamicformssystem::cars/message',null,false); 

    }

    public function storeLink($id, $url) {


        $obj = \dynamicformssystem\Model_Taxformurls::query()
                ->where('form_id',$id)
                ->where('url',$url)
                ->get_one();

        if(!is_object($obj)){
            $obj = new \dynamicformssystem\Model_Taxformurls();
            $obj->form_id =$id;
            $obj->url =$url;
        }

        $newurl = $this->generateBitlyURL($url);

        $obj->bitlyurl =$newurl;

        $obj->save();


        return $obj->bitlyurl;
    }
        
    public function generateBitlyURL($url) {
            
            \Package::load('Bitlyurl');  
            $databit = array();
            
            $databit['url'] = $url;
            
            $databit['user_access_token'] = $this->bity_api_key;

            $return =  \Bitlyurl::index($databit);
             
          
            $newURL = '';
            
            if(!empty($return) && is_array($return) && key_exists('url', $return)) {
                $newURL = $return['url']; 
            }else{
               
                $databit = array();
                $databit['url'] = $url;
                $databit['user_access_token'] = $this->bity_api_key;
                $return =  \Bitlyurl::index($databit);
 
                
                if(!empty($return) && is_array($return) && key_exists('url', $return)) {
                    $newURL = $return['url']; 
                }else{
              
                    \Session::set_flash('error', "Failed!");
                    \Session::set_flash('success', "");
                }
               
                \Log::error('Bitly URL not generated '.json_encode($return));
               
            }
            
            
            return $newURL;
    }
            
    public function get_clipboardJS() {
        
        $this->format="jsonp";
        $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
        $this->format="jsonpx";
        $string = \View::forge('dynamicformssystem::js/clipboard', $html = null);
        return  $this->response($string);
    }
    
    
    
    function action_setSettings(){
            
            $process = 0;

            $process = \Input::post("submitdata",'0');

            $settinglist = array( 
                                    array('id'=>1,'type'=>'textbox','name'=>'bity_api_key','visible'=>1,'group_id'=>1),
//                                    array('id'=>2,'type'=>'text','name'=>'pdf_creator','visible'=>1,'group_id'=>1),
                                    array('id'=>3,'type'=>'checkbox','name'=>'send_pdfmail','visible'=>1,'group_id'=>1),
//                                    array('id'=>4,'name'=>'pdf_mode','visible'=>1,'group_id'=>1),
                                    array('id'=>5,'type'=>'textbox','name'=>'pdf_report_name','visible'=>1,'group_id'=>1), 
//                                    array('id'=>6,'type'=>'textbox','name'=>'emailTo','visible'=>1,'group_id'=>1), 
//                                    array('id'=>7,'type'=>'textbox','name'=>'emailBcc','visible'=>1,'group_id'=>1), 
//                                    array('id'=>8,'type'=>'textbox','name'=>'senderName','visible'=>1,'group_id'=>1), 
                                    array('id'=>9,'type'=>'checkbox','name'=>'enableEmail','visible'=>1,'group_id'=>1), 
                                );
            
            if(\Input::method() == 'POST' ){
            
                $postdata = array();
            
                foreach ($settinglist as $list){
                    $postdata[$list['name']] = \Input::post($list['name']);
                }
                
                $data = Model_Forms::query();

                $data->where("name",$this->modulename);
                $sysobj = null;
                if($data->count()>0)
                    $sysobj = $data->get_one();

                 if(is_object($sysobj)){ 
                    $datap = json_encode($postdata);
                     $sysobj->systemsconfig = $datap;
                     $sysobj->save();
                 } 
            }

            $data = Model_Forms::query();

            $data->where("name",$this->modulename);
            $info = null;
            if($data->count()>0)
                $info = $data->get_one();
            $inforay = array();

            if(is_object($info)){
                //Show info
                $inforay = json_decode($info->systemsconfig,true);
            }

            $datax = array();

            $datax['formray']=$settinglist;
            $datax['inforay']=$inforay;
            $this->template->content = \View::forge('dynamicformssystem::systems/enablemodule', $datax); 
    }
    
    
    public function action_labelers() {

            $redirect = $this->base;
            
           $model = $this->model; 
           
                $form = \Fuel\Core\Fieldset::forge('Autofield', array(
    'form_attributes' => array(
        'id' => 'edit_article_form',
        'name' => 'edit_article',
        'enctype'=>"multipart/form-data"
        )));
                $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
                $flagarray = array('enableIndividualEmail', 'setCentralEmail','enableCentralEmail');
            

            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $html = array();
            $this->template->formdata = $this->getFormData();
            
            $name = $this->filepath; 
            $html['base'] = $this->base;
            $html['filepath'] = $this->filepath;
            $html['folder'] = $this->modulename;
              
            $this->template->content =  \View::forge($name.'/pdflabeler',$html,false);
	}

}

    
