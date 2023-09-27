<?php

namespace dynamicformssystem;
     
    
class Model_Formsettings extends Model_Base
{
        
    protected static $_table_name = 'fb_formsettings';
                
    protected static $_properties =  array( 
                        'form_data' => array(  
                                    'form'=> array(
                                            'type'=> 'text', 
                                                ),
                                    'type'=> 'blob',
                                    'null'=> true,
                                    'label'=> 'label.mguapfpbhg.form_data', 
               //  'limit' =>  '1',

                            ), 
		'modulename'=> array(
                    'listview'=>true, 
                    'null'=>true,
                    'type'=> 'varchar',   
                    'constraint'=> '100',   
                    'label' => 'label.from.modulename',
                    'form' => array('type' => 'text'),  
                    ),
'id' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'auto_increment' => true,'listview' => true,'form'=> array( 'type' => 'text'),'label'=> 'label.reports.id',
                                        
                                ),
                        'name' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'agent_id' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,'listview' => true,'form'=> array( 'type' => 'text'),'label'=> 'label.orders.agent_id',
                                        
                                ),
                        'mobile' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'flow' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'key_to' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'confirm' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'deleted' => array(
                                        'type'=> 'int',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'submitted_date' => array(
                                        'type'=> 'timestamp',                                         
                                        'form'=> array( 'type' => false),'null'=> true,
                                        
                                ),
                        'submittedupdate_date' => array(
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
          
    public static  $_has_one= array( 
            
    );
       
    
}
