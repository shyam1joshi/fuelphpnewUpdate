<?php

namespace haofeorders;

class Model_Deliverys extends \Model_Deliverys{
    
    
protected static $_properties =
array (
  'id' => 
  array (
    'label' => 'label.quotes.id',
    'data_type' => 'int',
  ),
  'name' => 
  array (
    'listview' => true,
    'label' => 'label.deliverys.name',
    'data_type' => 'varchar',
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
  'customer_id' => 
  array (
    'listview' => true,
    'label' => 'label.quotes.customer_id',
    'data_type' => 'int',
    'form' => 
    array (
      'type' => 'hidden',
      'class' => 'popup-autocomplete',
      'href' => '/customers/list.json',
      'style' => 'width:200px',
    ),
  ),
      'agent_id' => 
  array (
//    'listview' => true,
    'label' => 'label.quotes.customer_id',
    'data_type' => 'int',
    
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
      'agent_update_id' => 
  array (
//    'listview' => true,
    'label' => 'label.quotes.agent_update_id',
    'data_type' => 'int',
    'type' => 'int',
    
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
        'discount' => 
  array (
    'label' => 'label.orders.discount',
    'data_type' => 'float',
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
        'discount_all' => 
  array (
    'label' => 'label.orders.discount',
    'data_type' => 'float',
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
  'location_id' => 
  array (
    'label' => 'label.quotes.location_id',
    'data_type' => 'int',
    'form' => 
    array (
      'type' => 'select',
      'class' => 'select-remote',
      'href' => '/locations/list.json',
      'style' => 'width:200px',
    ),
  ),
  'last_visit_date' => 
  array ( 
    'label' => 'label.customers.last_visit_date',
    'data_type' => 'varchar',
    'form' => 
    array (
      'type' => 'date',
    ),
  ),
  'last_order_by_phone' => 
  array ( 
    'label' => 'label.customers.last_order_by_phone',
    'data_type' => 'varchar',
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
  'pricelist_id' => 
  array (
    'label' => 'label.quotes.pricelist_id',
    'data_type' => 'int',
    'form' => 
    array (
      'type' => 'select',
      'class' => 'select-remote',
      'href' => '/pricelists/list.json',
      'style' => 'width:200px',
    ),
  ),
//  'agent_id' => 
//  array (
//    'label' => 'label.quotes.customer_id',
//    'data_type' => 'int',
//    
//    'form' => 
//    array (
//      'type' => 'text',
//    ),
//  ),
  'amount_total' => 
  array (
    'label' => 'label.quotes.amount_total',
    'data_type' => 'float',
   
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
  'amount_totalbeforetax' => 
  array (
    'label' => 'label.quotes.amount_totalbeforetax',
    'data_type' => 'float',
   
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
  'confirm' => 
  array (
    'label' => 'label.quotes.confirm',
    'data_type' => 'int',
  ),
  'sendtocodebina' => 
  array (
    'label' => 'label.quotes.sendtocodebina',
    'data_type' => 'int',
  ),
  'sendtocodebinawarehouse' => 
  array (
    'label' => 'label.quotes.sendtocodebina',
    'data_type' => 'int',
  ),
  'senttocodebina' => 
  array (
    'label' => 'label.quotes.senttocodebina',
    'data_type' => 'int',
  ),
  'warehouseprint' => 
  array (
    'label' => 'label.quotes.warehouseprint',
    'data_type' => 'int',
  ),
  'userprint' => 
  array (
    'label' => 'label.quotes.userprint',
    'data_type' => 'int',
  ),
  'warehouseview' => 
  array (
    'label' => 'label.quotes.warehouseprint',
    'data_type' => 'int',
  ),
  'mobile' => 
  array (
    'label' => 'label.quotes.mobile',
    'data_type' => 'int',
    'form' => 
    array (
      'type' => false,
    ),
  ),
    
  'total_quantities' => 
  array (
    'label' => 'label.quotes.total_quantities',
    'data_type' => 'int',
     
    'form' => 
    array (
      'type' => false,
    ),
  ),
     'comment' => 
  array (
    'label' => 'label.quotes.comment',
    'data_type' => 'text',
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
     'supplydate' => 
  array (
    'label' => 'label.quotes.supplydate',
    'data_type' => 'text',
     
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
     'suppliedstatus' => 
  array (
    'label' => 'label.quotes.suppliedstatus',
    'data_type' => 'text',
    'form' => 
    array (
      'type' => 'text',
    ),
  ),
  'create_uid' => 
  array (
    'label' => 'label.quotes.create_uid',
    'data_type' => 'int',
    'form' => 
    array (
      'type' => false,
    ),
  ),
  'update_uid' => 
  array (
    'label' => 'label.quotes.update_uid',
    'data_type' => 'int',
    'form' => 
    array (
      'type' => false,
    ),
  ),
  'exported' => 
  array (
    'label' => 'label.deliverys.exported',
    'data_type' => 'long',
    'form' => 
    array (
      'type' => false,
    ),
  ),  'update_order_time' => 
  array (
 
    'label' => 'label.quotes.update_order_time',
    'data_type' => 'date',
    'form' => 
    array (
      'type' => false,
    ),
  ),
    'syncdate' => 
  array (
    'label' => 'label.quotes.syncdate',
    'data_type' => 'date',
    'form' => 
    array (
      'type' => false,
    ),
  ),
     
        'untaxed' => 
              array (
                'label' => 'label.deliverys.untaxed',
                'data_type' => 'int',
                'type' => 'int',
                'null' => true,
                'form' => 
                array (
                  'type' => false,
                ),
              ),
  'createdstamp' => 
  array (
    'label' => 'label.quotes.createdstamp',
    'data_type' => 'int',
    'form' => 
    array (
      'type' => false,
    ),
  ),
        'confirm_server_time' => 
              array ( 
                'label' => 'label.orders.confirm_server_time',
                'data_type' => 'date',
                'type' => 'timestamp',
                  'null'=>true,
                'form' => 
                array (
                  'type' => false,
                ),
              ),
        
        'deleted' => 
              array (
//                'listview' => true,
                'label' => 'label.orders.deleted',
                'data_type' => 'int',
                'default' => '0',
                'form' => 
                array (
                  'type' => false,
                ),
              ),
  'created_at' => 
  array (
    'listview' => true,
    'label' => 'label.quotes.created_at',
    'data_type' => 'date',
    'form' => 
    array (
      'type' => false,
    ),
  ),
  'updated_at' => 
  array (
    'label' => 'label.quotes.updated_at',
    'data_type' => 'date',
    'form' => 
    array (
      'type' => false,
    ),
  ),
);
 protected static $_has_many = array(
    'deliverylines' => array(
        'controller'=>'deliverylines',
        'key_from' => 'id',
        'model_to' => '\haofeorders\Model_Deliverylines',
        'key_to' => 'delivery_id',
        'cascade_save' => true,
        'cascade_delete' => true,
    )
);
   
   public function  save_data($cascade = null, $use_transaction = false){
      
       
    return parent::save_data($cascade, $use_transaction);
    
   }
   
   function editdeliverylines($data){
       
       
       //print_r($data);
       foreach($data as $key => $info){
           $flag = false;
           if(array_key_exists('delete_id',$info))
           {
               $del = \haofeorders\Model_Deliverylines::find($info['delete_id']);
               $del->delete();
               \Log::warning('orderline '.$info['delete_id'].' is deleted!! ');
           }else{  
           if(array_key_exists('id',$info))
           {
               
               $orderline = $this->deliverylines[$info['id']];
               unset($info['id']);
               $flag = true;
           }
           else 
                $orderline = new \haofeorders\Model_Deliverylines();

           
              $orderline->set($info);
              
              if(!$flag)
                  $this->deliverylines[] =$orderline ;
           }
           
          
       }
       
   }
   
   
      
   
   public function  save($cascade = null, $use_transaction = false){
        $auth = \Auth::get_user_id();
        $auth = $auth[1];
        $queryagent = \Model_Agents::query();
        $queryagent->where('connect_uid','=',$auth);
        $agent = $queryagent->get_one();
        if(is_object($agent))
            $this->agent_id = $agent->id;
       
        
        $customer = \Model_Customers::query()->where('agent_id',$this->agent_id)->get_one();
        
        if(is_object($customer))
            $this->customer_id = $customer->id;
       
        return parent::save($cascade, $use_transaction);
    
   }
   
   
   function calculate_total(){
       
       
       $auth = \Auth::get_user_id();
         $auth = $auth[1];
         $queryagent = \Model_Agents::query();
         $queryagent->where('connect_uid','=',$auth);
         $agent = $queryagent->get_one();
         if(is_object($agent))
             $this->agent_id = $agent->id;
       
       $this->amount_totalbeforetax = 0;
       foreach($this->deliverylines as $lines){
        $this->amount_totalbeforetax= $this->amount_totalbeforetax+    $lines->total_amt;
       }
       
       $tax = \Controller_Systems::distroinfo();
       $tax = $tax['distrotax'];
       
       
       $this->amount_total =  $this->amount_total +( $tax * $this->amount_totalbeforetax);
        /*****************enable round up or down start****************************/
       $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();

        if(is_object($info))
        {
            $info_val = json_decode($info->value, true);
            if(key_exists('enableroundup', $info_val))
                    $enableroundup =$info_val['enableroundup'];
            if(key_exists('enablerounddown', $info_val))
                    $enablerounddown =$info_val['enablerounddown'];
            if(key_exists('enableround', $info_val))
                    $enableround =$info_val['enableround'];
        }

        if(isset($this->amount_total) && !empty($this->amount_total))
        {
            $temp = $this->amount_total - floor($this->amount_total); 
            if(isset($enableroundup) && $enableroundup == '1')
            {       
                if($temp <= 0.5)
                        $this->amount_total = floor($this->amount_total) + 0.5;
                else 
                    $this->amount_total = round($this->amount_total);
            }
            elseif (isset($enablerounddown) && $enablerounddown == '1') 
            {  
                if($temp >= 0.5)
                        $this->amount_total = floor($this->amount_total) + 0.5;
                else 
                    $this->amount_total = round($this->amount_total);
            }
            elseif (isset($enableround) && $enableround == '1') 
            {                  
                $this->amount_total = round($this->amount_total);
            }
        }
//        echo  $this->amount_total;
//        die();
        /**************************************end********************************/
       $this->confirm =1;
       $this->created_at = \Date::time()->format('mysql');
       $info = Controller_Systems::deliverysequenceaddone();
       
       if(key_exists('distrodsequence', $info))
            $this->name = $info['distrodsequence'];
       $this->save();
       
       
   }
 static function query($options = array()){
        $query = parent::clearQuery($options);
        $query = $query->where_open();
        $query = $query->or_where("deleted" ,"0");
        $query = $query->or_where("deleted","is",null);
        $query = $query->where_close();
        
         $auth = \Auth::get_user_id();
         $auth = $auth[1];
         $user_now = \Model_User::query()->where("id",$auth)->get_one();
            
         if(is_object($user_now) && !is_null($user_now->clearance) &&$user_now->clearance < 4){
             
            $queryagent = \Model_Agents::query();
            $queryagent->where('connect_uid','=',$auth);
            $agent = $queryagent->get_one();
            if(is_object($agent))
                 $query = $query->where("agent_id","=",$agent->id); 
         }
         
        return $query;
    }
}