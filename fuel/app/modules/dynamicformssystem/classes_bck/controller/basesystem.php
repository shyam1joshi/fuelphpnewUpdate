<?php


namespace dynamicformssystem;
class Controller_Basesystem extends \Controller_Hybrid{ 
       
    public $interval = 6;
    
    public $filepath = '';
    public $uploadFolder = "Model_Products";
    
    public $modulename = '';
    
    public $pdfpath = '';
    
    public $formtype = 'Simple';
    
    public $shorten_url = 0;
    
    public $bity_api_key =  '3f7449c5256c20b01d07fd39083b7dfbba20a056';
    
    public $xy_pdf =  0;
    
    public $from = 'test_dummy@parikrama-tech.in';
    
    public $subject = 'New Mail';
    public $body = '';
    
    public $email = '';
    
    public $bccEmail = '';
    
    public $ccEmail = ''; 
    
    public $fileName = ''; 
    
    public $pdfString = ''; 
    
    public $flowSystem = 0;  // 1 yes 0 no
    
    public $flowType = 1;   //1 or 2
    
    public $send_pdfmail =  0;
    
    public $pdf_creator =  0;
    
    public $pdf_mode =  0;
    
    public $logo =  0;
    
    public $currentsequence =  1;
    
    public $auto_numbering =  0;
    
    public $removesalessoftbar =  0;
    
    public $show_last_draft =  0;
    
    public $enableAuthentication =  0;
    
    public $websiteMethods =  array( 'editRecord','jsonWebFormOrderComplete',
                                    'exportWebDocumentToPdf','showWebDocumentToPdf');
    public $websiteJsonMethods =  array( 'jsonWebFormOrderComplete');
    
    public $loginBaseArray = array("jsonFormOrderComplete",'createAndLoadPDF','showDocumentToPdf',
                                        "loadSampleDocumentToPdf",'createRecord','emptyRedirect',
//                                    'editRecord','exportWebDocumentToPdf','showWebDocumentToPdf', 
                                    'postProcessViewAndSign','showhidejs','mathjs','autosave', 'jsonsearchFields', 'viewandsign','linktocopyurl','tryagain',
                                       'jsonWebFormOrderComplete',"postProcessRecord",'setExportCSVFields'
                                    );
    public $uniqueKey = '';
    
   // public $maxFileSize = 1000000;
    
    public $maxFileSize = 13000000;
     
    public $curlOutput = array();
    public $disablerequirednextfield = 0;
    public $object = '';

    public  function before() {
                
        parent::before();
        
        if(isset($this->loginArray) && is_array($this->loginArray))
            $this->loginArray = array_merge($this->loginArray, $this->loginBaseArray);
        
        
        $this->validateModule();
        
        $lang = \Input::get('language','he');
        \Lang::load($lang);
        if(property_exists($this, 'model')) {
            $model = $this->model;
            $this->query = $model::query();
        }
        
        $flagArray = array ( 'enableAuthentication' , 'bity_api_key', 'pdf_mode', 'send_pdfmail',
                             'pdf_creator', 'logo', 'backgroundimage', 'color_scheme', 'logo_height',
                             'logo_width','logo_portrait_mode', 'logo_position', 'whatsapp_image', 'whatsapp_title',
                             'whatsapp_description', 'login_escape_functions', 'enableAuthentication','pdf_mode_flow2',
                             'enableExpire','expiryDate' ,'expiryMessage','formCreatedDate','showMessageBeforePDFflow2' ); 
        
        foreach($flagArray as $flag){
            $this->$flag = $this->getSettingValue($flag);
        }
                
        if(!empty($this->whatsapp_image)){
            $img = \Model_Image::find($this->whatsapp_image);
            
            if(is_object($img)){
                $this->whatsapp_image = \Uri::base(false).'Model_Products/'.$img->name;
            }
        }
        
        if(!empty($this->logo)){
            $img = \Model_Image::find($this->logo);
            
            if(is_object($img)){
                $this->logo = \Uri::base(false).'Model_Products/'.$img->name;
            }
        }else{
            $form = Model_Forms::query()->where('name',$this->modulename)->get_one();

                if(is_object($form) && isset($form->logo)  && !empty($form->logo)){
                    $this->logo = $form->logo;
                }
        }
        
        $this->setEscapeFunctions();
        
        $this->checkFormExpiry();
        
        $this->validateKeyAuthentication(); 
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
                
         $fromdate = \Input::get('created_from');
         $todate = \Input::get('created_to');
         if($fromdate != null){
            $fromdate = str_replace('/', '-', $fromdate);
            $fromdate = date ("Y-m-d",strtotime(date($fromdate)));     
        }
        if($todate != null){
            $todate = str_replace('/', '-', $todate);
            $todate = date ("Y-m-d",strtotime(date($todate))+3600*24);
        }
       
        if($fromdate !=null && $fromdate===$todate)
               $todate = date ("Y-m-d",strtotime(date($fromdate))+3600*24);
        
         if($fromdate!=null){
            $query->where("created_at",">",date ("Y-m-d H:i:s", strtotime(date($fromdate))));
            $uri .="&fromdate=$fromdate";
        }
        if($todate !=null){
            $query->where("created_at","<",date ("Y-m-d H:i:s", strtotime(date($todate))));
           $uri .="&todate=$todate";
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
        
        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
        $this->template->color_scheme = $this->color_scheme;
        $this->template->logo_width = $this->logo_width;
        $this->template->logo_height = $this->logo_height;
        $this->template->logo_position = $this->logo_position;
        $this->template->logo_portrait_mode = $this->logo_portrait_mode;
        $this->template->whatsapp_image = $this->whatsapp_image;
        $this->template->whatsapp_title = $this->whatsapp_title;
        $this->template->whatsapp_description = $this->whatsapp_description;
        
         $this->template->enableIndividualEmail = isset($enableIndividualEmail)?$enableIndividualEmail:'0';
            
        $formview =  $this->getCreateForm();
        $this->template->content = \View::forge($formview, $data);

    }    
    
    public function action_create(){
        

        if($this->show_last_draft == '1'){
              
            $clear = \Input::get('clear',0);
            $base = $this->base;

            if($clear == 0){ 

                $model = $this->model;

                $agent = $this->getAgent();

                $agent_id = is_object($agent)?$agent->id:"";

                $from = date('Y-m-d H:i:s',strtotime('-1 day', time()));

                $object = $model::query()
                        ->where('confirm', 3);  
                if(!empty($agent_id)){
                        $object->where('agent_id', $agent_id);  
                }
                  $object   =   $object->where('created_at','>', $from)  
                        ->order_by('id','desc')->get_one();

                if(is_object($object))
                    \Response::redirect("/$base/edit/".$object->id);
            } 
        }
        
        $this->action_createNew();

    }
    
    public function action_createNew() {
//    public function action_create() {
            
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
                                
                                 $draft = \Input::post('draft_id');
                                 
                                if(isset($draft) && !empty($draft)){
                                    $object = $model::find($draft);
                                    
                                    if(!is_object($object))
                                          $object = new $model();
                                }
                                
                                $created_at= $object->created_at;
                                
                                $object->set($values);
                
                                
                                $has_many_relations = $object->GetHasMany();
                                
              
                                if(is_array($has_many_relations)){
                                    foreach ($has_many_relations as $key=>$relation){
                                        
                                       if(!empty($draft)) {
                                        
                                        $modelline = $relation['model_to'];
                                        $defectDelete = $modelline::query()->where('key_to',$draft)->get();


                                          if(is_array($defectDelete)){
                                            array_walk ($defectDelete, function($record){




                                                if(is_object($record)) $record->delete();
                                            } );

                                        }
                                        }
                                        
                                        
                                        $line_data  =\Input::post($key);
            
                                        $model = $relation['model_to'];
                                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                                            
                
                                            foreach ( $line_data as $line  ){
                                                
                                                $objline  = new $model;
                                                $line = $this->getFormattedInputValues($line);
                                                
                                                $objline->set($line);
                                           
                                                $object->{$key}[] = $objline;
                                            }
                                        }
                                    }
                                }
            
                                $agent_id= $this->assignAgentId();
                                
                                $object->agent_id = $agent_id;
                                
                                if($this->flowSystem == 1)
                                    $object->flow = 1;
            
                                if($this->auto_numbering == 1)
                                   $object->name = $this->assignNumber();
                                
                                $object->created_at = $created_at;
                                $object->submitted_date = $this->formatCreatedDate();
                
				if ( $stop==false and $object and $object->save())
				{
                                        //$this->uploadFiles($object); 
                                        
                //                        \Session::set_flash('success', \Lang::get("message.done.caradd").$object->id.'.');
            
//                                        if($this->flowType =1){
                                            
                                            $this->postProcess($object);
//                                        }
//                                        $emails = \Input::post('email',0);
//                                        if( isset($enableIndividualEmail) && $enableIndividualEmail == 1)
//                                            $this->sendPDFMail($object->id,$emails); 
                                      
//                                        if( isset($enableCentralEmail) && $enableCentralEmail == 1 && isset($setCentralEmail) && !empty($setCentralEmail)){
            
            
//                                            $this->sendPDFMail($object->id,$setCentralEmail); 
//                                        }
                                       
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
        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
        $this->template->color_scheme = $this->color_scheme;
        $this->template->logo_width = $this->logo_width;
        $this->template->logo_height = $this->logo_height;
        $this->template->logo_position = $this->logo_position;
        $this->template->logo_portrait_mode = $this->logo_portrait_mode;
        $this->template->whatsapp_image = $this->whatsapp_image;
        $this->template->whatsapp_title = $this->whatsapp_title;
        $this->template->whatsapp_description = $this->whatsapp_description;
        
        $this->template->removesalessoftbar = $this->removesalessoftbar;
            $locked=\Input::get('locked',0);
            
            $hidebar=\Input::get('hidebar',0);
            $signatureFile=\Input::get('signatureFile',0);
            
            \Session::set('locked',$locked);
            \Session::set('hidebar',$hidebar);
            \Session::set('signatureFile',$signatureFile);
        
              
            $this->template->content =  \View::forge($name.'/create',$html,false);
    }
    
    public function postProcess($object) {
       
               
        $enableEmail = $this->getSettingValue('enableEmail');
        
       
        $encode_url = 0;
        $sendmail = 0;
        $pdf = 0;
        $redirect = $this->base;
                
        if($this->flowSystem == 1){ // add to flowSystem /  formtype
            
            
            switch ($this->flowType){
                case 1: $sendmail = 1;
                        $pdf = 1;
                        break;
                case 2: if($object->flow == 2 ){
                            $sendmail = 1;  
                            $pdf = 1; 
                        }else{
                            $encode_url = 1; 
                        }
                        break;
            }
        }else{
            $sendmail = 1;
            $pdf = 1;
        }
            
            
        if($sendmail == 1 && $this->send_pdfmail == 1 && $enableEmail == 1  ){
            $this->sendPDFMail($object->id); 
        }

        if($encode_url  == 1 && isset($this->shorten_url) && $this->shorten_url == 1){

            \Response::redirect($redirect."/linktocopyurl/{$object->id}");
        }
                
        if($pdf == 1  ){ 
            switch ($this->pdf_mode){

                case 1 : //$this->action_exportDocumentToPdfOnSubmit($object->id);                    
                        \Response::redirect($redirect."/exportDocumentToPdfOnSubmit/{$object->id}");
                        break;

                case 2 : //$this->action_showDocumentToPdf($object->id); 
                        \Response::redirect($redirect."/showDocumentToPdf/{$object->id}"); 
                        break;

                case 3 : //$this->action_showAndExportDocumentToPdf($object->id); 
                        \Response::redirect($redirect."/showAndExportDocumentToPdf/{$object->id}"); 
                        break;
                default :  break;
             }
        }
                    
        
        \Response::redirect($redirect);
    }
    
    public function postEditProcess($object) {
                
        $redirect = $this->base;
        
            switch ($this->pdf_mode){

                case 1 : //$this->action_exportDocumentToPdfOnSubmit($object->id);                    
                        \Response::redirect($redirect."/exportDocumentToPdfOnSubmit/{$object->id}");
                        break;

                case 2 : //$this->action_showDocumentToPdf($object->id); 
                        \Response::redirect($redirect."/showDocumentToPdf/{$object->id}"); 
                        break;

                case 3 : //$this->action_showAndExportDocumentToPdf($object->id); 
                        \Response::redirect($redirect."/showAndExportDocumentToPdf/{$object->id}"); 
                        break;
                default :  break;
             }     
        
        return ;
    }
    
    public function action_postProcessViewAndSign($id = null) {
        
        $redirect = $this->base;
        
        $model= $this->model;

        is_null($id) and \Response::redirect($redirect); 
        
        $object = $model::find($id);
                
        if ( is_object($object) ) {
            
            $this->postProcessViewAndSign($object);
            
        }
        
        \Response::redirect($redirect);
    }
    
    public function postProcessViewAndSign($object) {
       
        $redirect = $this->base; 
                
        if(!empty($this->pdf_mode_flow2)){ 
            switch ($this->pdf_mode_flow2){

                case 1 : //$this->action_exportDocumentToPdfOnSubmit($object->id);                    
                        \Response::redirect($redirect."/exportDocumentToPdfOnSubmit/{$object->id}");
                        break;

                case 2 : //$this->action_showDocumentToPdf($object->id); 
                        \Response::redirect($redirect."/showDocumentToPdf/{$object->id}"); 
                        break;

                case 3 : //$this->action_showAndExportDocumentToPdf($object->id); 
                        \Response::redirect($redirect."/showAndExportDocumentToPdf/{$object->id}"); 
                        break;
                case 4 : //$this->action_showAndExportDocumentToPdf($object->id); 
                        \Response::redirect("https://www.google.com"); 
                        break;
                default :  break;
             }
        }
                    
        
        \Response::redirect($redirect);
    }
                
    public function action_edit($id = null)  {
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

            $stop = false;
              if((property_exists($this,"error") && $this->error == 1))
                     $stop = true;

             $form->add('submit', '',array( 'type' => 'submit', 'value' => \Lang::get('message.save')?\Lang::get('message.save'):'שמור' ,'class'=>'btn btn-primary'));
            if (\Input::method() == 'POST') {
               
                    $val =  $form->validation();
                    
                    $agent_id = $object->agent_id ;

                      $created_at= $object->created_at;
                      
                    if ($val->run())
                    { 
                            $values = $this->getFormattedInputValues($val->input()); 

                            $object->set($values); 


//                            foreach ($object as $field => $val){
//
//                                if(is_array($val))
//                                    $object->$field = implode (',', $val);
//                            }

                            $has_many_relations = $object->GetHasMany(); 

                            if(is_array($has_many_relations)){
                                foreach ($has_many_relations as $key=>$relation){

                                    $line_data  =\Input::post($key);

                                    $model = $relation['model_to'];

                                    $objlinedel  = new $model;

                                    $del = $objlinedel::query()->where('key_to',$object->id)->get();


                                    if(!empty($del) && is_array($del) && count($del) > 0 )

                                        foreach ($del as $dline){
                                            $dline->delete();
                                        }

                                    if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                                        foreach ( $line_data as $line  ){
//                                            
                                            $objline  = new $model;
                                             $line = $this->getFormattedInputValues($line);
                                            $objline->set($line);

                                            $object->{$key}[] = $objline;
                                        }
                                    }
                                }
                            }
                            $object->agent_id = $agent_id;
//                             $object->submitted_date = $this->formatCreatedDate();
                              $object->created_at = $created_at;
//                                $object->flow = 2;
                            if ($stop==false and $object and $object->save())
                            {
//                                $this->uploadFiles($object); 

//                                    $emails = \Input::post('email',0);
//                                    $this->sendPDFMail($object->id,$emails); 
                                
                                $this->postEditProcess($object);
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
        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
        $this->template->color_scheme = $this->color_scheme;
        $this->template->logo_width = $this->logo_width;
        $this->template->logo_height = $this->logo_height;
        $this->template->logo_position = $this->logo_position;
        $this->template->logo_portrait_mode = $this->logo_portrait_mode;
        $this->template->whatsapp_image = $this->whatsapp_image;
        $this->template->whatsapp_title = $this->whatsapp_title;
        $this->template->whatsapp_description = $this->whatsapp_description;
     
        $this->template->removesalessoftbar = $this->removesalessoftbar;         
        $name = $this->filepath;
        $this->template->content =  \View::forge($name.'/edit',$html,false);
    }

    public function action_view($id = null) {

        $model= $this->model;

        is_null($id) and \Response::redirect($this->base);

        if ( ! $object = $model::find($id)) {
            
            \Session::set_flash('error', 'Could not find car #'.$id);
            \Response::redirect($this->base);
        }
        
        
        $data['order'] = $object;
        
        $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
        $data['model'] = $this->base;
        $data['base'] = $this->base;    
        $name = $this->filepath;
        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
        $this->template->color_scheme = $this->color_scheme;
        $this->template->logo_width = $this->logo_width;
        $this->template->logo_height = $this->logo_height;
        $this->template->logo_position = $this->logo_position;
        $this->template->logo_portrait_mode = $this->logo_portrait_mode;
        $this->template->whatsapp_image = $this->whatsapp_image;
        $this->template->whatsapp_title = $this->whatsapp_title;
        $this->template->whatsapp_description = $this->whatsapp_description;
   
        $this->template->removesalessoftbar = $this->removesalessoftbar;           
        $this->template->content = \View::forge($name.'/view', $data);

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
        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
        
        $this->template->removesalessoftbar = $this->removesalessoftbar;      
            $this->template->content =  \View::forge($name.'/pdflabeler',$html,false);
    }
    
    function printReport($url,$report,$data){

        $pdfData = array(
            "outputFormat"=>"pdf"
        );

        $handle = curl_init();

        $pdfData["data"]= json_encode($data);

        $pdfData["report"] = $report;

        $req = curl_init();
        curl_setopt_array($req, [
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => "PUT",
            CURLOPT_POSTFIELDS     => http_build_query($pdfData),
            CURLOPT_HTTPHEADER     => [ "Content-Type" => "application/json" ],
            CURLOPT_RETURNTRANSFER=>true
        ]);

        $response = curl_exec($req);

        $header_size = curl_getinfo($req, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $key = substr($response, 4);
        $getdata = http_build_query(
                        array(
                            'outputFormat' => 'pdf',
                            'key' => $key,
                         )
                    );



        return "$url?$getdata";   
    } 

    public function action_showDocumentToPdf($id = null) {
                
        try{
            
            if(\Config::get('pdfsign')==1) return $this->showSecureDocumentToPdf($id);    
	    
            $data_return = $this->getPdfInStringUsingId($id);// generatePDF($id);

            $reportname = $this->getSettingValue('pdf_report_name');     

            if(empty($reportname)){ 
                $reportname = 'report';    
            }
            
            header('Content-type: application/pdf');

            header("Content-disposition: inline;filename={$reportname}.pdf");
            
            echo  $data_return;//file_get_contents(urldecode($data_return)); 
            
        }catch(\Exception $ex){
            
            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
            \Response::redirect($this->base);
        }
    }
    
    public function action_showAndExportDocumentToPdf($id = null) {
                    
        $data['base'] = $this->base;  
        $data['id'] = $id;  
        $this->template->base = $this->base;  
        $this->template->id = $id;
        $this->template->download = 1;
        $this->template->showPDF = 1;
        $this->template->content =  \View::forge('dynamicformssystem::forms/pdf',$data,false);
    }
    
    public function action_exportDocumentToPdfOnSubmit($id = null) {
                
        $data['base'] = $this->base;  
        $data['id'] = $id;  
        $this->template->base = $this->base;  
        $this->template->id = $id;
        $this->template->download = 1;
        $this->template->redirect = 1;
        $this->template->content =  \View::forge('dynamicformssystem::forms/pdf',$data,false);
    }
    
    public function action_exportDocumentToPdf($id = null) {
                
        try{ 
            if(\Config::get('pdfsign')==1) return $this->exportSecureDocumentToPdf($id);
            $data_return = $this->getPdfInStringUsingId($id);// generatePDF($id);
           
            $reportname = $this->getSettingValue('pdf_report_name');     
                 
            if(empty($reportname)){ 
                $reportname = 'report';    
            }
            
           
                
            header('Content-type: application/pdf');

            header("Content-disposition:attachment;filename={$reportname}.pdf");
                
            
            echo $data_return;// file_get_contents($content); 
            
            die();
             
        }catch(\Exception $ex){
            
            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
            \Response::redirect($this->base);
        }
    }
    
    public function generatePDF($id = null ) {        
                
        $object = $this->getObject($id);
        
        $dataarray = $this->mapPDFData($object);
                
        $reporttemplate = $this->getSettingValue('pdf_template_name');   
        $data =  '';
        
        if(!empty($reporttemplate)){
            $data = $this->printReport("https://pdfcreatortest.dira2.co.il/albums/reporter/runWithName",$reporttemplate,$dataarray);
        } 
        return $data;
    }
    
    public function getObject($id = null ) {
        
        $object = null;
        
        if(!is_null($id)){
            
            $model= $this->model;
            
            $object= $model::find($id);
        }
        
        return $object;
    }
     
    public function mapPDFData($object = null) {
        
        $module = $this->modulename;
        
        $dataarray = array();
        
        if(is_object($object)){
            
            $dataarray = $this->sortPropertyData($object);

            $has_many_relations = $object->GetHasMany(); 

            if(is_array($has_many_relations) && count($has_many_relations) > 0){
                
                foreach ($has_many_relations as $key=>$relation){
//                    print_r($key); die();
                    unset($dataarray[$key]);
                    $count = 1;
                    foreach ($object->$key as $line){
                        
                        $linearr = $this->sortPropertyData($line);
                        $linearr['count'] = $count;
                        $dataarray[$key][] =  $linearr;
                         $count++;
                    }

                }
            }
            
//              $count = 1;
//              foreach($dataarray["bzzwhnvrfjline"] as $key=>$value){
//
//                  $dataarray["bzzwhnvrfjline"][$key]["count"]="$count";
//                      $count++;
//                }
           
            if(isset($object->agent_id) && !empty($object->agent_id)){
                $agent_id = $object->agent_id;
                
                $model = $module.'\Model_Agents';
                $agent = $model::find($agent_id);
                
                if(isset($agent->agent_code))
                    $dataarray['agent_code'] = $agent->agent_code;
                
                if(isset($agent->name))
                    $dataarray['agent_name'] = $agent->name;
                
            }else{
                 $dataarray['agent_code'] = '';
                 $dataarray['agent_code'] = '';
            }
        }
                
        return $dataarray;
    }
    
    /**
     * sort data based on input type
     * 
     * @param type $object
     * @return type
     */
    public function sortPropertyData($object = null ) {
        
        $forms = $object->GetPropertiesType();
         
        $dataarray = array();
        
        foreach($forms as $key=>$value) {

            if($key == 'id') 
               $dataarray[$key] = strval ($object->$key);
            else{
                
                if($key == 'agent_id' && isset($object->agent)){ 
                   $dataarray['agent_name'] = is_object($object->agent)?$object->agent->name:"";
                }
                
                switch ($value){
                    
                    case 'checkbox-group' : if(!empty($object->$key)){
                //                        $dataarray[$key]= json_decode($object->$key, true); 

                                            $arr =json_decode($object->$key, true);
                                            $atrdata = '';
                                            if(is_array($arr) && count($arr) > 0){
                                                
                                                $options = $object->GetPropertiesCheckboxData($key);
                                                $allvalue = array ();
                                                
                                                if(is_array($options) && count($options) > 0)
                                                    foreach ($options as $opt){

                                                        if(key_exists('value', $opt)){
    //                                                        print_r($arr);
                                                            if(in_array($opt['value'], $arr)){ 
                                                                $dataarray[$key.'_'.$opt['value']]= $opt['value']; 
                                                                $dataarray[$key.'_'.$opt['value'].'_value']= $object->GetPropertiesMapCheckboxData($key,$opt['value']);
                                                                $allvalue[] = $dataarray[$key.'_'.$opt['value'].'_value'];
                                                            }else{
                                                                 $dataarray[$key.'_'.$opt['value']]= ''; 
                                                                $dataarray[$key.'_'.$opt['value'].'_value']= '';

                                                            }

                                                        }
                                                    }
                    
//                                                foreach ($arr as $k=>$ar ){
//                                                    $dataarray[$key.'_'.$ar]= $ar; 
//                                                    $dataarray[$key.'_'.$ar.'_value']= $object->GetPropertiesMapCheckboxData($key,$ar);
//                                            
//                                                }
                                                
                                                $atrdata = implode(',', $arr);
                                                $dataarray[$key]= $atrdata; 
                                                $alldata = implode(',', $allvalue);
                                            
                                                $dataarray[$key.'_value']= $alldata;
                                             
                                            }
                                            
                                            
                                             
                                        } else{
                                            
                                            $options = $object->GetPropertiesCheckboxData($key);
                                            
                                            
                                            if(is_array($options) && count($options) > 0){
                                                foreach ($options as $opt){

                                                    if(key_exists('value', $opt)){

                                                        $dataarray[$key.'_'.$opt['value']]= ''; 
                                                        $dataarray[$key.'_'.$opt['value'].'_value']= '';

                                                    }
                                                }
                                            }
                                            $dataarray[$key]= ''; 
                                            $dataarray[$key.'_value']= ''; 
                                        }
                                        
                                        
                                        
                                        break;
                    case 'file' :   $limit = $object->GetPropertyValue('limit',$key);
                    
                                   if(!empty($object->$key)){

                                       $file = array();
                                       $filedata  = $object->$key;


                                       if(strpos($filedata, ',') > -1){

                                           $filevalues = explode(',', $filedata);

                                           
                                            if(is_array($filevalues) && count($filevalues) > 0)
                                                foreach ($filevalues as $val){

                                                    $img = \Model_Image::find($val);
                                                    if(is_object($img)){
                                                        
                                                        $ext = pathinfo($img->name, PATHINFO_EXTENSION);
                                                   
                                                        if(!empty($ext) && in_array($ext,array('pdf','PDF')))
                                                            $file[]['img'] = \Uri::base(false).'/assets/img/files/'.'/blank.png';
                                                        else
                                                            $file[]['img'] = \Uri::base(false).'/Model_Products/'.$img->name;
                                                        
//                                                        $file[]['img'] = \Uri::base(false).'/Model_Products/'.$img->name;
                                                    }
                                                }
                                       }else {
                                            $img = \Model_Image::find($filedata);
                                               if(is_object($img)){ 
                                                   $ext = pathinfo($img->name, PATHINFO_EXTENSION);
                                                   
                                                    if(!empty($ext) && in_array($ext,array('pdf','PDF')))
                                                        $file = \Uri::base(false).'/assets/img/files/'.'/blank.png';
                                                    else
                                                        $file = \Uri::base(false).'/Model_Products/'.$img->name;
                                               }
                                       }

                                       if($limit > 1){
                                           if(!is_array($file)){
                                               $file =  array(array('img' => $file));
                                           }
                                       }else{

                                           if(is_array($file)){
                                               $file =   $file[0]['img'];
                                           }
                                       } 
                                       $dataarray[$key]= $file; 

                                   }else{ 
                                       $file= \Uri::base(false).'/assets/img/files/'.'/blank.png'; 
                                       $filelink = '';
                                        
                                       if($limit > 1){

                                           $filelink =  array(array('img' => $file));

                                       }else{
                                           $filelink = $file;
                                       }

                                       $dataarray[$key]= $filelink; 
                                   }
                                break;
                    case 'canvas' :  if(empty($object->$key)){  
                                        $dataarray[$key]= "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKoAAACUCAIAAACMZCUIAAAAA3NCSVQICAjb4U/gAAAAGXRFWHRTb2Z0d2FyZQBnbm9tZS1zY3JlZW5zaG907wO/PgAAAXVJREFUeJzt1EENwDAQA8Em/DkGyhXGPXYGgaWVfGbmo+puD2CT/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gn3bS9g0ZmZ7Q2scf5p8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJn/YDKmQIAJkHRwkAAAAASUVORK5CYII=";
                                    }else{
                                        $dataarray[$key]=$object->$key; 
                                    }
                                break;
                    case 'select' : 
                        
                                    if($object->$key == '---'){
                                        $dataarray[$key]= ''; 
                                        $dataarray[$key.'_value']= '';
                                        
                                    }else{
                                        $dataarray[$key]=$object->$key; 

                                        if(!empty($object->$key)){  

                                            $dataarray[$key.'_value']= $object->GetPropertiesMapData($key,$object->$key);
                                        }
                                    }
                                     
                                    
                                break;
                    case 'radio' : 
                                    $dataarray[$key]=$object->$key; 
                        
                                    if(!empty($object->$key)){  
                                        
                                        $dataarray[$key.'_value']= $object->GetPropertiesMapData($key,$object->$key);
                                    }
                    case 'radio-group' : 
                                    $dataarray[$key]=$object->$key; 
                        
                                    if(!empty($object->$key)){  
                                        
                                        $dataarray[$key.'_value']= $object->GetPropertiesMapData($key,$object->$key);
                                    }
                                     
                                    
                                break; 
                    case 'date' :  
                        
                                    if(empty($object->$key)){  
                                        
                                        $dataarray[$key]= null;
                                    }else{
                                        if(strpos($object->$key, '/') > -1){
                                            $object->$key = str_replace('/','-',$object->$key);
                                        }
                                        
                                        $date = explode('-', $object->$key);
                                        
                                        if(key_exists(2,$date) && strlen($date[2]) >2){
                                            $object->$key = $date[2].'-'.$date[1].'-'.$date[0]; 
                                        }
                                        
                                        
                                        $dataarray[$key]= $object->$key;
                                    }
                                     
                                    
                                break;
                    default :   $dataarray[$key]=$object->$key; 
                                break;
                        
                    
                }
                
//
//                if($value == 'checkbox-group'){
//                    if(!empty($object->$key)){
////                        $dataarray[$key]= json_decode($object->$key, true); 
//                        
//                        $arr =json_decode($object->$key, true);
//                        $atrdata = '';
//                        if(count($arr) > 0){
//                            $atrdata = implode(',', $arr);
//                        }
//                        $dataarray[$key]= $atrdata; 
//                    } else
//                        $dataarray[$key]= ''; 
////                        $dataarray[$key]= array(); 
//                }else{ 
//                    
//                    if($value == 'file'){
//                        
//                         $limit = $object->GetPropertyValue('limit');
//                         
//                        if(!empty($object->$key)){
//                            
//                            $file = array();
//                            $filedata  = $object->$key;
//                            
//                            
//                            if(strpos($filedata, ',') > -1){
//
//                                $filevalues = explode(',', $filedata);
//
//                                foreach ($filevalues as $val){
//
//                                    $img = \Model_Image::find($val);
//                                    if(is_object($img)){
//                                        $file[]['img'] = \Uri::base(false).'/Model_Products/'.$img->name;
//                                    }
//                                }
//                            }else {
//                                 $img = \Model_Image::find($filedata);
//                                    if(is_object($img)){
////                                        $file[]['img'] = \Uri::base(false).'/Model_Products/'.$img->name;
//                                        $file = \Uri::base(false).'/Model_Products/'.$img->name;
//                                    }
//                            }
//                           
//                            if($limit > 1){
//                                if(!is_array($file)){
//                                    $file =  array(array('img' => $file));
//                                }
//                            }else{
//                
//                                if(is_array($file)){
//                                    $file =   $file[0]['img'];
//                                }
//                            }
//                            
////                            if(count($file) > 0)
////                                $filedata = $file;
////                            else 
//                            
//                            
//                            
//                            
//                            
////                            $dataarray[$key]= $filedata; 
//                            $dataarray[$key]= $file; 
//                            
//                        }else{ 
//                            $file= \Uri::base(false).'/assets/img/files/'.'/blank.png'; 
//                            $filelink = '';
////                             
//                            if($limit > 1){
//                                   
//                                $filelink =  array(array('img' => $file));
//                                
//                            }else{
//                                $filelink = $file;
//                            }
//                            
//                            $dataarray[$key]= $filelink; 
//                        }
//                        
//                    }else{ 
//                          if($value == 'canvas' && empty($object->$key)){
//                              
//                              $dataarray[$key]= "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKoAAACUCAIAAACMZCUIAAAAA3NCSVQICAjb4U/gAAAAGXRFWHRTb2Z0d2FyZQBnbm9tZS1zY3JlZW5zaG907wO/PgAAAXVJREFUeJzt1EENwDAQA8Em/DkGyhXGPXYGgaWVfGbmo+puD2CT/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gnyp8mfJn+a/Gn3bS9g0ZmZ7Q2scf5p8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJnyZ/mvxp8qfJn/YDKmQIAJkHRwkAAAAASUVORK5CYII=";
//                              
//                          }else{ 
//                                $dataarray[$key]=$object->$key; 
//                          }
//                    }
//                }
            }
        }
        
        return $dataarray;
    }
                 
    public function getSettingValue($flag = null) {
                    
        $reportname = '';

        $modulename = $this->modulename;

        $form = Model_Forms::query()->where('name',$modulename)->get_one();

        if(is_object($form)){

            $systemsconfig = $form->systemsconfig;

            $systemsconfig_de = json_decode($systemsconfig, true);

            if(is_array($systemsconfig_de) && key_exists($flag, $systemsconfig_de)){
                $reportname = $systemsconfig_de[$flag];
            }else{
                if(isset($this->$flag))
                    $reportname = $this->$flag;
            } 
        }else{
                if(isset($this->$flag))
                    $reportname = $this->$flag;
        }  
        
        return $reportname;
    }
                 
    public function getSetting($flag = null) {
            
        $flagval = '';

        $modulename = $this->modulename;

        $form = Model_Forms::query()->where('name',$modulename)->get_one();

        if(is_object($form) && isset($form->$flag)){ 

           $flagval = $form->$flag;
        }else{
            if(isset($this->$flag))
                $flagval = $this->$flag;
        } 
        
        return $flagval;
    }
        
    public function action_sendMail($id = null) {
        
        $this->sendPDFMail($id);
        
        \Response::redirect($this->base);
    }
        
    public function action_sendEmail($id = null,$email = null ) {
        
        $email = \Input::get('email');  
        
        $this->email = $email;
        
        $this->pdfString =  $this->getPdfInStringUsingId($id);//$this->generatePDF($id);
        
       // $this->pdfString = file_get_contents(urldecode( $this->pdfString));

        $this->fileName = $this->getSettingValue('pdf_report_name');     

        if(empty($this->fileName)){ 
            $this->fileName = 'report';    
        } 
        
        $this->sendMail();    
        
        \Response::redirect($this->base);
    }
    
    public function sendPDFMail($id = null) {
            
        $model = $this->model;
        
        $obj = $model::find($id);
        
        $this->object = $obj;
        
        $props =$obj->GetEmailProperties();
                

        $this->email = $this->getSettingValue('emailTo');
        
        if(isset($props) && count($props) > 0)
            foreach ($props as $prop){
            
                if(isset($obj->$prop) && !empty($obj->$prop))
                    $this->email .=','.$obj->$prop;
            }
                
        $this->bccEmail = $this->getSettingValue('emailBcc');
        
//        $this->subject = $this->getSettingValue('subject');
        
       // $this->ccEmail = $this->getSettingValue('emailcc');
                
      try{          

            if(\Config::get('pdfsign')==1)
		{

			$this->pdfString  = $this->generateSecurePDF($id);
		}
	     else {
         	   $this->pdfString = $this->getPdfInStringUsingId($id);/// $this->generatePDF($id);
               	  if(!empty($this->pdfString)) $this->pdfString = file_get_contents(urldecode( $this->pdfString));
              }      
            $this->fileName = $this->getSettingValue('pdf_report_name');     
                
            if(empty($this->fileName)){ 
                $this->fileName = 'report';    
            } 

            $this->sendMail();    
        
        }
        catch(\Exception $e) {

            $msg =$e->getMessage(); 
            \Log::warning("Email PDF Status :" .$msg);   
        }
    }
    
    public function action_testSendviewandsignMail($id = null) {

        $this->sendviewandsignMail($id);
        die();
    }
    
    public function sendviewandsignMail($id = null) {
            
        $sendviewandsignEmail = $this->getSettingValue('sendviewandsignEmail');
        
        \Log::warning('entered send mail view and sign '.$sendviewandsignEmail);
        if($sendviewandsignEmail == 1){
            $model = $this->model;

            $obj = $model::find($id);

            $this->object = $obj;

            $props =$obj->GetEmailProperties();


            $this->email = $this->getSettingValue('emailTo');

            if(isset($props) && count($props) > 0)
                foreach ($props as $prop){

                    if(isset($obj->$prop) && !empty($obj->$prop))
                        $this->email .=','.$obj->$prop;
                }

            $this->bccEmail = $this->getSettingValue('emailBcc');

    //        $this->subject = $this->getSettingValue('subject');

           // $this->ccEmail = $this->getSettingValue('emailcc');

          try{          
                $this->pdfString = $this->getPdfInStringUsingId($id) ;// $this->generatePDF($id);

                if(!empty($this->pdfString) && 1==0){
                     $this->pdfString = file_get_contents(urldecode( $this->pdfString));
                }

                $this->fileName = $this->getSettingValue('pdf_report_name');     

                if(empty($this->fileName)){ 
                    $this->fileName = 'report';    
                } 

                $this->sendMail();    

            }
            catch(\Exception $e) {

                $msg =$e->getMessage(); 
                \Log::warning("Email PDF Status :" .$msg);   
            }
        }
    }
        
    public function sendPDFMailRecord($id = null) {
            
        $model = $this->model;
        
        $obj = $model::find($id);
        
        $this->object = $obj;
        
        $props =$obj->GetEmailProperties();
                

        $this->email = $this->getSettingValue('emailTo');
        
        if(isset($props) && count($props) > 0)
            foreach ($props as $prop){
            
                if(isset($obj->$prop))
                $this->email .=','.$obj->$prop;
            }
                
        $this->bccEmail = $this->getSettingValue('emailBcc');
                    
                
      try{          
            $this->pdfString = $this->getPdfInStringUsingId($id) ;//$this->generatePDF($id);

            if(!empty($this->pdfString) && 1==0){
                 $this->pdfString = file_get_contents(urldecode( $this->pdfString));
            }
            
            $this->fileName = $this->getSettingValue('pdf_report_name');     
                
            if(empty($this->fileName)){ 
                $this->fileName = 'report';    
            } 

            $this->sendMail();    
        
        }
        catch(\Exception $e) {

            $msg =$e->getMessage(); 
            \Log::warning("Email PDF Status :" .$msg);   
        }
    }
        
    public function sendMail() {
          
        
            
            if(!empty($this->email)){
        try {
            
            $this->setEmailParam();
            $mail = $this->mapEmailData();
            
           if(\Config::get('pdfsign')==1) 
	 $mail->attach($this->pdfString,false,null,null,"{$this->fileName}.pdf");
	else {
           	 if(!empty($this->pdfString))
                               
           	 $mail->string_attach( $this->pdfString , "{$this->fileName}.pdf");
            }
            if(empty($this->body)){
               $this->body ="&nbsp;";
//                $mail->html_body($this->body);
            }
//            else
//                $mail->body( $this->body);
            
            $mail->html_body($this->body);
            
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
        }else
        \Log::warning("Email To empty");   
    }
    
    public function setEmailParam() {
        
        $module = $this->modulename;
            
        $emaildata = Model_Emaildetails::query()->where("module",$module)->get_one();

        if(is_object($emaildata)){ 

            if(!empty($emaildata->subject))
                $this->subject = $emaildata->subject;
            if(!empty($emaildata->body))
                $this->body = $emaildata->body;
        }
        
        if(isset($this->object) && !empty($this->object) && is_object($this->object)){
            
            $obj = $this->object;
            
            $props = $obj->GetPropertiesKey();
            
            foreach ($props as $prop){
                
                $$prop = $obj->$prop;
                
                $this->subject = str_replace("{".$prop."}", $obj->$prop, $this->subject);
                $this->body = str_replace("{".$prop."}", $obj->$prop, $this->body);
            }              
        } 
    }
    
    public function mapEmailData() {
        
        $mail = \Email::forge();
        
        $this->email = $this->convertSringToArray($this->email);
                
        $mail->to($this->email);

        if (!empty($this->bccEmail)) {            
            
            $this->bccEmail = $this->convertSringToArray($this->bccEmail);
            
            $mail->bcc($this->bccEmail);
        }

        if (!empty($this->ccEmail)) {
            
            $this->ccEmail = $this->convertSringToArray($this->ccEmail);
            
            $mail->cc($this->ccEmail);
        }

        $mail->from($this->from);

        $mail->subject($this->subject); 
        
        return $mail;
    }
    
    public function convertSringToArray($data = null) {
        
        $dataarr = array();
        $validemail = array();
        
        if(!is_null($data) && is_string($data) && strpos( $data, ',') >= 0){
            
            $dataarr = explode(',', $data);
        }
        
        if(count($dataarr) > 0 ){
            
            foreach($dataarr as $dat){
                
                if(filter_var($dat, FILTER_VALIDATE_EMAIL)){
                    $validemail[] = $dat;
                }
            }
        }
        
                
        return $validemail;
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
                    'max_size' => $this->maxFileSize, 
                    );
        \Upload::process($config);
        $key = key(\Upload::get_files());  
        }

            $uploadFolder = $this->uploadFolder;
            
            
            \Upload::save(DOCROOT."$uploadFolder",$key);


                $files = \Upload::get_files();
                 
                
                    if(key_exists($key, $files)){
                        $image = new \Model_Image();
                    $image->model_to = 'Model_Products';
                    $orignalname = $files[$key]['saved_as'];
                    $image->name = strtolower($files[$key]['saved_as']);
                    rename(DOCROOT.'Model_Products/'.$orignalname,DOCROOT.'Model_Products/'.$image->name);
                       
//                        $image->save();
//                        
//                        $data = array('id' => $image->id, 'name' => $image->name );
                         $fullcurrPath = DOCROOT.'Model_Products/'.$image->name;
                        $smallcurrPath = DOCROOT.'Model_Products/small_'.$image->name;
                       
                        $image->save();
                        
//                        $resize = new ResizeImage($fullcurrPath);
//                        $resize->resizeTo(100, 100, 'exact');
//                        $resize->saveImage($smallcurrPath);
//                        $img = new \Imagick();
//                        $img->readImage($fullcurrPath);
//
//                        $img->resizeImage(100, 100, \Imagick::FILTER_CATROM, 1);
////
//                        $img->writeImage($smallcurrPath);
//                        $data = array('id' => $image->id, 'name' =>'small_'.$image->name );
                        $data = array('id' => $image->id, 'name' =>$image->name );
                    echo json_encode($data); 
                    } else{
                        echo 0;
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

    public function getFormattedInputValues($inputs = array()) {
        
        $temp = array();
        if(is_array($inputs)){
            foreach ($inputs as $key => $input){
                if(is_array($input)){
//                    $input = implode(',',$input);
//                    $inputx = array_values($input);
                    $input = json_encode($input,JSON_FORCE_OBJECT);
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

    public function get_listx() {
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
            
    public function get_blankimg() {
        
//        $this->format="img";
        $this->response->set_header('Content-Type', 'img'); 
        $string = \View::forge('dynamicformssystem::images/blank', $html = null);
        return  $this->response($string);
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
            
            
            
            $locked= \Session::get('locked');
            $hidebar=\Session::get('hidebar');
            $removesubmit=\Session::get('removesubmit');
            $signatureFile=\Session::get('signatureFile',null);
            
               
        //@author Shyam Joshi <shyam@shyamjoshi.in>   
        //Check if getParam for signature exists , 
        //If exists show button , for adding existing signature 
        //Once button is clicked take image as base64 iamge to be used 
            
                
            //$signatureFile = \Input::get("signatureFile",null);
            //$signaturedata = null;
            $html['signaturedata'] = 0;
            
            $filepath = DOCROOT."/$signatureFile";
            
            if(!is_null($signatureFile) && file_exists($filepath)){
            $html['signaturedata'] =$signatureFile;
            }
            
            $html['locked'] =$locked;
            $html['removesubmit'] =$removesubmit;
            \Session::delete('locked');
            \Session::delete('removesubmit');
            \Session::delete('signatureFile');
            $html['hidebar'] =$hidebar;
            \Session::delete('hidebar');
            $html['disablerequirednextfield'] = $this->disablerequirednextfield;
            
            $string = \View::forge('dynamicformssystem::js/formbuilder', $html);
            return  $this->response($string);
    }    
    
    function get_formbuildersystemjs(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/formbuildersystem', $html = null);
            return  $this->response($string);
    }        
        
    function get_showhidejs(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/showhide', $html = null);
            return  $this->response($string);
    }        
        
    function get_mathjs(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/mathjs', $html = null);
            return  $this->response($string);
    }        
        
    function get_edittextjs(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/edittext', $html = null);
            return  $this->response($string);
    }        
    function get_autosave(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/autosave', $html = null);
            return  $this->response($string);
    }        
    
    function get_formbuildercss(){
    
            $this->format="css";
            $this->response->set_header('Content-Type', 'css');
            
            $string = \View::forge('dynamicformssystem::css/formcss', $html = null);
            return  $this->response($string);
    }        
    
    function get_ltrcss(){
    
            $this->format="css";
            $this->response->set_header('Content-Type', 'css');
            
            $string = \View::forge('dynamicformssystem::css/ltrcss', $html = null);
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
            
    public function action_viewandsignrecord($id = null) { 
            
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
                $flow = \Input::post('flow');
                $draft= \Input::post('draft_id');
                if($flow == 2){
            
                $created_at = $object->created_at;
                
            
                if(is_array($post_data) && count($post_data) > 0){
                    
                    foreach ($post_data as $key=>$fielddata){
                        $object->$key = $fielddata;
                    }
                }
                
                
                                
                                $has_many_relations = $object->GetHasMany();
                                
              
                                if(is_array($has_many_relations)){
                                    foreach ($has_many_relations as $key=>$relation){
                                        
                                       if(!empty($draft)) {
                                        
                                        $modelline = $relation['model_to'];
                                        $defectDelete = $modelline::query()->where('key_to',$draft)->get();


                                          if(is_array($defectDelete)){
                                            array_walk ($defectDelete, function($record){




                                                if(is_object($record)) $record->delete();
                                            } );

                                        }
                                        }
                                        
                                        
                                        $line_data  =\Input::post($key);
            
                                        $model = $relation['model_to'];
                                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                                             
                                            if(isset($object->{$key}) && count($object->{$key}) > 0)
                                                unset($object->{$key});
                
                                            foreach ( $line_data as $line  ){
                                                
                                                $objline  = new $model;
                                                $line = $this->getFormattedInputValues($line);
                                                
                                                $objline->set($line);
                                           
                                                $object->{$key}[] = $objline;
                                            }
                                        }
                                    }
                                }
                
                   $object->created_at = $created_at;
                     $object->flow = 2; 
                     
                    if($object->save()){
                        
                        $this->postProcessRecord($object);
//                        $this->action_sendFormMail($object->id);
                        \Session::set_flash('success', 'הטופס נשלח בהצלחה');
                        
                        \Response::redirect($this->base."/viewmessage/{$object->id}");
                        \Response::redirect("https://www.google.com");
                    }     
                    
                }
                                
            }

             
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = $this->base;
            $data['base'] = $this->base;   
            $name = $this->filepath;
            
                
            $data['jsurl'] = 'jsonWebFormOrderComplete';
            
            $this->setTemplateParams();
            
            $this->setHideLock();
                
            $data['order']=$object;
              
             $this->template->content = \View::forge($name.'/edit', $data);             
//             $this->template->content = \View::forge($name.'/viewandsign', $data);             
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
                $draft = \Input::post('draft_id');
//                $flow = \Input::post('flow');
//                if($flow == 2){
            
                $created_at = $object->created_at;
                
            
                if(is_array($post_data) && count($post_data) > 0){
                    
                    foreach ($post_data as $key=>$fielddata){
                        $object->$key = $fielddata;
                    }
                }
                
                
                                
                                $has_many_relations = $object->GetHasMany();
                                
              
                                if(is_array($has_many_relations)){
                                    foreach ($has_many_relations as $key=>$relation){
                                        
                                       if(!empty($draft)) {
                                        
                                        $modelline = $relation['model_to'];
                                        $defectDelete = $modelline::query()->where('key_to',$draft)->get();


                                          if(is_array($defectDelete)){
                                            array_walk ($defectDelete, function($record){




                                                if(is_object($record)) $record->delete();
                                            } );

                                        }
                                        }
                                        
                                        
                                        $line_data  =\Input::post($key);
            
                                        $model = $relation['model_to'];
                                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                                              
                                            if(isset($object->{$key}) && count($object->{$key}) > 0)
                                                unset($object->{$key});
                
                                            foreach ( $line_data as $line  ){
                                                
                                                $objline  = new $model;
                                                $line = $this->getFormattedInputValues($line);
                                                
                                                $objline->set($line);
                                           
                                                $object->{$key}[] = $objline;
                                            }
                                        }
                                    }
                                }
                
                   $object->created_at = $created_at;
                     $object->flow = 2; 
                     
                    if($object->save()){
                        
                        $this->sendviewandsignMail($object->id);
                        
                        if(isset($this->showMessageBeforePDFflow2) && $this->showMessageBeforePDFflow2 == 1){
                         
                            \Session::set_flash('success', 'הטופס נשלח בהצלחה');
                            \Response::redirect($this->base."/viewmessage/{$object->id}");
                            
                        }else{
                            
                            \Response::redirect($this->base."/postProcessViewAndSign/{$object->id}");
//                            $this->postProcessViewAndSign($object);
                        }
                        
                        \Response::redirect("https://www.google.com");
                    }     
                    
//                }
                                
            }

             
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = $this->base;
            $data['base'] = $this->base;   
            $name = $this->filepath;
            
                
            $data['jsurl'] = 'jsonWebFormOrderComplete';
            
            $this->setTemplateParams();
            
            $this->setHideLock();
                
            $data['order']=$object;
              
             $this->template->content = \View::forge($name.'/edit', $data);             
//             $this->template->content = \View::forge($name.'/viewandsign', $data);             
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
            
        \Response::redirect('/dynamicformssystem/forms/setSettings/'.$this->modulename);
            $process = 0;

            $process = \Input::post("submitdata",'0');

            $settinglist = $this->getSettingFlags();
            
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
            $datax['module']= $this->modulename; 
            
            $this->template->content = \View::forge('dynamicformssystem::systems/enablemodule', $datax); 
    }

            
    public function getSettingFlags() {
        
        $settinglist = array( array('id'=>1,'type'=>'textbox','name'=>'bity_api_key','visible'=>1,'group_id'=>1),
//                                    array('id'=>2,'type'=>'text','name'=>'pdf_creator','visible'=>1,'group_id'=>1),
                                    array('id'=>3,'type'=>'checkbox', 'value'=> 1,'name'=>'send_pdfmail','visible'=>1,'group_id'=>1),
//                                    array('id'=>4,'name'=>'pdf_mode','visible'=>1,'group_id'=>1),
                                    array('id'=>5,'type'=>'textbox','name'=>'pdf_template_name','visible'=>1,'group_id'=>1), 
                                    array('id'=>5,'type'=>'textbox','name'=>'pdf_report_name','visible'=>1,'group_id'=>1), 
                                    array('id'=>6,'type'=>'textbox','name'=>'emailTo','visible'=>1,'group_id'=>1), 
                                    array('id'=>7,'type'=>'textbox','name'=>'emailBcc','visible'=>1,'group_id'=>1), 
                                    array('id'=>8,'type'=>'textbox','name'=>'senderName','visible'=>1,'group_id'=>1), 
                                    array('id'=>9,'type'=>'checkbox', 'value'=> 1,'name'=>'enableEmail','visible'=>1,'group_id'=>1), 
//                                    array('id'=>10,'type'=>'checkbox','name'=>'flowSystem','visible'=>1,'group_id'=>1),     //value=>label
//                                    array('id'=>11,'type'=>'select', 'name'=>'flowType','visible'=>1,'group_id'=>1, 'options' => array('1'=>'1' , '2' => '2')), 
            
                                );
        
        return $settinglist;
    }
    
    
    public function post_loadDocumentToPdf() {
                
//        try{
            
                
            $dataarray = \Input::post();
                
            $reporttemplate = $this->getSettingValue('pdf_template_name');   

            $datax = $this->printReport("https://pdfcreatortest.dira2.co.il/albums/reporter/runWithName",$reporttemplate,$dataarray);
            

            $reportname = $this->getSettingValue('pdf_report_name');     

            if(empty($reportname)){ 
                $reportname = 'report';    
            }
            
            header('Content-type: application/pdf');

            header("Content-disposition: inline;filename={$reportname}.pdf");
            
            echo file_get_contents(urldecode($datax)); 
            
//        }catch(\Exception $ex){
//            
//            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
//            \Response::redirect($this->base);
//        }
    }
    
    public function get_loadSampleDocumentToPdf() {
                
//        try{
            
            $model = $this->model;

            $object = new $model;            
                
            $clear = \Input::get('clear');
            $clear = 1;
            
            $module = $this->modulename;
             $path = DOCROOT.'/samplefiles/sample'.$module.'.pdf';
             $flag= 0;
             
             if(file_exists($path) && $clear == 1 ){
               
                $flag= 1;
             
             }else{  
                 if(!file_exists($path)){ 
                      $flag= 1;
                 }
             }
            
             if($flag == 1 ){
                $dataarray = array();     

                $properties = $object->GetViewProperties();

                foreach ($properties as $key=>$prop){
                    $dataarray[$key] = '';
                }

                $has_many_relations = $object->GetHasMany();


                if(is_array($has_many_relations)){
                    foreach ($has_many_relations as $key2=>$relation){
                         $model = $relation['model_to'];
                        $objline  = new $model;

                        $lineproperties = $objline->GetViewProperties();
                        $line = array();
                        foreach ($lineproperties as $key3=>$prop){
                            $line[$key3] = '';
                        }             

                        $dataarray[$key2][] = $line; 
                    }
                }


                $reporttemplate = $this->getSettingValue('pdf_template_name');   

                $datax = $this->printReport("https://pdfcreatortest.dira2.co.il/albums/reporter/runWithName",$reporttemplate,$dataarray);


                $reportname = $this->getSettingValue('pdf_report_name');     

                if(empty($reportname)){ 
                    $reportname = 'report';    
                }
            
                
                $getData =  file_get_contents(urldecode($datax)); 
//             die();
                $this->createFile($getData);
             }
             
            if(file_exists($path)){
//                \File::download($path);    
                header('Content-type: application/pdf');

//            header("Content-disposition: inline;filename={$reportname}.pdf");
                echo file_get_contents(($path)); //$path;
            }
            
            die();
//        }catch(\Exception $ex){
//            
//            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
//            \Response::redirect($this->base);
//        }
    }
    
    function createFile($data = null ,$module = null)  {
        
            if(is_null($data)) return false;
            
             $clear = \Input::get('clear');
             $clear = 1;
            
            $module = $this->modulename;
            
            if(!is_dir(DOCROOT.'/samplefiles'))
                \File::create_dir(DOCROOT, 'samplefiles', 0755);
            
            $path = DOCROOT.'/samplefiles/sample'.$module.'.pdf';
            
            if($clear == 1 && file_exists($path)){
                 \File::delete(DOCROOT.'/samplefiles/sample'.$module.'.pdf'); 
            }
            
            if(!file_exists($path))
                \File::create(DOCROOT.'/samplefiles/', 'sample'.$module.'.pdf',  $data); 
        
            return true;
    }
        
    
    public function action_createAndLoadPDF() {
            
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
            
                                if($this->flowSystem == 1)
                                    $object->flow = 1;
            
                                if($this->auto_numbering == 1)
                                   $object->name = $this->assignNumber();
                                
                                
				if ( $stop==false and $object and $object->save())
				{            
                                    \Response::redirect($redirect."/showDocumentToPdf/{$object->id}"); 
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
        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
              
            $this->template->content =  \View::forge($name.'/create',$html,false);
    }
    
    
    public function post_downloadSampleDocumentToPdf() {
                die();
        try{
            
            $model = $this->model;

            $object = new $model;            
                
            $dataarray = \Input::post();   
            
            
            
//            $properties = $object->GetViewProperties();
//            
//            foreach ($properties as $key=>$prop){
//                $dataarray[$key] = '';
//            }
//             
//            $has_many_relations = $object->GetHasMany();
//               
//              
//            if(is_array($has_many_relations)){
//                foreach ($has_many_relations as $key2=>$relation){
//                     $model = $relation['model_to'];
//                    $objline  = new $model;
//
//                    $lineproperties = $objline->GetViewProperties();
//                    $line = array();
//                    foreach ($lineproperties as $key3=>$prop){
//                        $line[$key3] = '';
//                    }             
//                   
//                    $dataarray[$key2][] = $line; 
//                }
//            }
//            
                
            $reporttemplate = $this->getSettingValue('pdf_template_name');   

            $datax = $this->printReport("https://pdfcreatortest.dira2.co.il/albums/reporter/runWithName",$reporttemplate,$dataarray);
            

            $reportname = $this->getSettingValue('pdf_report_name');     

            if(empty($reportname)){ 
                $reportname = 'report';    
            }
            
            header('Content-type: application/pdf');

            header("Content-disposition: attachment;filename={$reportname}.pdf");
            
            echo file_get_contents(urldecode($datax)); 
            die();
        }catch(\Exception $ex){
            
            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
            \Response::redirect($this->base);
        }
    }
    
    public function action_loadPdf() {
                
        $this->template = \View::forge('dynamicformssystem::systems/enablemodule', $data ); 
   
    }
    
    
    public function assignNumber() {
        $sequence = 0;
                
        $data = Model_Forms::query();

        $data->where("name",$this->modulename);
            
        $info = $data->get_one();

        
        if(!is_object($info)){ 
            $info = new Model_Forms();

            $info->name = $this->modulename; 
        }else{ 
            //Show info
            $inforay = json_decode($info->systemsconfig,true);
        }
        
        if(isset($inforay) &&  is_array($inforay) ){
            if(key_exists('currentsequence', $inforay)){
                $sequence = $inforay['currentsequence'];
            }else{
                //$inforay = array();
               $sequence = $this->currentsequence; 
            }
        }else{
            $inforay = array();
        }

        $inforay['currentsequence'] = $sequence+1; 

        $datap = json_encode($inforay);
        $info->systemsconfig = $datap;
        $info->save(); 
        
        return $sequence;
    }
      
    public function get_formcss() {
    
        $this->format="css";
        $this->response->set_header('Content-Type', 'text/css');
        $string = \View::forge('dynamicformssystem::css/customcss', $html = null);
        
        return  $this->response($string);
    }  
    
    
     
    public function post_jsonFormOrderComplete(){
    
        \Log::warning("Entered base/jsonordercomplete");    
     
        $data = \Input::post(); 
        
        $model = $this->model;
             
        $ord_id = null;
//        $agent_id= $this->assignAgentId();
        $object = null;
            
        if(array_key_exists( 'created_at',$data) && !empty($data['created_at'])){
            $created_at = $data['created_at'];
            $created_at  = str_replace('/', '-', $created_at);
            $created_at = date('Y-m-d H:i:s', strtotime($created_at));
        }
          
        if(array_key_exists( 'draft_id',$data) && !empty($data['draft_id'])){
            $ord_id= $data['draft_id'];
            unset($data['draft_id']);    
        }
      
        if(!is_null($ord_id)){       
            $model = new $model();
            $object = $model::query()->where('id',$ord_id)->get_one();
            
        }
      
        if(!is_object($object)){ 
            $object = new $model();  
        }else{
            $created_at = $object->created_at;
        }
        
        if(is_object($object)){
            
            $has_many_relations = $object->GetHasMany();
              
            if(is_array($has_many_relations)){
                foreach ($has_many_relations as $key=>$relation){

                    $modelline = $relation['model_to'];
                    $defectDelete = $modelline::query()->where('key_to',$ord_id)->get();
                      if(is_array($defectDelete)){
                        array_walk ($defectDelete, function($record){
                            if(is_object($record)) $record->delete();
                        } );

                    }
                    
                    if(key_exists($key, $data)){
                       
                        $line_data = $data[$key];  
                        
                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                            foreach ( $line_data as $line  ){

                                $objline  = new $modelline;
                                $objline->set($line);

                                $object->{$key}[] = $objline;
                            }
                        }
                        unset($data[$key]);    
                    }
                } 
            }         
        }         
        
        $object->set($data);        
            
        $this->mapExtraVariables($object);
            
        
//        $object->agent_id = $agent_id; 
        
        if($object->save()){   
            
            echo $object->id;
        }
 
        exit();       
    }    
    
      
    public function post_jsonOrdercomplete(){
    
        $base = $this->base;
        
        \Log::warning("Entered $base/jsonordercomplete");    
     
        $data = \Input::post(); 
        
        $model = $this->model;
             
        $ord_id = null;
        
        $agent_id= $this->assignAgentId();
        
        $object = null;
          
        if(array_key_exists( 'created_at',$data) && !empty($data['created_at'])){
            $created_at = $data['created_at']; 
            $created_at  = str_replace('/', '-', $created_at);
            $created_at = date('Y-m-d H:i:s', strtotime($created_at));
        }
            
        if(array_key_exists( 'draft_id',$data) && !empty($data['draft_id'])){
            $ord_id= $data['draft_id'];
            unset($data['draft_id']);    
        }
      
        if(!is_null($ord_id)){       
            $model = new $model();
            $object = $model::query()->where('id',$ord_id)->get_one();
            
        }
      
        if(!is_object($object)){ 
            $object = new $model();  
        }else{
            $created_at = $object->created_at;
        }
       
        if(is_object($object)){
            
            $has_many_relations = $object->GetHasMany();
              
            if(is_array($has_many_relations)){
                foreach ($has_many_relations as $key=>$relation){

                    $modelline = $relation['model_to'];
                    $defectDelete = $modelline::query()->where('key_to',$ord_id)->get();
            
                   
                      if(is_array($defectDelete)){
                        array_walk ($defectDelete, function($record){
                             
                           
                 
                            
                            if(is_object($record)) $record->delete();
                        } );

                    }
                    
                    if(key_exists($key, $data)){
                       
                        $line_data = $data[$key];   
                        
                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                            
                            foreach ( $line_data as $line  ){
                                if(!empty($line)){
                                    $objline  = new $modelline;
                                    
                                    $line = $this->getFormattedInputValues($line);
                                    
                                    $objline->set($line);

                                    $object->{$key}[] = $objline;
                                }
                            }
                        }
                        unset($data[$key]);    
                    }
                } 
            }         
        }         
        $data = $this->getFormattedInputValues($data);
        $object->set($data);  
        
        $object->created_at   = $created_at;
                
        $this->mapExtraVariables($object);
         
        if(is_null($ord_id) && empty($object->agent_id))  
            $object->agent_id = $agent_id;  
        
        if($object->save()){   
            
            echo $object->id;
        }
 
        exit();       
    }    
    
    
    /**
     * 
     * @param type $object
     * @return type
     */
    public function mapExtraVariables($object) { 
        
        $object->enabled = 1;
        $object->confirm = 3; //draft
        $object->mobile=1;
        $object->deleted=0;            

        if (isset($object->comment)) {
            $object->comment = $this->convertToUTF8($object->comment);
        }
         

        $object->created_at = $this->formatCreatedDate($object->created_at);
        
        return $object;
    }
    
    /**
     * 
     * @param type $date
     * @return type
     */
    public function formatCreatedDate($date = null) {
        
        $newDate = ''; 
        
        if($date == null || strtotime($date) <= 0){  
            $newDate = date('Y-m-d H:i:s');
        }
        else {
            
            $newDate = date('Y-m-d H:i:s', strtotime($date));
        }
        
        return $newDate;
    }

    public function assignAgentId() {
        
        $agent = $this->getAgent();
        
        if(is_object($agent)){
            return $agent->id;
        }
    }

    public function getAgent() {
        try{
            $auth0 = \Auth::get_user_id();
            $auth = $auth0[1];

            $module = $this->modulename;

            if(class_exists("{$module}\Model_Agents")){
                $model = "{$module}\Model_Agents";
                $queryagent = $model::query();
                $queryagent->where('connect_uid','=',$auth);

                $agent = $queryagent->get_one();
                return $agent;
            }
        }catch(\Exception $ex){
            \Log::error('Exception Occured  '.$ex->getMessage()." at ".$ex->getLine());
        }
    }
    public function action_sendAllPDFEmail($form_id = null) {
            
        if(\Input::method() == 'POST' ){
            
            $record_id = \Input::post('record_id');
            
            $email = \Input::post('email');
          
            if(is_array($email)){
             $email =    implode(',', $email);
            }
            $this->email = $email; 

//            $this->pdfString = $this->generatePDF($record_id);
//
//            $this->pdfString = file_get_contents(urldecode( $this->pdfString));

            
            $this->body = \Uri::base(false)."/$this->base/exportDocumentToPdf/$record_id";

            
//            $this->fileName = $this->getSettingValue('pdf_report_name');     

//            if(empty($this->fileName)){ 
//                $this->fileName = 'report';    
//            } 
  
            $this->sendMail();    
        }        
        
        \Response::redirect('/sendPDFMail/'.$form_id);
    }

     public function get_indexcss() {
    
        $this->format="css";
        $this->response->set_header('Content-Type', 'text/css');
        $string = \View::forge('dynamicformssystem::css/indexcss', $html = null);
        
        return  $this->response($string);
    }     

     public function get_newformcss($var = null) {
    
        if(!is_null($var)){
            $this->format="css";
            $this->response->set_header('Content-Type', 'text/css');
            $string = \View::forge("dynamicformssystem::css/$var", $html = null);

            return  $this->response($string);
        }
    }

    public function setEscapeFunctions() {
        
        if(isset($this->login_escape_functions) && !empty($this->login_escape_functions)){
            
            if(strpos($this->login_escape_functions, ',') > -1){
                
                $function_list = explode(',', $this->login_escape_functions);
                
                if(isset($this->loginArray))
                    array_merge($this->loginArray, $function_list);
                else 
                    $this->loginArray = $function_list;
                
            }else{
                
                if(isset($this->loginArray))
                    $this->loginArray[] = $this->login_escape_functions;
                else
                    $this->loginArray = array($this->login_escape_functions);               
            }
        }
            
    }
    
    
    
        public function action_delete($id = null)
	{
            
                $redirect = $this->base;
                $model = $this->model;
		is_null($id) and \Response::redirect($redirect);

		if ($object =  $model::find($id))
		{
                    \Log::warning('deleted record module '.$redirect.' record: '.json_encode($object));
                    
			$object->delete();

			\Session::set_flash('success', 'Deleted car #'.$id);
		}

		else
		{
			\Session::set_flash('error', 'Could not delete car #'.$id);
		}

		\Response::redirect($redirect.'/listindex');

	}
        
        
    public function action_generatePDFData($id = null ) {        
                
        $object = $this->getObject($id);
        
        $dataarray = $this->mapPDFData($object);
        
        echo json_encode($dataarray);
        
        die();
    }

    public function formViewObject($object = null) {
        
        
        if(is_object($object)){
            
            $object = $this->sortObjectProperty($object);

            $has_many_relations = $object->GetHasMany(); 

            if(is_array($has_many_relations) && count($has_many_relations) > 0){
                
                foreach ($has_many_relations as $key=>$relation){
            
                    
                    foreach ($object->$key as $k=>$line){
                        
                        $line = $this->sortObjectProperty($line);
                        
                        $object->$key[$k] = $line;
                    }

                }
            }
        }
        
        return $object;
    }
                
    public function sortObjectProperty($object = null) { 
            
        if(is_object($object)){ 
            
            $forms = $object->GetPropertiesType();


            foreach($forms as $key=>$value) {

                if($value == 'checkbox-group'){
                    $object->$key= json_decode($object->$key, true); 
                }  
            }
        }
        
        return $object;
    }
    
    
    
    /****
     * methods for website
     * 
     */
    
    public function action_createRecord(){
                        
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
                                
                                $this->uniqueKey = \Input::post('unique_key');
                                 
                                 $draft = $this->getRecordId();
                                 
                                 
                                if(isset($draft) && !empty($draft)){
                                    $object = $model::find($draft);
                                    
                                    if(!is_object($object))
                                          $object = new $model();
                                }
                                
                                $created_at= $object->created_at;
                                
                                $object->set($values);
                
                                
                                $has_many_relations = $object->GetHasMany();
                                
              
                                if(is_array($has_many_relations)){
                                    foreach ($has_many_relations as $key=>$relation){
                                        
                                        $line_data  =\Input::post($key);
            
                                        $model = $relation['model_to'];
                                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                                            foreach ( $line_data as $line  ){
                                                
                                                $objline  = new $model;
                                                $line = $this->getFormattedInputValues($line);
                                                
                                                $objline->set($line);
                                           
                                                $object->{$key}[] = $objline;
                                            }
                                        }
                                    }
                                }
            
                                if($this->flowSystem == 1)
                                    $object->flow = 1;
            
                                if($this->auto_numbering == 1)
                                   $object->name = $this->assignNumber();
                                
                                $object->created_at = $created_at;
                                $object->submitted_date = $this->formatCreatedDate();
                
				if ( $stop==false and $object and $object->save())
				{
                                    \Session::set_flash('success', \Lang::get("message.done.caradd").$object->id.'.');

                                        
                                    $this->postProcessRecord($object);
                                            
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
            $html['jsurl'] = 'jsonWebFormOrderComplete';
            
            $this->setTemplateParams();
            
            $this->setHideLock();
              
        \Session::set('removesubmit',1);
            $this->template->content =  \View::forge($name.'/create',$html,false);
//            $this->template->content = $this->template->content .
//                    \View::forge("$name/loadsign",array("signFile"=>$signaturedata));
            
    }
    
    public function postProcessRecord($object = null ) {
       
        if(is_object($object)){
            if($this->flowSystem == 1){
                echo json_encode( array('flow' => $object->flow,'id' => $object->id));
            }else{
                echo json_encode( array('id' => $object->id));
            }
        }
        
        die();
    }
  
    public function action_postProcessRecord($id = null, $key = null) {
       
        $model = $this->model;
        $this->uniqueKey = $key;
        $draft = $this->getRecordId();
                                 
        if(isset($draft) && !empty($draft)){ 
            $object = $model::find($draft);
                          
            $enableEmail = $this->getSettingValue('enableEmail');


            if( $enableEmail == 1  ){
                $this->sendPDFMailRecord($object->id); 
            }   
        
        }
        
        die();
    }
    
            
    public function action_editRecord($id = null, $key = null)  {
        
        $redirect = $this->base;
            
        $flow = \Input::get('flow');
        if($this->flowSystem == 1 ){
            if($flow == 2 ){
                 \Response::redirect($redirect.'/viewandsignrecord/'.$id);
            }
//            else{
            
//               \Response::redirect($redirect.'/viewandsignrecord/'.$id);
//            }
        }
        
            is_null($id) and \Response::redirect($redirect.'/emptyRedirect');
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
                    \Response::redirect($redirect.'/emptyRedirect');
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

            $stop = false;
              if((property_exists($this,"error") && $this->error == 1))
                     $stop = true;

             $form->add('submit', '',array( 'type' => 'submit', 'value' => \Lang::get('message.save')?\Lang::get('message.save'):'שמור' ,'class'=>'btn btn-primary'));
            if (\Input::method() == 'POST') {

                    $val =  $form->validation();

                    $created_at = $object->created_at ;

                    if ($val->run())
                    { 
                            $values = $this->getFormattedInputValues($val->input()); 

                            $object->set($values); 

            

                            $has_many_relations = $object->GetHasMany(); 

                            if(is_array($has_many_relations)){
                                foreach ($has_many_relations as $key=>$relation){

                                    $line_data  =\Input::post($key);

                                    $model = $relation['model_to'];

                                    $objlinedel  = new $model;

                                    $del = $objlinedel::query()->where('key_to',$object->id)->get();


                                    if(!empty($del) && is_array($del) && count($del) > 0 )

                                        foreach ($del as $dline){
                                            $dline->delete();
                                        }

                                    if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                                        foreach ( $line_data as $line  ){
//                                            
                                            $objline  = new $model;
                                             $line = $this->getFormattedInputValues($line);
                                            $objline->set($line);

                                            $object->{$key}[] = $objline;
                                        }
                                    }
                                }
                            } 
                            
                            $object->created_at = $created_at;
                            if ($stop==false and $object and $object->save())
                            {
                                
                                    \Session::set_flash('success', \Lang::get("edit complete for this").$object->id.'.');

                                    \Response::redirect($redirect.'/emptyRedirect');
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
        $html['base'] = $this->base;
        $html['filepath'] = $this->filepath;
        $html['folder'] = $this->modulename;
        
        $this->setTemplateParams();
        
        $this->setHideLock();
        
            $name = $this->filepath; 
            $html['base'] = $this->base;
            $html['filepath'] = $this->filepath;
            $html['folder'] = $this->modulename;
            $html['jsurl'] = 'jsonWebFormOrderComplete';
            
            $this->setTemplateParams();
            
            $this->setHideLock();
              
        \Session::set('removesubmit',1);
        \Session::set('removesubmit',1);
        $name = $this->filepath;
         $this->template->order =  $object;
         $this->template->editWebsiteRecord =  1;
//        $this->template->content =  \View::forge($name.'/edit',$html,false);
        $this->template->content =  \View::forge($name.'/create',$html,false);
    }
        
    public function post_jsonWebFormOrderComplete(){
   

        \Log::warning("Entered base/jsonWebFormOrderComplete");    
     
        $data = \Input::post(); 
        
        $model = $this->model;
             
        $this->format ='json';
        
        $ord_id = null;
        

        $object = null;
        $flag = 0;
            
        if(array_key_exists( 'created_at',$data) && !empty($data['created_at'])){
            $created_at = $data['created_at'];
            $created_at  = str_replace('/', '-', $created_at);
            $created_at = date('Y-m-d H:i:s', strtotime($created_at));
        }
            

        if(array_key_exists( 'unique_id',$data) && !empty($data['unique_id'])
                && array_key_exists( 'draft_id',$data) && !empty($data['draft_id'])
                ){
            
            $flag = 1;
            $this->uniqueKey = $data['unique_id'];
             $ord_id = $data['draft_id'];
             
            $objectrecord = $this->getRecord($ord_id);
            
            unset($data['draft_id']);    
            unset($data['unique_id']);   
            
            if(is_object($objectrecord)){ 
                
                $object = $model::find($ord_id);
                    if(is_object($object)){ 
                       $created_at = $object->created_at;
                   }else{
                       //return "Invalid Key";
                       return $this->response( "Record does not exist");
                   }
               }else{
                   //return "Invalid Key";
                   return $this->response( "Invalid Key");
               }
            
        }else{
            $object = new $model();  
        }
            
        
        if(is_object($object)){
            
            $has_many_relations = $object->GetHasMany();
              
            if(is_array($has_many_relations)){
                foreach ($has_many_relations as $key=>$relation){

                    $modelline = $relation['model_to'];
                    $defectDelete = $modelline::query()->where('key_to',$ord_id)->get();
                      if(is_array($defectDelete)){
                        array_walk ($defectDelete, function($record){
                            if(is_object($record)) $record->delete();
                        } );

                    }
                    
                    if(key_exists($key, $data)){
                       
                        $line_data = $data[$key];  
                        
                        if(!empty($line_data) && is_array($line_data) && count($line_data) > 0 ){
                            foreach ( $line_data as $line  ){

                                $objline  = new $modelline;
                                $objline->set($line);

                                $object->{$key}[] = $objline;
                            }
                        }
                        unset($data[$key]);    
                    }
                } 
            }         
        }         
        
        $object->set($data);        
            
        $this->mapExtraVariables($object);
            
        
        if($object->save()){   
            
            $ukey = $this->generateUniqueKey($object->id);
            
            return $this->response( 
                        array(  
                                'id'=> $object->id, 
                                'uniqueid' => $ukey,
                                'flow' => $object->flow
                            ));
        }else{
            return $this->response( "Save Faild");
        }
 
//        exit();       
    }

    public function action_exportWebDocumentToPdf($id = null) {
                
        try{ 
                
                
            $clear = \Input::get('clear');
            
            $module = $this->modulename;
//             $path = DOCROOT."/$module/".$module.$this->uniqueKey.'.pdf';
             $path = DOCROOT."/$module/".$module.$id.'.pdf';
//             $flag= 0;
             $flag= 1;
             
             if(file_exists($path) && $clear == 1 ){
               
                $flag= 1;
             
             }else{  
                 if(!file_exists($path)){ 
                      $flag= 1;
                 }
             }
            
             if($flag == 1 ){
                //$id = $this->getRecordId($key);

                //$data_return = $this->getPdfInStringUsingId($id);//$this->generatePDF($id);

                $reportname = $this->getSettingValue('pdf_report_name');     

                if(empty($reportname)){ 
                    $reportname = 'report';    
                }
                

                $getData = $this->getPdfInStringUsingId($id);//  file_get_contents(urldecode($data_return)); 
                 
                $this->createRecordFile($getData,$id);
            }
             
            if(file_exists($path)){
                \File::download($path);     
            }
            
            die(); 
            
             
        }catch(\Exception $ex){
            
            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
            \Response::redirect($this->base);
        }
    }
    
    public function action_showWebDocumentToPdf($id = null) {
                
        try{
            
            $clear = \Input::get('clear');
            
            $module = $this->modulename;
             $path = DOCROOT."/$module/".$module.$id.'.pdf';
//             $flag= 0;
             $flag= 1;
             
             if(file_exists($path) && $clear == 1 ){
               
                $flag= 1;
             
             }else{  
                 if(!file_exists($path)){ 
                      $flag= 1;
                 }
             }
            
             if($flag == 1 ){ 

                //$data_return = $this->generatePDF($id);

                $reportname = $this->getSettingValue('pdf_report_name');     

                if(empty($reportname)){ 
                    $reportname = 'report';    
                }
            
            
                 $getData = $this->getPdfInStringUsingId($id);//  file_get_contents(urldecode($data_return)); 
//                 die();
                $this->createRecordFile($getData,$id);
             }
             
            if(file_exists($path)){ 
                header('Content-type: application/pdf');
            
                echo file_get_contents(($path)); 
            }
            
            die();
            
        }catch(\Exception $ex){
            
            \Log::error('Form System Exception Occured : '.$ex->getMessage().' at '.$ex->getLine());
            \Response::redirect($this->base);
        }
    }
    
    public function action_emptyRedirect() {
        die();
    }
    
//    
    public function get_jsonSearchData() {
        
        
        $this->jsonSearchData();
//        die();
    }
    
    public function post_jsonSearchData() {
        
        $this->jsonSearchData();
//        die();
        
    }
    public function jsonSearchData() {
        
        $this->format="json";
        $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]); 
        
        $result = array();
            
            
            $ids = \Input::post('ids','');
            $search_value = \Input::post('search_value','');
            $created_from = \Input::post('created_from','');
            $created_to = \Input::post('created_to','');
            
            if(!empty($search_value)){
                
                $model = $this->model;
            
                $query = $model::query();

                $props = $this->getProps();

                $query->where_open();
                if(is_array($props) && count($props) > 0){
                    foreach ($props as $key){

                        $query->or_where($key,'like',"%$search_value");
                        $query->or_where($key,'like',"%$search_value%");
                        $query->or_where($key,'like',"$search_value%");
                    }
                }
                $query->where_close();

                if(isset($created_from) && !empty($created_from)){

                    if(strpos($created_from, '/') != false){
                        $created_from = str_replace('/', '-', $created_from);
                    }

                    $created_from = date ("Y-m-d",strtotime(date($created_from)));

                    $query->where('created_at','>=',$created_from);
                }

                if(isset($created_to) && !empty($created_to)){

                    if(strpos($created_to, '/') != false){
                        $created_to = str_replace('/', '-', $created_to);
                    }

                    $created_to = date ("Y-m-d",strtotime(date($created_to))+3600*24);

                    $query->where('created_at','<',$created_to);
                }

                if(isset($ids) && !empty($ids)){

                    if(is_array($ids))
                        $query->where('id','in',$ids);
                    else
                        $query->where('id',$ids);                    
                }

                $data = $query->get();
               
                $module = $this->modulename;
               
                if(isset($data) && count($data) > 0){
                   
                    $listview = array();
                    if(key_exists(0, $data))
                        $listview = $data[0]->GetListViewRelations(); 
                   
                    foreach ($data as $dat){
                        $temp = array();
                        foreach ($dat as $k=>$d){
                            $trans = \Lang::get("label.$module.$k")?\Lang::get("label.$module.$k"):"";
                            
                            $type = $dat->GetPropertiesType($k);
                            
                            $temp[$k] = array($d, $trans, $type);
                            
                        }
                        
                        
                        $has_many_relations = $dat->GetHasMany();


                        if(is_array($has_many_relations)){
                            foreach ($has_many_relations as $key=>$relation){
                                
                                if(isset($dat->$key) && count($dat->$key)  > 0){
                                    
                                    foreach ($dat->$key as $rel){
                                        $temprel = array();
                                        foreach ($rel as $k1=>$d1){  
                                            $trans = \Lang::get("label.$module.$k1")?\Lang::get("label.$module.$k1"):"";

                                            $type = $dat->GetPropertiesType($k);
                            
                                            $temprel[$k1] = array($d1, $trans,$type);

                                        }
                                       
                                        $temp[$key][] =  $temprel;
                                    }
                                }
                            }
                        }
                                        
                        
                        
                        $result[] = $temp;
                    }
                   
                }
            }
            
        return  $this->response($result); 
            
    }
    
//    
//    public function get_jsonSearchFieldData() {
//        
//        
//        $this->jsonSearchFieldData();
////        die();
//    }
    
    public function post_jsonSearchFieldData() {
        
        $this->jsonSearchFieldData();
//        die();
        
    }
    /***
     * 
     * test string 
     * http://192.168.0.111/ibsvaukjgz/ibsvaukjgzs/jsonSearchFieldData?search_from=2019-11-01%2000:00:00&search_to=2019-11-14%2000:00:00&search_field=created_at
     * 
     * 
     */
    public function jsonSearchFieldData() {
        
        $this->format="json";
        $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]); 
        
        $result = array();
            
            
            $ids = \Input::post('ids','');
            $search_field = \Input::post('search_field','');
            $search_value = \Input::post('search_value','');
            $search_type = \Input::post('search_type','');
            $search_from = \Input::post('search_from','');
            $search_to = \Input::post('search_to','');
            
            if(!empty($search_field)){
                
                $model = $this->model;
            
                $query = $model::query();
            
                $typelist = array('select','checkbox-group','radio-group');

                if(!empty($search_type) && in_array($search_type, $typelist)){
                    
                    $query->or_where($search_field,$search_value);
                    
                }else{
                    if(!empty($search_value)){
                        $query->where_open();

                            $query->or_where($search_field,'like',"%$search_value");
                            $query->or_where($search_field,'like',"%$search_value%");
                            $query->or_where($search_field,'like',"$search_value%"); 

                        $query->where_close();
                    }
                }

                if(isset($search_from) && !empty($search_from)){

                    $query->where($search_field,'>=',$search_from);
                }

                if(isset($search_to) && !empty($search_to)){

                    $query->where($search_field,'<=',$search_to);
                }

                if(isset($ids) && !empty($ids)){

                    if(is_array($ids))
                        $query->where('id','in',$ids);
                    else
                        $query->where('id',$ids);                    
                }

                $data = $query->get();
               
                $module = $this->modulename;
               
                if(isset($data) && count($data) > 0){
                   
                    $listview = array();
                    if(key_exists(0, $data))
                        $listview = $data[0]->GetListViewRelations(); 
                   
                    foreach ($data as $dat){
                        $temp = array();
                        foreach ($dat as $k=>$d){
                            $trans = \Lang::get("label.$module.$k")?\Lang::get("label.$module.$k"):"";
                            
//                            $type = $dat->GetPropertiesType($k);
                            
                            $temp[$k] = array($d, $trans);
                            
                        }
                        
                        
                        $has_many_relations = $dat->GetHasMany();


                        if(is_array($has_many_relations)){
                            foreach ($has_many_relations as $key=>$relation){
                                
                                if(isset($dat->$key) && count($dat->$key)  > 0){
                                    
                                    foreach ($dat->$key as $rel){
                                        $temprel = array();
                                        foreach ($rel as $k1=>$d1){  
                                            $trans = \Lang::get("label.$module.$k1")?\Lang::get("label.$module.$k1"):"";

//                                            $type = $dat->GetPropertiesType($k);
                            
                                            $temprel[$k1] = array($d1, $trans);

                                        }
                                       
                                        $temp[$key][] =  $temprel;
                                    }
                                }
                            }
                        }
                                        
                        
                        
                        $result[] = $temp;
                    }
                   
                }
            }
            
        return  $this->response($result); 
            
    }
    
//    
    public function get_jsonSearchFields() {
        
        
        $this->jsonSearchFields();
//        die();
    }
    
    public function post_jsonSearchFields() {
        
        $this->jsonSearchFields();
//        die();
        
    }
    public function jsonSearchFields() {
        /**
         * 
         * first sedn field and data type
         * 
         * then based on search value send data in next function call
         */
        $this->format="json";
        $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]); 
        
        $result = $this->getPropsWithTypes(); 
        
        return  $this->response($result); 
            
    }
    

    public function validateKeyAuthentication() {
         
        $request = \Request::active();
        
        $params = $request->route->method_params;
        $action = $request->action;
        $flag = '';
           
        if(in_array($action, $this->websiteMethods)){
            $flag = 1;
            if(isset($params) && is_array($params) && key_exists('0', $params) 
                    && key_exists('1', $params)){ 
                $this->uniqueKey = $params[1];

                $record_id = $params[0];

                $record = $this->getRecord($record_id);
               
                if(is_object($record)){
                    $this->loginArray[] = $action;
                    $flag = 0;
                }            
            }else{
                 if(in_array($action, $this->websiteJsonMethods)){
                      $flag = 0;
                 }
            }  
        }   
//        if($flag == 1 && is_array($this->loginArray)){
        if($flag == 1  ){
            $arkey = array_search($action, $this->loginArray);
//            
            unset($this->loginArray[$arkey]);
//                   echo $flag; die();
//            die();
            \Response::redirect($this->base.'/emptyRedirect');
        } 
    }

    public function getRecordId() {
        
        $model = '\dynamicformssystem\Model_Websitekeys';
        $id = null;
        
        if(!empty($this->uniqueKey)){
            $object  = $model::query()->where('uniquekey', $this->uniqueKey)->get_one();

            if (is_object($object)) {
                $id = $object->record_id;
            }
        }
        
        return $id;
         
    }

    public function generateUniqueKey($id =null) {
        
        $model = '\dynamicformssystem\Model_Websitekeys';
        
        $object = $model::query()->where('record_id',$id)
                ->where('modulename',$this->modulename)->get_one();
        
        if(!is_object($object)) {           
            $object = new $model; 
            
            $object->record_id = $id;
            $object->uniquekey = $this->generateUniqueCode();
            $object->modulename  = $this->modulename;

            $object->save();
        }
        
        return $object->uniquekey;        
    }

    public function getRecord($record_id = null) {
          
        $model = '\dynamicformssystem\Model_Websitekeys';
        $object = '';
       
        if(!empty($this->uniqueKey)){
            
            
            $object  = $model::query()->where('record_id',$record_id)
                    ->where('uniquekey', $this->uniqueKey)->get_one();
        }
        
        return $object;
    }

    public function generateUniqueCode($length = 6) {
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    public function setHideLock() {        
        
        $locked=\Input::get('locked',0);

        $hidebar=\Input::get('hidebar',0);
         $signatureFile=\Input::get('signatureFile',0);
          \Session::set('signatureFile',$signatureFile);
        \Session::set('locked',$locked);
        \Session::set('hidebar',$hidebar);
    }

    public function setTemplateParams() {
        
        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
        $this->template->color_scheme = $this->color_scheme;
        $this->template->logo_width = $this->logo_width;
        $this->template->logo_height = $this->logo_height;
        $this->template->logo_position = $this->logo_position;
        $this->template->logo_portrait_mode = $this->logo_portrait_mode;
        $this->template->whatsapp_image = $this->whatsapp_image;
        $this->template->whatsapp_title = $this->whatsapp_title;
        $this->template->whatsapp_description = $this->whatsapp_description;
    }
    
    public function createRecordFile($data = null ,$id = null)  {
        
            if(is_null($data)) return false;
            
             $clear = \Input::get('clear');
             $clear = 1;
            
            $module = $this->modulename;
            
            if(!is_dir(DOCROOT."/$module"))
                \File::create_dir(DOCROOT, "$module", 0755);
            
            $path = DOCROOT."/$module/".$module.$id.'.pdf';
            if($clear == 1 && file_exists($path)){
                 \File::delete(DOCROOT."/$module/".$module.$id.'.pdf'); 
            }
            
            if(!file_exists($path))
                \File::create(DOCROOT."/$module/", ''.$module.$id.'.pdf',  $data); 
        
            return true;
    }
        
        
    public function action_createModule($module = null) {
        
        $this->modulename = $module;

        $this->createNewModule();
         
    }

    public function createNewModule() {
        
        $module = $this->modulename;
        $url = "http://192.168.0.111/dynamicformssystem/forms/downloadModule/$module";
        $domain = "http://192.168.0.111/";
//        $url = "https://carmel-general-forms.dira2.co.il/dynamicformssystem/forms/downloadModule/$module";
//        $domain = "http://carmel-general-forms.dira2.co.il/";
        
        $ch = curl_init(); 
        
        $curl_options= array( CURLOPT_POST => 1,
//                                    CURLOPT_POSTFIELDS => "email=shyam@shyamjoshi.in&password=ricca8259",
                                    CURLOPT_POSTFIELDS => "email=namrata&password=password",
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_COOKIEJAR => "cookie.txt",
                                    CURLOPT_URL => $domain,
                                  );
        
        $this->makeCurlCall($ch,$curl_options);
                     
        $curl_options= array(   CURLOPT_POST => 1,
                                CURLOPT_RETURNTRANSFER => true,   
                                CURLOPT_COOKIEJAR => "cookie.txt",               
                                CURLOPT_URL => $url,
                            );             
        
        curl_setopt_array($ch, $curl_options);
        
        $this->makeCurlCall($ch,$curl_options);
        
        curl_close($ch);
        
        $this->saveZipFile();
        $this->extractZipFile();
    }
    
    public function extractZipFile() {
        
        $module = $this->modulename;      
        $folder = "$module".'rrrrrr';   
        $filename = $module.".zip";
        $output_filename = "downloadedmodules/$filename";
          

        $path = APPPATH."modules/dynamicformssystem/modules/$folder";
         
        @mkdir($path);
        chmod($path, 0777);  
        
        $zip = new \ZipArchive;
        print_r($zip->open($output_filename)); die();
       
        if ($zip->open($output_filename) === TRUE) {
            $zip->extractTo($path);
            $zip->close();
            echo "Module $module Created";
        } else {
            echo "Module $module Creation Failed";
        }  
        
        die();
    }
    
    public function saveZipFile() {
        
        $module = $this->modulename;
        
        $rootpath = DOCROOT.'downloadedmodules';
        
        if(!is_dir($rootpath))
            @mkdir('downloadedmodules');
        
        $filename = $module.".zip";
        
        $output_filename = DOCROOT."downloadedmodules/$filename";
        $zip = new \ZipArchive;
           
        $zip -> open($output_filename, \ZipArchive::CREATE );
//         $zip->close();
    // the following lines write the contents to a file in the same directory (provided permissions etc)
        $fp = fopen($output_filename, 'w+');
        fputs($fp, $this->curlOutput);
        fclose($fp);        
        chmod($output_filename, 0777); 
        ob_end_clean(); 
    }
    
    public function makeCurlCall($ch,$curl_options) {
      
        try{ 
            
            curl_setopt_array($ch, $curl_options);
            $this->curlOutput = curl_exec($ch);
            
        } catch (\Exception $e){
            
              \Log::warning("url exception: ".$e->getMessage());
        }
            
    }
    
    public function validateModule() {
        
        $regenerate = \Input::get('regenerate');
            
        if($regenerate == 1){
        
            $module = $this->modulename;

            $path = APPPATH."modules/dynamicformssytem/modules/$module";

            if(!is_dir($path)){

                $this->createNewModule();
            }  
        }
    }

    public function getProps() {
        
        $model = $this->model;           
            
        $object = new $model;

        $props = $object->GetProperties();

        if(key_exists('created_at', $props))
                unset($props['created_at']);

        if(key_exists('id', $props))
                unset($props['id']);

        $prop_keys = array_keys($props);
        
        return $prop_keys;
    }

    public function getPropsWithTypes() {
        
        $model = $this->model;           
            
        $object = new $model;

        $props = $object->GetProperties();
        
        $module = $this->modulename;

        if(key_exists('created_at', $props))
                unset($props['created_at']);

        if(key_exists('id', $props))
                unset($props['id']);

        $prop_keys = array_keys($props);
        $proplist = array();
        foreach ($prop_keys as $prop){
            
            $type = $object->GetPropertiesType($prop);
            $data = $object->GetPropertiesData($prop,$type);
            
             $trans = \Lang::get("label.$module.$prop")?\Lang::get("label.$module.$prop"):"";

//                                            $type = $dat->GetPropertiesType($k);
                            
            
           $proplist[$prop] =  array( 'type'=> $type, 'data'=> $data,'label'=> $trans);
            
        }
        
        return $proplist;
    }
    
    
    public function validateAgent() {
        
        $base = $this->base;
        
        $agent = $this->getAgent();
        
        if(is_object($agent) && isset($agent->disableindex) && $agent->disableindex == 1){
            
            \Response::redirect("/$base/create");            
        }
    }

    public function getOptions(){
                      
        $model = $this->model;
        
        $objects = $model::query()->get_array();
        
        return $objects;
        
    }
    public function get_listoptions(){
        
        $this->format = 'json';
        
        $model = $this->model;
        
        $objects = $model::query()->get_array();
        
        
         return  $this->response($objects);
    }
    
    
    public function action_exportCSVData(){
        
        $model = $this->model;
        $modulename = $this->modulename;
        
        $object = new $model;
        
        $properties = $object->getProperties();
        
         $has_many_relations = $object->GetHasMany();
        $relationkeys = array();      
        if(is_array($has_many_relations)){
            foreach ($has_many_relations as $key=>$relation){
                
                $model = $relation['model_to'];
                $relationkeys[] = $key;
                $objline  = new $model;  
                
                $propertiesline = $objline->getProperties();
                
                $properties = array_merge($properties, $propertiesline);
            }
        }
        
        $query = $this->query;
        
        $data = $query->get();
        
        $object = $model::query()->get_one();
        
        $form = Model_Forms::query()->where('name',$modulename)->get_one();

        $csvproperties = array();
        
        if(is_object($form)){
            $csvproperties = json_decode($form->csvproperties,true);
        }
        $csv = array();
        if(!empty($csvproperties) && count($csvproperties) > 0){
            
            if(isset($properties) && count($properties) > 0){  
                foreach($properties as $key=>$prop){ 
                    
                    if(!key_exists($key, $csvproperties))
                            unset($properties[$key]);
                }
            }
            
        }
            
        \Package::load("excel");

        $objPHPExcel = new \PHPExcel();

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007"); 

        $alphabet = 'A';
        $count = 1;

        if(isset($properties) && count($properties) > 0){  
            foreach($properties as $key=>$prop){ 
                
//                if(isset($object->$key)){
                    $label =key_exists('label',$prop)?$prop['label']:"";

                    $objPHPExcel->getActiveSheet()->setCellValue($alphabet.$count, \Lang::get($label)?\Lang::get($label):"" );

                    $alphabet++;
//                }
            }
        }
        $count++;


        if(isset($data) && count($data) > 0){  
            foreach($data as $key=>$dat){ 

                
                if(count($relationkeys) > 0){
                    
                    foreach($relationkeys as $rkey){
                        
                        if(isset($dat->$rkey) && count($dat->$rkey) > 0 ){
                            
                            foreach($dat->$rkey as $linekey){
                                
                                 if(isset($properties) && count($properties) > 0){  
                                    foreach($properties as $key=>$prop){
                                        
                                        if(isset($dat->$key))
                                            $objPHPExcel->getActiveSheet()->setCellValue($alphabet.$count, $dat->$key );
                                        else{
                                            $objPHPExcel->getActiveSheet()->setCellValue($alphabet.$count, $linekey->$key );
                                       
                                        }
                                            $alphabet++;

                                    }
                                }
                                $count++;
                            }
                            
                            
                        }else{
                            
                            $alphabet = 'A';

                            if(isset($properties) && count($properties) > 0){  
                                foreach($properties as $key=>$prop){
                                   
                                    if(isset($dat->$key)){
                                        
                                        $type = $dat->GetPropertiesType($key);
                                        
                                        if(  in_array($type,array('checkbox-group','radio-group','select')) ){

                                                $datval = json_decode($dat->$key, true); 

                                                if(is_array($datval)){
                                                    $tempx = array();
                                                    $tempxy = '';
                                                    foreach($datval as $dv){

                                                       $tempxz =   $dat->GetPropertiesMapData($key, $dv);
                                                       $tempx[$dv] =  $tempxz;
                                                       $tempxy .= $dv.':'.$tempxz.',';
                //                                       $tempx[$dv] =  iconv('UTF-8','Windows-1255',$dat->GetPropertiesMapData($key, $dv));
                                                    } 
                //                                    $dat->$key = $tempx;
                //                                    $dat->$key = json_encode($tempx,true);
                                                    $dat->$key = $tempxy;
                //                                    print_r($dat->$key); die();
                                            }else{
                                                $dat->$key =  $dat->GetPropertiesMapData($key, $dat->$key);
                                            }
            
                                        }
                                        
                                        $objPHPExcel->getActiveSheet()->setCellValue($alphabet.$count, $dat->$key );
                                    }else{
                                            $objPHPExcel->getActiveSheet()->setCellValue($alphabet.$count, '' );
                                       
                                        }
                                        
                                    $alphabet++;

                                }
                            }
                            $count++;
                            
                        }
                        
                    }
                    
                    
                }else{
                
                    $alphabet = 'A';

                    if(isset($properties) && count($properties) > 0){  
                        foreach($properties as $key=>$prop){
                            
                            
                             $type = $dat->GetPropertiesType($key);
                                        
                            if(  in_array($type,array('checkbox-group','radio-group','select')) ){

                                $datval = json_decode($dat->$key, true); 

                                if(is_array($datval)){
                                    $tempx = array();
                                    $tempxy = '';
                                    foreach($datval as $dv){

                                       $tempxz =   $dat->GetPropertiesMapData($key, $dv);
                                       $tempx[$dv] =  $tempxz;
                                        $tempxy .= $dv.':'.$tempxz.',';
//                                       $tempx[$dv] =  iconv('UTF-8','Windows-1255',$dat->GetPropertiesMapData($key, $dv));
                                    } 
//                                    $dat->$key = $tempx;
//                                    $dat->$key = json_encode($tempx,true);
                                    $dat->$key = $tempxy;
//                                    print_r($dat->$key); die();
                                }else{
                                    $dat->$key =  $dat->GetPropertiesMapData($key, $dat->$key);
                                }

                            }                                     
                            $objPHPExcel->getActiveSheet()->setCellValue($alphabet.$count, $dat->$key );

                            $alphabet++;

                        }
                    }
                    $count++;
                }

            }
        }
            
       
        
        $filename = 'export.xls';
            
        $objWriter->save($filename); 
         
        if(file_exists($filename))
            \File::download($filename);  
        
        die();
//        csvproperties
        
    }
    
    public function action_setExportCSVFields(){
        
        $model = $this->model;
        $modulename = $this->modulename;
        
        $object = new $model;
        
        $properties = $object->getProperties();
                
        $has_many_relations = $object->GetHasMany();
              
        if(is_array($has_many_relations)){
            foreach ($has_many_relations as $key=>$relation){
                
                $model = $relation['model_to'];
                
                $objline  = new $model;
                
                $propertiesline = $objline->getProperties();
                
                $properties = array_merge($properties, $propertiesline);
            }
        }
//        print_r($properties);die();
        $data['properties'] = $properties;
        
        if(\Input::method() == 'POST'){ 
            $csvdata = \Input::post(); 
            
            $form = Model_Forms::query()->where('name',$modulename)->get_one();

            if(is_object($form)){
               $form->csvproperties = json_encode($csvdata); 
               $form->save();
               
            }  
            
            
            
            \Response::redirect($this->base.'/setExportCSVFields');
        }
        
        $form = Model_Forms::query()->where('name',$modulename)->get_one();

        if(is_object($form)){
            $data['csvproperties'] = json_decode($form->csvproperties,true);
        }
        
        $this->template->content = \View::forge('dynamicformssystem::forms/setexportcsv',$data);
        
        
    }
    
    public function action_addMenuLinks(){
 
        $data = null;
                
        $this->template->content = \View::forge('dynamicformssystem::systems/addmenulinks', $data ); 
           
    }
    
    public function post_addMenuLinks(){
        
        
        
        
    }
    
    public function checkFormExpiry(){
        $expired = 0;
        
        if(isset($this->enableExpire) && $this->enableExpire == 1 ){
            
            $todayDate = date('Y-m-d');
           
            if(isset($this->expiryDate) && !empty($this->expiryDate) && $todayDate > $this->expiryDate ){
                $expired = 1;
            
            }else{
//                $this->formCreatedDate
                
                if(!empty($this->formCreatedDate)){
                    $dateto= date('Y-m-d', strtotime('next Year' , 
                                        strtotime($this->formCreatedDate)));

                    if(  $todayDate > $dateto ){
                        $expired = 1;
                    }
                }
            }
            
        }
            
        
        if($expired == 1){
            
            $data['expiryMessage'] = $this->expiryMessage; 
            
            $this->template  = \View::forge('dynamicformssystem::systems/expiry', $data);
            
        }
    }
    
    function get_responsive(){
    
            $this->format="css";
            $this->response->set_header('Content-Type', 'css');
            
            $string = \View::forge('dynamicformssystem::css/responsive', $html = null);
            return  $this->response($string);
    } 

function getPdfInStringUsingId($id){
	$pdfID = $this->generatePDF($id);
	$pdfString = "";
	if(!empty($pdfID)) $pdfString = file_get_contents(urldecode($pdfID));
	return $pdfString;
} 

function showSecureDocumentToPdf($id){
    if(\Config::get('pdfsign')==1){
	      $pdfString = $this->generateSecurePDF($id);
	      $url = str_replace(DOCROOT,"",$pdfString);
	      \Response::redirect($url);
              die();
 	}
}

function generateSecurePDF($id){
	     \Package::load('Pdfsign');
             $pdfString = $this->getPdfInStringUsingId($id);
             $x = new \Pdfsign\Seta();
             $pathPDF = DOCROOT.DIRECTORY_SEPARATOR."pdfs".DIRECTORY_SEPARATOR;
             $pathPDF = $pathPDF.uniqid().".pdf";
             $pdfString=    $x->signDocument($pdfString,$pathPDF);
	     return $pdfString;
}


function exportSecureDocumentToPdf($id){
$pdfString = $this->generateSecurePDF($id);
$url = str_replace(DOCROOT,"",$pdfString);
\File::download($pdfString);
die();

}

}

    
