 
use Orm\Model;

namespace <?php if(isset($module)) echo $module ?>;

class Model_Agents extends \Model_Base
{
    protected static $_table_name = 'fb_<?php if(isset($module)) echo $module ?>_agents';

protected static $_properties =array(
	
'id'=>array(
   
                                        'type' => 'int',
                                        'auto_increment' => true, 

    ),    
    'distributor_number'=>array(
                                    'form'=> array(
                                            'type'=> 'text', 
                                                ),
                                    'type'=> 'int',
                                    'null'=> true,
                                    'label'=> 'label.agents.distributor_number',
                                    'type'  =>  'varchar',
                                    'constraint' =>  '100', 
                   
      ),
    
    'name'=>array(
                	   'form'=> array(
                                            'type'=> 'text', 
                                                ),
                                    'type'=> 'int',
                                    'null'=> true,
                                    'label'=> 'label.agents.name',
                                    'type'  =>  'varchar',
                                    'constraint' =>  '100',
                                    'listview' => true,
                   
		),
  'seq_order_start'=>array(
                                    'form'=> array(
                                            'type'=> 'text', 
                                                ),
                                    'type'=> 'int',
                                    'null'=> true,
                                    'label'=> 'label.agents.sequence_start',
                                    'type'  =>  'int',
                                    'constraint' =>  '11', 
                   
      ),
  'seq_order_end'=>array(
                                    'form'=> array(
                                            'type'=> 'text', 
                                                ),
                                    'type'=> 'int',
                                    'null'=> true,
                                    'label'=> 'label.agents.sequence_end',
                                    'type'  =>  'int',
                                    'constraint' =>  '11', 
                   
      ),
    
     'seq_order_current'=>array(
                                    'form'=> array(
                                            'type'=> 'text', 
                                                ),
                                    'type'=> 'int',
                                    'null'=> true,
                                    'label'=> 'label.agents.sequence_current',
                                    'type'  =>  'int',
                                    'constraint' =>  '11',
                                    'listview' => true,
                   
      ), 
  'agent_code'=>array(
		   'form'=> array(
                                            'type'=> 'text', 
                                                ),
                                    'type'=> 'int',
                                    'null'=> true,
                                    'label'=> 'label.agents.agent_code',
                                    'type'  =>  'varchar',
                                    'constraint' =>  '11', 
                   
    ),
     
    'phone_number'=>array(
                	'label'=>'label.agents.phone_number',
			'data_type'=>'varchar',
			'type'=>'varchar',
			'constraint'=>30,
			'null'=>true, 
    'form' => array('type' => 'text'),
		),
	 
    'allow_web'=>array(
                	'label'=>'label.agents.allow_web',
			'data_type'=>'int',
                                    'null'=> true,
                                    'type'  =>  'int',
                        'default' => 0,
    'form' => array('type' => 'checkbox', 'value' => '1' ),
		),
	
    'allow_mobile'=>array(
                	'label'=>'label.agents.allow_mobile',// flag = boxes, field =quanboxes
			'data_type'=>'int',
                                    'null'=> true,
                                    'type'  =>  'int',
                        'default' => 0,
    'form' => array('type' => 'checkbox', 'value' => '1', ),
		),
  	
    
    'enableagentmail' => array(        
                	'label'=>'label.agents.enableagentmail',
			'data_type'=>'int',
                                    'null'=> true,
                                    'type'  =>  'int',
                        'default' => 0,
                        'form' => array('type' => 'checkbox', 'value' => '1' ),
                    ),
    'allowupdate' => array(        
                	'label'=>'label.agents.allowupdate',
			'data_type'=>'int',
                                    'null'=> true,
                                    'type'  =>  'int',
                        'default' => 0,
                        'form' => array('type' => 'checkbox', 'value' => '1' ),
                    ),
    
    
 'limit_menu'=>array(
                	'label'=>'label.agents.limit_menu',
			'data_type'=>'int',
                                    'null'=> true,
                                    'type'  =>  'int',
    'form' => array('type' => 'text'),
		),	
  
'connect_uid'=>array(
		'label'=>'label.agents.connect_uid',
                'data_type'=>'int',
                                    'null'=> true,
                                    'type'  =>  'int',
        "listview"=>true,
    'form' => array('type' => 'select','class'=>'select-remote','href'=>'/users/list.json','style'=>"width:200px"),
		),
	
                        'created_at' => array(
                                        'type'=> 'timestamp',
                                        'null'=> true, 
                                        'form'=> array( 'type' => false)
                                ),
                        'updated_at' => array(
                                        'type'=> 'timestamp on update current_timestamp',
                                        'null'=> true, 
                                        'form'=> array( 'type' => false),
                                        'listview' => true,
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

protected static $_has_one = array(
            'user' => array(
                        'key_from' => 'connect_uid',
                        'model_to' => '\\Model_User',
                        'key_to' => 'id',
                        'cascade_save' => true,
                        'cascade_delete' => false,
                    )
    );

 function save($cascade = null, $use_transaction = false){
     $diff =  $this->get_diff();
     
     if(key_exists('seq_payment_start', $diff)){
         $this->seq_payment_current = $this->seq_payment_start;
     }
     if(key_exists('seq_order_start', $diff)){
         $this->seq_order_current = $this->seq_order_start;
     }
     
     if(isset($this->enable_allreports) && $this->enable_allreports != 1)
         $this->enable_allreports = 0;
     if(isset($this->enable_replace) && $this->enable_replace != 1)
         $this->enable_replace = 0;
     if(isset($this->enable_freetext) && $this->enable_freetext != 1)
         $this->enable_freetext = 0;
     if(isset($this->enable_customercards) && $this->enable_customercards != 1)
         $this->enable_customercards = 0;
     if(isset($this->enablepriceedit) && $this->enablepriceedit != 1)
         $this->enablepriceedit = 0;
     if(isset($this->enableorderpriceedit) && $this->enableorderpriceedit != 1)
         $this->enableorderpriceedit = 0;
     if(isset($this->enablequotepriceedit) && $this->enablequotepriceedit != 1)
         $this->enablequotepriceedit = 0;
     if(isset($this->enabledeliverypriceedit) && $this->enabledeliverypriceedit != 1)
         $this->enabledeliverypriceedit = 0;
     if(isset($this->enablereceiptinvoicepriceedit) && $this->enablereceiptinvoicepriceedit != 1)
         $this->enablereceiptinvoicepriceedit = 0;
     if(isset($this->enabledeliverysliptoinvoice) && $this->enabledeliverysliptoinvoice != 1)
         $this->enabledeliverysliptoinvoice = 0;
     
    return parent::save($cascade, $use_transaction);
 }

    public static function setNewSequence($properties,$vars) {

           foreach ($vars as $var) {

                     $properties["$var"] =  array('data_type'=>'int',
                       'label'=>'label.agents.'.$var,
                       'form' => array('type' => 'text'),
                     );
           }
           return $properties;    
    }
    public static function setCheckbox($properties,$vars) {

           foreach ($vars as $var) {

                     $properties["$var"] =  array('data_type'=>'int',
                       'label'=>'label.agents.'.$var,
                       'form' => array('type' => 'checkbox','value'=>'1'),
                     );
           }
           return $properties;    
    }
 
    
 
    public static function _init(){

        $table = self::table();
        self::preInit($table);
       $flagarray = array( 'enablegoodmeat','enableVisitReport', 'jsonCusromerCreate','turnoffsequence','receiptinvoicenewsequence','enablepriceoffers','enableinventorys','inforeports');


       $flags = \Controller_Base::getModuleFlags($flagarray);

       if (is_array($flags)) {
           foreach ($flags as $key => $value)  
               $$key = $value;
       }

       $arr = static::$_properties;
     
    
        static::$_properties  =$arr; 
   
        parent::_init();
    }
     
   
    public static function unsetFields($properties) {
        
        $fields = $this->getReceiptinvoiceNewFields();
        
        foreach ($fields as $field){
            unset($properties[$field]);
        }
        
        return $properties;
    }

    public static function preInit($table) {
       
        try{ 
            
            $prop = self::$_properties;
            $arrayKeys = array_keys($prop);
            
            
            foreach ($arrayKeys as $key){
                if(!\DBUtil::field_exists($table, array($key))){
                    
                   \DBUtil::add_fields($table, array($key=>$prop[$key]));
                }
            }
            
        } catch (\Exception $ex) {
          
            \DBUtil::create_table($table, static::$_properties,array("id"));
            
            self::addDefaultData();
            
            return;
        } 
        
    }
    
    public static function addDefaultData(){
    
        $users = array('saed','shyam@shyamjoshi.in','namrata');
     
        
        foreach($users as $user){

            $userobj = \Model_User::query()->where('username',$user)->get_one();

            if(is_object($userobj)){
                $agent = array('name'=>$userobj->name,'allow_web' => '1', 'allow_mobile' => '1','connect_uid'=>$userobj->id);
 
                $agentdata = Model_Agents::forge()->set($agent);
                
                 $agentdata->save();
            }
        }
        
    }
    
}
