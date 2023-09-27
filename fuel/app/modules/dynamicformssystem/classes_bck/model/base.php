<?php

namespace dynamicformssystem;

class Model_Base extends \Model_Base{
    
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
                }
            }
            
        } catch (\Exception $ex) {
         
            \DBUtil::create_table($table, static::$_properties,array("id"));
       
        } 
//        
    }
    
    
    static function clearQuery($options = array()){
        return parent::query($options);
    }
   
}