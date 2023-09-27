<?php

namespace trackdevices;

class Model_Userdevices extends \Model_Base
{
	protected static $_properties = array(
		'id'=>  array (
                        'type' => 'int',
                          'label' => 'label.user.id',
                          'data_type' => 'int',
                     'auto_increment' => true,
                        ),
		'username'=> array(
                    'type' => 'varchar',
                    'constraint' => 50,
                    'null'=>true,
                    'listview'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.user.username',
                    'form' => array('type' => 'text'), 
                    ),
		'user_id'=>array(
                    'type' => 'int',
                    'null'=>true,
                    'data_type' => 'int',
                    'label' => 'label.user.user_id',
                    'form' => array('type' => 'select','class'=>"select-remote","href"=> "/users/list.json"), 
                    ),
		'device_id'=>array(
                    'type' => 'varchar',
                    'null'=>true,
                    'data_type' => 'varchar',
                    'label' => 'label.user.device_id',
                    'constraint' => 50,
                    'form' => array('type' => 'text'), 
                    ),
                'blocked'=> array(
                    'listview'=>true,
                    'data_type' => 'int',
                    'label' => 'label.user.blocked',
                    'type' => 'int',
                    'null'=>true,
                    'default'=> 0,
                    'form' => array('type' => 'checkbox',"value" => "1"), 
                   ),
		   
        'create_uid' =>  array (
                          'label' => 'label.quotes.create_uid',
                          'data_type' => 'int',
                        'type' => 'int',
                        'null'=>true,
                          'form' => 
                          array (
                            'type' => false,
                          ),
                        ),
        'update_uid' => array (
                          'label' => 'label.quotes.update_uid',
                          'data_type' => 'int',
                        'type' => 'int',
                        'null'=>true,
                          'form' => 
                          array (
                            'type' => false,
                          ),
                        ),
        'created_at' => array (
                          'listview' => true,
                          'label' => 'label.quotes.created_at',
                          'data_type' => 'date',
                        'type' => 'timestamp',
                        'null'=>true,
                          'form' => 
                          array (
                            'type' => false,
                          ),
                        ),
        'updated_at' =>  array (
                          'label' => 'label.quotes.updated_at',
                          'data_type' => 'date',
                        'type' => 'timestamp on update current_timestamp',
                        'null'=>true,
                          'form' => 
                          array (
                            'type' => false,
                          ),
                        ),
	);

        protected static $_has_one = array(
            'user' => array(
                    'key_to' => 'id',
                    'model_to' => '\\Model_User',
                    'key_from' => 'user_id',
            )
        );

                public static function validateDevice() {
        $device_id  = \Input::post('device_id', "");
        $email  = \Input::post('email', "");
        
        if(!empty($device_id)){
            
            $device = Model_Userdevices::query()
                       ->where("device_id",$device_id)
                       ->where("username",$email)->get_one();
            
            if(is_object($device)){
                if($device->blocked != 1){
                    return true;
                }else{
                    return false;
                }
            }else{
                self::createNewDevice();
                 return true;
            }
            
        }else{
            return true;
        }

    }
      
    public static function createNewDevice() {
        
        $device_id  = \Input::post('device_id', "");
        $email  = \Input::post('email', "");
        if(!empty($device_id) && !empty($email)){
            
        $user_id = \Auth::get_user_id();
         $device = new Model_Userdevices();
         
         $device->user_id = $user_id[1]; 
         $device->device_id = $device_id; 
         $device->username = $email; 
         $device->blocked = 0; 
         
         $device->save();
        
         return true;
        }
    }
 
     public static function _init(){
         
        $table = self::table();
        self::preInit($table);
         
        parent::_init();
     }
    
    public static function preInit($table) {
        
        try{
            
            \DBUtil::table_exists($table); 
            
        } catch (\Exception $ex) {
         
            
            \DBUtil::create_table($table,self::$_properties,array("id"));
        } 
        
    }
}
