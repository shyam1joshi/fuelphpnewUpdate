<?php

namespace dynamicformssystem;
 
class Model_Emaildetails extends Model_Base{
    
    protected static $_table_name = 'formsystememailconfig';
    
     protected static $_properties = array(
		'id'=> array(
                            'type'=> 'int',                                         
                            'auto_increment' => true,
                            'form'=> array( 'type' => false)
                    ), 
		'form_id'=> array(  
                    'null'=>true,
                    'type'=> 'int',     
                    'label' => 'label.from.form_id',
                    'form' => array('type' => 'text'),  
                    ),
		'module'=> array( 
                    'null'=>true,
                    'type'=> 'varchar',   
                    'constraint'=> '100',    
                    'label' => 'label.from.name',
                    'form' => array('type' => 'text'),  
                    ),
		'subject'=> array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'type'=> 'longtext',     
                    'label' => 'label.from.subject',
                    'form' => array('type' => 'text'), 
                    ),
                'body'=>array( 
                    'null'=>true,
                    'label'=>'label.orders.body',
                    'type'=> 'longtext',    
                    'form'=>array('type'=>'text')
                    
		),
                'deleted' => array(
                                'type'=> 'int',    
                                'label' => 'label.images.deleted',                                     
                                'null'=> true,
                                'form'=> array( 'type' => false)
                        ),
                'created_at' => array(
                                'type'=> 'timestamp',                                         
                                'null'=> true,
                                'form'=> array( 'type' => false)
                        ),
                'updated_at' => array(
                                'type'=> 'timestamp on update current_timestamp',                                         
                                'null'=> true,
                                'form'=> array( 'type' => false)
                        ),
                'create_uid' => array(
                                'type'=> 'int',                                         
                                'null'=> true,
                                'form'=> array( 'type' => false)
                        ),
                'update_uid' => array(
                                'type'=> 'int',                                         
                                'null'=> true,
                                'form'=> array( 'type' => false)
                        ),
    );
    
    
    public static $_has_one = array (
        'form' => array (
            'model_to' => '\dynamicformssystem\Model_Forms',
            'key_to' => 'id',
            'key_from' => 'form_id',
        ),
    
    );
    
}