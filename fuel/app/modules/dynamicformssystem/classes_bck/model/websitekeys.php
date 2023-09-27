<?php

namespace dynamicformssystem;

class Model_Websitekeys extends Model_Base{
    
    protected static $_table_name = 'websitekeys';
    
    protected static $_properties = array(
		'id'=> array(
                            'type'=> 'int',                                         
                            'auto_increment' => true,
                            'form'=> array( 'type' => false)
                    ), 
		'modulename'=> array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'null'=>true,
                    'type'=> 'varchar',   
                    'constraint'=> '100',   
                    'label' => 'label.from.modulename',
                    'form' => array('type' => 'text'),  
                    ),
		'uniquekey'=> array(
                    'listview'=>true,
                    'null'=>true,
                    'data_type' => 'varchar',
                    'type'=> 'varchar',   
                    'constraint'=> '100',   
                    'label' => 'label.from.uniquekey',
                    'form' => array('type' => 'text'), 
                    ),
                'record_id'=>array( 
                    'null'=>true,
                    'label'=>'label.orders.record_id',
                    'type'=> 'int',   
                    'data_type'=>'varchar',
                    'form'=>array('type'=>false)
                    
		),
                'agent_id'=>array( 
                    'null'=>true,
                    'label'=>'label.orders.agent_id',
                    'type'=> 'int',   
                    'data_type'=>'varchar',
                    'form'=>array('type'=>false)
                    
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
    
    
}