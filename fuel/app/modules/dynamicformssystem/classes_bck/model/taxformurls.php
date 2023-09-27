<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace dynamicformssystem;
class Model_Taxformurls extends \Model_Base{
    
    protected static $_table_name = 'dynamicsystem_taxformurls';
    protected static $_properties = array(
        
         
         'id'=> array(
                    'label'=>'label.orders.id',
                    'data_type'=>'int', 
                    'type' => 'int', 
                        'auto_increment' => true,
                    'form' => array('type' => 'text'),
                ),  
        
        'form_id' =>array(
              'listview'=>'true',
             'label'=>'label.orders.name',
                    'data_type'=>'text',
                    'null' =>true,      
                    'type' => 'varchar', 
                    'constraint' => '20', 
                    'form' => array('type' => 'text'),
             
         ),
        
        'url' =>array( 
             'label'=>'label.orders.url',
                    'data_type'=>'text',
                    'null' =>true,      
                    'type' => 'varchar', 
                    'constraint' => '100', 
                    'form' => array('type' => 'text'),
             
         ),
        'bitlyurl' =>array( 
             'label'=>'label.orders.bitlyurl',
                    'data_type'=>'text',
                    'null' =>true,      
                    'type' => 'varchar', 
                    'constraint' => '100', 
                    'form' => array('type' => 'text'),
             
         ),
     'create_uid'=>array(
                    'label'=>'label.emaillog.create_uid',
                    'data_type'=>'int' ,
                    'type' => 'int', 
                    'null' =>true,
                    'form' => array('type' => false)
                    ),
        'update_uid'=>array(
                    'label'=>'label.emaillog.update_uid',
                    'data_type'=>'int',
                    'type' => 'int', 
                    'null' =>true,
                    'form' => array('type' => false)
                    ),
        'created_at'=>array(
                     'listview'=>true,
                    'label'=>'label.orders.created_at',
                    'data_type'=>'date',
                    'type' => 'timestamp',
                    'null'=>true,
                    'form' => array('type' => 'text')
                    ),
        'updated_at'=>array(
                    'label'=>'label.emaillog.updated_at',
                    'data_type'=>'date',
                    'type' => 'timestamp on update current_timestamp',
                    'null'=>true,
                    'form' => array('type' => false)
                    ), 
        
        
    
    );
    
        
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
        
    }
    
    
}
