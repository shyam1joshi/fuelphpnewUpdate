<?php 

namespace dynamicformssystem;
class Controller {

 public   $postDataReceivedFields = array(    
                                    'json_data' => 'json_data', 
                                    'logo' => 'logo', 
                                    'enableAuthentication' => 'login',
                                    'logo_id' => 'logo', 
                                    'flowType' => 'flowType', 
                                    'flowSystem' => 'flowSystem', 
                                    'formtype' => 'formtype', 
                                    'backgroundimage' => 'backgroundimage', 
                                    'backgroundimage_id' => 'backgroundimage', 
                                    'backgroundimg' => 'backgroundimage', 
                                    'agentmodule'=>"",
                                    "menuref"=>"",
                                    'email' => 'emailing', 
                                    'form_title' => 'form_title', 
                                    'color_scheme' => 'color_scheme', 
                                    'bordercolor' => 'bordercolor', 
                                    'iconcolor' => 'iconcolor', 
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
                                    'showMessageBeforePDFflow2' => 'showMessageBeforePDFflow2'
                                );

            public function __construct(
                 $name, 
                 $model, 
                 $module,
                $array
            ) {

                $this->name = $name;
                
                $this->model = $model;

                $this->module = $module;
                $this->settings =  $array;
                $this->controllerName = \Inflector::classify($this->name);
                
            }



            public function controllerPath(){
                return $this->module->getModulePath().DS.$this->module->name.DS."classes".DS."controller/";
            }

            public function controllerPathFile(){
                return $this->controllerPath().$this->name.".php";
            }
            function checkSetAndEmpty($val){
                return isset($val) && !empty($val) ;
            }
            public function getSettingsFromPost(){

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
            }

            function getAgentTable($module){
                return $module;
            }
            



            public function populateSettings(){

                $this->getSettingsFromPost();
               
                if($this->checkSetAndEmpty($this->login) && $this->login == 1) {
                    if($this->checkSetAndEmpty($this->agentmodule) && str_len($this->agentmodule)>5){
                        $this->getAgentTable($this->agentmodule);
                    }
                    $this->inheritFrom = "Controller_Base";
    
                }  else 
                $this->inheritFrom = "Controller_Basesystem";


                if($this->checkSetAndEmpty($this->menuref) && str_len($this->menuref)>5){
                    $this->config("menu",$menupdate);
                    //Config::load('foo::custom', 'bar');
                }


            }


public function flushFile( $stringTemplate){
    $file  =  $this->controllerPathFile();

    if(file_exists($file)) \File::delete($file);

    \File::create($this->controllerPath(),"{$this->name}.php",$stringTemplate);
}


public function postProcess(){
   $stringTemplate =  $this->classTemplate("","");
   $this->flushFile($stringTemplate);
}


public function classTemplate($contents,$contentfunctions){
   // $this->inheritFrom = "asd";
    $inheritFrom = $this->inheritFrom;

    $contents = $this->getControllerProperties($this->controllerName);

    $contentfunctions = $this->getControllerFunctions($this->controllerName);


$filedata  = <<<CONTROLLER
<?php

namespace {$this->module->name};

\Module::load('dynamicformssystem');   

class Controller_{$this->controllerName} extends \dynamicformssystem\\{$inheritFrom}
{
{$contents}

{$contentfunctions}
}

CONTROLLER;


    return  $filedata ;
}


public function getControllerFunctions() {
        
    $data =  '';
    
    if(isset($this->login) && $this->login == 1){
        
        $data =  \View::forge('logindata/loginbefore',null); 
        
    }
    
     $data .=  \View::forge('logindata/loginindex',null); 
    
    return $data;
}

public function getControllerProperties($class_name = null) {
       $this->filenamespace= $this->module->name;
       $this->filename= $class_name;
       $this->controller=  $class_name;
       $this->PDFXY = 1;
    $controllerProperties = <<<CONTENTS
        public \$model =  '\\{$this->filenamespace}\Model_{$class_name}';
        public \$base =  '{$this->filenamespace}/{$this->controller}';
        public \$filepath =  '{$this->filename}';
        public \$pdfpath =  '{$this->filename}';
        public \$modulename =  '{$this->filename}';
        public \$formtype =  '{$this->formtype}';
        public \$color_scheme =  '{$this->color_scheme}';
        public \$bordercolor =  '{$this->bordercolor}';
        public \$iconcolor =  '{$this->iconcolor}';
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
        public \$dont_store_data =  '{$this->dont_store_data}';
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

public function getEscapeArray() {
        
    $this->formEscapeMehodArray();
    
    $data = "array('formbuilderjs','sinatureJS','clipboardJS','formbuildercss'
            ,'formcss','newformcss','login', 'logout', 'exportDocumentToPdfOnSubmit','exportDocumentToPdf', 'showDocumentToPdf','showAndExportDocumentToPdf',
            'rest_login','jsonOrdercomplete','jsonPaymentcomplete','viewxPDF','index',
            'specialprocess_import','jsonPaymentfailed','jsonOrderfailed','createImagex',$this->loginMethods)";
     
    
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
}