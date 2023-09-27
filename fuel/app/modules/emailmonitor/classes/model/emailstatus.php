<?php

namespace emailmonitor;

class Model_Emailstatus extends \Model_Base
{
protected static $_table_name = 'emailstatus';
protected static $_properties =array(
	
'id'=>array(
    'label'=>'label.emailstatus.id',
    'data_type'=>'int',
    'form' => array('type' => 'text'),

    ),   
'type'=>array(
    'label'=>'label.emailstatus.type',
    'data_type'=>'varchar',
    "listview"=>true,
    'form' => array('type' => 'text'),

    ),    
'quote_id'=>array(
    'label'=>'label.emailstatus.quote_id',
    'data_type'=>'varchar',
    "listview"=>true,
    'form' => array('type' => 'text'),

    ),     
'name'=>array(
    'label'=>'label.orders.name',
    'data_type'=>'varchar',
    "listview"=>true,
    'form' => array('type' => 'text'),

    ),     
'email'=>array(
    'label'=>'label.emailstatus.email',
    'data_type'=>'varchar',
    "listview"=>true,
    'form' => array('type' => 'text'),

    ),   
      
'status'=>array(
    'label'=>'label.emailstatus.status',
    'data_type'=>'int',
    "listview"=>true,
    'form' => array('type' => 'text'),

    ),  
'create_uid'=>array(
		'label'=>'label.emailstatus.create_uid',
			'data_type'=>'int','form' => array('type' => false),
		),
	
'update_uid'=>array(
		'label'=>'label.emailstatus.update_uid',
			'data_type'=>'int','form' => array('type' => false),
		),
	
'created_at'=>array(
		'label'=>'label.emailstatus.created_at',
                'listview'=>true,
			'data_type'=>'date',
      'form' => array('type' => false),
		),
	
'updated_at'=>array(
		'label'=>'label.emailstatus.updated_at',
			'data_type'=>'date','form' => array('type' => false),
		),
    
	);

public function GetListViewProperties(){
        $arr = $this->properties();
                foreach($arr as $property=>$val){
                         if(//isset($val['form']['type']) and
                                  //(bool)$val['form']['type'] === true &&
                                  array_key_exists('listview', $val))
                         {
                             $arr[$property]['label'] = \Lang::get($arr[$property]['label'])?
                                     \Lang::get($arr[$property]['label']) :
                                        $arr[$property]['label'];
                             continue;
                         }
                         else unset($arr[$property]);
                }
                return $arr;
    }

}
