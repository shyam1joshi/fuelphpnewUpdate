<?php

namespace dynamicformssystem;

class Model_Validlinks extends Model_Base{
    protected static $_table_name = 'dynamicformssystem_validlinks';
    
    protected static $_properties = array(
		'id' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'auto_increment' => true,
                                        
                                ),
		'modulename'=> array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.modulename',
                    'form' => array('type' => 'text'),  
                                    'null'=> true,    
                     'type'  =>  'varchar',
                                    'constraint' =>  '140',
                    ),
                'record_id'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.record_id',
                    'form' => array('type' => 'text'), 
                                    'null'=> true,    
                     'type'  =>  'varchar',
                                    'constraint' =>  '140',
                    ),
                'link_expire_date'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.link_expire_date',
                    'form' => array('type' => 'text'), 
                                    'null'=> true,    
                     'type'  =>  'varchar',
                                    'constraint' =>  '140',
                    ), 
                'link'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.link',
                    'form' => array('type' => 'text'), 
                                    'null'=> true,    
                     'type'  =>  'varchar',
                                    'constraint' =>  '140',
                    ),
                 
                        'deleted' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'created_at' => array(
                                        'type'=> 'timestamp',                                         
                                        'form'=> array( 'type' => false),'null'=> true,'listview' => true,'form'=> array( 'type' => 'text'),'label'=> 'label.orders.created_at','filter' => '1',
                                        
                                ),
                        'updated_at' => array(
                                        'type'=> 'timestamp on update current_timestamp',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'create_uid' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'update_uid' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
	);
     


	
}