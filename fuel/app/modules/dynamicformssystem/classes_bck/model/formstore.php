<?php

namespace dynamicformssystem;

class Model_Formstore extends Model_Base{
    protected static $_properties = array(
		'id',
		'name'=> array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.name',
                    'form' => array('type' => 'text'),
                    'validation' => array('trim', 'max_length'=>array(200),
                    'min_length'=>array(3)),
                    'image'=>true,
                    ),
                'systemsconfig_id'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.model_to',
                    'form' => array('type' => 'text'),
                    'validation' => array('trim', 'max_length'=>array(200),
                    'min_length'=>array(3)),
                    ),
            'currentform'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.model_to',
                    'form' => array('type' => 'text'),
                    'validation' => array('trim', 'max_length'=>array(200),
                    'min_length'=>array(3)),
                    ),
		'create_uid',
		'update_uid',
		'created_at',
		'updated_at',
	);
    
    
    function   createTableForThisModel(){

      }
    
    
      function   addMissingColumns(){
        
          
    }


	
}