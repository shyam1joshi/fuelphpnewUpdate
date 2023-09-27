<?php

namespace dynamicformssystem;

class Model_Menu extends Model_Base{
    protected static $_table_name = 'dynamicformssystem_menu';
    
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
                'module_id'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.module_id',
                    'form' => array('type' => 'text'), 
                                    'null'=> true,    
                     'type'  =>  'varchar',
                                    'constraint' =>  '140',
                    ),
                'module_linked_to'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.module_linked_to',
                    'form' => array('type' => 'text'), 
                                    'null'=> true,    
                     'type'  =>  'varchar',
                                    'constraint' =>  '140',
                    ),
                'menu_name'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.menu_name',
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
                'translation'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.translation',
                    'form' => array('type' => 'text'), 
                                    'null'=> true,    
                     'type'  =>  'varchar',
                                    'constraint' =>  '140',
                    ),
            'showLink'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.showLink',
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
    
    
    function   createTableForThisModel(){

      }
    
    
      function   addMissingColumns(){
        
          
    }


	
}