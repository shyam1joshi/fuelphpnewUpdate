<?php

namespace dynamicformssystem;

class Model_Image extends Model_Base{
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
                'model_to'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.images.model_to',
                    'form' => array('type' => 'text'),
                    'validation' => array('trim', 'max_length'=>array(200),
                    'min_length'=>array(3)),
                    ),
                 'model_id'=>array(
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.image.model_id',
                    'form' => array('type' => 'text'),
                    ),
		'create_uid',
		'update_uid',
		'created_at',
		'updated_at',
	);


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[40]');
		$val->add_field('model', 'Model', 'required|valid_string[numeric]');
		$val->add_field('create_uid', 'Create Uid', 'required|valid_string[numeric]');
		$val->add_field('update_uid', 'Update Uid', 'required|valid_string[numeric]');

		return $val;
	}

    static function query($options = array()){
        
        $query = parent::clearQuery($options);
         
        return $query;
    } 
}