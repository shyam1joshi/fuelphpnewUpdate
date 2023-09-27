<?php

namespace dynamicformssystem;

class Model_Forms extends Model_Base{
    
    protected static $_table_name = 'formsystemconfig';
    
    protected static $_properties = array(
		'id'=> array(
                            'type'=> 'int',                                         
                            'auto_increment' => true,
                            'form'=> array( 'type' => false)
                    ), 
		'name'=> array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'null'=>true,
                    'type'=> 'varchar',   
                    'constraint'=> '100',   
                    'label' => 'label.from.name',
                    'form' => array('type' => 'text'),  
                    ),
		'title'=> array(
                    'listview'=>true,
                    'null'=>true,
                    'data_type' => 'varchar',
                    'type'=> 'varchar',   
                    'constraint'=> '100',   
                    'label' => 'label.from.title',
                    'form' => array('type' => 'text'), 
                    ),
                'currentform'=>array( 
                    'null'=>true,
                    'label'=>'label.orders.currentform',
                    'type'=> 'text',   
                    'data_type'=>'varchar',
                    'form'=>array('type'=>'text')
                    
		),
                'currentform_json'=>array( 
                    'null'=>true,
                    'label'=>'label.orders.currentform_json',
                    'type'=> 'text',   
                    'data_type'=>'varchar',
                    'form'=>array('type'=>'text')
                    
		),
                'currentform_title'=>array( 
                    'null'=>true,
                    'label'=>'label.orders.currentform_title',
                    'type'=> 'text',   
                    'data_type'=>'varchar',
                    'form'=>array('type'=>'text')
                    
		),
                'systemsconfig_id'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'type'=> 'int',   
                    'label' => 'label.images.model_to',
                    'form' => array('type' => 'text'), 
                    ),
                'systemsconfig'=>array( 
                    'null'=>true, 
                    'type'=> 'text',   
                    'label' => 'label.images.text',
                    'form' => array('type' => 'text'), 
                    ),
                'bitlyApiKey'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'type'=> 'varchar',
                    'constraint'=> '100',      
                    'label' => 'label.images.bitlyApiKey',
                    'form' => array('type' => 'text'), 
                    ),
                'oldforms'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.oldforms',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ),
                'logo'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.logo',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ),
                'backgroundimage'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.backgroundimage',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ),
                'logo_id'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.logo_id',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ),
                'backgroundimage_id'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.backgroundimage_id',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ),
                'email'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.email',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ),
                'color_scheme'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.color_scheme',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ),
                'color_code'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.color_code',
                    'type'=> 'varchar',   
                    'constraint'=> '100',      
                    'form' => array('type' => 'text'), 
                    ),
                'shorten_url'=>array( 
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.shorten_url',
                    'type'=> 'text',   
                    'form' => array('type' => 'text'), 
                    ), 
                'csvproperties'=>array( 
                    'null'=>true, 
                    'label' => 'label.images.csvproperties',
                    'type'=> 'longtext',   
                    'form' => array('type' => 'text'), 
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
        'logoimage' => array (
            'model_to' => '\\Model_Image',
            'key_to' => 'id',
            'key_from' => 'logo_id',
        ),
        'backgroundimg' => array (
            'model_to' => '\\Model_Image',
            'key_to' => 'id',
            'key_from' => 'backgroundimage_id',
        ),
    );
    
}