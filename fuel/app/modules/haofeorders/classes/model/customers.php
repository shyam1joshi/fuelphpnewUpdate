<?php

namespace haofeorders;

class Model_Customers extends \Model_Customers{
    
        
     public static function _init(){
         
            $arr = static::$_properties; 
            $arr['usercreated'] =  array ( 
                                   'label' => 'label.customers.usercreated',
                                   'form' =>  
                               array (
                                   'type' => false,
                                 )
                                 );
            $arr['baseurl'] =  array ( 
                                   'label' => 'label.customers.baseurl',
                                   'form' =>  
                               array (
                                   'type' => false,
                                 )
                                 );
         
             
            static::$_properties  =$arr; 
            
           parent::_init();
    }
    
}