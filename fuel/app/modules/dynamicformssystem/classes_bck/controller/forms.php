<?php

namespace dynamicformssystem;

class Controller_Forms extends \Controller_Base{
    
    public $model = '\dynamicformssystem\Model_Forms';
    public $base = 'dynamicformssystem/forms';
    public $forId;
    
    
    private $postDataReceivedFields = array(    'json_data' => 'json_data', 
                                                'logo' => 'logo', 
                                                'enableAuthentication' => 'login',
                                                'logo_id' => 'logo', 
                                                'flowType' => 'flowType', 
                                                'flowSystem' => 'flowSystem', 
                                                'formtype' => 'formtype', 
                                                'backgroundimage' => 'backgroundimage', 
                                                'backgroundimage_id' => 'backgroundimage', 
                                                'backgroundimg' => 'backgroundimage', 
                                                'email' => 'emailing', 
                                                'form_title' => 'form_title', 
                                                'color_scheme' => 'color_scheme', 
                                                'logo_position' => 'logo_position', 
                                                'logo_height' => 'logo_height', 
                                                'logo_width' => 'logo_width', 
                                                'shorten_url' => 'shorten_url', 
                                                'bity_api_key' => 'bity_api_key', 
                                                'formId' => 'formId', 
                                                'pdf_creator' => 'pdf_creator', 
                                                'send_pdfmail' => 'send_pdfmail', 
                                                'pdf_mode' => 'pdf_mode',  
                                                'pdf_template_name' => 'pdf_template_name',  
                                                'pdf_report_name' => 'pdf_report_name',  
                                                'login' => 'login',  
                                                'loginMethods' => 'loginMethods',  
                                                'view_type' => 'view_type',  
                                                'autosave' => 'autosave',  
                                                'show_last_draft' => 'show_last_draft',  
                                                'showcreatedonindex' => 'showcreatedonindex',  
                                                'arrangebycreated' => 'arrangebycreated',  
                                                'showagentonindex' => 'showagentonindex',  
                                                'showeditbtnonindex' => 'showeditbtnonindex',  
                                                'showdeletebtnonindex' => 'showdeletebtnonindex',  
                                                'createddatefilter' => 'createddatefilter',  
                                                'auto_numbering' => 'auto_numbering',  
                                                'showautonumberingonindex' => 'showautonumberingonindex',  
                                                'whatsapp_image' => 'whatsapp_image',  
                                                'whatsapp_description' => 'whatsapp_description',  
                                                'whatsapp_title' => 'whatsapp_title',  
                                                'removesalessoftbar' => 'removesalessoftbar',  
                                                'disablerequirednextfield' => 'disablerequirednextfield',  
                                                'enableExportCSV' => 'enableExportCSV',  
                                                'enableMultiMenu' => 'enableMultiMenu',  
                                                'enableExpire' => 'enableExpire',  
                                                'expiryDate' => 'expiryDate',  
                                                'expiryMessage' => 'expiryMessage',  
                                                'formCreatedDate' => 'formCreatedDate',  
                                                'logo_portrait_mode' => 'logo_portrait_mode',  
                                                'logo_width' => 'logo_width',  
                                                'logo_height' => 'logo_height',  
                                                'pdf_mode_flow2' => 'pdf_mode_flow2',  
                                                'showMessageBeforePDFflow2' => 'showMessageBeforePDFflow2',  
//                                                'menuList' => 'menuList',  
                                    );
    private $systemsconfig = '';
    
    private $count = 0;
    
    private $listviewLimit= 5;
    
    private $sections = array();    
    
    private $type = '';
    
    private $viewType = '';
    
    private $filedata = '';
    
    private $basepath = '';
    
    private $fields = null;
 
    private $filename = null;
    
    private $controller = null;
    
    private $file = null;
    
    private $PDFXY = null;
    
    private $defaultProperties = array('id','name','agent_id', 'mobile', 'flow','key_to', 'confirm', 'deleted', 'submitted_date', 'submittedupdate_date', 'created_at', 'updated_at', 'create_uid', 'update_uid');
        
    private $fieldtypes = array('radio-group','time', 'autocomplete' , 'checkbox-group' , 'select','canvas', 'date', 'file', 'text', 'textarea','bankdetails','editabletext');
   
    private $module_path = '';
    
    private $chmod = 0777;
    
    private $fileExtension = '.php';
    
    private $translation = '';
    
    private $varcharlimit = '140';
    
    private $varcharFields = array('text','date','file','select','hidden');
    
    private $textFields = array('textarea', 'checkbox-group','checkbox','radio');
    
    private $longtextFields = array('longtext');
    
    private $properties = '';
    
    private $redirectUrl = '/dynamicformssystem/forms/create';
    
//    private $mainModulePath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules';                
    
    public $hasMany = 2; 
    
    public $hasManyCounter = 1;
    
    public $hasManyRelation = '';
    
    public $hasOneRelation = '';    
    
    public $printHasMany = 0;
    
    public $filenamespace = '';
    
    public $cloneData = array();
    
    private $maxOldForms = 3;
    private $showEditData = 0;
    private $noListView = 0;
    public $modelProperties = array();
    private $separators = array();
    
    private $fielddatareceived = array();
    private $hasManyData = 0;
    private $json = 0;
    private $minYearValue = 1940;
    private $original_title;
    private $controllerName = '';
    private $tempcount = 0;
    private $form_title_eng = '';
    private $filenamehasmanylang = '';

    /**
     * Form Design View
     */
    public function action_create() {
        
        $this->template = \View::forge('forms/create',$data = null);
    }
    
    /**
     * Form Design View
     */
    public function action_edit($id = null) {
        
        $model = $this->model;
        
        $data['object'] = $model::find($id);
        $data['settings'] = json_decode( $data['object']->systemsconfig, true);
                
        $this->template = \View::forge('forms/create',$data );
    }
    
    public function action_index() {
        
        $query = $this->query;
        $data['mode_select'] = $query->get_one();
        $filter = \Input::get('filter');
        $formname=\Input::get('form_name');
        $uri = "/{$this->base}/index/?";
        if(is_array($filter))
            foreach($filter as $where => $value)
                if($value != 0 && !empty($value))
                {
                    $query->where($where, $value);
                    $uri .="&filter[$where]=$value";
                }
          
        if( !empty($formname))  {
            $query->where('name','like',"%".$formname."%");
            $uri .="&formname=$formname";
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

            $query->order_by('updated_at','desc');
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
//        $data['filepath'] = $this->filepath;
//        $data['folder'] = $this->modulename;
         $this->template->enableIndividualEmail = isset($enableIndividualEmail)?$enableIndividualEmail:'0';
            
//        $formview =  $this->getCreateForm();
        $this->template->content = \View::forge('forms/index', $data);

    }    
        
    /**
     * Form preview Render View
     */
    public function action_indexRender($id = null) {
         $model = $this->model;
        
        $data['object'] = $model::find($id);
        
        $this->template = \View::forge('forms/indexRender',$data);
    }
      
    /**
     * to preview the form created
     * 
     * pass @get parameter form_name
     * 
     * @return boolean
     */
    public function action_showForm($id = null) {
        
        $model  = $this->model;
        
        $form_name = \Input::get('form_name',null);
        $this->formId = $id;
        if (is_null($form_name)) {
            
            return false;
        }

        $sysobj = $model::query()->where("id",$this->formId)->get_one(); 
//        $sysobj =  \Model_Systemconfig::query()->where("name",$form_name)->get_one(); 
        
        $datax['form_name'] = $form_name;
        
        $datax['sysobj'] = is_object($sysobj)?$sysobj->currentform:"";
        
        $this->template = \View::forge('forms/preview',$datax);
    }
    
    /**
     *  post request to create form
     */
    public function post_createForm() { 
            
        $this->processData();        
    }
    
    /**
     * initialize settings
     */
    public function before() {
                
        $postDataFields  = $this->postDataReceivedFields; 
        
        $systemsconfig = array(); 
        if(is_array($postDataFields) && count($postDataFields) > 0 ){
            
            foreach ($postDataFields as $key => $postField){
                
                $this->$key= \Input::post($postField,null);
                
                if(is_array($this->$key)){
                    $postdata = implode(',', $this->$key);
                    
                    $systemsconfig[$key] = $postdata;
                    
                }else{
                
                    $systemsconfig[$key] = $this->$key;
                }
            }
        } 
        
        $systemsconfig['emailTo'] = $this->email;
//        $systemsconfig['modified'] = 1;
        $systemsconfig['emailBcc'] = '';
        $systemsconfig['senderName'] = '';
        $systemsconfig['enableEmail'] = '1';
        
      
        $this->form_title_eng = \Input::post('form_title_eng','');   
        unset($systemsconfig['json_data']);
        
        $this->systemsconfig = $systemsconfig;
        
        parent::before();
      
    }
    
    /**
     *  process form creation
     */
    public function processData() {
       
        $this->storeData();
         
        $this->sortFieldsNew();
        
        $this->createController();    
        
        $this->createModel();
            
        $this->createView();  
        
        $this->createLang(); 
        
        if(isset($this->login) && !empty($this->login)  && $this->login == 1){
            $this->createLogin(); 
        
            $this->createAgents();  
        }
        
         $this->createIndexView(); 
        
        if(is_object($this->forId) && is_a($this->forId, "Model_Formstore") && 1===0){
            $this->forId->currentform = "/$this->filename/$this->controller";
            $this->forId->save();
        }
      
        
        \Response::redirect("/$this->filename/$this->controller/create");            
                
    } 
    
    public function storeMenu($title = null) {
        
        if(is_null($title)){
            $menuList = \Input::post('menuList');

            $obj = Model_Menu::query()->where('modulename',$title)->get_one();
            
            if(!is_object($obj)){
                $obj = new Model_Menu();
                $obj->modulename = $title;                
            }
        }
    }
    
    public function storeData() {
               
        
        
        $this->formData();
        
        $model  = $this->model;
        $json_data = ($this->json_data);
//        $json_data = htmlspecialchars($this->json_data);
        $data = json_encode( array('json_data' => $json_data, 'form_title' => $this->form_title) );         
        
        $title = $this->formTitle();
        
        $this->storeMenu($title);
                
        if( !is_null($data)){    
                
            $sysobj = $model::query()->where("id",$this->formId)->get_one(); 
            
            $oldforms = '';
            
            if(!is_object($sysobj)){
                
               $sysobj = new $model;
               
            } 
              
            if(!empty($sysobj->currentform)){ 

                $oldforms = $this->getPastFormData($sysobj->oldforms, $sysobj->currentform);

            }  
            
            $sysobj->name = $title;
            $sysobj->systemsconfig = json_encode($this->systemsconfig);
            $sysobj->oldforms = $oldforms;            
            $sysobj->currentform = $data;
            $sysobj->title = $this->form_title;
            $sysobj->bitlyApiKey = $this->bity_api_key;
            $sysobj->backgroundimage = $this->backgroundimage;
            $sysobj->logo_id = $this->logo_id;
            $sysobj->logo = $this->logo;
            $sysobj->backgroundimage_id = $this->backgroundimage_id;
            $sysobj->color_scheme = $this->color_scheme;
            $sysobj->email = $this->email;
            $sysobj->shorten_url = $this->shorten_url;
            $sysobj->enableAuthentication = $this->login;
            
            $sysobj->save();
            
                
            return $sysobj->id;
//            print_r($sysobj); die();
//                die();
        } 
    }    
    

    public function getPastFormData($oldforms = null, $currentform = null) {
        
        $oldformsen  ='';
        $oldformsde  ='';
        
        if(!is_null($oldforms)){
            
            $oldformsde = json_decode($oldforms);
        }
        
        if(!is_array($oldformsde)){

            $oldformsde = array();
        }
        
        if(!is_null($currentform)){
                            
            if(count($oldformsde) == $this->maxOldForms){

                array_shift($oldformsde); //delete the older form
            }

            $oldformsde[] = $currentform;

            $oldformsen = json_encode($oldformsde); 
        } 
        
        return $oldformsen;
    }

    public function formTitle() {
        
//        $form_title = \Input::post('form_title_eng',''); 
        $form_title = $this->form_title_eng; 
//                print_r($form_title); die();
        if(!empty($form_title)){
            $title = preg_replace('/[^A-Za-z\']/', '', $form_title);   

            $form_title = strtolower($title); 
        }else{
           
            if($this->json == 0)
            \Response::redirect($this->redirectUrl);   
        }
      
        return $form_title;
    }
                
    public function getImage($id = 0 ) { 
        
        $imagepath = "";
        
        if(!is_null($id) && $id > 0){
            $image  = \Model_Image::find($id);
            if(is_object($image))
                $imagepath = "/$image->model_to/$image->name";
        }
        
        return $imagepath;
    }
        
    public function formData() { 
       
//        $this->json_data = str_replace('-', '_', $this->json_data);
//        print_r(  $this->json_data ); die();
        $this->fields = json_decode($this->json_data, true); 
        
        $this->replaceDashInName();
         
        $this->filename =  $this->formTitle();
                
        $this->logo = $this->getImage($this->logo);
                
        if (is_null($this->formtype) || empty($this->formtype)) {
            $this->formtype = '1';
        }

        $this->backgroundimage = $this->getImage($this->backgroundimage);
          
        return true;
    }
    
    public function replaceDashInName() {
       
        $this->getSeparatorList();
        
        $fields = $this->fields;
        
        $fieldlist  = array();
        
        
        if(is_array($fields) && count($fields) > 0 )
            foreach ($fields as $fld){

                if(key_exists('name', $fld))
                    $fld['name'] = str_replace('-', '_', $fld['name']);

                if(key_exists('section', $fld) && !empty($fld['section']))
                    $fld['section'] = str_replace('-', '_', $fld['section']);
                
                if(key_exists('ShowOnClick', $fld) && !empty($fld['ShowOnClick']))
                    $fld['ShowOnClick'] = str_replace('-', '_', $fld['ShowOnClick']);


                $fieldlist[] = $fld;

            }
        
//        print_r($this->fields);
            
        $this->fielddatareceived = $fieldlist;
        
        $this->fields = $fieldlist;
        
//         print_r($this->fields);die();
    }

    public function sortFieldsNew() { 
   
        $fields = $this->fields;       
                  
        if (is_array($fields) && count($fields) > 0) {
                
            $this->assignShowList();
                        
            $this->sortMathFields();
            
            $this->getSectionList();
            
            $this->assignSectionFields();
            
            $this->sortSectionFields();
            
            $this->sortFields();     
           
        }
                
    }
//replaceDashInName
    public function getSeparatorList() {
        
        $fields = $this->fields;
        
        $separators = array_map(function($val){

                if(key_exists('type', $val) && $val['type'] == 'hr'){ 
                    return $val;
                } 
            }, $fields);
            
                
        foreach ($separators as $hr){
            
            if(is_array($hr)){
                $element = $this->getKeyValue($hr,'element');
                
                foreach ($fields as $key=>$fld){

                    $name = $this->getKeyValue($fld,'name');

                    if($name == $element){ 

                        $fields[$key]['hr'] = 1;
                    }
                }          
            }          
        }    
        
        $this->fields = $fields;
        
    }
    
    public function getSectionList() {
        
        $fields = $this->fields;
        
        $this->sections = array_map(function($val){

                if(key_exists('type', $val) && $val['type'] == 'section'){
                    $val['fields'] = array();
                    return $val;
                } 
            }, $fields);
    }
    
    public function assignShowList() {
        
        $fields = $this->fields;
                
        $showlist = array();
                
        foreach($fields as $val){

                if(key_exists('ShowOnClick', $val) 
                        && !empty($val['ShowOnClick'])
                        &&  $val['ShowOnClick'] != '--select--'
                ){
                
                    $showlist[] = array( 'name'=> $val['name'], 'show' => $val['ShowOnClick']);
                } 
        }  
        
        foreach($fields as $key => $val){

            if(key_exists('name', $val)){
               
                foreach($showlist as $val1){
                
                    if($val['name'] == $val1['show']){

                        $fields[$key]['showElementList'][] = $val1['name'];

                    }
                }  
            }  
        }  
       $this->fields = $fields;     

    }

    public function assignSectionFields() {
        
        $fields = $this->fields;
           
        foreach ($this->sections as $key => $section){

            if(is_array($section) && key_exists('type', $section) && $section['type'] == 'section'){
                
                foreach ($fields as $field){

                    if( key_exists('type', $field) && $field['type'] ==  'section'){
                        continue;
                        
                    }else{

                        if(key_exists('section', $field) && $field['section'] == $section['name']){

                            $field['className'] = 'form-control form-fields';
//                            if(key_exists('name', $field))
//                                $field['name'] = str_replace('-', '_', $field['name']);
                            
                            $this->sections[$key]['fields'][] = $field;
                        }
                    }
                }
            }else{
                unset($this->sections[$key]);
            }
        } 
    }
    
    public function sortSectionFields() {
                
        foreach ($this->sections as $key => $section){

            if(is_array($section) && key_exists('type', $section) && $section['type'] == 'section'){
                foreach ($this->sections as $k=>$field){

                    if( key_exists('section', $field) && $field['section'] == $section['name']){

                            $field['className'] = 'form-control form-fields';
//                            if(key_exists('name', $field))
//                                $field['name'] = str_replace('-', '_', $field['name']);
                    
                            $this->sections[$key]['fields'][] = $field;
                            unset($this->sections[$k]);
                    } 
                }
            }else{
                unset($this->sections[$key]);
            }
        } 
    }
    
    public function sortFields() {
        
        $sorted_fields = array();
        
        $fields = $this->fields;
        
        foreach ($fields as $field){

            if(key_exists('section', $field) && key_exists('type', $field) &&  $field['type'] != 'section' && $field['section'] != '__select__'){

                if(key_exists('PDF', $field) && $field['PDF'] == "3"){
                    $this->PDFXY = 1;
                }

                continue; //skip type non section which are already added to the sections field list
            }else{


                if(key_exists('PDF', $field) && $field['PDF'] == "3"){
                    $this->PDFXY = 1;
                }

                if(key_exists('type', $field) &&  $field['type'] == 'section'){
                    // get fields assigned to type section and reassign to the section
                    foreach ($this->sections as $key => $section){ 

                        if(key_exists('name', $section) && key_exists('name', $field)){
                            if($field['name'] == $section['name']){
                                $sorted_fields[] = $section;
                            } 
                        } 
                    } 
                }else{
                    // get fields not assigned to type section
//                    if(key_exists('name', $field))
//                        $field['name'] = str_replace('-', '_', $field['name']);
                    
                    $sorted_fields[] = $field;
                }
            }
        }
      
      
        $this->modelProperties = $this->fields;   
      
        
//        $this->modelProperties = $sorted_fields;   
//            print_r($sorted_fields); die();
        $this->fields = $sorted_fields;
    }
    
    public function sortMathFields() {
        
        $sorted_fields = array();
        
        $fields = $this->fields;
//        print_r($fields); die();
        foreach ($fields as $field){

            if(key_exists('name', $field) ){

                
                  foreach ($fields as $fld){ // print_r($fld); die();
                  
                        $fld_name = ''; 
                        if(key_exists('name', $fld))
                            $fld_name = str_replace('-', '_', $fld['name']); 
                  
                        if(key_exists('name', $field)   && key_exists('math_value', $fld) && $fld['math_value'] != '--select--'){
                          
                          $mathval = $fld['math_value'];
                          $mathval = str_replace('-', '_', $mathval);
                          $show_total = $fld['show_total'];
                          $calculate = $fld['calculate'];
                          $show_total = str_replace('-', '_', $show_total);
                          
                         
                            if( $mathval ==  $field['name'] && in_array($calculate, array(1,2,3,4,5,6))){
                            
//                                 print_r($field); die();
                                    switch ($calculate){
                                        
                                        case 1: 
                                                $fld_name = str_replace('-', '_', $fld['name']); 
                                        
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " add ";
                                                else
                                                    $field['calculate-class'] = " add ";
                                                
                                                 $field['show_add_total'] = $show_total;
                                                $field['add_value'] = $fld_name;
                                                break;
                                        case 2: 
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " subtract ";
                                                else
                                                    $field['calculate-class'] = " subtract ";
                                                 $field['show_subtract_total'] = $show_total;
                                                $field['subtract_value'] = $mathval;
                                                break;
                                        case 3:  
                                                $fld_name = str_replace('-', '_', $fld['name']); 
                                         
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " multiply ";
                                                else
                                                    $field['calculate-class'] = " multiply ";
                                                
                                                 $field['show_multiply_total'] = $show_total;
                                                $field['multiply_value'] = $fld_name;
                                                break;
                                        case 4:  
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " divide ";
                                                else
                                                    $field['calculate-class'] = " divide ";
                                                
                                                 $field['show_divide_total'] = $show_total;
                                                $field['divide_value'] = $mathval;
                                                break;
                                        case 5:  
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " tax ";
                                                else
                                                    $field['calculate-class'] = " tax ";
                                                
                                                 $field['show_tax_total'] = $show_total;
                                                $field['tax_value'] = $mathval;
                                                break;
                                        case 6:  
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " discount ";
                                                else
                                                    $field['calculate-class'] = " discount ";
                                                
                                                 $field['show_discount_total'] = $show_total;
                                                $field['discount_value'] = $mathval;
                                                break;
                                        default:  
                                                break;
                                        
                                    }
                                
                                if(!in_array($calculate, array(1,3))){
                                    
                                    $field['parent_math_value'] = $fld['name'];
                                }
                                
                                
//                                $field['calculate'] = $fld['calculate'];
//                                $field['show_total'] = $show_total;
                                
                            }
                      }
                      
//                      if(key_exists('name', $field) && key_exists('show_total', $fld) ){
//                          
//                          $mathval = $fld['show_total'];
//                          $mathval = str_replace('-', '_', $mathval);
//                           $show_total = $fld['show_total'];
//                          $show_total = str_replace('-', '_', $show_total);
//                          
//                              if( $mathval ==  $field['name']){
//                          
////                                    $fld_name = str_replace('-', '_', $fld['name']);
////                                    $calculate = str_replace('-', '_', $fld['calculate']);
////                                    $show_total = str_replace('-', '_', $fld['show_total']);
////                         
////                            $field['math_value'] = $mathval;
////                            $field['calculate'] = $calculate;
////                            $field['show_total'] = $show_total;
//                        }
//                      }
                  }
                  
                  if(key_exists('math_value', $field) && key_exists('calculate', $field)   ){
                          
                                    $mathval = $field['math_value'];
                                    $mathval = str_replace('-', '_', $mathval); 
                                
                        $calculatex = $field['calculate'];
                        
//                         if(key_exists('show_total', $field) )
                          $show_total = $field['show_total']; 
                                $show_total = str_replace('-', '_', $show_total); 
//                           else{
//                               $show_total = $fld['show_total'];
//                           }
                        switch ($calculatex){

                            
                                        case 1: 
                                                $fld_name = str_replace('-', '_', $fld['name']); 
                                        
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " add ";
                                                else
                                                    $field['calculate-class'] = " add ";
                                                
                                                 $field['show_add_total'] = $show_total;
                                                $field['add_value'] = $mathval;
                                                break;
                                        case 2: 
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " subtract ";
                                                else
                                                    $field['calculate-class'] = " subtract ";
                                                 $field['show_subtract_total'] = $show_total;
                                                $field['subtract_value'] = $mathval;
                                                break;
                                        case 3:  
                                                $fld_name = str_replace('-', '_', $fld['name']); 
                                         
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " multiply ";
                                                else
                                                    $field['calculate-class'] = " multiply ";
                                                
                                                 $field['show_multiply_total'] = $show_total;
                                                $field['multiply_value'] = $mathval;
                                                break;
                                        case 4:  
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " divide ";
                                                else
                                                    $field['calculate-class'] = " divide ";
                                                
                                                 $field['show_divide_total'] = $show_total;
                                                $field['divide_value'] = $mathval;
                                                break;
                                        case 5:  
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " tax ";
                                                else
                                                    $field['calculate-class'] = " tax ";
                                                
                                                 $field['show_tax_total'] = $show_total;
                                                $field['tax_value'] = $mathval;
                                                break;
                                        case 6:  
                                                if(key_exists('calculate-class', $field))
                                                    $field['calculate-class'] .= " discount ";
                                                else
                                                    $field['calculate-class'] = " discount ";
                                                
                                                 $field['show_discount_total'] = $show_total;
                                                $field['discount_value'] = $mathval;
                                                break;
                                        default:  
                                                break;

                        }
                    }
                  
//                  if(key_exists('math_value', $field)   ){
//                          
//                          $mathval = $field['math_value'];
//                          $mathval = str_replace('-', '_', $mathval);
//                            $field['math_value'] = $mathval;
//                
//                    }
                  if(key_exists('show_total', $field)   ){
                          
                          $show_total = $field['show_total'];
                          $show_total = str_replace('-', '_', $show_total);
                            $field['show_total'] = $show_total;
                
                    }
//                   print_r($field); die();
                  $field['attr_name']= $field['name'];
                 $sorted_fields[] = $field;
//                if(key_exists('PDF', $field) && $field['PDF'] == "3"){
//                    $this->PDFXY = 1;
//                }

//                continue; //skip type non section which are already added to the sections field list
//            }else{
//
//
//                if(key_exists('PDF', $field) && $field['PDF'] == "3"){
//                    $this->PDFXY = 1;
//                }
//
//                if(key_exists('type', $field) &&  $field['type'] == 'section'){
//                    // get fields assigned to type section and reassign to the section
//                    foreach ($this->sections as $key => $section){ 
//
//                        if(key_exists('name', $section) && key_exists('name', $field)){
//                            if($field['name'] == $section['name']){
//                                $sorted_fields[] = $section;
//                            } 
//                        } 
//                    } 
//                }else{
//                    // get fields not assigned to type section
////                    if(key_exists('name', $field))
////                        $field['name'] = str_replace('-', '_', $field['name']);
//                    
                   
//                }
            }
        }
      
      
//        $this->modelProperties = $this->fields;   
      
        
//        $this->modelProperties = $sorted_fields;   
//            print_r($sorted_fields); die();
        $this->fields = $sorted_fields;
    }

    /***
     * Controller Creation
     */
    public function createController() {
        
        $this->type = 'controller';
        
        $this->getDocumentPath();
        
        $this->formControllerData();                    
        
        $this->createFile();
    }
            
    /**
     * 
     * @return boolean
     */
    public function getDocumentPath() {
        
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules';
        
        $this->filenamespace = $this->filename;
        
        if(substr($this->filename, -1) != 's'){
            $this->file = $this->filename.'s';
        }else{
            
            $this->file = $this->filename;
        }
                
        $this->file .= $this->fileExtension;
        
        $this->createDirectory($this->filename);
        
        $this->createDirectory('classes');
                
        $this->createDirectory($this->type);
                    
        return true;
    }
    
    /**
     * 
     * @param type $newdir
     * @return boolean
     */
    public function createDirectory($newdir = null) {
        
        if(!is_null($this->basepath) && !is_null($newdir)){ 
                
            $newpath = $this->basepath.DS.$newdir;
            
            if (!is_dir($newpath)) {
                
                \File::create_dir($this->basepath, $newdir, $this->chmod);
                
            } 
            
            $this->basepath = $newpath;
        }
        
        return true;
    }
    
    /**
     * 
     * @return boolean
     */
    public function formControllerData() {
        
        
        $class_name = $this->getClassName();
        $this->controller = strtolower($class_name);
        
        $contents = $this->getControllerProperties($class_name);
        $contentfunctions = $this->getControllerFunctions($class_name);
    
         $this->filedata  = <<<CONTROLLER
<?php

namespace {$this->filenamespace};

\Module::load('dynamicformssystem');   
    
class Controller_{$class_name} extends \dynamicformssystem\Controller_Basesystem
{
    {$contents}
    
    {$contentfunctions}
}

CONTROLLER;
//      class Controller_{$class_name} extends \dynamicformssystem\Controller_Base
        return true;
    }
    
    public function getClassName() {
        
        $name = \Inflector::classify($this->filename);
        
        $name = $name.'s';
        
        return $name;
    }    
    
    public function getCustomClassName() {
        
        $name = \Inflector::classify($this->newfilename);
        
        $name = $name.'s';
        
        return $name;
    }    
    
    public function getControllerProperties($class_name = null) {
       
        $controllerProperties = <<<CONTENTS
            public \$model =  '\\{$this->filenamespace}\Model_{$class_name}';
            public \$base =  '{$this->filenamespace}/{$this->controller}';
            public \$filepath =  '{$this->filename}';
            public \$pdfpath =  '{$this->filename}';
            public \$modulename =  '{$this->filename}';
            public \$formtype =  '{$this->formtype}';
            public \$color_scheme =  '{$this->color_scheme}';
            public \$shorten_url =  '{$this->shorten_url}';
            public \$xy_pdf =  '{$this->PDFXY}';
            public \$pdf_creator =  '{$this->pdf_creator}';
            public \$flowSystem =  '{$this->flowSystem}';
            public \$flowType =  '{$this->flowType}';
            public \$send_pdfmail =  '{$this->send_pdfmail}';
            public \$pdf_mode =  '{$this->pdf_mode}';
            public \$pdf_template_name =  '{$this->pdf_template_name}'; 
            public \$loadbase = '{$this->filename}';
            public \$auto_numbering = '{$this->auto_numbering}';
            public \$removesalessoftbar = '{$this->removesalessoftbar}';
            public \$show_last_draft = '{$this->show_last_draft}';
            public \$disablerequirednextfield = '{$this->disablerequirednextfield}';
            public \$loginRedirect = '/{$this->filenamespace}/{$this->controller}/listindex';
            public \$loginArray = {$this->getEscapeArray()};
            
      
    
CONTENTS;
            
        if(!empty($this->bity_api_key)){
            $controllerProperties .= <<<CONTENTS
            public \$bity_api_key =  '{$this->bity_api_key}';
    
CONTENTS;
        }
        if(isset($this->arrangebycreated) && !empty($this->arrangebycreated) && $this->arrangebycreated > 0 ){
            
            
            switch ($this->arrangebycreated){
                case 1 : $arrangebycreated = 'asc'; break;
                case 2 : $arrangebycreated = 'desc'; break;
                default : $arrangebycreated = ''; 
            }
                    
            $controllerProperties .= <<<CONTENTS
            public \$arrange_by_created =  '{$arrangebycreated}';
    
CONTENTS;
        }
    
        return $controllerProperties;
    }
        
    /**
     * 
     * @return boolean
     */
    public function createFile() {
                    
        if(!is_null($this->basepath) && !is_null($this->filename) && !is_null($this->filedata)){
                    
            if (!is_file($this->basepath.DS.$this->file)) {
                    
                \File::create($this->basepath, $this->file, $this->filedata);
            }else{
                
                \File::update($this->basepath, $this->file, $this->filedata);
            }
        }
        
        return true;
    }
    
    /***
     * Model Creation
     */
    public function createModel() {
                
        $this->type = 'model';
                
        $this->getDocumentPath();
        
        $this->formModelData();        
        
        $this->createFile();
    }
        
    public function formModelData() {
                
        $this->getProperties();
        
        $class_name = $this->getClassName();
        
        $contents = $this->getModelProperties($class_name);
        
        $this->filedata = <<<MODEL
<?php

namespace {$this->filenamespace};
    
\Module::load('dynamicformssystem');  
    
class Model_{$class_name} extends \dynamicformssystem\Model_Basesystem
{
    {$contents}
    
MODEL;
    
//    class Model_{$class_name} extends \dynamicformssystem\Model_Base

                
$this->filedata .= <<<MODEL
      
    public static  \$_has_one= array(
    
            {$this->hasOneRelation}
    );

MODEL;
    $this->hasOneRelation = '';
            
if($this->printHasMany == 0){
    
$this->filedata .= <<<MODEL
      
    public static  \$_has_many = array(
    
            {$this->hasManyRelation}
    );

MODEL;
            
            $this->hasManyRelation = '';
}

$this->filedata .= <<<MODEL
    
}

MODEL;
      
        return true;
    }
      
    
    public function getProperties() {
        
        $prop = ''; 
        
//        print_r($this->modelProperties); die();
        
        if(  is_array($this->modelProperties)){
            
            foreach ($this->modelProperties as $key => $field){
                
                if(key_exists('value',$field) && !empty($field['type'])){
                    if(strpos($field['value'], '"') || strpos($field['value'], "'")){
                     $field['value'] = addslashes($field['value']); 
                    }
                }
                 
                 
                if(key_exists('type',$field) && in_array($field['type'], $this->fieldtypes)){
                    
                             
                                        
                    $fldname = strtolower($field['name']);
//                    print_r($fldname); echo "   ";
                    if(in_array($fldname, $this->defaultProperties)){
                        $field['name'] = $field['name'].'_new';
                        
                        $this->modelProperties[$key]['name'] = $field['name'];
                    }
                    
                    if($field['type'] == 'autocomplete'){
                        
                        $autocomplete = $this->mapAutocompleteField($field);
                        
                          $prop .= <<<PROP
                        '{$autocomplete['name']}' => {$this->mapField($autocomplete)}

PROP;
                    }
                    
                    
                    if($field['type'] == 'bankdetails'){
                        
//                        $bankdetails = $this->mapBankdetailFields($field);
                        $num = '';
                        $name = $this->getKeyValue($field,'name',false);
                        $bankname = $this->getKeyValue($field,'bankname',false);
                        $branchcode = $this->getKeyValue($field,'branchcode',false);
                        $branchname = $this->getKeyValue($field,'branchname',false);
                        $field['type'] =  'text';

                        if(isset($name) && strpos($name, '_') > -1){
                            $temp = explode('_',$name);

                            $num = '_'.$temp[1];
                        }
                        
                        if($bankname == 'yes'){
                          $prop .= <<<PROP
                        'bankname{$num}' => {$this->formatProperty($field)}

PROP;
                        }
                        
                        if($branchcode == 'yes'){
                        $prop .= <<<PROP
                        'branchcode{$num}' => {$this->formatProperty($field)}

PROP;
                        }
                        
                        if($branchname == 'yes'){
                          $prop .= <<<PROP
                        'branchname{$num}' => {$this->formatProperty($field)}

PROP;
                        }
                
                          $prop .= <<<PROP
                        'branch_id{$num}' => {$this->formatProperty($field)}

PROP;
                        
                        $field['uploadBankdetails'] =  'yes';
                        
                          $prop .= <<<PROP
                        '{$name}' => {$this->formatProperty($field)}

PROP;
                    }else{
                    
                    if($field['type'] == 'date' && key_exists('DateType',$field) && $field['DateType'] == '2'){
                        
                
                        $field['type'] = 'text';
                        $this->noListView = 1;
                          $prop .= <<<PROP
                        '{$field['name']}_date' => {$this->formatProperty($field)}
                        '{$field['name']}_month' => {$this->formatProperty($field)}
                        '{$field['name']}_year' => {$this->formatProperty($field)}

PROP;
                     $this->noListView = 0;
                        
                    }else{
                        if($field['type'] == 'editabletext'  ){


                            $namex = $this->getKeyValue($field,'name',false); 

                            $ckname =  str_replace("editabletext","checkbox_group",$namex);
                            $textname =  str_replace("editabletext","textareaedit",$namex);
                            
                            $fieldx = $field;
                            $fieldx['type'] = 'checkbox';
                            $fieldx['name'] = $ckname;
                            $fieldy = $field;
                            $fieldy['name'] = $textname;
                            
                            $this->noListView = 1;
                              $prop .= <<<PROP
                            '$ckname' => {$this->formatProperty($fieldx)}
                            '$textname' => {$this->formatProperty($fieldy)} 

PROP;
                         $this->noListView = 0;

                        }else{


                        $prop .= <<<PROP
                            '{$field['name']}' => {$this->formatProperty($field)}

PROP;
                        }
                    }
                }
                if(key_exists('label', $field))  {     
                    $field['label'] = htmlspecialchars_decode($field['label']);
                    $field['label'] = strip_tags($field['label']); 
                    $field['label'] = addslashes($field['label']);     
                    $this->translation .= <<<TRANSLATION
                        '{$field['name']}' => '{$field['label']}',
    
TRANSLATION;
                 }
                }else{
                    
                    /**
                     * has many
                     */
                    if(key_exists('type',$field) &&  $field['type'] == 'section' && $field['sectionType'] == 2){
                
                        $this->printHasMany = 1;
                        
                            if(key_exists('sectionType',$field) &&  $field['sectionType'] == $this->hasMany ){
                                
                                 $field['fields']  = array();
                                 
                                 
                                if (isset($this->modelProperties) && count($this->modelProperties) > 0){
                                    foreach ($this->modelProperties as $fld){
                                        if(key_exists('section', $fld) && $field['name'] == $fld['section']){
                                            $field['fields'][] = $fld;
                                        }
                                    }
                                }
                                
                                $this->createHasManyModel($field,$key);
                            }
                            
                        $this->printHasMany = 0;
                    }
                    
                    
                }
            }
        }
                
        $prop .= $this->getDefaultProperties();
        
        $this->properties = <<<PROPERTIES
array( 
{$prop}
            );
PROPERTIES;
                
        
    }

    public function mapAutocompleteField($field = array()) {
                                    
        $type =  $this->getKeyValue($field,'type'); 
        $subtype= $this->getKeyValue($field,'subtype'); 
        
        if(is_array($field) && $type == 'autocomplete'){ 
                
            $cust_arr = array('customer name', 'customer number');
            $prod_arr = array('product name', 'product number');
            
            switch ($subtype){

                case in_array($subtype, $cust_arr) :  $subtype = 'customer';
                                                    break;
                case in_array($subtype, $prod_arr) : $subtype = 'product';
                                                    break;
            } 
            
            $field['type'] = 'hidden';
            $field['class']= 'updateflag';
            $field['name'] = "{$subtype}_id";
            $field['href']= "/{$subtype}s/listkey.json";
            $field['map-controller']= "{$subtype}s";
        } 
        
        return $field;
    }  
    
    public function mapBankdetailFields($field = array()) {
                                    
        $type =  $this->getKeyValue($field,'type'); 
        $subtype= $this->getKeyValue($field,'subtype'); 
        
        if(is_array($field) && $type == 'autocomplete'){ 
                
            $cust_arr = array('customer name', 'customer number');
            $prod_arr = array('product name', 'product number');
            
            switch ($subtype){

                case in_array($subtype, $cust_arr) :  $subtype = 'customer';
                                                    break;
                case in_array($subtype, $prod_arr) : $subtype = 'product';
                                                    break;
            } 
            
            $field['type'] = 'hidden';
            $field['class']= 'updateflag';
            $field['name'] = "{$subtype}_id";
            $field['href']= "/{$subtype}s/listkey.json";
            $field['map-controller']= "{$subtype}s";
        } 
        
        return $field;
    }    
    
    public function getKeyValue($field = array(), $key = '', $value= '') {
        
        $val = '';
        if(is_array($field)){
            $val = key_exists($key,$field)?$field[$key]:$value;
        }
        return $val;
    }
        
    public function mapField($field = array()) {
        
        $tempfield = '';
        $tempoptions = '';
        $propertyattr = '';
        
        if(is_array($field)){
            if(key_exists('dbtype', $field)){
               $tempfield .= <<<TEMPFIELD
'type'  =>  '{$field['dbtype']}',

TEMPFIELD;
            }
        
            if(key_exists('constraint', $field)){
               $tempfield .= <<<TEMPFIELD
                                    'constraint' =>  '{$field['constraint']}',

TEMPFIELD;
            }
            if(key_exists('XPosition', $field)){
               $tempfield .= <<<TEMPFIELD
                                    'x' =>  '{$field['XPosition']}',

TEMPFIELD;
            }
            if(key_exists('YPosition', $field)){
               $tempfield .= <<<TEMPFIELD
                                    'y' =>  '{$field['YPosition']}',

TEMPFIELD;
            }
            if(key_exists('Validation', $field)){
               $tempfield .= <<<TEMPFIELD
                                    'input_validation' =>  '{$field['Validation']}',

TEMPFIELD;
            }
            if(key_exists('maxlimit', $field)){
               $tempfield .= <<<TEMPFIELD
                                    'limit' =>  '{$field['maxlimit']}',

TEMPFIELD;
            }else{
               $tempfield .= <<<TEMPFIELD
               //  'limit' =>  '1',

TEMPFIELD;
            }
            
            if(key_exists('uploadCSV', $field) && $field['uploadCSV'] == 'yes'){
                
                
            
            $original_title = $this->getKeyValue($field, 'name'); 
            $module  = strtolower($this->filename); 
            
            $original_title = str_replace('_', '', $original_title);
            $original_title = str_replace('-', '', $original_title);
            $this->newfilename = $original_title;
            $class = $this->getCustomClassName($original_title);
            $modelname = "\\{$module}\Model_{$class}"; 
            
               $tempfield .= <<<TEMPFIELD
                                    'uploadCSV' =>  '1',
                                    'model' => '{$modelname}'

TEMPFIELD;
            }
            
            if(key_exists('uploadBankdetails', $field) && $field['uploadBankdetails'] == 'yes'){
                
            
                    $original_title = $this->getKeyValue($field, 'name'); 
                    $module  = strtolower($this->filename); 

                    $original_title = str_replace('_', '', $original_title);
                    $original_title = str_replace('-', '', $original_title);
                    $this->newfilename = $original_title;
                    $class = $this->getCustomClassName($original_title);
                    $modelname = "\\{$module}\Model_{$class}"; 
            
               $tempfield .= <<<TEMPFIELD
                                    'uploadBankdetails' =>  '1', 
                                    'model' => '{$modelname}'

TEMPFIELD;
            }
            if(key_exists('send_mail', $field) && $field['send_mail'] == '1'){
               $tempfield .= <<<TEMPFIELD
                                    'send_mail' =>  '1',

TEMPFIELD;
            }
            if(key_exists('filter', $field) && $field['filter'] == 'yes'){
               $tempfield .= <<<TEMPFIELD
                                    'filter' =>  '1',

TEMPFIELD;
            }
            if(key_exists('calculate', $field) && $field['calculate'] > 0){
                /**
                 * 1 add
                 * 2 subtract
                 * 3 multiply
                 * 4 divide
                 */
               $tempfield .= <<<TEMPFIELD
                                    'math_operation' =>  {$field['calculate']},

TEMPFIELD;
            }
        
        /*    if($this->count < $this->listviewLimit && key_exists('type', $field) &&  !in_array($field['type'],array('file','canvas','textarea' )) && $this->noListView == 0){
               $tempfield .= <<<TEMPFIELD
                                    'listview' => true,
                   
TEMPFIELD;
                $this->count++;
            }
         * 
         */ 
            if(key_exists('showonindex', $field) && $field['showonindex'] == 'yes'){
                /**
                 * 1 add
                 * 2 subtract
                 * 3 multiply
                 * 4 divide
                 */
               $tempfield .= <<<TEMPFIELD
                       'listview' => true,
                   
TEMPFIELD;

            }
        
            if(key_exists('type', $field) &&  in_array($field['type'],array('select', 'checkbox-group', 'radio-group'))){
                $tempoptions .= <<<TEMPOPTIONS
                   
                                                'options'  => array( {$this->formatOptions($field['values'])})
TEMPOPTIONS;
                }

            $propertyattr = <<<PROPERTYATTR
array(  
                                    'form'=> array(
                                            'type'=> '{$field['type']}', {$tempoptions}
                                                ), 
                                    'null'=> true,     
 
PROPERTYATTR;
                                            
   if(isset($tempfield) && !empty($tempfield)){
       
            $propertyattr .= <<<PROPERTYATTR
                    {$tempfield}        
 
PROPERTYATTR;
   }else{
       
            $propertyattr .= <<<PROPERTYATTR
                      'type'=> 'int',         
 
PROPERTYATTR;
   }
   
   if(isset($this->filenamehasmanylang) && !empty($this->filenamehasmanylang)){
                                     
            $propertyattr .= <<<PROPERTYATTR
                     
                                    'label'=> 'label.{$this->filenamehasmanylang}.{$field['name']}',
 
PROPERTYATTR;
                                    }else{
                               
            $propertyattr .= <<<PROPERTYATTR
                    
                                'label'=> 'label.{$this->filename}.{$field['name']}',
PROPERTYATTR;
                                    }
            $propertyattr .= <<<PROPERTYATTR
                                {$tempfield}
                            ),
PROPERTYATTR;
        } 
        
        return $propertyattr;                            
    }
    
    /**
     * 
     * @param type $property
     * @return type
     */
    public function formatProperty($property = array()) {
                        
        $field = $this->getFieldType($property);       
        
        $propertyattr = $this->mapField($field);

        
        return $propertyattr;
    }
    
    /**
     * 
     * @param type $options
     * @return type
     */
    public function formatOptions($options = array()) {
        
        $temp = '';
    
        if (is_array($options)) {
            
            foreach ($options as $opt) {
                
                $label = $this->getKeyValue($opt,'label','label');  
                
                $value = $this->getKeyValue($opt,'value','value');  
                
                $mapvalue = $this->getKeyValue($opt,'mapvalue','mapvalue');  
                
                $label = $this->escapeSingleQuote($label);
                $value = $this->escapeSingleQuote($value);
                $mapvalue = $this->escapeSingleQuote($mapvalue);
                
                $temp .= <<<TEMP

                                                    array ( 'label' => '{$label}', 'value' => '{$value}', 'mapvalue' => '{$mapvalue}' ),
TEMP;
            }
        }

        return $temp;
    }
    
    public function escapeSingleQuote($value = null) {
        
        $data = '';
        
        if (!is_null($value) && strpos($value, "'") > -1) {
                
            $data = addslashes($value);
        } else {
            if (!is_null($value) && strpos($value, '"') > -1) {
                $data = addslashes($value);
            } else {
                $data = $value;
            }
        }

        return $data;
    }
    
    public function removeSingleQuote($value = null) {
        
        $data = '';
        
//        if (!is_null($value) && strpos($value, '\\') > -1) {
                
            $data = stripslashes($value);
//        }  
        return $data;
    }
            
    /**
     * 
     * @param type $field
     * @return string
     */
    public function getFieldType($field = null) {
                
        $type = $this->getKeyValue($field, 'type');
        $send_mail = $this->getKeyValue($field, 'send_mail');
        $subtype = $this->getKeyValue($field, 'subtype');
        
        if(isset($type) && !is_null($type)){
            
            switch ($type){
                
                case 'radio-group'    : $type = 'radio';  break;
                
                case 'checkbox-group' : $type = 'checkbox';  break;
                
                // signature image
                case 'canvas'       : $type = 'mediumblob';  break;
                
                case 'editabletext'       : $type = 'blob';  break;
                
                case 'date'           : $type = 'date';  break; 
                
                case 'select'         : $type = 'select';  break;
                
                case 'file'           : $type = 'file';  break;
                
                case 'textarea'       : $type = 'textarea';  break;
                
                case  'hidden'        : $type = 'hidden';  break; 
                // text, autocomplete
                default               : $type = 'text';
            }
                
            switch ($type){
                
                case \in_array($type,$this->textFields)  :   $field['dbtype'] = 'text';  break; 
                case \in_array($type,$this->varcharFields)   :   $field['dbtype'] = 'varchar';
                                                                 $field['constraint'] = $this->varcharlimit; break;  
                                                        
                case \in_array($type,$this->longtextFields)  :   $field['dbtype'] = 'longtext';  break; 
                
                case   'mediumblob'              : $field['dbtype'] = 'mediumblob'; break;
                case   'blob'              : $field['dbtype'] = 'blob'; break;
                default                 : $field['dbtype'] = 'int';
            }
            
            if($subtype == 'email' && $send_mail == 'yes')
                $field['send_mail'] = '1';
        }
                
        return $field;
    }

    public function createHasManyModel($field,$fldkey) {
                
        $model_name=  $this->getClassName();
        
        $name= '';
        if(key_exists('name', $field)){
            $name= str_replace("_",'',$field['name']);
            
          
        }
        
        $controlname = strtolower($model_name).$name;
                
         
        $previousfilename =  $this->filename;
//        $previousFields =  $this->fields;
        $previousfile =  $this->file;
        $previouscontroller =  $this->controller;
        $previousmodelProperties =  $this->modelProperties;
        
//        $this->controller = $this->generateRandomString();
        $this->controller = $controlname;
//        $this->filenamespace = $previousfilename;
     
         $this->filename = $this->controller;
          if(substr($this->filename, -1) != 's'){
            $this->file = $this->filename.'s';
        }else{
            
            $this->file = $this->filename;
        }
                
        $this->file .= $this->fileExtension;
        
        $sectionname = '';
        
        foreach ($field['fields'] as $key=>$fld){
            $sectionname = $fld['section'];
            $field['fields'][$key]['model'] = $this->filename.'line';
        }
                
        $previousFields[$fldkey]['fields'] = $field['fields'];
        
        
        foreach ($previousmodelProperties as $prop){
            $psrentsection = '';
            if(key_exists('type', $prop) && $prop['type'] == 'section' && 
                    $prop['name'] == $sectionname && $prop['sectionType'] == 2){
                
                $psrentsection = $prop['section'];
            }
            
            
            $fieldlist  = array();
            foreach ($this->fields as $key=>$fieldlis){
                
                if(key_exists('name', $fieldlis) && $fieldlis['name'] == $psrentsection){
                   
                    foreach ($fieldlis['fields'] as $key1=>$fieldl){

                        if($fieldl['section'] == $fieldlis['name']){


                            if(key_exists('fields', $fieldlis['fields'][$key1])){
                                foreach ($fieldlis['fields'][$key1]['fields'] as $key2=>$fieldl){

                                    $fieldlis['fields'][$key1]['fields'][$key2]['model'] = $this->filename.'line';

                                } 
                            } 
                        } 
                    } 
                }
                $fieldlist[] = $fieldlis;
            }
            
            $this->fields = $fieldlist;
        } 
        
//        $this->fields = $field['fields'];
                
        $this->modelProperties = $field['fields'];
        
       
         
        $this->hasOneRelation = <<<hasMany
        '{$previousfilename}' => array (
                'key_to' => 'key_to',
                'model_to' => '\\{$previousfilename}\Model_{$model_name}', 
                'key_from' => 'id',
            ),
hasMany;
                
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filenamespace.DS.'classes'.DS.'controller';
    
        $this->formControllerData();    

       
        $this->createFile();
                 
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filenamespace.DS.'classes'.DS.'model'; 
                
        $this->filenamehasmanylang =$previousfilename;
        
        $this->formModelData();    
        
       
        $this->createFile();
                
        $this->hasManyCounter++;
        
        $model_name=  $this->getClassName();
        $filename =  $this->filename;
        
        $this->filenamehasmanylang ='';
        $this->filename =$previousfilename;
        $this->file =$previousfile;
//        $this->fields =$previousFields;
        $this->controller = $previouscontroller;
        $this->modelProperties = $previousmodelProperties;
        
        $this->hasManyRelation .= <<<hasMany
    '{$filename}line' => array (
                'key_to' => 'key_to',
                'model_to' => '\\{$this->filename}\Model_{$model_name}', 
                'key_from' => 'id',
            ),
hasMany;
                
        return ;
    }
    
    function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
        
    public function getDefaultProperties() {
  
        $defaultprop = '';
        if(is_array($this->defaultProperties)){
            
            foreach ($this->defaultProperties as $prop){
                
                $type = $this->getDefaultPropertyType($prop);
                
                $propdefine = "'form'=> array( 'type' => false),";

                $propdefine .= $prop=='id'?"'auto_increment' => true,":"'null'=> true,";
                
                if(isset($this->showcreatedonindex) && $this->showcreatedonindex == 1 && $prop=='created_at'){
                    $propdefine .= "'listview' => true,";
                    $propdefine .= "'form'=> array( 'type' => 'text'),";
                    $propdefine .= "'label'=> 'label.orders.created_at',";
                }
                if(isset($this->showautonumberingonindex) && $this->showautonumberingonindex == 1 && $prop=='id'){
                    $propdefine .= "'listview' => true,";
                    $propdefine .= "'form'=> array( 'type' => 'text'),";
                    $propdefine .= "'label'=> 'label.reports.id',";
                }
                if(isset($this->createddatefilter) && $this->createddatefilter == 1 && $prop=='created_at'){
                    $propdefine .= "'filter' => '1',"; 
                }
                                
                if(isset($this->showagentonindex) && $this->showagentonindex == 1 && $prop=='agent_id'){
                    $propdefine .= "'listview' => true,";
                    $propdefine .= "'form'=> array( 'type' => 'text'),";
                    $propdefine .= "'label'=> 'label.orders.agent_id',";
                }
                
                $defaultprop .= <<<DEFAULTPROPS
'{$prop}' => array(
                                        'type'=> '{$type}',                                         
                                        {$propdefine}
                                        
                                ),
                        
DEFAULTPROPS;

            }
            
        }
        
        return $defaultprop;
    }
    
    /**
     * 
     * @param type $prop
     * @return string
     */
    public function getDefaultPropertyType($prop = null) {
        
        if(!is_null($prop)){
        
            switch ($prop){
                case 'submitted_date'   : $type = 'timestamp'; 
                                        break;
                case 'created_at'   : $type = 'timestamp'; 
                                        break;
                case 'created_at'   : $type = 'timestamp'; 
                                        break;

                case 'updated_at'   : $type = 'timestamp on update current_timestamp'; 
                                        break;

                default             : $type = 'int';
            }

            return $type;
        }
    }
       
    public function getModelProperties() {
        
        $modelProperties = <<<CONTENTS
    
    protected static \$_table_name = 'fb_{$this->controller}';
                
    protected static \$_properties =  {$this->properties}
CONTENTS;
    
        return $modelProperties;
    }
    
    /***
     * View Creation
     */   
    public function createView() {
        /**
         * create,edit,view
         * create folder
         */
        
        $this->type = 'views';
        
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS;
        
        $this->createDirectory($this->filename);
        
        $this->createDirectory($this->type);        
        
        $this->createDirectory($this->filename);
        
        $viewfiles = array( 
                            'edit'=>'edit.php', 
                            'viewandsign'=>'viewandsign.php', 
                            'view'=>'view.php',
                            'pdf'=>'pdfview.php',
                            'pdflabeler'=>'pdflabeler.php'
                        );
       
        if($this->formtype == '1'){
        
            $viewfiles['create'] =  'create.php';
        }else{
//      if formtype == '2' pop up
            
            $viewfiles['popupCreate'] =  'createform.php'; 
        }
        /**
         * commented since section was breaking
         * enable if required
         */
//        $this->sortFields();
       
        foreach ($viewfiles as $key=>$file){   
                
            $this->viewType = $key; 
            $this->file = $file; 
            $this->formViewData();        
             
            if($this->PDFXY == 1 && $key == "pdf"){
                 
                $newpath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filename;
                $newdir = 'config';
                
               
                if (!is_dir($newpath.DS.$newdir)) {

                    \File::create_dir($newpath, $newdir, $this->chmod);                
                } 
                
                  if (!is_file($newpath.DS.$newdir)) {

                    \File::create($newpath.DS.$newdir, $this->file, $this->filedata);
                }
            }else{
                
                $this->createFile();
            }
            
        }
                
        
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filename.DS.$this->type.DS;
        
        $this->file = 'template.php';
        
        $this->viewType = 'template';
        
        $this->formViewData();        
            
        $this->createFile();
    }

    public function formViewData() {
     
        if(!is_null($this->viewType)){
            
            switch ($this->viewType){
                case 'template' : $this->filedata = $this->formTemplate();
                                    break;
                case 'create' :  
                                    $this->filedata = $this->getCreateForm(); 
                                break;
                case 'edit' :     $this->filedata = $this->getCreateForm(); 
                                break;
                case 'viewandsign' :     $this->filedata = $this->getCreateForm(); 
                                break;
                case 'view' :    $this->showEditData = 1;
                    
                                $this->filedata = $this->getViewForm(); 
                
                                break;
                case 'pdf' :    $this->showEditData = 1;
                                $this->filedata = $this->getPDFViewForm(); 
                
                                break;
                case 'pdflabeler' :   
                    $this->filedata = $this->getCreateForm(); 
//                    $this->filedata = $this->getPDFLabelViewForm(); 
                
                                break;
                case 'popupCreate' : $this->filedata = $this->getPOPUpIndexForm();     
                                    break;
                case 'index' :    
                                break;
                default : break;
            }
            
        }
        
    }
    
    public function formTemplate(){
                
        $html =<<<HTML
<html>
    {$this->getHeader()}
    {$this->getBody()} 
</html>
HTML;
            
        return $html;
    }

    public function getHeader() {
                
        $background =<<<BACKGROUND
                   body.background-image div.row-fluid {
                    background: initial;
            }
BACKGROUND;
        $header =<<<HEADER
                
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
HEADER;
        
//                
//        if(isset($this->whatsapp_image) && !empty($this->whatsapp_image)){
//            
//            $image = \Model_Image::find($this->whatsapp_image);
//            
//            if(is_object($image) && !empty($image->name)){
//                $imagelink = '/Model_Products/'.$image->name;
                
      
//            }
//        }
//        if(isset($this->whatsapp_description) && !empty($this->whatsapp_description)){
        
                $header .=<<<HEADER
                  
   <?php if(isset(\$whatsapp_title) && !empty(\$whatsapp_title)) { ?>
        <meta property="og:title" content="<?php  echo \$whatsapp_title ?>">
              <?php } ?>
                
HEADER;
          $header .=<<<HEADER
                <?php if(isset(\$whatsapp_image) && !empty(\$whatsapp_image)) { ?>
        <meta property="og:image" content="<?php  echo \$whatsapp_image ?>">
              <?php } ?>
HEADER;
          $header .=<<<HEADER
                  
   <?php if(isset(\$whatsapp_description) && !empty(\$whatsapp_description)) { ?>
        <meta property="og:description" content="<?php  echo \$whatsapp_description ?>">
              <?php } ?>
                
                
HEADER;
//        }
//        if(isset($this->whatsapp_title) && !empty($this->whatsapp_title)){
       
//        }
        
        $header .=<<<HEADER
                {$this->getCSS()}
        <title><?php  if(isset(\$title)) echo \Lang::get(\$title); ?></title>
	<style>
            .form-group .span6{
                margin-right:0 !important;
            }
         
            .background-image{
                background-image: <?php if(isset(\$backgroundimage) && !empty(\$backgroundimage)) { echo "url('".\$backgroundimage."')";   }else{ ?> url('{$this->backgroundimage}') <?php } ?> ;
                background: <?php if(isset(\$backgroundimage) && !empty(\$backgroundimage)) { echo "url('".\$backgroundimage."')";   }else{ ?> url('{$this->backgroundimage}') <?php } ?>  no-repeat fixed center;
                 background-size: cover;
                    zoom: unset !important;
            }
                {$background}
            div.box-header.section-color{
                background-color:  <?php if(isset(\$color_scheme)){  
                    echo \$color_scheme;
        } ?> !important; 
                color: black !important;
                border-bottom: 1px solid <?php if(isset(\$color_scheme)){  
                    echo \$color_scheme;
        } ?> !important;
            }
            div.box.section-border-top {
                border-top: 1px solid <?php if(isset(\$color_scheme)){  
                    echo \$color_scheme;
        } ?> !important;
            }
            .button {
                display: inline-block; 
                display: inline;
                padding: 4px 12px;
                margin-bottom: 0; 
                margin-right: .3em;
                font-size: 14px;
                line-height: 20px;
                color: #333;
                text-align: center;
                text-shadow: 0 1px 1px rgba(255,255,255,0.75);
                vertical-align: middle;
                cursor: pointer;   
                    box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 1px 2px rgba(0,0,0,0.05);
    border-radius: 4px;
            }
            div img#header-logo{
                <?php if(isset(\$logo_position) && !empty(\$logo_position)){  ?>
                    float: <?php echo \$logo_position ?>; 
                <?php } ?>
                <?php if(isset(\$logo_portrait_mode) && \$logo_portrait_mode == 1){  ?>
                    <?php if(isset(\$logo_height) && isset(\$logo_width) && !empty(\$logo_height) 
                        && !empty(\$logo_width)){ ?>
                     <?php      if(\$logo_width  < \$logo_height){  ?> 
                        height: <?php echo \$logo_height ?>px;  
                        width: <?php echo \$logo_width ?>px; 
                        <?php }else{ ?>

                     height: <?php echo \$logo_width ?>px;  
                        width: <?php echo \$logo_height ?>px; 
                       <?php } ?> 
                    <?php }else{ ?>
                        height: auto;  
                              width: auto; 
                    <?php } ?>
                <?php }else{ ?> 
                     <?php if(isset(\$logo_height) && isset(\$logo_width) && !empty(\$logo_height) 
                        && !empty(\$logo_width)){ ?>
                     <?php      if(\$logo_width  > \$logo_height){  ?> 
                        height: <?php echo \$logo_height ?>px;  
                        width: <?php echo \$logo_width ?>px; 
                        <?php }else{ ?>

                     height: <?php echo \$logo_width ?>px;  
                        width: <?php echo \$logo_height ?>px; 
                       <?php } ?> 
                    <?php }else{ ?>
                        height: auto;  
                              width: auto; 
                    <?php } ?>
                <?php } ?>
   
   
            }
        </style>
    </head>
HEADER;
        
    /*        
    <?php if(isset(\$logo_width) && !empty(\$logo_width)){  ?>
                    height: <?php echo \$logo_width ?>px; 
                <?php }else{ ?>
                       width: 140; 
                <?php } ?>
                <?php if(isset(\$logo_height) && !empty(\$logo_height)){  ?>
                    width: <?php echo \$logo_height ?>px; 
                 <?php }else{ ?>
                       height: 140; 
                <?php } ?>
                <?php } ?> */
        return $header;
    }

    public function getBody() {
        
        $body =<<<BODY
<body class="background-image" <?php if(isset(\$editWebsiteRecord) && \$editWebsiteRecord == 1) { ?> onload="fillData()" <?php } ?> >  
        {$this->getMenu()}
        <div class="row-fluid show-grid">
            <div class="span12 text-center">
                {$this->getLogo()}
            </div>
            <div class="span12 text-center">
                <h1><?php if(isset(\$title))  echo \$title; ?></h1>
                 
                <?php if (\Session::get_flash('success')): ?>
			<div class="alert alert-success">
				<strong><?echo \Lang::get('message.sucess');?></strong>
				<p>
				<?php echo implode('</p><p>', e((array) \Session::get_flash('success'))); ?>
				</p>
			</div>
                <?php endif; ?>
                <?php if (\Session::get_flash('error')): ?>
			<div class="alert alert-error">
				<strong><?echo \Lang::get('message.error');?></strong>
				<p>
				<?php echo implode('</p><p>', e((array) \Session::get_flash('error'))); ?>
				</p>
			</div>
                <?php endif; ?>
            </div>
            <div class="span12">
                <?php if(isset(\$content))  echo \$content; ?>  
                    <!--- Signature Box : Starta---
                    <div class="sinature-box hidesignature" id="sinatureCanvasBox" >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">חתימה</h4>
                            </div>
                            <div class="modal-body">
                                  <div id="middle">
                                    <div id="bcPaint" ></div>  
                                  </div>
                            </div>
                                <button type="button" class="btn btn-default" id="close-modal" style="display:none" data-dismiss="modal">סגירה</button>

                          </div>!-- /.modal-content --
                              </div>!-- /.modal-dialog --
                    </div>
                    !-- Signature Box : ends -->
                
                
        <div class="sinature-box hidesignature  modal" id="sinatureCanvasBox" >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">חתימה</h4>
                            </div>
                            <div class="modal-body" style="padding-left:0px;padding-right:0px">
                                  <div id="middle">
                                      
                                      
                                      <canvas id="signature-pad" class="signature-pad" style="width:inherit;height:inherit"></canvas>
                                     <!--  <div id="bcPaint"  style="width:100%"></div> -->
                                      
                                     
                                  </div>
                            </div>
                              
                                <div id="bcPaint-bottom" class="modal-footer">
                                  <button id="sigpad-reset" class="btn btn-default model-btn">אפס</button>
                                  <button id="sigpad-export" class="btn btn-primary model-btn">שמור חתימה</button>
                                  <button type="button" class="btn btn-default" id="close-modal" style="display:none" data-dismiss="modal">סגירה</button>
                              </div>
                                <button type="button" class="btn btn-default" id="close-modal" style="display:none" data-dismiss="modal">סגירה</button>

                          </div> 
                        </div> 
                    </div>
            </div>
        </div>
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">   
        </div> <!--/.modal -->
        
     
                        
        {$this->getFooter()}
    </body>
BODY;
        
        return $body;
    }

    public function getFooter() {
        
           
        
        $footer =<<<FOOTER
                
        <script>
                var  enableIndividualEmail = '<?php if(isset(\$enableIndividualEmail)) echo \$enableIndividualEmail ?>';
               
        </script>
                
            {$this->getJS()}
            <script>
             $(document).ready(function(){
                <?php if(isset(\$redirectInFive) &&  \$redirectInFive == 1){ ?>
                    window.setTimeout(function() {
                    location.href = "/<?php echo \$base; ?>/postProcessViewAndSign/<?php echo \$id ?>";
                    }, 6000);
                <?php } ?>
                 if($('#clickcopyclip').val() != undefined)
                 new ClipboardJS('#clickcopyclip');
            
                   var triggerForm =  '<?php if(isset(\$triggerform)) echo 1; else echo 0; ?>'
                    if(triggerForm==1 && $("#openNewCallx").length>0) $("#openNewCallx").click();
   
            
                    
           ///     if($('.showMoreOptionMulti').val() != undefined)
             //       $('.showMoreOptionMulti').trigger('change');
            
            
                if($('form').find('.showMoreOptionMulti').val() != undefined)
                    $('form').find('.showMoreOptionMulti').trigger('change');
                });
            
                    <?php if(isset(\$showPDF) &&  \$showPDF == 1){ ?>
                        window.setTimeout(function() {
                        location.href = "/<?php echo \$base; ?>/showDocumentToPdf/<?php echo \$id ?>";
                        }, 5000);
                    <?php } ?>
                                   <?php if(isset(\$redirect) &&  \$redirect == 1){ ?>
                        window.setTimeout(function() {
                        location.href = "/<?php if(isset(\$base)) echo \$base; ?>";
                        }, 8000);
                    <?php } ?>                              <?php if(isset(\$download)){ ?>
           $(".icon-download").parent()[0].click(); 
            <?php 
               
        } ?>
            
            
            
<?php if(isset(\$editWebsiteRecord) && \$editWebsiteRecord == 1) { ?>
var data = '<?php if(isset(\$order) && is_object(\$order)) echo json_encode(\$order->to_array()); ?>';

function fillData(){

    var json = JSON.parse(data);
     
    if(Object.keys(json).length > 0){
        
        $.each(json, function(idx, val){
                var ipt =  $('input[name="'+idx+'"]').val();
            
                if(ipt != undefined){
                    
                    var type= $('input[name="'+idx+'"]').attr('type');
                    if(type == 'radio'){
                        
                        $('input[name="'+idx+'"][value="'+val+'"]').attr('checked','checked');
                    }else{
                        if(type == 'checkbox'){
                            
                        $('input[name="'+idx+'"][value="'+val+'"]').attr('checked','checked');
                        }else{
                            $('input[name="'+idx+'"]').val(val);
                            
                        }
                    }
                    
                     
                 }else{
                    var textarea =  $('textarea[name="'+idx+'"]').val();
           
                    if(textarea != undefined)
                           $('textarea[name="'+idx+'"]').val(val);
                    else{
                        
                        var select =  $('select[name="'+idx+'"]').val();

                        if(select != undefined)
                            $('select[name="'+idx+'"]').children('option[value="'+select+'"]').attr('selected','selected'); 
                    }
                }
                    
        });
            
              
        if($('.showMoreOption').val() != undefined)
            $('.showMoreOption').trigger('change');
        if($('.showMoreOptionMulti').val() != undefined)
            $('.showMoreOptionMulti').trigger('change');
        
    }
}

<?php  } ?>
            
            
            </script>
        
                
                
FOOTER;
                
        return $footer;
        
    }

    public function getLogo($logostyle = '') {
        
        $img = '';
        
        if(!empty($this->logo)){
            
            $img = '<?php if(isset($logo) && !empty($logo)) { ?> <img src="<?php echo $logo; ?>" id="header-logo" '. $logostyle .' /> <?php } ?>'; 
        }
        
        return $img;
        
    }

    public function getMenu() {
        
        $hidebar = '';
       if($this->removesalessoftbar == 1){
            $hidebar = "style='display:none !important'";
        }
        
        $menu = <<<MENU
<div class="navbar navbar-inverse navbar-fixed-top" {$hidebar}>
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand">SalesSoft</a>           
                    <div class="nav-collapse collapse">  
                        <ul class="nav  vertical-nav"  >                               

MENU;
        
        if(isset($this->enableMultiMenu) && $this->enableMultiMenu == 1){
        $menu .= <<<MENU
                
                <?php if(isset(\$menuList) && count(\$menuList) >0){ ?>
                <?php foreach(\$menuList as \$menu ){ ?>
                    <li>
                        <a href="/<?php echo \$menu['link'] ?>"><?php echo \$menu['name'] ?></a>
                    </li>
                <?php } ?>
                <?php } ?>
               
MENU;
        
/*         <?php if(isset(\$menuLogout) && !empty(\$menuLogout)){ ?> 
                    <li>
                        <a href="///<?php echo \$menuLogout ?>"><?php echo \Lang::get('menu.logout'); ?></a>
                    </li> 
                //<?php } ?> */
        }else{
            
//        }
        
/*        if(isset($this->login) && $this->login == 1){ */
        $menu .= <<<MENU
                 <li>
                        <a href="/{$this->filename}/{$this->controller}/listindex">Form</a>
                    </li>
                    <li class="pull-left">
                        <a href="/{$this->filename}/base/logout"><?php echo \Lang::get('menu.logout');?></a>
                    </li>
MENU;
        } 
        $menu .= <<<MENU
                        </ul>
                    </div>  
                </div>
            </div>
        </div>
MENU;
        /* <li class="pull-left">
                                <a href="/{$this->filename}/{$this->controller}">form</a>
                            </li> */
        return $menu;
    }

            
    public function getJS(){
                
    $data['filename'] = $this->filename;
    $data['controller'] = $this->controller;
    $data['cloneData'] = $this->cloneData;
    
    $js = \View::forge('js/jslinks', $data);  
    $js .= \View::forge('js/addlines', $data);
                
    return $js;
}
    
    public function getCSS(){

        $ltrcss = '';
        
        if($this->view_type == 'ltr'){
            $ltrcss = <<<ltrcss
                    <link rel="stylesheet" href="/{$this->filename}/{$this->controller}/ltrcss">
ltrcss;
        }
        
        $css =<<<CSS
        
        
        <?php echo Asset::css('bootstrap.min.css');
        
            #echo Asset::css('jquery-ui-1.8.20.custom.css');
            echo Asset::css('minified/jquery-ui.min.css');
            echo Asset::css('chosen.min.css');
            echo Asset::css('select/select2.css'); 
        ?><style>
                 @media only screen and (max-width: 500px) and (min-width: 320px) {
   		.modal.fade.in{
   		width:96%;
   		right:76%;
   		
   		}
   
   }
                </style>
                
        <?php echo \Asset::css('formbuilder/formbuilder.css'); ?> 
        <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/assets/css/checkbox-x.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.snow.min.css">
                <link rel="stylesheet" href="/{$this->filename}/{$this->controller}/formcss">
                <link rel="stylesheet" href="/{$this->filename}/{$this->controller}/newformcss/formcsstwo">
                <link rel="stylesheet" href="/{$this->filename}/{$this->controller}/formbuildercss">
                <link rel="stylesheet" href="/{$this->filename}/{$this->controller}/responsive">
                {$ltrcss}
CSS;
        return $css;
    }
    
    public function getCreateForm() {
            
             $view  =  <<<CREATE
<form method='post' action="<?php // echo \$base;/create ?>" id="myFormId" js-url="/{$this->filename}/{$this->controller}/<?php if(isset(\$jsurl) && !empty(\$jsurl)) echo \$jsurl; else echo 'jsonOrdercomplete'; ?>" enctype='multipart/form-data' role="form" class="box-body">        
{$this->getElements($this->fields)}

   <!-- <div id="emailWrap" style="display:none;">
        <label>Enter the Email</label>
        <input type="text" name="email" id="enterEmail"  value="{$this->email}"/>
    </div> -->
CREATE;
        if(in_array($this->viewType, array('edit','viewandsign'))){
             $view  .=  <<<CREATE
    <input name="draft_id" type="hidden" value="<?php if(isset(\$order) && is_object(\$order)) echo \$order->id; ?>" />
CREATE;
        }
             $view  .=  <<<CREATE
    
	</form>
CREATE;
            
if(count($this->cloneData) > 0){
    
    foreach ($this->cloneData as $cldata){
         $view  .= <<<CREATE
<div id="{$cldata['clone-id']}"  style="display:none;" count="<?php if(isset(\$count_{$cldata['clone-id']}) && \$count_{$cldata['clone-id']} > 0) echo \$count_{$cldata['clone-id']}; else echo 1; ?>"> 
{$cldata['clone-view']}

</div>
                 
CREATE;
    }
    
}
 
$view  .=  <<<CREATE
<input id="uploadUrl" type="hidden" value="/{$this->filename}/{$this->controller}/createImagex" />

CREATE;
                
        return $view; 
    }

    public function getViewForm() {
        
        $view  =  <<<VIEW
{$this->getElements($this->fields)}
<div class="box-body form-group print-div">
    <a class="btn btn-success" id="print-click" href="/{$this->filename}/{$this->controller}/exportDocumentToPdf/<?php echo \$order->id; ?>"  ><?php echo \Lang::get('message.print')?\Lang::get('message.print'):'Print'; ?></a>    
</div>
VIEW;
        return $view;
    }    
    
    public function getPDFViewForm() {
        
        if($this->PDFXY == 1){
           
           $view  =  <<<VIEW
<?php return    array( 
                   
            'defaults' => array( 

VIEW;
            $i = 1;
             if(is_array($this->fields) && count($this->fields) > 0){
                 foreach ($this->fields as $field){
                if(key_exists('name', $field)) continue;
                
                if(key_exists('PDF', $field) && $field['PDF'] == "3" && key_exists('XPosition', $field) && key_exists('YPosition', $field)){
                    
            
           $view  .=  <<<VIEW
               array ('x' => {$field['XPosition']} , 'y' => {$field['YPosition']}, 'value' => '{$field['label']}'),

VIEW;
                   
             }
             $i++;
               }}   
             
           $view  .=  <<<VIEW
           ), 
        );
                   
VIEW;
             
        }else{
        
        $logostyle = 'style="width:150px;height:auto;text-align:center; "';
        $view  =  <<<VIEW
               
                
                
                <table style="width: 100%;text-align: right;border-bottom:solid #0000BB 0.5pt;border-bottom-color: #0000BB;">
    <tr>
        <td>
            <table>
                    {$this->getPDFUpperRightFields()}
            </table>
        </td> 
        <td>
        </td> 
        <td>
            <table style="text-align: left;">
                    <tr>
                        <td>
                             {$this->getLogo($logostyle)}
                        </td>
                    </tr> 
                    <tr>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
VIEW;
 $view  .=  '<?php if(!empty($order->{"updated_at"})) echo date("d/m/Y", strtotime($order->{"updated_at"})); ?>';
$view  .= <<<VIEW
</td>
                    </tr>
            </table>
        </td>
    </tr>
    <tr>
    <td>
    </td>
    <td>
    </td>
    </tr>
</table>  
        <table>
         {$this->getPDFElements()}
   </table>
VIEW;
        }
//                {//$this->getElements($this->fields)}
        return $view;
    }
    
    public function getPDFLabelViewForm() {
        
        if($this->PDFXY == 1){
           
           $view  =  <<<VIEW
<?php return    array( 
                   
            'defaults' => array( 

VIEW;
            $i = 1;
             if(is_array($this->fields) && count($this->fields) > 0){
                 foreach ($this->fields as $field){
                if(key_exists('name', $field)) continue;
                
                if(key_exists('PDF', $field) && $field['PDF'] == "3" && key_exists('XPosition', $field) && key_exists('YPosition', $field)){
                    
            
           $view  .=  <<<VIEW
               array ('x' => {$field['XPosition']} , 'y' => {$field['YPosition']}, 'value' => '{$field['label']}'),

VIEW;
                   
             }
             $i++;
               }}   
             
           $view  .=  <<<VIEW
           ), 
        );
                   
VIEW;
             
        }else{
        
        $logostyle = 'style="width:150px;height:auto;text-align:center; "';
        $view  =  <<<VIEW
               
                
                
                <table style="width: 100%;text-align: right;border-bottom:solid #0000BB 0.5pt;border-bottom-color: #0000BB;">
    <tr>
        <td>
            <table>
                    {$this->getPDFUpperRightFields()}
            </table>
        </td> 
        <td>
        </td> 
        <td>
            <table style="text-align: left;">
                    <tr>
                        <td>
                             {$this->getLogo($logostyle)}
                        </td>
                    </tr> 
                    <tr>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
VIEW;
 $view  .=  '<?php if(!empty($order->{"updated_at"})) echo date("d/m/Y", strtotime($order->{"updated_at"})); ?>';
$view  .= <<<VIEW
</td>
                    </tr>
            </table>
        </td>
    </tr>
    <tr>
    <td>
    </td>
    <td>
    </td>
    </tr>
</table>  
        <table>
         {$this->getPDFElements()}
   </table>
VIEW;
        }
//                {//$this->getElements($this->fields)}
        return $view;
    }

    public function getPOPUpIndexForm() {
//   modal-window      
        
        $popupform = <<<POPUPFORM
                
<!-- The Modal -->
<!--<div  class="modal fade" style="display: none;" id="myModal"  tabindex="-1" role="dialog"> -->
<div  id="popUpForm" style="display: none;" >
    <div class="modal-dialog modal-lg  my-5  modal-confirm">
        <div class="modal-content" style="    max-height: 550px;
    overflow-y: auto;
    overflow-x: hidden;">
            <div class="col-sm-12">        
                <button type="button" id="closeModalForm" class="close" data-dismiss="modal" aria-hidden="true" style="float:left;">&times;</button>
            </div>
             <div class="modal-header">
                <h4 class="modal-title font-weight-bold">
        <?php  if(isset(\$model)) echo \$model; ?></h4>
            </div>
                <div>
            {$this->getCreateForm()}
            </div>
        </div>
    </div>
</div> 
POPUPFORM;
        
        return $popupform;
        
    }
       
    public function getPDFUpperRightFields() {
        
            
        $view = '';
        $flag = 0;
        
        if(is_array($this->fields) && count($this->fields) > 0){
            foreach ($this->fields as $field){
                
                if(key_exists('PDF', $field) && $field['PDF'] == 1 && key_exists('name', $field)){
                    
                    $flag = 1;
                    $field['label'] = htmlspecialchars_decode($field['label']);
                    $view .= <<<view
                            <tr>
                                <td> 
view;
                    
    $view  .=  '<?php echo  $order->{"'.$field['name'].'"}; ?>';
        
                    $view .= <<<view
                     : {$field['label']}  </td>
                            </tr><tr>
                                <td> </td>
                            </tr>
view;
                }
            }
        }
        
        if($flag == 0){
               $view .= <<<view
                            <tr>
                                <td> </td>
                            </tr>
view;
        }
        
        
        return $view;
        
    }

    public function getPDFElements() {
//      
        $flag = 0;
         $view = <<<view
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
view;
         
         if(is_array($this->fields) && count($this->fields) > 0){
             
            
            foreach ($this->fields as $field){
                $childelements = array();
                 if( key_exists('type', $field) &&  ($field['type'] == 'button' || $field['type'] == 'section') )  {
                     continue;
                 }
                 
                 if( key_exists('PDFSameLine', $field) &&  $field['PDFSameLine'] != '--select--' )  {
                     continue;
                 }
                 
                 if( key_exists('name', $field) && (!key_exists('PDF', $field) || (key_exists('PDF', $field) && $field['PDF'] == 2 ))){
                    
                    $flag = 1;
                    
                     foreach ($this->fields as $fieldchild){
                            if( key_exists('PDFSameLine', $fieldchild) &&  $fieldchild['PDFSameLine'] == $field['name'] )  {
                     
                                $childelements[] = $fieldchild;
                            }
                     
                    }
                    
                 if(key_exists('label', $field))   {
                  $field['label'] = htmlspecialchars_decode($field['label']);
                
                 
                    $view .= <<<view
                            <tr>
                                <td colspan="3">  
                                <table> <tr> 
                                    <td>  
                       {$field['label']}  </td>
                                <td> 
view;
                 }
                                                
                    if( key_exists('type', $field)){
                        
                        switch ($field['type']){
                            case 'canvas' :
                                            $name = $this->getKeyValue($field,'name');  
                                            if(!empty($name)){
                                                $value = '<?php if(isset($order->{"'.$name.'"})) echo $order->{"'.$name. '"} ?>';
                                              } 
                                            $value = $this->getViewElements($field, $value, $name);
                                
                                            $view .= $this->formSignatureTag($field, $attributes = array(),$value);
                                            break;
                            case 'file' : $view .=  $this->getFileDisplay($field);
                                        break;
                            case 'paragraph' : $view .=<<<paragraph
            {$field['label']}  
paragraph;
                                        break;
                            case 'header' : $view .=<<<header
                                    {$field['subtype']} class='form-control'>
            {$field['label']} 
        </{$field['subtype']}>
header;
                                        break;
                            default :  $view  .=  '<?php echo  $order->{"'.$field['name'].'"}; ?>';
                                break;
                        }
                    }
                            
                    $view .= <<<view
                                </td>   
view;
                    $flag2 = 0;
                    
                    if(count($childelements) > 0){
                    foreach ($childelements as $childe){ 
                                $view .= <<<view
 
                                <td> 
                      {$childe['label']}  </td>
                                <td> 
view;
                    
                    
                                                
                    if( key_exists('type', $childe)){
                        
                        switch ($childe['type']){
                            case 'canvas' : $view .= $this->formSignatureTag($childe, $attributes = array(),'');
                                            break;
                            case 'file' : $view .=  $this->getFileDisplay($childe);
                                        break;
                            default :  $view  .=  '<?php echo  $order->{"'.$childe['name'].'"}; ?>';
                                break;
                        }
                    }
                            
                    $view .= <<<view
                                </td>  
view;
                            
                    }
                    
                 }
//                    if($flag2 == 1){
                         $view .= <<<view
                                </tr></table> </td>
                            </tr> 
view;
                        
//                    }else{
//                         $view .= <<<view
//                                <td> </td>
//                            </tr> 
//view;
//                    }
                    
                    $view .= <<<view
                            <tr> 
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
view;
                }else{
                    
                    if(key_exists('type', $field) &&  in_array($field['type'],array('header','paragraph')) && key_exists('subtype', $field) && key_exists('label', $field) &&  (key_exists('PDF', $field) && $field['PDF'] == 2 )){
                       
                        
                  $field['label'] = htmlspecialchars_decode($field['label']);
                        $view .= <<<view
                            <tr>
                                <td colspan="3">  
                                <table> 
                                    <tr> 
                                    <td>  
                       <{$field['subtype']} class='form-control'>
            {$field['label']} 
        </{$field['subtype']}> </td>
                                 
                       </tr> </table> </td> </tr> 
                            <tr> 
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
view;
                    }
                }
            }
        }
        
        if($flag == 0){
               $view .= <<<view
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
view;
        }
        
        
        return $view;
        
    }
     
    public function getElements($fields = array()) {
            
        $fielddata = '';
//        print_r($fields); die();
        if(is_array($fields)){
            
            foreach ($fields as $field){
                
                if(key_exists('type',$field) && $field['type']  == 'hr'){
                    continue;
                }
                if(key_exists('value',$field) && !empty($field['type'])){
                    if(strpos($field['value'], '"') || strpos($field['value'], "'")){
                     $field['value'] = addslashes($field['value']); 
                    }
                }
                
                if(key_exists('type', $field) && $field['type'] == 'section' ){
                    
                     $flow = $this->getKeyValue($field,'flow',false);
                     $flowread = '';
                     $flowstyle = '';
                    switch ($flow){
                
                        case 1: if  (in_array($this->viewType, array('viewandsign'))){
                                      $flowread = 'readonly';
                                        $disabled = 1;
                                    }
                        
                                    if ($this->flowSystem == 1 && $this->viewType == 'edit' ){
                                        $flowstyle = 'readonly="readonly"';
                                        $disabled = 1; 
                                    }
                                break;
                        case 2:    if ($this->viewType == 'create'  ){
//                                        $attributes['readonly'] = 'readonly';
                                        $flowstyle = 'style="display:none"';
                                        $disabled = 1; 
                                    }
                                     if (  $this->viewType == 'pdflabeler'){
//                                        $attributes['readonly'] = 'readonly';
                                        $flowstyle = '';
//                                        $disabled = 1; 
                                    }
                                    
                        case 12:    if ($this->viewType == 'create' || $this->viewType == 'pdflabeler'){
//                                        $attributes['readonly'] = 'readonly';
                                        $flowstyle = '';
                                        $disabled = ''; 
                                    }
                        
                                    
                                break;
                        default:  
                                    if ($this->flowSystem == 1 && $this->viewType == 'edit' ){
                                        $flowstyle = 'readonly="readonly"';
                                        $disabled = 1; 
                                    }
                                break;
                    }
                    
                    
                    $bgcolor = $this->getKeyValue($field, 'bgcolor');
                    $textcolor = $this->getKeyValue($field, 'textcolor');
                    $showheader = $this->getKeyValue($field, 'showheader');
                    $showoutline = $this->getKeyValue($field, 'showoutline');
                    
                    $subsectionstyle = 'style="';
                    $subsectionparentstyle = 'style="';
                    
                    if(!empty($bgcolor)){
                         $subsectionstyle .= 'background-color:'.$bgcolor.' !important;border-bottom:1px solid '.$bgcolor.' !important;';
                         $subsectionparentstyle .= 'border-top: 1px solid '.$bgcolor.' !important;';   
                    }
                    
                    if(!empty($showheader) && $showheader == 'no')
                         $subsectionstyle .= 'display:none;';     
                    if(!empty($textcolor)  )
                         $subsectionstyle .= "color:$textcolor !important;";     
                    
                    if(!empty($showoutline) && $showoutline == 'no')
                         $subsectionparentstyle .= 'box-shadow:none;border-top: none;';   
                    
                    $subsectionstyle .= '"';     
                    $subsectionparentstyle .= '"';     
                    
                    
                    if($field['sectionType'] == $this->hasMany){
                        
                        $this->hasManyData = 1;  
                   $this->hasManyCloneData[$field['name']] =  array('clone-id' => $field['name'].'_line', 'id' => 'add'.$field['name']);
                    
                  $field['label'] = htmlspecialchars_decode($field['label']);
                 $hidediv = "";    
                     
                    if(key_exists('ShowOnClick', $field) && !empty($field['ShowOnClick'])   &&  $field['ShowOnClick'] != '__select__'){
                        
                        $comparevalue = $this->getKeyValue($field,'ShowCompareValue');
                        $y = $comparevalue;
                        if(strpos($comparevalue, ',') > -1){
                            $x = explode(',',$comparevalue); 
                            $y = json_encode($x); 

                            $y = htmlentities($y);
                        } else{
                             if(strpos($comparevalue, '|') > -1){
                                $x  = explode('|',$comparevalue); 
                                $y = json_encode($x); 

                                $y = htmlentities($y);
                               }else{
                                    $x  = array($y) ;
                                  $y = json_encode($x); 

                                    $y = htmlentities($y);  
                               }
            //                 $x = array($comparevalue); 
            //                $y = json_encode($x); 
            //                $y = htmlentities($y);
                        } 
                    
                        
                        if($this->viewType == 'view' || $this->viewType == 'edit'){
                            
         $line_name = $this->getKeyValue($field,'line_name'); 
         $flname = $this->getKeyValue($field,'name'); 
         $flShowOnClick = $this->getKeyValue($field,'ShowOnClick');  
         
//         $field['ShowOnClick']
    /*         if(!empty($line_name) && $this->showEditData == 1){
//                   $value = '<?php if(isset($order->{"$line_name)) echo $order->{"'.$line_name. '  ';
                   $value = '<?php if(isset($line->{"$line_name"})) echo $line->{"'.$line_name. '"} ?>';
             }else{
                if(!empty($name)){
                   $value = '<?php if(isset($order->{"'.$name.'"})) echo $order->{"'.$name. '"} ?>';
                }
             }*/
         if(strpos($comparevalue, ',') > -1){
             $yz  = explode(',',$comparevalue); 
             $arry = '';
             foreach ($yz as $y1){
                 $arry .= "'$y1',";
             }
           if(!empty($line_name) ){
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  in_array(\$line->{"$flShowOnClick"},array($arry) )){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  in_array(\$order->{"$flShowOnClick"},array($arry)) ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }else{
//                echo 1;            echo strpos($comparevalue, '|'); die();
         if(strpos($comparevalue, '|') > -1){
             $yz  = explode('|',$comparevalue); 
             $arry = '';
             foreach ($yz as $y1){
                 $arry .= "'$y1',";
             }
           if(!empty($line_name) ){
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  in_array(\$line->{"$flShowOnClick"},array($arry) )){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  in_array(\$order->{"$flShowOnClick"},array($arry)) ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }else{
           if(!empty($line_name) ){
               
                if(strpos($y, '"') > -1 || strpos($y, "'") > -1){
                    $y = addslashes($y);
                }
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  \$line->{"$flShowOnClick"} == "$y" ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                if(strpos($y, '"') > -1 || strpos($y, "'") > -1){
                    $y = addslashes($y);
                }
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  \$order->{"$flShowOnClick"} == "$y" ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }        
                        }        
                        
                            $hidediv .= '  '.$viewhidediv.' data-val="'.$y.'" data-name="" data-parent-name="'.$field['ShowOnClick'].'" ';
                    
                        }else
                        $hidediv .= '  style="display:none" data-val="'.$y.'" data-name="" data-parent-name="'.$field['ShowOnClick'].'" ';
                    
                        
                        
                    } 
                   
                if($this->viewType == 'pdflabeler')  {
                       
                        $liname = '';
                    
                   
                         foreach ($field['fields'] as $key=>$fld){
                             
                             if(key_exists('name', $fld)){
                                if(key_exists('model', $fld)){
                                    $liname = $fld['model'];
                                }
                                
                                $field['fields'][$key]['id'] =   $fld['name'];
                             }
            
                        }
			$removeButtonCode  = "";
                    
				    $fielddataitems= $this->getElements($field['fields']);
					
					 if(!(($this->viewType == 'edit' || $this->viewType == 'viewandsign') && $flow == 1)){
                   
                   $removeButtonCode = <<<fielddata
                                    <a class="btn pull-left removeFaultButton btn-modify-elmor" style="display:block !important" id="Delete"><i style="display:block !important" class="icon-trash" title="Delete"></i></a>
                             
fielddata;
                   }
				   
				   
					
                     $fielddata .= <<<fielddata
                           <div class=" box-body form-group appendData" $hidediv>  
							<div class="span12 box-body form-group section-col" style="margin-right:0px;">
                            <div class="box box-gray" $subsectionparentstyle>
                                <div class="box-header  with-border bg-gray" $subsectionstyle data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
								{$removeButtonCode}
                       <h4 class="box-title" style="width: 70%; text-align: center;"><span class="title">{$field['label']} {{$liname}}</span></h4>
                                    <button type="button" class="btn pull-right" data-widget="collapse"> <i class="icon-minus">-</i></button>                                    
                                </div>
                                <div id="lab" class="box-body" data-inset="true" data-theme="e" style="text-align:right" data-content-theme="d" >
								{$fielddataitems}
                            </div>
                            </div>
                            </div>
							</div>
fielddata;
                   
                   
                   
                   
                   
                   
                   
                }else{
                        
                            
                    
                        $fielddata .= <<<fielddata
                           <div class=" box-body form-group appendData" $hidediv  > 
                </div>
                <div class=" box-body form-group" $hidediv >
                    <div class="span12">
                        <label></label>
                    </div>
                    <div class= "span12 form-control text-center">
fielddata;
                    
                    if(in_array($this->viewType, array('edit','viewandsign')) || $this->viewType == 'view')  { 
                        
                        $this->showEditData = 1;
                        $liname = '';
                                    
                         foreach ($field['fields'] as $key=>$fld){
                             
                             if(key_exists('name', $fld)){
                                if(key_exists('model', $fld)){
//                                    $field['fields'][$key]['name'] = $fld['model'].'[count]['. $fld['name'].']';
////                                    $field['fields'][$key]['line_name'] = $fld['model'].'"}->{"'. $fld['name'].'"}';
//                                    $field['fields'][$key]['line_name'] =  $fld['name'];
                                    
                                    $liname = $fld['model'];
                                }
                                
                                $field['fields'][$key]['id'] =   $fld['name'];
                             }
            
                        }
                        

						$newfields = $field['fields'];
                         foreach ($newfields as $key=>$fld){
                             
                             if(key_exists('name', $fld)){
                                if(key_exists('model', $fld)){
                                    $newfields[$key]['name'] = $fld['model'].'[<?php echo $i ?>]['. $fld['name'].']';
//                                    $field['fields'][$key]['line_name'] = $fld['model'].'"}->{"'. $fld['name'].'"}';
                                    $newfields[$key]['line_name'] =  $fld['name'];
                                    
                                    $liname = $fld['model'];
                                }
                                
                                $newfields[$key]['id'] =   $fld['name'];
                             }
            
                        }

						$fieldsData= $this->getElements($newfields);
						
					
				   
						
$removeButtonCode  = "";
		   if( !(($this->viewType == 'edit' || $this->viewType == 'viewandsign') &&  $this->flowSystem >0 && $flow<1)){
				 $removeButtonCode = <<<SECTION
					 <a class="btn pull-left removeFaultButton btn-modify-elmor" style="display:block !important" id="Delete"><i style="display:block !important" class="icon-trash" title="Delete"></i></a>
											
SECTION;
	}

	$fielddata .= <<<SECTION
						   <div class=" box-body form-group appendData"> 
						 <?php 
						
								if(isset(\$order->{$liname}) && count(\$order->{$liname}) > 0){ 
								
							   \$count_{$field['name']}_line = count(\$order->{$liname})+1;
								\$i=1;
								 foreach(\$order->{$liname} as \$key=>\$line){   

							?>
					<div class="span12 box-body form-group " style="margin-right:0px;">
					<div class="box box-gray" >
						<div class="box-header  with-border bg-gray" data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
						 {$removeButtonCode}
                             <h4 class="box-title" style="width: 70%; text-align: center;"><span class="title">{$field['label']} <?php echo \$i ?></span></h4>
                                    <button type="button" class="btn pull-right" data-widget="collapse"> <i class="icon-minus">-</i></button>                                    
                                </div>
                                <div id="lab" class="box-body" data-inset="true" data-theme="e" style="text-align:right" data-content-theme="d" >
								{$fieldsData} 
                            </div>
                            </div>
                            </div>
                                  <?php 
                                      
                                    \$i++;
                                        } ?>
                                  <?php } ?>
                            </div>
                <div class=" box-body form-group">
                    <div class="span12">
                        <label></label>
                    </div>
                    <div class= "span6 form-control">
SECTION;
                        
                        
                        
                    }
                             $newfields = $field['fields'];
                    foreach ($newfields as $key=>$fld){

                        if(key_exists('name', $fld)){
                           if(key_exists('model', $fld)){
                               $newfields[$key]['name'] = $fld['model'].'[count]['. $fld['name'].']';
                               $newfields[$key]['linename'] = $fld['model'];
                           }

                           $newfields[$key]['id'] =   $fld['name'];
                        }

                   }
                    
                    
                     $this->showEditData = 0;
                     $buttonCode = "";
                     if(in_array($this->viewType, array('edit','viewandsign','create')) ){
                         $limitval = '';
                         if(key_exists('limit', $field))
                         $limitval =$field['limit'];
                         
                         $section_label =$field['label'];
                         $section_label = strip_tags($section_label);
                         
                   $btndisabled = '';     
                   if(in_array($this->viewType, array('edit','viewandsign')) &&  $this->flowSystem >0 && $flow<1 ){
                        $btndisabled= 'disabled="disabled"';
                   } 
                   $buttonCode .= <<<fielddata
                    <button  {$btndisabled} class="btn btn-primary"  clone-id="{$field['name']}_line" placeholder="" value="" autocomplete="off" clone-limit={$limitval} name="{$field['name']}" id="add{$field['name']}" >הוסף {$section_label}</button>
fielddata;
                     }
					 
					 
                   $fielddata .= <<<fielddata
								{$buttonCode}
                           </div> 
                           </div>
						  
			   
fielddata;


if (in_array($this->viewType, array('edit','viewandsign'))){
	$fielddata .= " </div></div>";
	
}


                     $removeButtonCode = "";
					 
					   if(!(in_array($this->viewType, array('edit','viewandsign')) &&  $this->flowSystem >0 && $flow<1)){
                                   
                   $removeButtonCode= <<<SECTION
                       <a class="btn pull-left removeFaultButton btn-modify-elmor" parent-button = "add{$field['name']}" style="display:block !important" id="Delete"><i style="display:block !important" class="icon-trash" title="Delete"></i></a>
SECTION;
   }
   
   
                          
                        
                        $fieldDataMap= $this->getElements($newfields);
					 
                   $fielddataclone = <<<SECTION
                            
							<div class="span12 box-body form-group section-col" style="margin-right:0px;">
                            <div class="box box-gray" $subsectionparentstyle >
                                <div class="box-header  with-border bg-gray" $subsectionstyle data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
								{$removeButtonCode}
                       <h4 class="box-title" style="width: 70%; text-align: center;"><span class="title">{$field['label']}</span></h4>
                                    <button type="button" class="btn pull-right" data-widget="collapse"> <i class="icon-minus">-</i></button>                                    
                                </div>
                                <div id="lab" class="box-body" data-inset="true" data-theme="e" style="text-align:right" data-content-theme="d" >
								$fieldDataMap
								</div>
								</div>
								</div>
SECTION;
                          
						 // if(in_array($this->viewType, array('edit','viewandsign'))) { echo $fielddataclone;}
                         $this->cloneData[$field['name']] =  array('clone-id' => $field['name'].'_line', 'id' => 'add'.$field['name'],'clone-view' => $fielddataclone );
                }    
                
                 $this->hasManyData = 0;  
                    }else{      
//            <div class="span12 box box-danger ">
                    
                
                    $hidediv = '';

                    if(empty($flowstyle)){
                        if(key_exists('ShowOnClick', $field) && !empty($field['ShowOnClick'])   &&  $field['ShowOnClick'] != '__select__'){

                            $comparevalue = $this->getKeyValue($field,'ShowCompareValue');
                            $y = $comparevalue;
                            if(strpos($comparevalue, ',') > -1){
                                $x = explode(',',$comparevalue); 
                                $y = json_encode($x); 

                                $y = htmlentities($y);
                            } else{
                                 if(strpos($comparevalue, '|') > -1){
                $x  = explode('|',$comparevalue); 
                $y = json_encode($x); 
            
                $y = htmlentities($y);
               }else{
                                    $x  = array($y) ;
                                  $y = json_encode($x); 

                                    $y = htmlentities($y);  
                               }
                //                 $x = array($comparevalue); 
                //                $y = json_encode($x); 
                //                $y = htmlentities($y);
                            } 
                            
                        if($this->viewType == 'view' || $this->viewType == 'edit'){
                            
         $line_name = $this->getKeyValue($field,'line_name'); 
         $flname = $this->getKeyValue($field,'name'); 
         $flShowOnClick = $this->getKeyValue($field,'ShowOnClick'); 
    /*         if(!empty($line_name) && $this->showEditData == 1){
//                   $value = '<?php if(isset($order->{"'.$line_name.')) echo $order->{"'.$line_name. '  ';
                   $value = '<?php if(isset($line->{"'.$line_name.'"})) echo $line->{"'.$line_name. '"} ?>';
             }else{
                if(!empty($name)){
                   $value = '<?php if(isset($order->{"'.$name.'"})) echo $order->{"'.$name. '"} ?>';
                }
             }*/
         if(strpos($comparevalue, ',') > -1){
             $yz  = explode(',',$comparevalue); 
             $arry = '';
             foreach ($yz as $y1){
                 $arry .= "'$y1',";
             }
           if(!empty($line_name) ){
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  in_array(\$line->{"$flShowOnClick"},array($arry) )){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  in_array(\$order->{"$flShowOnClick"},array($arry)) ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }else{
//                             echo 2;            echo strpos($comparevalue, '|'); die();
         if(strpos($comparevalue, '|') > -1){
             $yz  = explode('|',$comparevalue); 
             $arry = '';
             foreach ($yz as $y1){
                 $arry .= "'$y1',";
             }
           if(!empty($line_name) ){
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  in_array(\$line->{"$flShowOnClick"},array($arry) )){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  in_array(\$order->{"$flShowOnClick"},array($arry)) ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }else{
           if(!empty($line_name) ){
               
                if(strpos($y, '"') > -1 || strpos($y, "'") > -1){
                    $y = addslashes($y);
                }
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  \$line->{"$flShowOnClick"} == "$y" ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                if(strpos($y, '"') > -1 || strpos($y, "'") > -1){
                    $y = addslashes($y);
                }
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  \$order->{"$flShowOnClick"} == "$y" ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }        
                        }        
                        
                            $hidediv .= '  '.$viewhidediv.' data-val="'.$y.'" data-name="" data-parent-name="'.$field['ShowOnClick'].'" ';
                    
                        }else
                            $hidediv .= '  style="display:none" data-val="'.$y.'" data-name="" data-parent-name="'.$field['ShowOnClick'].'" ';
                        }
                    }else{
                        $hidediv .= $flowstyle;
                    }
                       $fielddatamap = "";
                        if (key_exists('fields', $field)) {
                            $fielddatamap  = $this->getElements($field['fields']);
                        }					  
                        
                  $field['label'] = htmlspecialchars_decode($field['label']);
                    $fielddata .= <<<SECTION
                            
							<div class="span12 box-body form-group section-col" {$hidediv} >
                            <div class="box box-{$this->color_scheme} section-border-top" $subsectionparentstyle >
                                <div class="box-header  with-border bg-{$this->color_scheme} section-color" $subsectionstyle data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
                                    <h4 class="box-title" style="width: 80%; text-align: center;"><span class="title">{$field['label']}</span><span class="headerChange"></span></h4>
                                    <button type="button" class="btn pull-right" data-widget="collapse"> <i class="icon-minus">-</i></button>                                    
                                </div>
                                <div id="lab"  class="box-body" data-inset="true" data-theme="e" style="text-align:right" data-content-theme="d" >
								{$fielddatamap}
                            </div>
                            </div>
                            </div>
SECTION;
                    }
                    $fielddata .= <<<SECTION
                      <div class="span12 " >      <hr/> </div>
SECTION;
                    
                    continue;
                }
                
                 $fielddata .= $this->formElement($field);
            
            }
            
        }
            
        return $fielddata;
    }
    
    public function formElement($field = array()){                
        
         $label = key_exists('type', $field)&& !in_array($field['type'],array('button','canvas'))?$this->getKeyValue($field,'label'):"" ;
         $name = $this->getKeyValue($field,'name');  
         $line_name = $this->getKeyValue($field,'line_name');  
         
         $value = '';
         
         if(in_array($this->viewType,array('edit','view','pdf','viewandsign'))){
             
             if(!empty($line_name) && $this->showEditData == 1){
//                   $value = '<?php if(isset($order->{"$line_name)) echo $order->{"'.$line_name. '  ';
                   $value = '<?php if(isset($line->{"'.$line_name.'"})) echo $line->{"'.$line_name. '"} ?>';
             }else{
                if(!empty($name)){
                   $value = '<?php if(isset($order->{"'.$name.'"})) echo $order->{"'.$name. '"} ?>';
                }
             }
             
            if($this->viewType == 'view' || $this->viewType == 'pdf'){
                if( key_exists('type', $field) && $field['type'] == 'button') return '';
                
                $value = $this->getViewElements($field, $value, $name);
            }
        } 
        
        
      
        switch ($this->viewType){
            case 'create' :  $flow = $this->getKeyValue($field,'flow',false);
                            if($flow == 2) return;
                            $value = $this->getTag($field);
                            break;
            case 'pdflabeler' : 
//                            $flow = $this->getKeyValue($field,'flow',false);
//                            if($flow == 2) return;
                            $value = $this->getTag($field);
                            break;
            case 'popupCreate' : $value = $this->getTag($field);
                            break;
            case 'edit' :   $flow = $this->getKeyValue($field,'flow',false);
                            $type = $this->getKeyValue($field,'type',false);
                            if($flow == 1 && $type == 'button') return;
                            $value = $this->getTag($field,$value);
                            break;
            case 'viewandsign' :   $flow = $this->getKeyValue($field,'flow',false);
                            $type = $this->getKeyValue($field,'type',false);
                            if($flow == 1 && $type == 'button') return;
                            $value = $this->getTag($field,$value);
                            break;
        }
        
        
        $type = $this->getKeyValue($field,'type');    
        
        if($type == 'hidden'){
            return  $value;
        }
        
        $hr = $this->getKeyValue($field,'hr',false);
        $required = $this->getKeyValue($field,'required');  
        
        $showLabel = $this->getKeyValue($field,'showLabel');
        $label_html =  htmlspecialchars_decode($label);
        if($required == 1) $label_html .= '<span class="fb-required">*</span>';
//        $label_html .= '<span class="fb-required">*</span>';
        
        $field_data = '';
                    if( key_exists('type', $field)){
        switch ($field['type']){ 
            case in_array($field['type'],array('header','paragraph')) :
                
                $field_data = htmlspecialchars_decode($field['label']);
                                            $field_data =<<<FIELDDATA
<{$field['subtype']} class='form-control'>
            {$field_data} 
        </{$field['subtype']}>
FIELDDATA;
                            break;
            case in_array($field['type'],array('editabletext')) :
                
                $field_data =  $value;
                            break;
            default :      
//                &nbsp; &nbsp;
                $field_data = '';
    if($showLabel == '' ||  $showLabel == 'yes'){           
                $field_data = <<<FIELDDATA
<div class="span12"><label>{$label_html} 
FIELDDATA;

if($this->viewType == 'pdflabeler'){
    
$label_name =$this->getKeyValue($field,'name');
$tagtype =$this->getKeyValue($field,'type');
$DateType =$this->getKeyValue($field,'DateType');

    if($tagtype == 'date' && $DateType == 2){
            
        $field_data .=  <<<FIELDDATA
        {{$label_name}_date}&nbsp;&nbsp;
        {{$label_name}_month}&nbsp;&nbsp;
        {{$label_name}_year} 
FIELDDATA;
    }else{
        $field_data .=  <<<FIELDDATA
        {{$label_name}}
FIELDDATA;
    }
}

$field_data .=  <<<FIELDDATA
        </label></div> 
FIELDDATA;
    }
    
$divclass = ' form-control';

if(in_array($type , array('checkbox-group',"radio-group"))){
    $divclass .= ' span12 displayCheck ';
}else{
    $divclass = ' span6 ';
}

$divtip = '';

if(key_exists('tooltip', $field) && $field['tooltip'] == 'yes' && key_exists('tooltip_text', $field))
    $divtip =  ' data-tip="'.$field['tooltip_text'].'"';  

    
$field_data .=  <<<FIELDDATA
        
        <div class='{$divclass}' $divtip>
            {$value} 
        </div>
FIELDDATA;
            
            
                            break;
            
        }
        }
        
        $hidediv = '';
        
        if(key_exists('ShowOnClick', $field) && !empty($field['ShowOnClick'])   &&  $field['ShowOnClick'] != '__select__'){
            
            $comparevalue = $this->getKeyValue($field,'ShowCompareValue');
            $y = $comparevalue;
            if(strpos($comparevalue, ',') > -1){
                $x = explode(',',$comparevalue); 
                $y = json_encode($x); 
            
                $y = htmlentities($y);
            } else{
                 if(strpos($comparevalue, '|') > -1){
                $x  = explode('|',$comparevalue); 
                $y = json_encode($x); 
            
                $y = htmlentities($y);
               }else{
                                    $x  = array($y) ;
                                  $y = json_encode($x); 

                                    $y = htmlentities($y);  
                               }
//                 $x = array($comparevalue); 
//                $y = json_encode($x); 
//                $y = htmlentities($y);
            }   
            
            
            
            $linename = $this->getKeyValue($field,'linename');
            $ShowOnClick = $field['ShowOnClick'];
            if(!empty($linename)){
                $ShowOnClick = $linename."[count][$ShowOnClick]";
            }
            
           

//            $hidediv .= '  style="display:none" data-val="'.$comparevalue.'" data-name="" data-parent-name="'.$ShowOnClick.'" ';
            
                        if($this->viewType == 'view' || $this->viewType == 'edit'){
                            
         $line_name = $this->getKeyValue($field,'line_name'); 
         $flname = $this->getKeyValue($field,'name'); 
         $flShowOnClick = $this->getKeyValue($field,'ShowOnClick'); 
    /*         if(!empty($line_name) && $this->showEditData == 1){
//                   $value = '<?php if(isset($order->{"$line_name)) echo $order->{"'.$line_name. '  ';
                   $value = '<?php if(isset($line->{"$line_name"})) echo $line->{"'.$line_name. '"} ?>';
             }else{
                if(!empty($name)){
                   $value = '<?php if(isset($order->{"'.$name.'"})) echo $order->{"'.$name. '"} ?>';
                }
             }*/
         if(strpos($comparevalue, ',') > -1){
             $yz  = explode(',',$comparevalue); 
             $arry = '';
             foreach ($yz as $y1){
                 $arry .= "'$y1',";
             }
             
           if(!empty($line_name) ){
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  in_array(\$line->{"$flShowOnClick"},array($arry) )){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  in_array(\$order->{"$flShowOnClick"},array($arry)) ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }else{
                         
         if(strpos($comparevalue, '|') > -1){
             $yz  = explode('|',$comparevalue); 
             $arry = '';
             foreach ($yz as $y1){
                 $arry .= "'$y1',";
             }
//                 echo 3;            echo $comparevalue; die();
           if(!empty($line_name) ){
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  in_array(\$line->{"$flShowOnClick"},array($arry) )){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  in_array(\$order->{"$flShowOnClick"},array($arry)) ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }else{
           if(!empty($line_name) ){
               
                if(strpos($y, '"') > -1 || strpos($y, "'") > -1){
                    $y = addslashes($y);
                }
               
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$line->{"$flShowOnClick"}) &&  \$line->{"$flShowOnClick"} == "$y" ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }else{
               
                if(strpos($y, '"') > -1 || strpos($y, "'") > -1){
                    $y = addslashes($y);
                }
                              
                            $viewhidediv = <<<VIEWH
                                    <?php 
                              if(isset(\$order->{"$flShowOnClick"}) &&  \$order->{"$flShowOnClick"} == "$y" ){   ?>        
                                    <?php }else{ ?>style="display:none"
                                 <?php }    ?>
VIEWH;
           }    
                        }        
                        }        
                        
                            $hidediv .= '  '.$viewhidediv.' data-val="'.$y.'" data-name="" data-parent-name="'.$field['ShowOnClick'].'" ';
                    
                        }else
                            $hidediv .= '  style="display:none" data-val="'.$y.'" data-name="" data-parent-name="'.$ShowOnClick.'" ';
        }
        
        $element = <<<ELEMENT
    <div class=" box-body form-group" {$hidediv} >
        {$field_data}
    </div>

ELEMENT;
        if($hr == 1)
         $element .= '<hr/>';
                    
        return $element;
    }
    public function getViewElements($field,$value,$name) {
        
            $hr = $this->getKeyValue($field,'hr',false);
            $id = $this->getKeyValue($field,'id',false);
         $valuex = $value;
         
         
                
        if($this->hasManyData == 1){ 
              $mapvariablex = 'line';
              $mapvariable = '$'.$mapvariablex.'->{"'.$id.'"}';
          }else{
              $mapvariablex = 'order';
              $mapvariable = '$'.$mapvariablex.'->{"'.$name.'"}';
          }
                
         
        if( key_exists('type', $field) ){
        switch($field['type']){ 
            case 'button' : return ''; 
            case 'canvas' : $attributes = array('style' => 'min-height:70px;','name' => $field['name']);
                             if($this->viewType == 'view'){
                                 $valuex = $this->formSignatureTag($field, $attributes,$value);
                             }else{
                                 
                                 $valuex = $this->getCanvasPDFImage($field);
                            }
                            break;
            case 'file' :  if($this->viewType == 'view'){
                                $valuex = html_tag('input', array(

                                            'type' => 'hidden', 
                                            'class' => 'file-upload-control', 
                                            'value' => $value,
                                            'name' => $field['name']
                                        ));
                            }else{
                                
                                $valuex =  $this->getFileDisplay($field);
                            }
                        break;
            case 'textarea' :   
                            $valuex = '<?php if(isset('.$mapvariable.')) echo  htmlspecialchars_decode('.$mapvariable.'); ?>';
                        break;
            case 'select' :  
                            $valuex = $this->getformOption($field['name'], $field['values'], $value,$id);
                        break;
           case "bankdetails" :   
                            $valuex = $this->getBankOptions($field['name'], $field, $value,$id);
                        break;
            case 'radio-group' :   
                            $form = new \Form();
//                            $valuex = $this->formGroupViewtags($field, $value);
//                            $valuex = $this->formGroupViewtags($field, $value);
                            $valuex = $this->formGrouptags('radio',$field,$form,$value);
                        break;
            case 'checkbox-group' :  
                            $form = new \Form();
//                            $valuex = $this->formGroupViewtags($field, $value);
//                            $valuex = $this->formGroupViewtags($field, $value);
                            $valuex = $this->formGrouptags('checkbox',$field,$form,$value);
                        break;
            case 'editabletext' :    $valuex = $this->formEditableTextTag($field,array(),$value);
                                     break;
            case 'date' :  $dateType = $this->getKeyValue($field,'DateType');
                
                 if($this->hasManyData == 1){ 
                     $name = $id;
                 }
                            if($dateType == 2){
                                
                                $valuex = '<?php if(isset($'.$mapvariablex.'->{"'.$name.'_date"}) && !empty($'.$mapvariablex.'->{"'.$name.'_date"})) echo  htmlspecialchars_decode($'.$mapvariablex.'->{"'.$name. '_date"}); ?>-';
                                $valuex .= '<?php if(isset($'.$mapvariablex.'->{"'.$name.'_month"}) && !empty($'.$mapvariablex.'->{"'.$name.'_month"})) echo  htmlspecialchars_decode($'.$mapvariablex.'->{"'.$name. '_month"}); ?>-';
                                $valuex .= '<?php if(isset($'.$mapvariablex.'->{"'.$name.'_year"}) && !empty($'.$mapvariablex.'->{"'.$name.'_year"})) echo  htmlspecialchars_decode($'.$mapvariablex.'->{"'.$name. '_year"}); ?>';
                            }else{
                                     $valuex = '<?php if(isset('.$mapvariable.') && !empty('.$mapvariable.')) echo  date("d-m-Y", strtotime('.$mapvariable.')); ?>';
                            
                            }
                        break;
            case 'hr' :   
//                            $valuex = '<hr/>';
                            $valuex = '';
                        break;
        }
        }
        
        if($hr == 1)
            $valuex .= '<hr/>';
        
        return $valuex;
    }
    public function formSignatureTag($field = array(), $attributes = array(), $value = '') {
                
        $tag = '';
        $style = '';
        
            $bgcolor = $this->getKeyValue($field, 'bgcolor',false);
            $textcolor = $this->getKeyValue($field, 'textcolor',false);
        
            if(!empty($bgcolor)){
                $style .= 'background-color:'.$bgcolor.'!important;';
                $style .= 'border: 1px solid '.$bgcolor.'!important;';
                $style .= 'background-image: -webkit-gradient(linear,0 0,0 100%,from('.$bgcolor.'),to('.$bgcolor.'));';
            }
            if(!empty($textcolor)){
                $style .= 'color:'.$textcolor.'!important;';
            }
            
            
        if(in_array($this->viewType,array('edit','viewandsign', 'create','pdflabeler'))){
            
            $attributes['type']= 'hidden';
            if($this->formtype == '1'){
                $attributes['class']= 'signature-btn';
            }else{
                $attributes['class']= 'signature-btn-popup';
            }
            
            
            $required = $this->getKeyValue($field,'required');  
            if($required == 1) $attributes['class'] .= ' requiredfield ';
            
            if(isset($this->autosave) && $this->autosave == 1){
                 $attributes['class'] .= ' input-modify-elmor ';
            }

            $input_tag = html_tag('input', $attributes);
             $tag = <<<TAG
                {$input_tag}
TAG;
        }

        $img= '';
         
        unset($attributes['type']);
        
        $attributes['label']= $field['label'];
        $attributes['id']= $field['name'];
        $attributes['style']= $style;
        
        
        
        if(in_array($this->viewType,array('edit','viewandsign', 'create','pdflabeler'))){ 
            
            if($this->formtype == '1'){
                $attributes['class']= 'btn btn-primary signature-btn text-center';  
            }else{
                $attributes['class']= 'btn btn-primary signature-btn-popup text-center';
            }
            $field['label'] = htmlspecialchars_decode($field['label']);
                $img = $field['label'];
             $div_tag =  html_tag('button',$attributes,$img);
             
        }else{
            
            if($this->formtype == '1'){
                $attributes['class']= 'box signature-btn text-center'; 
            }else{
                $attributes['class']= 'box signature-btn-popup text-center';
            }
            
            if(!empty($value)) {
                $img = ' <?php if(isset($order->{"'.$field['name'].'"}) && !empty($order->{"'.$field['name'].'"})){ ?> ';
                $img .= html_tag('img', array(
                    'class' => 'img-responsive pad' ,
                    'src' => $value));
                $img .= '<?php } ?> ';
            }else{
                $img .= $field['label'];
                $img = htmlspecialchars_decode($img);
            }
         
           
            $div_tag =  html_tag('div',$attributes,$img);
        } 
         
        $tag .= <<<TAG
                {$div_tag}
TAG;
        return $tag;
    }

    public function formFileTag($field = array(), $attributes = array()) {
        
        $attributes['multiple'] = $this->getKeyValue($field,'multiple');
        
        $attributes['class'] =  $attributes['class'].' file-upload-control';
        $attributes['maxlimit'] = $this->getKeyValue($field,'maxlimit');
        $attributes['readonly'] = $this->getKeyValue($field,'readonly');
           
        $bgcolor = $this->getKeyValue($field, 'bgcolor',false);
        $textcolor = $this->getKeyValue($field, 'textcolor',false);
        $style = '';
        
        if(!empty($bgcolor)){
            $style .= 'background-color:'.$bgcolor.'!important;';
            $style .= 'border: 1px solid '.$bgcolor.'!important;';
            $style .= 'background-image: -webkit-gradient(linear,0 0,0 100%,from('.$bgcolor.'),to('.$bgcolor.'));';
        }
        if(!empty($textcolor)){
            $style .= 'color:'.$textcolor.'!important;';
        }
        
            $style .= 'padding: 6px 13px;border-radius: 4px;';
            
        if(empty($attributes['maxlimit'])){
            $attributes['maxlimit'] = 1;
        }
        
        if(!empty($attributes['readonly'])){
            $attributes['readonly'] .="onclick='return false;'";
        }
        
        $attributes['data-url']="/dynamicformssystem/forms/createImagex";
           
            $label = htmlspecialchars_decode($attributes['label']);

            $attributes['label'] = strip_tags(html_entity_decode($label)); 
        $attributes['style'] = '    opacity: 0;
    z-index: 111; 
    width: 98px;
    margin-right: 25%;';
        
        
            if(isset($this->autosave) && $this->autosave == 1){
                 $attributes['class'] .= ' input-modify-elmor ';
            }

//          $attributes['label'] = addslashes($attributes['label']);
        $input_tag = html_tag('input', $attributes );
        $tag = <<<TAG
{$input_tag}
        
TAG;
        unset($attributes['id']);
        $attributes['type'] = 'hidden';
           $attributes['label'] = addslashes($attributes['label']);
//           $attributes['label'] = strip_tags($attributes['label']);
           
            $label = htmlspecialchars_decode($attributes['label']);

            $attributes['label'] = strip_tags(html_entity_decode($label)); 
           
        $input_tag_hidden = html_tag('input', $attributes);
        
        $tag .= <<<TAG
    {$input_tag_hidden}
TAG;
                
        $attributesbtn =  $attributes;
        $attributesbtn['style'] =  '    margin-left: 32px;    margin-top: -27px;';
        $attributesbtn['class'] =  ' pull-left file-upload-button file-upload-control';
//        $attributesbtn['class'] =  ' pull-left file-upload-button ';
        $attributesbtn['onclick'] =  'return false;';  
        $attributesbtn['style'] = $style;
        $label =  ( $attributesbtn['label']);
//        $attributesbtn['label'] = trim( $attributesbtn['label']);
//        $label = htmlspecialchars_decode($attributesbtn['label']);
//
//        $labelx = strip_tags(html_entity_decode($label)); 
        unset($attributesbtn['label']);
           
        $button =    html_tag('button', $attributesbtn,$label);
        
                 $tag .= <<<TAG
    {$button}
TAG;
        return $tag;                        
    }

    public function formAutocompleteTag($field = array(), $attributes = array(), $value = '') {
                                                
        $field_new =    $this->mapAutocompleteField($field);
        $attributes['type']= "text";
        $attributes['href']= $this->getKeyValue($field_new,'href');
        $attributes['map-controller']= $this->getKeyValue($field_new,'map-controller');
        $attributes['name']= $this->getKeyValue($field,'name');
        $attributes['autocomplete']= "off";
        $attributes['class']= "popup-autocomplete ui-autocomplete-input";
        $field_name = ''; 
        
        if(isset($this->autosave) && $this->autosave == 1){
             $attributes['class'] .= ' input-modify-elmor ';
        }
        $subtype = $this->getKeyValue($field,'subtype'); 
        
        switch ($subtype){

            case 'customer name' :   $attributes['mapper'] = 'name';
                                     $field_name = 'customer_id';
                                     $attributes['id']= "customer_id";
                                    $attributes['class'] .=' hidden_customer_id';
                                    $attributes['value'] = $value;
                                     break;
            case 'customer number' :  $attributes['mapper'] = 'customer_key';
                                     $field_name = 'customer_id';
                                     $attributes['id']= "customer_id";
                                    $attributes['class'] .=' hidden_customer_id';
                                    $attributes['value'] = $value;
                                      break;
            case 'product name' :  $attributes['mapper'] = 'item_name';
                                     $field_name = 'product_id';
                                     $attributes['id']= "product_id";
                                    $attributes['class'] .=' hidden_product_id';
                                    $attributes['value'] = $value;
                                      break;
            case 'product number' :  $attributes['mapper'] = 'item_key';
                                     $field_name = 'product_id';
                                     $attributes['id']= "product_id";
                                    $attributes['class'] .=' hidden_product_id';
                                    $attributes['value'] = $value;
                                      break;
        } 
        
        $tag_element =  html_tag('input', $attributes);
        $tag = <<<TAG
{$tag_element}
            
TAG;
        $attributes['class']= "popup-autocomplete updateflag ui-autocomplete-input";
        $attributes['type']= "hidden";
        
        $attributes['id']= "hidden_".$attributes['id'];
        $attributes['name']= $field_name; 
        
        $value_new = '<?php if(isset($order->{"'.$attributes['name'].'"})) echo $order->{"'.$attributes['name'].'"} ?>';
        $attributes['value']= $value_new; 
        $tag_element_id =  html_tag('input', $attributes);
        $tag .= <<<TAG
{$tag_element_id}
TAG;
        
        return $tag;
    }
    
    public function getFileDisplay($field) {
        
        
        if(empty($field))            return '';
        
        $fileDisplay = <<<FILEDISPLAY
            <?php if(isset(\$order->{"{$field['name']}"})){ 
                
                if(strpos(\$order->{"{$field['name']}"},',') !== false)
                  \$imageids =   explode(',',\$order->{"{$field['name']}"});
                else
                    \$imageids = array(\$order->{"{$field['name']}"});
                
                if(is_array(\$imageids) && count(\$imageids) > 0){
                    foreach(\$imageids as \$img){
                        
                       \$image =  \Model_Image::find(\$img);
                       
                       if(is_object(\$image)){
                            
                            \$imagepath = '/'.\$image->model_to.'/'.\$image->name;    
                                
                            if(file_exists(DOCROOT.\$imagepath)){ ?>
                                <img src="<?php echo \$imagepath ?>" style="width:100px;height:auto;"/>
                          <?php  }
                       }
                    }
                }
            }
             ?>    
FILEDISPLAY;
        
        return $fileDisplay;
        
    }

    public function getCanvasPDFImage($field) {
        
        if(empty($field))            return '';
        
        $canvas = <<<CANVAS
                <?php
                  \$temp = \$order->{"{$field['name']}"};
                        \$id = \$order->id;
                        \$name = "canvas";
                        \$filenamejpg = \Attachment::base64_to_jpeg(\$temp,\$id,\$name);  
                        \$output_file_jpg = 'assets/img/'.\$filenamejpg;
                        if(file_exists(\$output_file_jpg)){
                          echo \Asset::img(\$filenamejpg, array('id' => 'logo', 'alt'=>"img", 'style'=>'margin: -80px 0px; height: 65px; width: 150px;'));  
                        }
                  ?>
CANVAS;
            
        return $canvas;
    }

    public function getTag($field = array(),$value = null) {
        
        $tag = "";
        
        if(is_array($field)){
                
            $form = new \Form();
            $className = $this->getKeyValue($field,'className');  
            $required = $this->getKeyValue($field,'required');  
            if($required == 1) $className .= ' requiredfield ';
            
            $type = $this->getKeyValue($field,'type');  
            $label = $this->getKeyValue($field,'label');  
            $placeholder = $this->getKeyValue($field,'placeholder');
            $required = $this->getKeyValue($field,'required',false);
            $flow = $this->getKeyValue($field,'flow',false);
            $dateType = $this->getKeyValue($field,'DateType',false);
            $datasize = $this->getKeyValue($field,'size',false);
            $maxlength2 = $this->getKeyValue($field,'maxlength2',false);
            $calculate = $this->getKeyValue($field,'calculate',false);
            $fix_value = $this->getKeyValue($field,'fix_value',false);
            $show_total = $this->getKeyValue($field,'show_total',false);
            $attr_name = $this->getKeyValue($field,'attr_name',false);
            $math_value = $this->getKeyValue($field,'math_value',false);
            $add_value = $this->getKeyValue($field,'add_value',false);
            $subtract_value = $this->getKeyValue($field,'subtract_value',false);
            $multiply_value = $this->getKeyValue($field,'multiply_value',false);
            $divide_value = $this->getKeyValue($field,'divide_value',false);
            $tax_value = $this->getKeyValue($field,'tax_value',false);
            $discount_value = $this->getKeyValue($field,'discount_value',false);
            $show_add_total = $this->getKeyValue($field,'show_add_total',false);
            $show_subtract_total = $this->getKeyValue($field,'show_subtract_total',false);
            $show_multiply_total = $this->getKeyValue($field,'show_multiply_total',false);
            $show_divide_total = $this->getKeyValue($field,'show_divide_total',false);
            $show_tax_total = $this->getKeyValue($field,'show_tax_total',false);
            $show_discount_total = $this->getKeyValue($field,'show_discount_total',false);
            $parent_math_value = $this->getKeyValue($field,'parent_math_value',false);
            $calculate_class = $this->getKeyValue($field,'calculate-class',false);
            $model = $this->getKeyValue($field,'model',false);
            $id = $this->getKeyValue($field,'id',false);
            $show_final_total = $this->getKeyValue($field,'show_final_total',false);
            
            $bgcolor = $this->getKeyValue($field, 'bgcolor',false);
            $textcolor = $this->getKeyValue($field, 'textcolor',false);
//            $hr = $this->getKeyValue($field,'hr',false);
            
            if(key_exists('showElementList', $field) && count($field['showElementList']) > 0){
                
//                $className .= ' showMoreOption';
                $className .= ' showMoreOptionMulti';
            }
            
            $className .= $this->getValidationClass($field);
            $label = htmlspecialchars($label);
            $label = addslashes($label);
//            if($required == 1) $required = 'required';
            if($required == 1) $className .= ' requiredfield ';
//            $label = htmlspecialchars($label);  
            
            if($this->viewType == 'pdflabeler'){
                $placeholder = $this->getKeyValue($field,'name');
            }else
            $placeholder = htmlspecialchars($placeholder);    
                
            $attributes = array(   'type' => $type,
                                    'class' => $className,
                                    'label' => $label,
//                                    'required' => $required,
                                    'placeholder' => $placeholder,
                                    'value' => $value, 
                                    'autocomplete' => 'off', 
                                    'attr-name' => $attr_name, 
                                    'name' => $this->getKeyValue($field,'name')   
                                );
            
            
            if(isset($this->autosave) && $this->autosave == 1){
                 $attributes['class'] .= ' input-modify-elmor ';
            }
            if(isset($show_final_total) && !empty($show_final_total) && $show_final_total != '--select--'){
                
                  $show_final_total = str_replace('-', '_', $show_final_total);
                                    
                $attributes['show-final-total'] = $show_final_total;
                 
                 $attributes['class'] .= ' show_final_total ';
            }
            if(isset($model) && !empty($model)){
                 $attributes['model'] = $model;
            }
            if(isset($parent_math_value) && !empty($parent_math_value)){
                 $attributes['parent_math_value'] = $parent_math_value;
            }
            if(isset($id) && !empty($id)){
                 $attributes['id'] = $id;
            }
            $disabled = 0;
            switch ($flow){
                
                case 1:     
//                    if  (in_array($this->viewType, array('edit','viewandsign')) && $this->showEditData == 1){
//                    if  (in_array($this->viewType, array('viewandsign')) && $this->showEditData == 1){
                    if  (in_array($this->viewType, array('viewandsign'))){
                              $attributes['readonly'] = 'readonly';
                            $disabled = 1;
                            }
                              if ($this->flowSystem == 1 && $this->viewType == 'edit' ){
                                        $flowstyle = 'readonly="readonly"';
                                        $disabled = 1; 
                                    }
                        break;
                case 2: if ($this->viewType == 'create' ){
                            $attributes['readonly'] = 'readonly';
                            $attributes['style'] = 'display:none';
                            $disabled = 1;
//                            $attributes['disabled'] = 'disabled';
                            }
                                     
                            if (  $this->viewType == 'pdflabeler'){ 
                                $flowstyle = '';
//                                $disabled = 1; 
                            }
                                    
                        break;
                case 12:    if ($this->viewType == 'create' || $this->viewType == 'pdflabeler'){
//                                        $attributes['readonly'] = 'readonly';
                                $flowstyle = '';
                                $disabled = ''; 
                            } 
                        break;
                default:  if ($this->flowSystem == 1 && $this->viewType == 'edit' ){
                                        $flowstyle = 'readonly="readonly"';
                                        $disabled = 1; 
                                    }
                        break;
            }
            
            switch ($type){
                
                case "select" :  if($disabled == 1 )
                                    $field['disabled'] = 'disabled'; 
                
                                $tag = $this->formSelectTag($field,$value);                                 
                                 break;
                            
                case "checkbox-group" :  if($disabled == 1 )
                                            $field['disabled'] = 'disabled';
                
                                            $tag = $this->formGrouptags('checkbox',$field,$form,$value);
                                break;
                            
                case "radio-group" :  if($disabled == 1 )
                                            $field['disabled'] = 'disabled';
                                        $tag = $this->formGrouptags('radio',$field,$form,$value);
                                break;
                                
                case "textarea" :   
                                $textarea_type = $field['subtype'];
                  
                                if(key_exists('id', $field))
                                $field["id"] = $this->getKeyValue($field,'id') ;
                                else {
                                     $field["id"] = $this->getKeyValue($field,'name') ;
                                }
                                $textarea_disabled = '';
                                if($disabled == 1 )
                                    $textarea_disabled = 'readonly';
                                
                                $datesizetext = '';
                
                                if(!empty($maxlength2) )
                                    $datesizetext = 'data-size="'.$maxlength2.'"';
                                
                                 if(isset($this->autosave) && $this->autosave == 1){
                                        $className .= ' input-modify-elmor ';
                                   }
                                
                                    $tag =  "<textarea  id='".$field["id"]."' type='".$textarea_type."' $textarea_disabled $datesizetext class='$className' name='".$field["name"]."' placehoder='".$placeholder."'>".$value."</textarea>";
                
                                    break;                             
                            
                case "file" :   if($disabled == 1 )
                                        $attributes['readonly'] = 'readonly'; 
                                $tag = $this->formFileTag($field,$attributes,$value);
                                break;
                            
                case "canvas" : if($disabled == 1 )
                                    $attributes['disabled'] = 'disabled'; 
                                $tag = $this->formSignatureTag($field,$attributes,$value);
                                break;
                case "date" :   if($disabled == 1 )
                                    $attributes['readonly'] = 'readonly'; 
                               
                                if($dateType == 2){
                                    $tag = '';
                                    
                                    
                                    $this->minYearValue =  $this->getKeyValue($field,'year',1940);
                                    
                                    $attributes_year = $attributes;
                                    $attributes_year['type'] = 'select'; 
                                    $attributes_year['className'] = 'span4';
                                    $attributes_year['name'] = $attributes_year['name'].'_year';
                                    $attributes_year['values'] = $this->getYearValues();
                                    if($this->viewType == 'pdflabeler'){
                                        $attributes_year['placeholder'] = $attributes_year['name'];
                                    }
                                    
                                    $tag .= $this-> getTag($attributes_year,$value);
                                    $tag .= '&nbsp&nbsp';
                                    
                                    $attributes_month = $attributes;
                                    $attributes_month['type'] = 'select';
                                    $attributes_month['className'] = 'span3 date-col';
                                    $attributes_month['name'] = $attributes_month['name'].'_month';
                                    $attributes_month['values'] = $this->getMonthValues();
                                    if($this->viewType == 'pdflabeler'){
                                        $attributes_month['placeholder'] = $attributes_month['name'];
                                    }
                                    
                                    $tag .= $this-> getTag($attributes_month,$value);
                                    $tag .= '&nbsp&nbsp';
                                    
                                    $attributes['className'] = 'span3 date-col';
                                    
                                    $attributes_date = $attributes;
                                    $attributes_date['type'] = 'select';
                                    $attributes_date['name'] = $attributes_date['name'].'_date'; 
                                    $attributes_date['values'] = $this->getDateValues();
                                    if($this->viewType == 'pdflabeler'){
                                        $attributes_date['placeholder'] = $attributes_date['name'];
                                    }
                                    $tag .= $this->getTag($attributes_date,$value);
                                    
                                    
                                }else{
                                    $tag = html_tag('input', $attributes);
                                }
                                    break;
                case "address" :   
                                    if($disabled == 1 )
                                    $attributes['readonly'] = 'readonly'; 
                                    
                                    $attributes['type'] = 'text'; 
                                    $attributes['class'] = 'form-control'; 
                                    
                                    
                                    $tag = $this->formAddressTag($field,$attributes,$value);      
                                    
                                    break;
                case "bankdetails" :   
                                    if($disabled == 1 )
                                    $attributes['readonly'] = 'readonly'; 
                                    
                                    $attributes['type'] = 'text'; 
                                    $attributes['class'] = 'form-control'; 
                                    
                                    
                                    $tag = $this->formBankdetailsTag($field,$attributes,$value);      
                                    
                                    break;
                case "text" :  $attributes['type']= $this->getKeyValue($field,'subtype');
                
                                if(!empty($datasize) )
                                    $attributes['data-size'] = $datasize;
                                if(!empty($show_total) && $show_total != '--select--'){
                                    
                                    $show_total = str_replace('-', '_', $show_total);
//                                    print_r($show_total); die();
//                                    print_r($show_total); die();
                                    $attributes['show-data-total'] = $show_total;
                                }
                                
                                
                                if(!empty($math_value) && $math_value != '--select--'){
                                    
                                    $math_value = str_replace('-', '_', $math_value);
                                    
                                    $attributes['math-value'] = $math_value;
                                }
                                if(!empty($add_value) && $add_value != '--select--'){
                                    
                                    $add_value = str_replace('-', '_', $add_value);
                                    
                                    $attributes['add-value'] = $add_value;
                                }
                                if(!empty($subtract_value) && $subtract_value != '--select--'){
                                    
                                    $subtract_value = str_replace('-', '_', $subtract_value);
                                    
                                    $attributes['subtract-value'] = $subtract_value;
                                }
                                if(!empty($multiply_value) && $multiply_value != '--select--'){
                                    
                                    $multiply_value = str_replace('-', '_', $multiply_value);
                                    
                                    $attributes['multiply-value'] = $multiply_value;
                                }
                                if(!empty($divide_value) && $divide_value != '--select--'){
                                    
                                    $divide_value = str_replace('-', '_', $divide_value);
                                    
                                    $attributes['divide-value'] = $divide_value;
                                }
                                if(!empty($tax_value) && $tax_value != '--select--'){
                                    
                                    $tax_value = str_replace('-', '_', $tax_value);
                                    
                                    $attributes['tax-value'] = $tax_value;
                                }
                                if(!empty($discount_value) && $discount_value != '--select--'){
                                    
                                    $discount_value = str_replace('-', '_', $discount_value);
                                    
                                    $attributes['discount-value'] = $discount_value;
                                }
                                if(!empty($show_add_total) && $show_add_total != '--select--'){
                                    
                                    $show_add_total = str_replace('-', '_', $show_add_total);
                                    
                                    $attributes['show-add-total'] = $show_add_total;
                                }
                                if(!empty($show_subtract_total) && $show_subtract_total != '--select--'){
                                    
                                    $show_subtract_total = str_replace('-', '_', $show_subtract_total);
                                    
                                    $attributes['show-subtract-total'] = $show_subtract_total;
                                }
                                if(!empty($show_multiply_total) && $show_multiply_total != '--select--'){
                                    
                                    $show_multiply_total = str_replace('-', '_', $show_multiply_total);
                                    
                                    $attributes['show-multiply-total'] = $show_multiply_total;
                                }
                                if(!empty($show_divide_total) && $show_divide_total != '--select--'){
                                    
                                    $show_divide_total = str_replace('-', '_', $show_divide_total);
                                    
                                    $attributes['show-divide-total'] = $show_divide_total;
                                }
                                if(!empty($show_tax_total) && $show_tax_total != '--select--'){
                                    
                                    $show_tax_total = str_replace('-', '_', $show_tax_total);
                                    
                                    $attributes['show-tax-total'] = $show_tax_total;
                                }
                                if(!empty($show_discount_total) && $show_discount_total != '--select--'){
                                    
                                    $show_discount_total = str_replace('-', '_', $show_discount_total);
                                    
                                    $attributes['show-discount-total'] = $show_discount_total;
                                }
                
                                
                                if($calculate > 0){       
                                    
                                    if(key_exists('class', $attributes)){
                                           $attributes['class'] .= ' calculate ';
                                    } else {
                                           $attributes['class'] = ' calculate ';
                                    }
                                    
                                    $op = $this->getMathOperation($calculate);
                                    
                                    $attributes['data-operation'] = $op;
//                                    $attributes['data-operation'] = $op;
                                    $attributes['class'] .= " $op";
//                                    $attributes['data-operation'] = $op;
                                }
                                
                                if(key_exists('class', $attributes)){
                                    $attributes['class'] .= " $calculate_class";
                                }
                                        
                                
                                 if($disabled == 1 )
                                    $attributes['readonly'] = 'readonly'; 
                                 
                                    $tag = html_tag('input', $attributes);
                                    break;
                case "time" :  
                                $className = 'form-control';
                                if($this->hasManyData == 1){
                                    $className .=' form-fields ';
                                    $mapvariable = 'line';
                                }else{
                                    $mapvariable = 'order';
                                }
                                
                                 if($disabled == 1 )
                                    $attributes['readonly'] = 'readonly'; 

                                if($required == 1) 
                                    $className .= ' requiredfield '; 
                                
                                $attributes['class']= $className;
                                    $tag = html_tag('input', $attributes);
                                    break;
                            
                case "button"  :   if($disabled == 1 )
                                    $attributes['disabled'] = 'disabled'; 
                    
                                    $attributes['type']= $field['subtype'];
                                    $attributes['value']= '';
                                    $label = htmlspecialchars_decode($label);  
                                    $labelx = strip_tags(html_entity_decode($label));  
                                    $attributes['class']= "  ";
                                    $attributestyle= '';
                                    if(!empty($bgcolor)){
                                        $attributestyle .= "background-color:$bgcolor; border:1px solid $bgcolor; ";
                                    $attributes['class'] .= "button ";
                                    } else{
                                        
                                    $attributes['class'] .= "btn btn-primary ";
                                    }
                                    if(!empty($textcolor)){
                                        $attributestyle .= "color:$textcolor; ";
                                    } 
                                    
                                    $attributes['style']= $attributestyle;
//                                    $tag = html_tag('input', $attributes);
                                    $tag = html_tag('button', $attributes,$labelx);
                                        break;
                case "autocomplete"  :   $tag = $this->formAutocompleteTag($field,$attributes,$value);
                
                                     break;
                case 'editabletext' :    $tag = $this->formEditableTextTag($field,$attributes,$value);
                                     break;
                case "hidden"  :    
                                    $attributes['type'] = 'hidden';
                                    $attributes['value'] = $fix_value;
                 if(!empty($show_total) && $show_total != '--select--'){
                                    
                                    $show_total = str_replace('-', '_', $show_total);
                                    
                                    $attributes['show-data-total'] = $show_total;
                                }
                                
                                
                                
                                if(!empty($math_value) && $math_value != '--select--'){
                                    
                                    $math_value = str_replace('-', '_', $math_value);
                                    
                                    $attributes['math-value'] = $math_value;
                                }
                                if(!empty($add_value) && $add_value != '--select--'){
                                    
                                    $add_value = str_replace('-', '_', $add_value);
                                    
                                    $attributes['add-value'] = $add_value;
                                }
                                if(!empty($subtract_value) && $subtract_value != '--select--'){
                                    
                                    $subtract_value = str_replace('-', '_', $subtract_value);
                                    
                                    $attributes['subtract-value'] = $subtract_value;
                                }
                                if(!empty($multiply_value) && $multiply_value != '--select--'){
                                    
                                    $multiply_value = str_replace('-', '_', $multiply_value);
                                    
                                    $attributes['multiply-value'] = $multiply_value;
                                }
                                if(!empty($divide_value) && $divide_value != '--select--'){
                                    
                                    $divide_value = str_replace('-', '_', $divide_value);
                                    
                                    $attributes['divide-value'] = $divide_value;
                                }
                                if(!empty($tax_value) && $tax_value != '--select--'){
                                    
                                    $tax_value = str_replace('-', '_', $tax_value);
                                    
                                    $attributes['tax-value'] = $tax_value;
                                }
                                if(!empty($discount_value) && $discount_value != '--select--'){
                                    
                                    $discount_value = str_replace('-', '_', $discount_value);
                                    
                                    $attributes['discount-value'] = $discount_value;
                                }
                                if(!empty($show_add_total) && $show_add_total != '--select--'){
                                    
                                    $show_add_total = str_replace('-', '_', $show_add_total);
                                    
                                    $attributes['show-add-total'] = $show_add_total;
                                }
                                if(!empty($show_subtract_total) && $show_subtract_total != '--select--'){
                                    
                                    $show_subtract_total = str_replace('-', '_', $show_subtract_total);
                                    
                                    $attributes['show-subtract-total'] = $show_subtract_total;
                                }
                                if(!empty($show_multiply_total) && $show_multiply_total != '--select--'){
                                    
                                    $show_multiply_total = str_replace('-', '_', $show_multiply_total);
                                    
                                    $attributes['show-multiply-total'] = $show_multiply_total;
                                }
                                if(!empty($show_divide_total) && $show_divide_total != '--select--'){
                                    
                                    $show_divide_total = str_replace('-', '_', $show_divide_total);
                                    
                                    $attributes['show-divide-total'] = $show_divide_total;
                                }
                                if(!empty($show_tax_total) && $show_tax_total != '--select--'){
                                    
                                    $show_tax_total = str_replace('-', '_', $show_tax_total);
                                    
                                    $attributes['show-tax-total'] = $show_tax_total;
                                }
                                if(!empty($show_discount_total) && $show_discount_total != '--select--'){
                                    
                                    $show_discount_total = str_replace('-', '_', $show_discount_total);
                                    
                                    $attributes['show-discount-total'] = $show_discount_total;
                                }
                                
                                if($calculate > 0){       
                                    
                                    if(key_exists('class', $attributes)){
                                           $attributes['class'] .= ' calculate ';
                                    } else {
                                           $attributes['class'] = ' calculate ';
                                    }
                                    
                                    $op = $this->getMathOperation($calculate);
                                    
                                    $attributes['data-operation'] = $op;
                                    $attributes['data-operation'] = $op;
                                }
                                
                                 if(key_exists('class', $attributes)){
                                    $attributes['class'] .= " $calculate_class";
                                }
                                   
                                
                                    $tag = html_tag('input', $attributes);
                                    break; 
                case 'hr' :   
//                                $tag = '<hr/>';
                                $tag = '';
                            break;
                                    
            }
            
        }
        
//        if($hr == 1)
//         $tag .= '<hr/>';
        
        return $tag;
        
    }
    
    public function getValidationClass($field) {
        
        $val = $this->getKeyValue($field,'Validation',false);
        
        switch ($val){
            
            case 1:  $val = ' validateId'; break;
            case 2:  $val = ' validateCellPhone'; break;
            case 3:  $val = ' validateEmail'; break;
            default : $val = ''; break;
            
        }
        
        return $val;
    }

    public function formSelectTag($field = array(),$value = null) {
            
        $className = $this->getKeyValue($field, 'className');
        $values = $this->getKeyValue($field, 'values');
        $placeholder = $this->getKeyValue($field,'placeholder');
        $name = $this->getKeyValue($field, 'name');
        $disabled = $this->getKeyValue($field, 'disabled');
        $fieldid = $this->getKeyValue($field, 'id');
        $uploadCSV = $this->getKeyValue($field, 'uploadCSV');
       
        if(key_exists('showElementList', $field) && count($field['showElementList']) > 0){
            
              $className .= ' showMoreOptionMulti';
          }
        $selectvalue = '';
        $module  = strtolower($this->filename);
         $href = "";
        if($uploadCSV == 'yes' ){ 
            if($this->viewType == 'create'){ 
                $this->createSelectDataFiles($field);
            } 
            $original_title = $this->getKeyValue($field, 'attr_name'); 
            $namex = str_replace('_', '', $original_title);
            $namex = str_replace('-', '', $namex);  
            $href = ' href="/'.$module.'/'.$namex.'s"';
            $className .= ' getOptions '; 
            
            
                  
                if($this->hasManyData == 1){ 
                    $mapvariable = 'line';
                    $mapvariable = '$'.$mapvariable.'->{"'.$fieldid.'"}';
                }else{
                    $mapvariable = 'order';
                    $mapvariable = '$'.$mapvariable.'->{"'.$name.'"}';
                }
                
               $selectvalue = ' <?php if(isset('.$mapvariable.')) { echo "value=\'";  echo '.$mapvariable.'; echo "\'";} ?> ';
            
                $options = '';
        }else{
        
            $options = '';
            if (!empty($placeholder)) {
                $options = '<option disabled="null" selected="null" >' . $placeholder . '</option>';
            }
            $options .= $this->getformOption($name, $values,$value,$fieldid);
        }
        
        if(!empty($disabled)){ 
            $disabled = 'readonly';
        }

        $multiple = $this->getKeyValue($field,'multiple');

        if($multiple == 1){
            $multiple = 'multiple="true" ';
        }
        if(isset($this->autosave) && $this->autosave == 1){
                 $className .= ' input-modify-elmor ';
        }

        $tag = '<select class="'.$className.'" '.$href.'  '.$module.' id="'.$fieldid.'" '.$selectvalue.'  name="'.$name.'" '.$disabled.' '.$multiple.' >'.$options.'</select>';
        
        return $tag;
    }
    
    public function getformOption($name = '',$options = array(),$value = null,$fieldid =null) {
            
        $tag ='';
        $addSlash = 0;
        if (is_array($options)) {
            foreach ($options as $opt) { 
            
                if(key_exists('value',$opt) && !empty($opt['value'])){
                    if(strpos($opt['value'], '"') != false || strpos($opt['value'], "'") != false ){
//                     $opt['value'] = addslashes($opt['value']); 
                     $opt['value'] = ($opt['value']); 
                    }
                }
                if(key_exists('label',$opt) && !empty($opt['label'])){
                    if(strpos($opt['label'], '"')!= false  || strpos($opt['label'], "'") != false ){
//                     $opt['label'] = addslashes($opt['label']); 
                     $opt['label'] = $this->removeSingleQuote($opt['label']); 
                    }
                } 
                
                  
                if($this->hasManyData == 1){ 
                    $mapvariable = 'line';
                    $mapvariable = '$'.$mapvariable.'->{"'.$fieldid.'"}';
                }else{
                    $mapvariable = 'order';
                    $mapvariable = '$'.$mapvariable.'->{"'.$name.'"}';
                }
$value = "";                
                if($addSlash == 0){
               $value = <<<MAPV
                       <?php   
                if(isset($mapvariable)&& (strpos($mapvariable, '"') > -1 || strpos($mapvariable, "'") > -1)){
                    $mapvariable = addslashes($mapvariable);
                }
                    ?>
MAPV;
                }
                
               $addSlash++;
                
               $value .= <<<VAL
                       <?php     if(isset($mapvariable)&& $mapvariable == "
VAL;
               $value .= $opt['value'];
               
               if($this->viewType == 'view' || $this->viewType == 'pdf'){
                   
//                    $value .= '"){ echo "';
                    $value .= '"){ ?>';
                    $value .= $opt['label'].'<?php } ?>'; 

                    $opt_tag = $value;
                    
               }else{               
                $value .= '"){ echo "selected"; } ?>'; 
                $opt_tag = '<option value="'.$opt['value'].'" '.$value.' >'.$this->removeSingleQuote($opt['label']).'</option>'; 
               
               }
               $tag .= <<<TAG
        {$opt_tag}  
        
TAG;
            }
        }
        
        return $tag;
    }
                
    public function formGrouptags($type = '',$field = '',$form = '',$value = null) {
        
        $tags= '';
            
        $name = $this->getKeyValue($field,'name');  
        $required = $this->getKeyValue($field,'required',false);  
        $disabled = $this->getKeyValue($field,'disabled',false);  
        $fieldid = $this->getKeyValue($field,'id',false); 
        
        $className = 'cbx ';
        
        if(key_exists('showElementList', $field) && count($field['showElementList']) > 0){

//              $className .= ' showMoreOption';
              $className .= ' showMoreOptionMulti';
        }  
        if($this->hasManyData == 1){
            $className .=' form-fields ';
            $mapvariable = 'line';
            $mapvariable = '$'.$mapvariable.'->{"'.$fieldid.'"}';
        }else{
            $mapvariable = 'order';
            $mapvariable = '$'.$mapvariable.'->{"'.$name.'"}';
        }
        
        if(!empty($disabled)){
            $disabled = 'disabled';
            
//            $tags .= '<input type = "hidden" name="'.$name.'" value="<?php if(isset( $order->{"'.$name.'"})) echo $order->{"'.$name.'"};  " />';
            $tags .= '<input type = "hidden" name="'.$name.'" value="<?php if(isset( '.$mapvariable.')) echo '.$mapvariable.'; ?>" />';
        }else{
            
            if($this->viewType == 'view')
                $disabled = 'disabled';
            else
                $disabled = '';
        }
        
//        if($required == 1) $required = 'required';
        if($required == 1) $className .= ' requiredfield ';

        foreach ($field['values'] as $opt){
                
                if(key_exists('value',$opt) && !empty($opt['value'])){
                    if(strpos($opt['value'], '"') != false || strpos($opt['value'], "'") != false ){
//                     $opt['value'] = addslashes($opt['value']); 
                     $opt['value'] = $this->removeSingleQuote($opt['value']); 
                    }
                }
                if(key_exists('label',$opt) && !empty($opt['label'])){
                    if(strpos($opt['label'], '"')!= false  || strpos($opt['label'], "'") != false ){
//                     $opt['label'] = addslashes($opt['label']); 
                     $opt['label'] = $this->removeSingleQuote($opt['label']); 
                    }
                } 
              
                
//            $value .= '"}) && is_array($'.$mapvariable.'->{"'.$fieldid.'"}) && in_array("';
                
           if($type == 'radio')     {
                $value = '<?php   if(isset('.$mapvariable.') && !empty('.$mapvariable.')  '
                        . '&& '.$mapvariable.' == "';
                 $value .= $opt['value'];
                $value .= '"){';
            $value .= ' echo "checked"; }else{  ';  
            $value .= ' echo 0; }   ';  
            $value .= '     ?>'; 
           }else{
                
            $value = '<?php   if(isset('.$mapvariable.')){  '.$mapvariable.' = html_entity_decode('.$mapvariable.');   '
                    . ' if(isset('.$mapvariable.')  && !empty('.$mapvariable.')  && in_array("';
            $optval = addslashes($opt['label']);
            $value .= $optval;
            if($type == 'checkbox')
            {
                $value .='", json_decode('.$mapvariable.'';
                
            }else{ 
                $value .='", array('.$mapvariable.'';
            }
            $value .= ', true))){';
            $value .= ' echo "checked"; }else{  ';  
            $value .= ' echo 0; }   ';  
            $value .= '  }  ?>'; 
            
           } 
            
//            if($this->hasManyData == 1){
//                $className .=' form-fields ';
//            } 
            if(isset($this->autosave) && $this->autosave == 1){
                 $className .= ' input-modify-elmor ';
            }
//            $attr = array($value,'class'=>' '.$className ,'id'=>$fieldid,'required' => $required, $disabled => $disabled );
            $attr = array($value,'class'=>' '.$className ,'id'=>$fieldid, $disabled => $disabled );
//            $div_tag_open = '<div class="checkbox" style=" display: inline-flex;">'; 
            $div_tag_open = '<div class="checkbox checkboxDiv">'; 
            $tags .= <<<TAG
{$div_tag_open}
    
TAG;
                $name_map = $field['name'];
                
              
 if($type == 'checkbox'){ 
                    $name_map = $name_map.'[]';
               }
               
                
            $field_tag = $form->{$type}($name_map,$opt['value'],$attr);
            
            $tags .= <<<TAG
                    <div style="    padding: 0px 5px;">
            {$field_tag}
            </div>
TAG;
                    
            
            $field_tag_label = $opt['label']; 
            $tags .= <<<TAG
                    <div style="    margin-right: 16px;">
{$field_tag_label}
            </div>
            
TAG;
            $div_tag_close = '</div>'; 
            $tags .= <<<TAG
{$div_tag_close}   
            
TAG;
            
        } 
                
        return $tags;
    }
                
    public function formGroupViewtags($field = '',$value = null) {
        
        $tags= '';
           
        $type = $this->getKeyValue($field,'type');    
        $name = $this->getKeyValue($field,'name');   
        
            if($this->hasManyData == 1){ 
                $mapvariable = 'line';
            }else{
                $mapvariable = 'order';
            }
                
        
        foreach ($field['values'] as $opt){
                
                if(key_exists('value',$opt) && !empty($opt['value'])){
                    if(strpos($opt['value'], '"') != false || strpos($opt['value'], "'") != false ){
                     $opt['value'] = addslashes($opt['value']); 
                    }
                }
                if(key_exists('label',$opt) && !empty($opt['label'])){
                    if(strpos($opt['label'], '"')!= false  || strpos($opt['label'], "'") != false ){
                     $opt['label'] = addslashes($opt['label']); 
                    }
                } 
              $value = '<?php   if(isset($'.$mapvariable.'->{"';
            $value .= $name;
            $value .= '"})){  $'.$mapvariable.'->{"';
            $value .= $name;
            $value .= '"} = html_entity_decode($'.$mapvariable.'->{"';
            $value .= $name;
            $value .= '"});    if(isset($'.$mapvariable.'->{"';
            $value .= $name;
//            $value .= '"}) && is_array($'.$mapvariable.'->{"'.$name.'"}) && in_array("';
            $value .= '"})  && !empty($'.$mapvariable.'->{"';
            $value .= $name;
            $value .= '"})  && in_array("';
                
               $value .= $opt['value']; 
                if($type == 'checkbox-group')
                {
                    $value .='", explode(",",$'.$mapvariable.'->{"'; 

                }else{ 
                    $value .='", array($'.$mapvariable.'->{"';
                } 
                $value .= $name.'"}))){ ?>  ';
                   $div_tag_open = '<div class="checkbox">'; 
            $value .= <<<TAG
{$div_tag_open}
    
TAG;

               $value .= '<?php echo "'.$opt['label'].'";  ?>';  
            $div_tag_close = '</div>'; 
            $value .= <<<TAG
{$div_tag_close}   
            
TAG;
            $value .= '<?php } ?>';  
               
            $tags .= <<<TAG
{$value}
            
TAG;
        
            
        } 
        
        return $tags;
    }
    
    /***
     * Lang Creation
     */
    public function createLang() {
                        
        $this->type = 'lang';
        
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS;
        
        $this->createDirectory($this->filename);
        
        $this->createDirectory($this->type);
        
        $this->createDirectory('he');
        
        $this->file = 'he.php'; 
        
        $this->formLangData();                        
        
        $this->createFile();
    }

    public function formLangData() {
        
        $lang = <<<LANG
<?php   

    return array(
        'label' => array (
                    '{$this->filename}' => array(
    {$this->translation}),
    
      'reports' => 
        
            array( 
                'name' => 'מספר דוח', 
                'id' => 'מספר דוח', 
                ),
         'agents' =>array( 
            'label' => 'Label',
            'value' => 'Value',
            'mapvalue' => 'Mapvalue',
        ),            
    
    'elmor' => array (
            
             'fill_work_form' => 'מילוי יומן עבודה',
             'fill_username' => 'שם משתמש',
             'fill_password' => 'סיסמא',
             'clearbtn' => 'נקה טופס',
             'list_previous_work_log' => 'שם לקוח',
            
        ),  
    'bankdetails' =>array(
            'bankname' => 'Bank Name',
            'banknumber' => 'Bank Number',
            'branchname' => 'Branch Name',
            'branchcode' => 'Branch Code',
        ),
     'base' => array ( 'reset' => 'אתחל',
                'submit' => 'הכנס',
                ),
    
                ),   
        'base' => array (
                    '{$this->filename}\\{$this->controller}' => '{$this->form_title}',
                    '{$this->filename}/{$this->controller}' => '{$this->form_title}',
                    '{$this->filename}' => '{$this->form_title}',
                    '{$this->filename}\\agents' => 'Agents',
                    '{$this->filename}/agents' => 'Agents',  
                        'reset' => 'אתחל',
                'submit' => 'הכנס',
                ),
                    
          
    );              

?>
LANG;
        
        $this->filedata = $lang;
    }
    

        
    



    
    

    /**
     * logo upload
     */
    public function uploadLogo($id = null) {
        
         try{ 
             
          if(\Input::file('logo',0)){
                $config = array(
                            'randomize' => true,
                            'max_size' => 1000000,
                            'ext_whitelist' => array('JPG', 'JPEG','PNG','GIF','jpg', 'jpeg','png','gif'),
                            );
                \Upload::process($config);
                $key = key(\Upload::get_files('logo'));  
            }

        
                \Upload::save(DOCROOT.'Model_Products',$key);


                $files = \Upload::get_files('logo');
                 
                
                    if(key_exists($key, $files)){
                        $image = new \Model_Image();
                    $image->model_to = 'Model_Products';
                        $image->name = $files[$key]['saved_as'];
                          if(!is_null($id) && $id != 0){
                            $image->model_id = $id;
                          }
                        $image->save();
                        
                        
//                         $filesrc = DOCROOT.'Model_Products/'.$image->name;
//                         
//                         $resize = new \Imagick($filesrc);
//                        $d = $resize->getImageGeometry();
//                        $s = $resize->getImageLength();
//                        $w = $d['width'];
//                        $h = $d['height'];
//
//
//                        $ratios = $this->getRatio($w,$h);
//
////                        if($s > 1000000){ //greator than 1 mb
//
//                            if($w > $h){
//                                if($w > 500){
//                                    $val = 500/$ratios['w'];
//                                    $w = $val * $ratios['w'];
//                                    $h = $val * $ratios['h'];
//                                }
//
//                                if($h > 500){
//                                    $val = 500/$ratios['h'];
//                                    $w = 500;
//                                    $w = $val * $ratios['w'];
//                                    $h = $val * $ratios['h'];
//                                }
//                            }else{
//                                if($h > 500){
//                                    $val = 500/$ratios['h'];
//                                    $w = $val * $ratios['w'];
//                                    $h = $val * $ratios['h'];
//                                }
//
//                                if($w > 500){
//                                    $val = 500/$ratios['w'];
//                                    $w = 500;
//                                    $w = $val * $ratios['w'];
//                                    $h = $val * $ratios['h'];
//                                }
//                            }
//
//
//                            $resize->resizeImage($w, $h, \Imagick::FILTER_CATROM, 1);
//                            $resize = $this->autorotate($resize);
//                            $resize->writeImage($filesrc);
                         
                         
//
//                        $img->resizeImage(100, 100, \Imagick::FILTER_CATROM, 1);
                        
                        
                        
                        
                        $this->image = $image;
                    }
                    
                    
         }catch(\Exception $ex){
             echo $ex->getMessage();
         }
                    die();

    } 


    public function action_getImportLinks($module = null) {
        
        if(is_null($module)) return false;
//        uploadCSV
        \Module::load($module);
        $settinglist = $this->getSettingFlags();
        
        $class = \Inflector::classify($module);
        
        $class = $class.'s';
        
        $model =  "\\$module\Model_$class";
        $object = new $model;
        
        $props = $object->properties();
        
        $importlinks = array();
        
        foreach ($props as $key=>$prop){

            if(key_exists('uploadCSV', $prop) && $prop['uploadCSV']){
                
                $label = $prop['label'];
                $label2 = $prop['label'];
                
                \Lang::load("$module::he.php");
                $name = str_replace('_', '', $key);
                $name = str_replace('-', '', $name);
                $this->newfilename = $name;
                $class = $this->getCustomClassName($name);
                $class_name = strtolower($class); 
                
                $temp = array();
                
//                $temp['name'] = \Lang::get($label)?\Lang::get($label):$label;            
                $temp['name'] = $class_name;            
                $temp['module'] = $module;            
                $temp['link'] = "/$module/$class_name/importcsv";   
                $temp['label'] = \Lang::get($label2)?\Lang::get($label2):$label2;   
                
                $importlinks[] = $temp;
            }

            if(key_exists('uploadBankdetails', $prop) && $prop['uploadBankdetails']){
                
                $label = $prop['label'];
                $label2 = $prop['label'];
                
                \Lang::load("$module::he.php");
                $name = str_replace('_', '', $key);
                $name = str_replace('-', '', $name);
                $this->newfilename = $name;
                $class = $this->getCustomClassName($name);
                $class_name = strtolower($class); 
                
                $temp = array();
                
//                $temp['name'] = \Lang::get($label)?\Lang::get($label):$label;            
                $temp['name'] = $class_name;            
                $temp['module'] = $module;            
                $temp['link'] = "/$module/$class_name/importcsv";   
                $temp['label'] = \Lang::get($label2)?\Lang::get($label2):$label2;   
                
                $importlinks[] = $temp;
            }
        }
       
        $data['importlinks'] = $importlinks; 
            
        $this->template = \View::forge('dynamicformssystem::systems/template'); 
        $this->template->content = \View::forge('dynamicformssystem::systems/importlinks', $data); 
            
        
    }
            


    public function action_setSettings($module = null) {
        
        if(is_null($module)) return false;
        
        $settinglist = $this->getSettingFlags();
         $logo = '';   
         $backgroundimage = '';   
         $whatsapp_image = '';   
            if(\Input::method() == 'POST' ){
            
                $postdata = array();
            
                foreach ($settinglist as $list){
                    
//                    if(in_array($list['name'], array('email_subject','email_content'))) continue;
                    
                    $postdata[$list['name']] = \Input::post($list['name']);
                }
                $postdata['whatsapp_image'] = \Input::post('whatsapp_image');
                 
                $data = Model_Forms::query()->where("name",$module);
                
                $sysobj = $data->get_one();

                 if(!is_object($sysobj)){ 
                     $sysobj = new Model_Forms();
                     
                     $sysobj->name = $module; 
                 }
                    $datap = json_encode($postdata);
                    $sysobj->systemsconfig = $datap;
                    
                    $sysobj->logo_id = \Input::post('logo');  
                    $sysobj->backgroundimage_id = \Input::post('backgroundimage');  
                    
                    if(empty( $sysobj->logo_id))
                        $sysobj->logo = '';
                    else
                        $sysobj->logo = $this->getImage($sysobj->logo_id);
            
                    if(empty( $sysobj->backgroundimage_id))
                        $sysobj->backgroundimage = '';
                    else
                        $sysobj->backgroundimage = $this->getImage($sysobj->backgroundimage_id);
                    
                    $sysobj->save();
                    
            
                    $emaildata = Model_Emaildetails::query()->where("module",$module)->get_one();
            
                    if(!is_object($emaildata)){ 
                        $emaildata = new Model_Emaildetails();

                        $emaildata->module = $module; 
                    }
                    
                    $emaildata->form_id = $sysobj->id;
                    
                    $emaildata->subject = \Input::post('email_subject');  
                    
                    $emaildata->body = \Input::post('email_content');  
            
                    $emaildata->save();
            }

            $data = Model_Forms::query()->where("name",$module);
            
            $info = $data->get_one();
            $dataxy = Model_Emaildetails::query()->where("module",$module);
           
            $infox = $dataxy->get_one();
            
            $inforay = array();

            if(is_object($info) && !empty($info->systemsconfig)){
                //Show info
                $inforay = json_decode($info->systemsconfig,true);
            }
            if(is_object($infox)){
                //Show info
                $inforay['email_subject'] = $infox->subject;
                $inforay['email_content'] = htmlentities($infox->body);
            }
            if(is_object($info) && is_object($info->logoimage)){
                //Show info
                $logo = $info->logoimage;
            }
            if(is_object($info) && is_object($info->backgroundimg)){
                //Show info
                $backgroundimage = $info->backgroundimg;
            } 
            if(is_object($info) && !empty($info->systemsconfig)){
                //Show info
                
                $datapx = json_decode($info->systemsconfig,true);
                
                if(key_exists('whatsapp_image', $datapx) && !empty($datapx['whatsapp_image'])){
                
                    $img = \Model_Image::find($datapx['whatsapp_image']);
                    
                    if(is_object($img))
                        $whatsapp_image = $img;
                }
            } 
           /* else{
                $inforay = array('bity_api_key','send_pdfmail','pdf_template_name','emailTo','emailBcc','senderName','enableEmail');
            }*/
       
            $datax = array();
            
            $datax['formray']=$settinglist;
            $datax['inforay']=$inforay;
            $datax['module']= $module; 
            $datax['logo']= $logo; 
            $datax['backgroundimage']= $backgroundimage; 
            $datax['whatsapp_image']= $whatsapp_image; 
            
            $this->template = \View::forge('dynamicformssystem::systems/template'); 
            $this->template->content = \View::forge('dynamicformssystem::systems/enablemodule', $datax); 
            
        
    }
            
    public function getSettingFlags() {
        
        $settinglist = array( array('id'=>1,'type'=>'textbox','name'=>'bity_api_key','title'=>'Bity API Key','visible'=>1,'group_id'=>1),
//                                    array('id'=>2,'type'=>'text','name'=>'pdf_creator','visible'=>1,'group_id'=>1),
                                    array('id'=>3,'type'=>'checkbox', 'value'=> 1,'title'=> 'Send PDF Mail','name'=>'send_pdfmail','visible'=>1,'group_id'=>1),
                              array('id'=>23,'type'=>'checkbox', 'value'=> 1,'title'=>'Send View and Sign Email','name'=>'sendviewandsignEmail','visible'=>1,'group_id'=>1), 
     array('id'=>26,'type'=>'checkbox', 'title'=>'Enable Expire', 'name'=>'enableExpire','visible'=>1,'group_id'=>1, ), 
     array('id'=>27,'type'=>'textbox', 'title'=>'Logo Width', 'name'=>'logo_width','visible'=>1,'group_id'=>1, ), 
     array('id'=>28,'type'=>'textbox', 'title'=>'Logo Height', 'name'=>'logo_height','visible'=>1,'group_id'=>1, ), 
     array('id'=>29,'type'=>'checkbox', 'title'=>'Logo Portrait Mode', 'name'=>'logo_portrait_mode','visible'=>1,'group_id'=>1, ), 
    array('id'=>30,'type'=>'select','title'=>'Two Step Form Download PDF/Show in Browser', 'name'=>'pdf_mode_flow2','visible'=>1,'group_id'=>1, 'options' => array('1'=>'Download' , '2' => 'Show in Browser', '3' => 'Show in Browser  & Download', '4' => '-- None --')), 
    array('id'=>31,'type'=>'checkbox','title'=>'Two Step Form Show Message Before PDF', 'name'=>'showMessageBeforePDFflow2','visible'=>1,'group_id'=>1,  ), 
                                   array('id'=>24,'type'=>'date', 'title'=>'Expire Date', 'name'=>'expiryDate','visible'=>1,'group_id'=>1, ), 
                                    array('id'=>25,'type'=>'textarea','subtype'=>'tinymce', 'elementid'=>'expiry_messge_content','title'=>'Expiry Message', 'name'=>'expiryMessage','visible'=>1,'group_id'=>1, ), 
                               //                                    array('id'=>4,'name'=>'pdf_mode','visible'=>1,'group_id'=>1),
                                    array('id'=>5,'type'=>'textbox','name'=>'pdf_template_name','title'=>'PDF Template Name ','visible'=>1,'group_id'=>1), 
                                    array('id'=>5,'type'=>'textbox','name'=>'pdf_report_name','title'=>'PDF Report Name','visible'=>1,'group_id'=>1), 
                                    array('id'=>6,'type'=>'textbox','name'=>'emailTo','title'=>'Email To','visible'=>1,'group_id'=>1), 
                                    array('id'=>7,'type'=>'textbox','name'=>'emailBcc','title'=>'Email Bcc','visible'=>1,'group_id'=>1), 
                                    array('id'=>8,'type'=>'textbox','name'=>'senderName','title'=>'Email Sender Name','visible'=>1,'group_id'=>1), 
                                    array('id'=>14,'type'=>'textbox','name'=>'currentsequence','title'=>'Form Sequence','visible'=>1,'group_id'=>1), 
                                    array('id'=>9,'type'=>'checkbox', 'value'=> 1,'title'=>'Enable Email','name'=>'enableEmail','visible'=>1,'group_id'=>1), 
//                                    array('id'=>10,'type'=>'checkbox','name'=>'flowSystem','title'=>'','visible'=>1,'group_id'=>1),     //value=>label
//                                    array('id'=>11,'type'=>'select', 'name'=>'flowType','title'=>'','visible'=>1,'group_id'=>1, 'options' => array('1'=>'1' , '2' => '2')), 
                                    array('id'=>12,'type'=>'select','title'=>'Download PDF/Show in Browser', 'name'=>'pdf_mode','visible'=>1,'group_id'=>1, 'options' => array('1'=>'Download' , '2' => 'Show in Browser', '3' => 'Show in Browser  & Download')), 
//                                    array('id'=>13,'type'=>'file','title'=>'העלה לוגו טופס', 'name'=>'logo','visible'=>1,'group_id'=>1, ), 
                                    array('id'=>15,'type'=>'textbox','title'=>'Add Section color', 'name'=>'color_scheme','visible'=>1,'group_id'=>1, ), 
//                                    array('id'=>16,'type'=>'textbox','title'=>'Logo Width', 'name'=>'logo_width','visible'=>1,'group_id'=>1, ), 
//                                    array('id'=>17,'type'=>'textbox','title'=>'Logo Height', 'name'=>'logo_height','visible'=>1,'group_id'=>1, ), 
                                    array('id'=>18,'type'=>'select','title'=>'Logo Position', 'name'=>'logo_position','visible'=>1,'group_id'=>1,  'options' => array( '0' => 'center','right'=>'right' , 'left' => 'left')), 
//                                    array('id'=>15,'type'=>'textbox','title'=>'whatsapp image', 'name'=>'whatsapp_image','visible'=>0,'group_id'=>1, ), 
                                    array('id'=>19,'type'=>'textbox','title'=>'Whatsapp Title', 'name'=>'whatsapp_title','visible'=>1,'group_id'=>1, ), 
                                    array('id'=>20,'type'=>'textbox','title'=>'Whatsapp Description', 'name'=>'whatsapp_description','visible'=>1,'group_id'=>1, ), 
                                    array('id'=>21,'type'=>'textbox','subtype'=>'tinymce','elementid'=>'email_subject','title'=>'Email Subject', 'name'=>'email_subject','visible'=>1,'group_id'=>1, ), 
                                    array('id'=>22,'type'=>'textarea','subtype'=>'tinymce', 'elementid'=>'email_content','title'=>'Email Content', 'name'=>'email_content','visible'=>1,'group_id'=>1, ), 
                               
                   );
        
        return $settinglist;
    }
    
    public function getDateValues() {
        
        
        $arr = $this->formOptionList(1,31);
            
        return $arr;
    }
    
    public function getMonthValues() {
        
        
        $arr = $this->formOptionList(1,12);
            
        return $arr;
    }
    
    public function getYearValues() {
        
        $arr = $this->formOptionList($this->minYearValue,2021);
        
        return $arr;
    }
    
    public function formOptionList($start =null,$end =null) {
        
        $arr = array();
        $arr[] = array('label'=>'','value'=>'');
        
        for($i=$start; $i<=$end; $i++){
            
            if (strlen($i) == 1) {
                $j = "0" . $i;
            } else {
                $j = $i;
            }

            $arr[] = array('label'=>$j,'value'=>$j);
        }
        
        return $arr;
    }

    
    function get_formbuildersystemjs(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/formbuildersystem', $html = null);
            return  $this->response($string);
    }    
    function get_formbuilder(){
    
            $this->format="jsonp";
            $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
            $this->format="jsonpx";
            $string = \View::forge('dynamicformssystem::js/formbuilder', $html = null);
            return  $this->response($string);
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

    public function createLogin() {
        
        if(isset($this->login) && !empty($this->login) ){
            
            $this->type = 'controller';
        
            $this->getDocumentPath();

            $this->formLoginData();                    

            $this->createFile();
            
        }
    }
    public function createAgentModel() {
        
        if(isset($this->login) && !empty($this->login) ){
            
            $this->type = 'model';
        
            $this->getDocumentPath();

            $this->formAgentModelData();                    

            $this->createFile();
            
            
            $agent =  "\\$this->filename\Model_Agents";

            \Module::load($this->filename);

            $agentObject = new $agent;
        }
    }

    public function formLoginData() {
            
        if(isset($this->login) && $this->login == 1){
            
            $class_name = $this->getClassName(); 

            $this->controller = strtolower($class_name); 
           
            $data['module'] = strtolower($this->filename);
            $data['loginEscapeArray'] = "array('login', 'showhidejs','logout','rest_login','jsonOrdercomplete','jsonPaymentcomplete','specialprocess_import','jsonPaymentfailed','jsonOrderfailed',$this->loginMethods )";
            $data['filepath'] = $this->filenamespace.'/'.$this->controller;

            $this->filedata =  '<?php  '; 
            $this->filedata .=  \View::forge('logindata/base',$data); 
            $this->filedata .=  ' ?> '; 


            $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filenamespace."/classes/controller/";

            $this->file = 'base.php';
        }
    }

    public function formAgentModelData() {
            
        if(isset($this->login) && $this->login == 1){
            
                       
            $data['module'] = strtolower($this->filename); 

            $this->filedata =  '<?php  '; 
            $this->filedata .=  \View::forge('logindata/agentmodel',$data); 
            $this->filedata .=  ' ?> '; 


            $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filenamespace."/classes/model/";

            $this->file = 'agents.php';
        }
    }

    public function getControllerFunctions() {
        
        $data =  '';
        
        if(isset($this->login) && $this->login == 1){
            
            $data =  \View::forge('logindata/loginbefore',null); 
            
        }
        
         $data .=  \View::forge('logindata/loginindex',null); 
        
        return $data;
    }

    public function formEscapeMehodArray() {
        
         $escapeArray = array ( 'create','listIndex','edit','view' ,'viewandsign');

         if(is_array($this->loginMethods)){
            foreach ($escapeArray as $key => $asArr){
                if(in_array($asArr, $this->loginMethods))
                    unset ($escapeArray[$key]);
            }
         }

        $this->loginMethods = "'".implode("','", $escapeArray)."'";

    }
    
    public function getEscapeArray() {
        
        $this->formEscapeMehodArray();
        
        $data = "array('formbuilderjs','sinatureJS','clipboardJS','formbuildercss'
                ,'formcss','newformcss','login', 'logout', 'exportDocumentToPdfOnSubmit','exportDocumentToPdf', 'showDocumentToPdf','showAndExportDocumentToPdf',
                'rest_login','jsonOrdercomplete','jsonPaymentcomplete','viewxPDF','index',
                'specialprocess_import','jsonPaymentfailed','jsonOrderfailed','createImagex',$this->loginMethods)";
         
        
        return $data;
    }

    public function createAgents() {
        
        $this->createAgentModel(); 
        
        $this->createAgentController(); 
    }

    public function createAgentController() {
        
            $this->type = 'controller';
        
            $this->getDocumentPath();

            $this->formAgentControllerData();                    

            $this->createFile();
            
    }

    public function formAgentControllerData() {
                               
        $data['module'] = strtolower($this->filename); 

        $this->filedata =  '<?php  '; 
        $this->filedata .=  \View::forge('logindata/agentcontroller',$data); 
        $this->filedata .=  ' ?> '; 


        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filenamespace."/classes/controller/";

        $this->file = 'agents.php';
    }

    public function createIndexView() {
        
        $this->type = 'views';
            
        
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS;
        
        $this->createDirectory($this->filename);
        
        $this->createDirectory($this->type);        
        
        $this->createDirectory($this->filename);
        
//        $this->formViewData();  
//        
        
        $this->viewType = 'index';
        
        $this->formIndexViewData();        
            
        $this->file = 'index.php';
        
        $this->createFile();
    }

    public function formIndexViewData() {
        
        $data['filepath'] = $this->filenamespace.'/'.$this->controller;
        $data['showeditbtnonindex'] = $this->showeditbtnonindex;
        $data['showdeletebtnonindex'] = $this->showdeletebtnonindex;
        $data['enableExportCSV'] = $this->enableExportCSV;
            
        $this->filedata =  \View::forge('logindata/indexview',$data);  
    }

    public function get_formbuilderminJS() {
        
        $this->format="jsonp";
        $this->response->set_header('Content-Type', $this->_supported_formats[$this->format]);
        $this->format="jsonpx";
        $string = \View::forge('dynamicformssystem::js/formbuildermin', $html = null);
        return  $this->response($string);
    }

    public function getMathOperation($calculate = null) {
        
        $op = '';
        
        if(!is_null($calculate)){
            
            switch ($calculate){
                case 1 : $op = 'add'; break;
                case 2 : $op = 'subtract'; break;
                case 3 : $op = 'multiply'; break;
                case 4 : $op = 'divide'; break;
                case 5 : $op = 'tax'; break;
                case 6 : $op = 'discount'; break;
                default : $op = ''; break;
            }
        }
        
        return $op;
    }

    
    public function post_jsonFormcomplete() {
        
//        $data = \Input::post();
                
        $this->json = 1;
        
        $id = $this->storeData();
        
        echo $id;
        
        die();
    }
    
//    public function storeJSONData() {
//                 
//        $this->formData();
//        
//        $model  = $this->model;
//        
//        $data = json_encode( array('json_data' => $this->json_data, 'form_title' => $this->form_title) );         
//        
//        $title = $this->formTitle();
//                
//        if( !is_null($data)){    
//                
//            $sysobj = $model::query()->where("id",$this->formId)->get_one(); 
//            
//            $oldforms = '';
//            
//            if(!is_object($sysobj)){
//                
//               $sysobj = new $model;
//               
//            } 
//              
//            if(!empty($sysobj->currentform)){ 
//
//                $oldforms = $this->getPastFormData($sysobj->oldforms, $sysobj->currentform);
//
//            }  
//            
//            $sysobj->name = $title;
//            $sysobj->systemsconfig = json_encode($this->systemsconfig);
//            $sysobj->oldforms = $oldforms;            
//            $sysobj->currentform = $data;
//            $sysobj->title = $this->form_title;
//            $sysobj->bitlyApiKey = $this->bity_api_key;
//            $sysobj->backgroundimage = $this->backgroundimage;
//            $sysobj->logo_id = $this->logo_id;
//            $sysobj->logo = $this->logo;
//            $sysobj->backgroundimage_id = $this->backgroundimage_id;
//            $sysobj->color_scheme = $this->color_scheme;
//            $sysobj->email = $this->email;
//            $sysobj->shorten_url = $this->shorten_url;
//            
//            $sysobj->save();
//            
//            return $sysobj->id;
////            print_r($sysobj); die();
////                die();
//        } 
//    }    
    
    
    
    public function post_downloadModule($module = null) {
        
        \Log::warming('Entered action_downloadModule: '.$module );
            
        if(!is_null($module)){
                
            $info = Model_Forms::query()->where("name",$module)->get_one();
                
            if(is_object($info)) {

                $path = APPPATH.'/modules/dynamicformssystem/modules/'.$module;
                
                if(is_dir($path)){
                    $this->createZipFile($module);
                }                
            }
        }
        die();
    }
    
    public function custom_copy($src, $dst) {  

        // open the source directory 
        $dir = opendir($src);  

        // Make the destination directory if not exist 
        @mkdir($dst);  

        // Loop through the files in source directory 
        while( $file = readdir($dir) ) {  

            if (( $file != '.' ) && ( $file != '..' )) {  
                if ( is_dir($src . '/' . $file) )  
                {  

                    // Recursively calling custom copy function 
                    // for sub directory  
                    $this->custom_copy($src . '/' . $file, $dst . '/' . $file);  

                }  
                else {  
                    if(file_exists($src . '/' . $file))
                        copy($src . '/' . $file, $dst . '/' . $file);  
                }  
            }  
        }  

        closedir($dir); 
    }  

    function zipFolder($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new \ZipArchive();
        if (!$zip->open($destination, \ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true)
        {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file)
            {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true)
                {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                }
                else if (is_file($file) === true)
                {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        }
        else if (is_file($source) === true)
        {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }
     
    public function createZipFile($module = null) {
        
        $rootpath = DOCROOT.'carmelmodules';
        
        if(!is_dir($rootpath))
            \File::create_dir(DOCROOT, 'carmelmodules', 0777); 
        
         $path = APPPATH.'modules/dynamicformssystem/modules/'.$module;
         
         $newpath = DOCROOT.'carmelmodules/'.$module;
         
         if(is_dir($newpath))
             \File::delete_dir($newpath);
                
        $this->custom_copy($path, $newpath);
        
        $this->zipFolder($newpath, DOCROOT.'/carmelmodules/'.$module.'.zip');
                
        \File::download(DOCROOT.'/carmelmodules/'.$module.'.zip');
        
        die();
        
       
    }

    public function createSelectDataFiles($field = null) {
        
           
         if($this->hasManyData ==  1){
             
     /*       $original_name = $this->getKeyValue($field, 'attr_name');
//                                            print_r($original_name);die();
             $original_name = str_replace('[<?php echo $i ?>]', '', $original_name);
            $original_name = str_replace('[count]', '', $original_name);
             $original_name = str_replace('[', '', $original_name);
             $original_name = str_replace(']', '', $original_name);
             $field['name'] = $original_name;*/
                
             
            $field['name'] = $this->getOriginalName($field);
//             print_r($field['name']); die();
        }
        
        
        if(!is_null($field)){
            
            $basepath = $this->basepath;
            $file = $this->file;
            $type = $this->type;
            
            $original_title = $this->getKeyValue($field, 'name');
            
            $name = str_replace('_', '', $original_title);
             $name = str_replace('[<?php echo $i ?>]', '', $name);
            $name = str_replace('[count]', '', $name);
            $name = str_replace('-', '', $name);
            $this->newfilename = $name;
            $class = $this->getCustomClassName($name);
            $class_name = strtolower($class); 
                
            $this->controllerpath = 'selectdata/selectcontroller';
            $this->original_title = $original_title;
            $this->modelpath = 'selectdata/selectmodel';
            $this->controllerName = $class;
            $this->modelName = $class;
            $this->newfilename = $class_name;
            
            $this->createDataController($field);
            
            $this->createDataModel($field);
            
            $this->basepath = $basepath;
            $this->type = $type;
            $this->file = $file;
           // $this->createDataViews($field);
        }
        
    }

    public function createDataController() {
        
            $this->type = 'controller';
        
            $this->getDocumentPath();

            $this->formDataControllerData();                    

            $this->createFile();
    }

    public function createDataModel() {
        
            $this->type = 'model';
        
            $this->getDocumentPath();

            $this->formDataModelData();                    

            $this->createFile();
                
    }

    public function createDataViews() {
        
    }

    public function formDataControllerData() {
                                       
        $data['module'] = strtolower($this->filename); 
        $data['controller'] =  $this->controllerName; 
        $data['original_title'] =  $this->original_title; 

        $this->filedata =  '<?php  '; 
        $this->filedata .=  \View::forge($this->controllerpath,$data); 
        $this->filedata .=  ' ?> '; 

                
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filenamespace."/classes/controller/";
                
        $this->file = $this->newfilename.'.php';
    }

    public function formDataModelData() {
                               
        $data['module'] = strtolower($this->filename); 
        $data['model'] =  $this->modelName;  

        $this->filedata =  '<?php  '; 
        $this->filedata .=  \View::forge($this->modelpath,$data); 
        $this->filedata .=  ' ?> '; 


        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules'.DS.$this->filenamespace."/classes/model/";

        $this->file = $this->newfilename.'.php';
    }

    public function createBankDataFiles($field) {
        
         if($this->hasManyData ==  1){
             
          /*  $original_name = $this->getKeyValue($field, 'attr_name');
//                                            print_r($original_name);die();
             $original_name = str_replace('[<?php echo $i ?>]', '', $original_name);
            $original_name = str_replace('[count]', '', $original_name);
             $original_name = str_replace('[', '', $original_name);
             $original_name = str_replace(']', '', $original_name);
             $field['name'] = $original_name;*/
                
            $field['name'] = $this->getOriginalName($field);
             
//             print_r($field['name']); die();
        }
        if(!is_null($field)){
            
            $basepath = $this->basepath;
            $file = $this->file;
            $type = $this->type;
            
            $original_title = $this->getKeyValue($field, 'name');
            
            $name = str_replace('_', '', $original_title);
            $name = str_replace('-', '', $name);
            $this->newfilename = $name;
            $class = $this->getCustomClassName($name);
            $class_name = strtolower($class); 
                
            $this->controllerpath = 'selectdata/bankcontroller';
            $this->original_title = $original_title;
            $this->modelpath = 'selectdata/bankmodel';
            $this->controllerName = $class;
            $this->modelName = $class;
            $this->newfilename = $class_name;
//             if($this->hasManyData ==  1){ 
//             print_r($this->newfilename); die();
//        }
            
            if(  $this->viewType == 'create'){
            $this->createDataController($field);
            
            $this->createDataModel($field);
            }
            $this->basepath = $basepath;
            $this->type = $type;
            $this->file = $file;
           // $this->createDataViews($field);
        }
        
    }

    public function bankDataFiles($field) {
        
         if($this->hasManyData ==  1){
             
          /*  $original_name = $this->getKeyValue($field, 'attr_name');
//                                            print_r($original_name);die();
             $original_name = str_replace('[<?php echo $i ?>]', '', $original_name);
            $original_name = str_replace('[count]', '', $original_name);
             $original_name = str_replace('[', '', $original_name);
             $original_name = str_replace(']', '', $original_name);
             $field['name'] = $original_name;*/
                
            $field['name'] = $this->getOriginalName($field);
             
//             print_r($field['name']); die();
        }
        if(!is_null($field)){
            
            $basepath = $this->basepath;
            $file = $this->file;
            $type = $this->type;
            
            $original_title = $this->getKeyValue($field, 'name');
            
            $name = str_replace('_', '', $original_title);
            $name = str_replace('-', '', $name);
            $this->newfilename = $name;
            $class = $this->getCustomClassName($name);
            $class_name = strtolower($class); 
                
            $this->controllerpath = 'selectdata/bankcontroller';
            $this->original_title = $original_title;
            $this->modelpath = 'selectdata/bankmodel';
            $this->controllerName = $class;
            $this->modelName = $class;
            $this->newfilename = $class_name; 
            $this->basepath = $basepath;
            $this->type = $type;
            $this->file = $file;
           // $this->createDataViews($field);
        }
        
    }

    public function formBankdetailsTag($field, $attributes, $value) {
            $required = $this->getKeyValue($field,'required',false);
        $bankname = $this->getKeyValue($field,'bankname',false);
        $branchcode = $this->getKeyValue($field,'branchcode',false);
        $branchname = $this->getKeyValue($field,'branchname',false);
        $banknamelabel= $this->getKeyValue($field,'banknamelabel',false);
        $branchnamelabel= $this->getKeyValue($field,'branchnamelabel',false);
        $branchcodelabel = $this->getKeyValue($field,'branchcodelabel',false);
        $tag = '';
        $num = '';
        $model = '';
        $divattr = array('class'=>'span12'); 
        $req = '';
        $name2 = $this->getKeyValue($field,'name',false);
        $name = $this->getKeyValue($field,'name',false);
        if(isset($required) && $required == 'yes'){
            $req = '<span class="fb-required">*</span>';
        }
        \Log::error(' $this->createBankDataFiles($field);*******'.$this->viewType);
         $this->createBankDataFiles($field);
        $mod =strtolower($this->filename);
        $con =strtolower($this->controllerName);
        if($this->hasManyData ==  1){

        /*    $original_name = $this->getKeyValue($field, 'attr_name');
//                                        $original_name = $this->getKeyValue($field, 'name');
            $original_name = str_replace('[<?php echo $i ?>]', '', $original_name);
            $original_name = str_replace('[count]', '', $original_name);
            $original_name = str_replace('[', '', $original_name);
            $original_name = str_replace(']', '', $original_name);
//                                        $field['name'] = $original_name;*/
            $name =  $this->getOriginalName($field);;
                
            $model = $this->getKeyValue($field,'model',false);  
        }else{

        }
        
          if($this->viewType ==  'edit'){
              $name = str_replace('[count]', '[<?php echo $i ?>]', $name);
          }
        if(isset($name) && strpos($name, '_') > -1){
            $temp = explode('_',$name);

            $num = '_'.$temp[1];
        }


        if(isset($bankname) && $bankname == 'yes'){

            $attributes2 = $attributes;

        $attributes2['value'] = str_replace('bankdetails', 'bankname', $value);  
            $attributes2['class'] .= ' form-fields select-remote getBranch';
            $attributes2['href'] = "/$mod/$con/list";
             if($this->hasManyData ==  1){
                $attributes2['attr-name'] = 'bankname'.$num;
                 if($this->viewType ==  'edit'){
                     
                $attributes2['name'] = $model.'[<?php echo $i ?>][bankname'.$num.']';
               $attributes2['branch_number'] = $model.'[<?php echo $i ?>][branchcode'.$num.']';
                $attributes2['branch_name'] = $model.'[<?php echo $i ?>][branchname'.$num.']';
          }else{
                $attributes2['name'] = $model.'[count][bankname'.$num.']';
                $attributes2['branch_number'] = $model.'[count][branchcode'.$num.']';
                $attributes2['branch_name'] = $model.'[count][branchname'.$num.']';
          }
            }else{
                $attributes2['name'] = 'bankname'.$num;
                $attributes2['branch_name'] ='branchname'.$num;
                $attributes2['branch_number'] ='branchcode'.$num;
            }
            $banknamelabel .= $req;
            $label1 = html_tag('label', $divattr,$banknamelabel);
            $tag1 = html_tag('select', $attributes2,'');

            $label1 .=  html_tag('div', $divattr,$tag1);
            $tag .=  html_tag('div', $divattr,$label1);

        }
        if(isset($branchcode) && $branchcode == 'yes'){

        $attributes['value'] = str_replace('bankdetails', 'branchcode', $value);  
            $attributes['mapper'] ="branchcode";
            $attributes['map-controller'] ="$mod/$con";
            $attributes['href2'] ="/$mod/$con/listkey";
            $attributes['href'] ="/$mod/$con/listkey";
            $attributes['class'] = ' form-fields popup-autocomplete popup-autocomplete-product-key'
                    . ' form-control ui-autocomplete-input ';
            if($this->hasManyData ==  1){
                $attributes['id'] = $model.'-count-branch_id'.$num;
                $attributes['hiddenid'] ="$model-count-branch_id$num";
                $attributes['idattr'] ="hidden_$model-count-branch_id$num";
            }else{
                $attributes['id'] = 'branch_id'.$num;
                $attributes['class'] .= ' hidden_branch_id'.$num;
            }

            $branchcodelabel .= $req;
            if($this->hasManyData ==  1){

//                                            print_r($attributes['href2']); die();
               
                $attributes['attr-name'] = 'branchcode'.$num;
                
                   if($this->viewType ==  'edit'){
                     
                 $attributes['name'] = $model.'[<?php echo $i ?>][branchcode'.$num.']';
                 
          }else{
                 $attributes['name'] = $model.'[count][branchcode'.$num.']';
          }
            }else{
                $attributes['name'] = 'branchcode'.$num;
            }
            $label1 = html_tag('label', $divattr,$branchcodelabel);
            $tag1 = html_tag('input', $attributes);

            $label1 .=  html_tag('div', $divattr,$tag1);
            $tag .=  html_tag('div', $divattr,$label1);
        }
        if(isset($branchname) && $branchname == 'yes'){
            
        $attributes['value'] = str_replace('bankdetails', 'branchname', $value);  
            $attributes['mapper'] ="branchname";
            $attributes['map-controller'] ="$mod/$con";
            $attributes['href2'] ="/$mod/$con/listkey";
            $attributes['href'] ="/$mod/$con/listkey";
            $attributes['class'] = 'form-fields popup-autocomplete popup-autocomplete-product-key'
                    . ' form-control ui-autocomplete-input ';
            if($this->hasManyData ==  1){
                $attributes['id'] = $model.'-count-branch_id'.$num;
                $attributes['hiddenid'] ="$model-count-branch_id$num";
                $attributes['idattr'] ="hidden_$model-count-branch_id$num";
            }else{
                $attributes['id'] = 'branch_id'.$num;
                $attributes['class'] .= ' hidden_branch_id'.$num;
            }
                
            $branchnamelabel .= $req;
            if($this->hasManyData ==  1){ 
                $attributes['attr-name'] = 'branchname'.$num;

                   if($this->viewType ==  'edit'){
                     
                 $attributes['name'] = $model.'[<?php echo $i ?>][branchname'.$num.']';
                 
          }else{
                 $attributes['name'] = $model.'[count][branchname'.$num.']';
          }
            }else{
            $attributes['name'] = 'branchname'.$num;
            }
            $label1 = html_tag('label', $divattr, $branchnamelabel);
            $tag1 = html_tag('input', $attributes);

            $label1 .=  html_tag('div', $divattr,$tag1);
            $tag .=  html_tag('div', $divattr,$label1);
        }
        if($this->hasManyData ==  1){
            $attributes['id'] = 'hidden_'.$model.'-count-branch_id'.$num;
        }else{
             $attributes['id'] = 'hidden_branch_id'.$num;
        }


        $attributes['value'] = str_replace('bankdetails', 'branch_id', $value);  
            $attributes['type'] ="hidden";
            $attributes['map-controller'] ="$mod/$con"; 
            $attributes['class'] = 'form-fields updateflag  form-control';

            if($this->hasManyData ==  1){ 
                $attributes['attr-name'] = 'branch_id'.$num;
                 $attributes['hiddenid'] ="";
                $attributes['idattr'] ="";
                
                   if($this->viewType ==  'edit'){
                     
                 $attributes['name'] = $model.'[<?php echo $i ?>][branch_id'.$num.']';
                 
          }else{
                 $attributes['name'] = $model.'[count][branch_id'.$num.']';
          }
            }else{
            $attributes['name'] = 'branch_id'.$num;
            }
            $tag .= html_tag('input', $attributes); 
            $field['name']= $name2;
            $attributes['name']= $name2;
            return $tag;
    }

    public function formEditableTextTag($field, $attributes, $value) {
            $required = $this->getKeyValue($field,'required',false);
        $checkboxrequired = $this->getKeyValue($field,'checkboxrequired',false); 
//        echo $checkboxrequired; die();
        $tag = '';
        $num = '';
        $model = '';
        $divattr = array('class'=>'span12'); 
        $req = '';
        $label = $this->getKeyValue($field,'label',false);
        $name = $this->getKeyValue($field,'name',false);
        if(isset($required) && $required == 'yes'){
            $req = '<span class="fb-required">*</span>';
        }
        \Log::error(' $this->formEditableTextTag($field);*******'.$this->viewType);
        
        $ckname =  str_replace("editabletext","checkbox_group",$name);
        $ckid =  str_replace("editabletext","checkbox_group",$name);
        $textname =  str_replace("editabletext","textareaedit",$name);
        $textid =  str_replace("editabletext","textareaedit",$name);
        $textidmap =  str_replace("editabletext","textareaedit",$name);
        $atagname =  str_replace("editabletext","atag",$name);
        $atagtid =  str_replace("editabletext","atag",$name);
        $paraname =  str_replace("editabletext","para",$name);
                

        if($this->hasManyData ==  1){
            $ckoriid = $this->getOriginalName($field);
            $ckid =  str_replace("editabletext","checkbox_group",$ckoriid);
            $textid =  str_replace("editabletext","textareaedit",$ckoriid);
            $atagtid =  str_replace("editabletext","atag",$ckoriid);
           
        }
                 
        if($this->viewType == 'edit' || $this->viewType == 'view'){
             if($this->hasManyData ==  1){
                  $obj = '$line';  
             }else{
               $obj = '$order';  
             }
             
             if($checkboxrequired == 'yes'){
            $tag  .= "<?php if(isset({$obj}->{$ckid}) && {$obj}->{$ckid} == 1) { ?>";
            
             }
            $divattributes = array( 'class' =>  'showText',  // ' box-body form-group box-body-flex ',  
                                );
            $ckinput =  "<?php if(isset({$obj}->{$textid})) { "
            . "         echo  htmlspecialchars_decode({$obj}->{$textid}); } ?>";
            
            $tag .= html_tag('div', $divattributes, $ckinput);
            
             
             if($checkboxrequired == 'yes'){
            $tag  .= "<?php } ?>";
             }
                
        }else{
            if($this->viewType == 'create' ||  $this->viewType == 'pdflabeler'){
                
                $ckattributes = array( 'class' => 'checkInput', 
                                        'name' => $ckname,
                                        'attr-name' => $ckid,
                                        'id' => $ckid,
                                        'value' => '1',
                                        'type' => 'checkbox',
                                    );
                
                $atagattributes = array( 'class' => 'editText', 
                                        'para-id' => $paraname,
                                        'text-id' => $textname,
                                        'name' => $atagname,
                                        'id' => $atagtid,
                                    ); 
                $textattributes = array( 'class' => 'hideText', 
                                        'para-id' => $paraname,                
                                        'name' => $textname,
                                        'attr-name' => $textid,
                                        'id' => $textid,
                                    );
                
                 if($this->hasManyData ==  1){
                    $model = $this->getKeyValue($field,'model',false);  
                
                    $ckattributes['class'] .= ' form-fields ';
                     $atagattributes['class'] .= ' form-fields ';
                    $textattributes['class'] .= ' form-fields ';
                    $ckattributes['model'] = $model;
                     $atagattributes['model'] = $model;
                     $atagattributes['text-id'] = $model.'-'.$textid.'-count';
//                      $textidmap =  str_replace("editabletext","atag",$ckoriid);
                    $textattributes['model'] = $model;
                 }
                   
                $ckinput = '';
                
                if($checkboxrequired == 'yes'){
                   $ckinput = html_tag('input', $ckattributes);

                   if( $this->viewType == 'pdflabeler'){
                       $ckinput .= "{$ckname}";
                   } 
                }
                $atag = html_tag('a', $atagattributes, '<i class="icon-wrench" ></i>');

                $ckinput .=$atag;
                
                $texttag = html_tag('textarea', $textattributes, $label);
                if( $this->viewType == 'pdflabeler'){
                    $texttag .= "{$textname}";
                }
                $divattributes = array( 'class' => 'showText', 
                                        'id' => $paraname,     
                                    );

                $divtag = html_tag('div', $divattributes, htmlspecialchars_decode($label));

                $divtag .= $texttag;

                $divattributes = array( 'class' => 'box-body form-group',  
                                    );

                $divtag = html_tag('div', $divattributes, $divtag);

                $ckinput .=$divtag;
                
                $divattributes = array( 'class' => ' box-body form-group box-body-flex',  
                                    );

                $tag = html_tag('div', $divattributes, $ckinput);
            }
        }
        
                

        return $tag;
    }

    public function getBankOptions($field, $field, $value, $id) {
        $banknameval = str_replace('bankdetails', 'bankname', $value);  
        $branchcodeval = str_replace('bankdetails', 'branchcode', $value);  
        $branchnameval = str_replace('bankdetails', 'branchname', $value);  
        
        $required = $this->getKeyValue($field,'required',false);
        $bankname = $this->getKeyValue($field,'bankname',false);
        $branchcode = $this->getKeyValue($field,'branchcode',false);
        $branchname = $this->getKeyValue($field,'branchname',false);
        $banknamelabel= $this->getKeyValue($field,'banknamelabel',false);
        $branchnamelabel= $this->getKeyValue($field,'branchnamelabel',false);
        $branchcodelabel = $this->getKeyValue($field,'branchcodelabel',false);
        $tag = '';
        $num = '';
        $model = '';
        $divattr = array('class'=>'span12'); 
        $req = ''; 
        $name = $this->getKeyValue($field,'name',false);
                
        $attributes['class'] = ' form-fields  form-control ';
        $attributes2['class'] = ' form-fields  form-control ';
        $attributes2['value'] = $banknameval;
        $this->bankDataFiles($field);
        $mod =strtolower($this->filename);
        $con =strtolower($this->controllerName);
        
        if(isset($required) && $required == 'yes'){
            $req = '<span class="fb-required">*</span>';
        }
        
        if($this->hasManyData ==  1){

/*            $original_name = $this->getKeyValue($field, 'attr_name');
            $original_name = str_replace('[<?php echo $i ?>]', '', $original_name);
            $original_name = str_replace('[count]', '', $original_name);
            $original_name = str_replace('[', '', $original_name);
            $original_name = str_replace(']', '', $original_name); */
            $name =  $this->getOriginalName($field);
                
            $model = $this->getKeyValue($field,'model',false);  
        }else{

        }
        if(isset($name) && strpos($name, '_') > -1){
            $temp = explode('_',$name);

            $num = '_'.$temp[1];
        }


        if(isset($bankname) && $bankname == 'yes'){
            $attributes2['class'] .= ' form-fields select-remote getBranch';
            $attributes2['href'] = "/$mod/$con/list";
            $banknamelabel .= $req;
            $label1 = html_tag('label', $divattr,$banknamelabel);
            $tag1 = html_tag('select',$attributes2,'');

            $label1 .=  html_tag('div', $divattr,$tag1);
            $tag .=  html_tag('div', $divattr,$label1);

        }
        if(isset($branchcode) && $branchcode == 'yes'){
                
            $branchcodelabel .= $req;
                
            $label1 = html_tag('label', $divattr,$branchcodelabel);
            $tag1 =  $branchcodeval;

            $label1 .=  html_tag('div', $divattr,$tag1);
            $tag .=  html_tag('div', $divattr,$label1);
        }
        if(isset($branchname) && $branchname == 'yes'){
                
            $branchnamelabel .= $req; 
            $label1 = html_tag('label', $divattr, $branchnamelabel);
            $tag1 =  $branchnameval;  

            $label1 .=  html_tag('div', $divattr,$tag1);
            $tag .=  html_tag('div', $divattr,$label1);
        } 
                
        return $tag;
    }

    public function formAddressTag($field, $attributes, $value) {
        
        $cityval = str_replace('bankdetails', 'city', $value);  
        $streetval = str_replace('bankdetails', 'street', $value);  
        $streetnumberval = str_replace('bankdetails', 'streetnumber', $value);  
        $apartmentval = str_replace('bankdetails', 'apartment', $value);  
        $zipval = str_replace('bankdetails', 'zip', $value);  
        
        $required = $this->getKeyValue($field,'required',false);
        $city = $this->getKeyValue($field,'city',false);
        $street = $this->getKeyValue($field,'street',false);
        $streetnumber = $this->getKeyValue($field,'streetnumber',false);
        $apartment = $this->getKeyValue($field,'apartment',false);
        $zip = $this->getKeyValue($field,'zipname',false);
        $citylabel= $this->getKeyValue($field,'citylabel',false);
        $streetlabel= $this->getKeyValue($field,'streetlabel',false);
        $streetnumberlabel= $this->getKeyValue($field,'streetnumberlabel',false);
        $apartmentlabel= $this->getKeyValue($field,'apartmentlabel',false);
        $ziplabel = $this->getKeyValue($field,'ziplabel',false);
                
        $this->addressDataFiles($field);
        $mod =strtolower($this->filename);
        $con =strtolower($this->controllerName);
        
        
        if(isset($city) && $city == 'yes'){
            $attributes2['class'] .= ' form-fields select-remote getBranch';
            $attributes2['href'] = "/$mod/$con/list";
            $banknamelabel .= $req;
            $label1 = html_tag('label', $divattr,$banknamelabel);
            $tag1 = html_tag('select',$attributes2,'');

            $label1 .=  html_tag('div', $divattr,$tag1);
            $tag .=  html_tag('div', $divattr,$label1);

        }
        
        
        
    }

    public function addressDataFiles($field) {
                
         if($this->hasManyData ==  1){
                
            $field['name'] = $this->getOriginalName($field);
                
        }
        if(!is_null($field)){
            
            $basepath = $this->basepath;
            $file = $this->file;
            $type = $this->type;
            
            $original_title = $this->getKeyValue($field, 'name');
            
            $name = str_replace('_', '', $original_title);
            $name = str_replace('-', '', $name);
            $this->newfilename = $name;
            $class = $this->getCustomClassName($name);
            $class_name = strtolower($class); 
                
            $this->controllerpath = 'selectdata/addresscontroller';
            $this->original_title = $original_title;
            $this->modelpath = 'selectdata/addressmodel';
            $this->controllerName = $class;
            $this->modelName = $class;
            $this->newfilename = $class_name; 
            $this->basepath = $basepath;
            $this->type = $type;
            $this->file = $file; 
        }
        
    }

    public function getOriginalName($field) {
        
        $original_name = $this->getKeyValue($field, 'attr_name'); 
        $original_name = $this->getKeyValue($field, 'attr_name'); 
        $original_name = str_replace('[<?php echo $i ?>]', '', $original_name);
        $original_name = str_replace('[count]', '', $original_name);
        $original_name = str_replace('[', '', $original_name);
        $original_name = str_replace(']', '', $original_name);
        
        return $original_name;
    }
    
    public function action_duplicate($id = null){
        
        if(!is_null($id)){
            
            $object = Model_Forms::find($id);
            
            
            if(is_object($object)){
            
                $this->processDuplicateObject($object);

                $this->processData();
            }
            
        }
        
    }
    
    /**
     * initialize settings
     */
    public function processDuplicateObject($object) {
                
        $postDataFields  = $this->postDataReceivedFields; 
        
        $dataarray = array();
        
        if(isset($object->currentform)){
            
            $data = json_decode($object->currentform);
            
            foreach($data as $key=>$dat){
                
                $dataarray[$key] = $dat;
            }
            
        }
        
        if(isset($object->systemsconfig)){
            
            $data = json_decode($object->systemsconfig);
            
            foreach($data as $key=>$dat){
                
                $dataarray[$key] = $dat;
            }
            
        }
                
        
        $systemsconfig = array(); 
        if(is_array($postDataFields) && count($postDataFields) > 0 ){
            
            foreach ($postDataFields as $key => $postField){
                
                if(key_exists($postField,$dataarray))
                    $this->$key= $dataarray[$postField];
                else
                    $this->$key= '';
                    
                
                if(is_array($this->$key)){
                    $postdata = implode(',', $this->$key);
                    
                    $systemsconfig[$key] = $postdata;
                    
                }else{
                
                    $systemsconfig[$key] = $this->$key;
                }
            }
        } 
        
        
        $this->form_title_eng = $this->generateRandomStringB();
        
        $systemsconfig['emailTo'] = $this->email;
        
        $systemsconfig['emailBcc'] = '';
        $systemsconfig['senderName'] = '';
        $systemsconfig['enableEmail'] = '1';
        
      
                
        unset($systemsconfig['json_data']);
        $this->formId = '';
        
        $this->systemsconfig = $systemsconfig;
        
        
      
    }
    
    function generateRandomStringB($length = 9) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    

}
