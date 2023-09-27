<?php

namespace haofeorders;

class Model_Deliverylines extends \Model_Deliverylines{
    
        
    public static function _init(){
        
        $arr = static::$_properties;              
                      
        $arr["original_quantity"] =  array('data_type'=>'text', 
                                            'label'=>'label.deliverylines.original_quantity', 
                                            'form' => array('type' => 'text'),
                                        );      
        $arr["supplied"] =  array('data_type'=>'text', 
                                            'label'=>'label.deliverylines.supplied', 
                                            'form' => array('type' => 'text'),
                                        );      
        
        static::$_properties  =$arr; 
        parent::_init();
    }
}


