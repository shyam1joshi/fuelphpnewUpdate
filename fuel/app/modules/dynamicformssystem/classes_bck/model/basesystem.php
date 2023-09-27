<?php

namespace dynamicformssystem;

class Model_Basesystem extends \Model_Base{
    
    protected static $_properties =array();


    public static $_observers = array(
                'Observer_images'=>array(
                        'events' => array('before_save'),
                        'mysql_timestamp' => true,
                ),
		
		'Observer_users' => array(
                        'property' => 'updated',
                        'events' => array('before_insert','before_save'),
                        'mysql_timestamp' => true,
                ),
        
	);
    protected static $_has_many = array();
    protected static $_has_one = array();
 
    public function  save($cascade = null, $use_transaction = false){
          
       
        if($this->get_isNew() == false){
           $this->enabled = 1;
        }
         
        return parent::save($cascade, $use_transaction);
    
   }
   
   
    public function get_isNew() {
        return $this->_is_new;
    }
   
    static function query($options = array()){
        
        $query = parent::query($options);
        
        $query->where_open();
        $query->or_where("deleted","0");
        $query->or_where("deleted","is",null);
        $query->where_close();
        return $query;
    }   
            
    public static function _init(){

       $table = self::table();
       self::preInit($table);
       
//       static::postInit();

          
//            $prop_array = static::$_properties; 
//            
//            
//            if(is_array($prop_array)){
//                foreach ($prop_array as $key=>$jarr){
//
//                    if(  key_exists('uploadCSV', $jarr) && $jarr['uploadCSV'] == 1){
//                        
//                        if(  key_exists('model', $jarr) && !empty($jarr['model'] )){
//                            $model = $jarr['model'];
//                            
//                            $objects =  $model::query()->get_array();
//                            $temp = array();
//                            if(is_array($objects) && count($objects) > 0){
//                                foreach ($objects as $key2 => $obj) {
//                                    $tmp['label'] = $obj['label'];
//                                    $tmp['value'] = $obj['value'];
//                                    $tmp['mapvalue'] = $obj['mapvalue'];
//                                    $temp[] = $tmp;
//                                }
//                            }
//                            if( count($temp) > 0 && key_exists('form', $jarr) ){
//                             $prop_array[$key]['form']['options'] = $temp;
//                               
//                            }
//                            
//                           
//                        }                
//                    }                
//                }
//            } 
//        
//        static::$_properties = $prop_array;
//             
            
        parent::_init();
    }
    
    public static function preInit($table) {
        
        try{
          
            \DBUtil::table_exists($table); 
            
            $prop = self::properties();
            $arrayKeys = array_keys($prop);
            
            foreach ($arrayKeys as $key){
                if(!\DBUtil::field_exists($table, array($key))){
                    
                   \DBUtil::add_fields($table, array($key=>$prop[$key]));
        print_r($prop['checkbox_group_1621935908108']); die();
                }
            }
            
        } catch (\Exception $ex) {
         
            \DBUtil::create_table($table, static::$_properties,array("id"));
           
       
        } 
//        
    }
    
    public static function postInit() {
         
    }
    
    
    static function clearQuery($options = array()){
        return parent::query($options);
    }
    
    public function GetPropertiesKey(){ 
        $arr = $this->properties();
        $temp = array_keys($arr);
        return $temp;
    }
    
    public function GetEmailProperties(){
             
                $temp = array();
                $arr = $this->properties();
                foreach($arr as $property=>$val){
                         if(isset($val['send_mail']) and  $val['send_mail'] === '1')
                           $temp[] = $property;
                }
                return $temp;
        }
    
    public function GetPropertiesType($prop =null){
             
                $temp = array();
                $arr = $this->properties();
                
                if($prop != null && key_exists($prop, $arr)) {
                    
                    if(isset($arr[$prop]['form']) && isset($arr[$prop]['form']['type']))
                               $temp = $arr[$prop]['form']['type'];
                    
                }else{
                    foreach($arr as $property=>$val){
                             if(isset($val['form']) && isset($val['form']['type']))
                               $temp[$property] = $val['form']['type'];
                    }
                }
                
                return $temp;
    }
    
    public function GetPropertyValue($prop = null, $field = null){
        
        $value = '0';
             
        if(!is_null($prop)){ 
            $arr = $this->properties();
            foreach($arr as $property=>$val){
                
                     if($property == $field && key_exists($prop, $val))
                       $value = $val[$prop];
            }
        }
        return $value;
    }
    
    public function GetFilters(){
        
        $data['arr'] = $this->properties();
        $data['filiterLimit'] = 4;
        
        $form = \View::forge('dynamicformssystem::logindata/indexfilter',$data);
        
        return $form;
        
    }
    
    public function GetPropertiesData($prop =null,$type =null){
             
        $data = array(); 
//        $arr = $this->properties();
//
//        if(!is_null($prop) && !is_null($type)) {
//
//            if(isset($arr[$prop]['form']) && isset($arr[$prop]['form']['options']))
//                $data = $arr[$prop]['form']['options'];
//
//        } 
//        
        $typelist = array('select','checkbox-group','radio-group');
        
        
        $module_name = \Request::active()->module;
        $moddata = \dynamicformssystem\Model_Forms::query()->where('name',$module_name)->get_one();
        
        $formdata = $moddata->currentform;
        $formdatade = json_decode($formdata,true);
        $json_data = $formdatade['json_data'];
        $json_array = json_decode($json_data,true);
        
        if(is_array($json_array)){
            foreach ($json_array as $jarr){
                if(key_exists('name', $jarr) && $jarr['name']){
                    
                    if(strpos($jarr['name'], '-') != -1) 
                            $jarr['name'] = str_replace ('-', '_', $jarr['name']);
                    
                    if( $jarr['name'] == $prop && key_exists('values', $jarr)
                            && key_exists('type', $jarr) && in_array($jarr['type'], $typelist) ){
                            $data = array();
                            
                            if(is_array($jarr['values'])){
                                foreach ($jarr['values'] as $key=>$val){
                                    $data[] = array('label' => $val['label'] , 'value' => $val['value']);
                                }
                            }
                    }
                }
                
            }
        } 
        
        return $data;
    }
    
    
    
    public function GetPropertiesMapData($prop =null,$value =null){
             
        $data = '';   
        $typelist = array('select','checkbox-group','radio-group');
        
//        $prop_array = $this->properties();
        $prop_array = static::$_properties;
   
        if(is_array($prop_array)){
            foreach ($prop_array as $key=>$jarr){
                          
                if( $key == $prop && key_exists('form', $jarr) && is_array($jarr['form']) ){
                             
                    if( key_exists('type', $jarr['form']) && in_array($jarr['form']['type'], $typelist) 
                            && key_exists('options', $jarr['form'])  ){
                                                         
                        if(is_array($jarr['form']['options'])){
                            
                            foreach ($jarr['form']['options'] as $key=>$val){

                                if(is_array($val) && key_exists('value', $val) && $value == $val['value']){  
                                    if(key_exists('mapvalue', $val)){

                                        $data = $val['mapvalue'];
                                    }else{

                                        $data = $val['value'];
                                    } 
                                }
                            }
                        } 
                    } 
                }                
            }
        } 
        
        return $data;
    }
    public function GetPropertiesMapCheckboxData($prop =null,$value =null){
             
        $data = '';   
        $typelist = array('checkbox-group');
        
        $prop_array = $this->properties();
   
        if(is_array($prop_array)){
            foreach ($prop_array as $key=>$jarr){
                          
                if( $key == $prop && key_exists('form', $jarr) && is_array($jarr['form']) ){
                             
                    if( key_exists('type', $jarr['form']) && in_array($jarr['form']['type'], $typelist) 
                            && key_exists('options', $jarr['form'])  ){
                        
                        if(is_array($jarr['form']['options'])){
                            
                            foreach ($jarr['form']['options'] as $key=>$val){

                                if($value == $val['value']){  
                                    if(key_exists('mapvalue', $val)){

                                        $data = $val['mapvalue'];
                                    }else{

                                        $data = $val['value'];
                                    } 
                                }
                            }
                        } 
                    } 
                }                
            }
        } 
        
        return $data;
    }
    
    public function GetPropertiesCheckboxData($prop =null,$value =null){
             
        $data = '';   
        $typelist = array('checkbox-group');
        
        $prop_array = $this->properties();
   
        if(is_array($prop_array)){
            foreach ($prop_array as $key=>$jarr){
                          
                if( $key == $prop && key_exists('form', $jarr) && is_array($jarr['form']) ){
                             
                    if( key_exists('type', $jarr['form']) && in_array($jarr['form']['type'], $typelist) 
                            && key_exists('options', $jarr['form'])  ){
                        
                        if(is_array($jarr['form']['options'])){
                            
                           $data = $jarr['form']['options'];
                        } 
                    } 
                }                
            }
        } 
        
        return $data;
    }
    
//    public static function getOptions(){
//                     
//        $data = '';    
//        $prop_array = self::properties();
//          
//        if(is_array($prop_array)){
//            foreach ($prop_array as $key=>$jarr){
//                          
//                if(  key_exists('form', $jarr) && is_array($jarr['form']) ){
//                             
//                    if( key_exists('type', $jarr['form'])  
//                            && key_exists('options', $jarr['form'])  ){
//                        
//                        if(is_array($jarr['form']['options'])){
//                            
//                           $data = $jarr['form']['options'];
//                        } 
//                    } 
//                }                
//            }
//        } 
//        print_r($data); die
//        
//        return $data;
//    }
    
    
}