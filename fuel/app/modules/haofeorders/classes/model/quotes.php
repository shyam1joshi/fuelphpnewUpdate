<?php

namespace haofeorders;


class Model_Quotes extends \Model_Quotes
{

    
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
    'label' => 'label.quotes.name',
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
//      'listview' => true,
    'label' => 'label.quotes.customer_id',
    'data_type' => 'int',
    
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
//    'label' => 'label.quotes.agent_id',
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
        'delivery_id' => 
              array (
                'label' => 'label.deliverys.delivery_id',
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
    'quotelines' => array(
        'controller'=>'quotelines',
        'key_from' => 'id',
        'model_to' => '\\Model_Quotelines',
        'key_to' => 'quote_id',
        'cascade_save' => true,
        'cascade_delete' => true,
    )
);
  static function query($options = array()){
        $query = parent::clearQuery($options);
        $query->where_open();
        $query->or_where("deleted","0");
        $query->or_where("deleted","is",null);
        $query->where_close();
        
        
//         $auth = \Auth::get_user_id();
//         $auth = $auth[1];
//         $user_now = \Model_User::query()->where("id",$auth)->get_one();
//            
//         if(is_object($user_now) && !is_null($user_now->clearance) &&$user_now->clearance < 4){
//             
//            $queryagent = \Model_Agents::query();
//            $queryagent->where('connect_uid','=',$auth);
//            $agent = $queryagent->get_one();
//            if(is_object($agent))
//                 $query = $query->where("agent_id","=",$agent->id); 
//         }
         
        return $query;
    }
       

   function editquotelines($data){
       
       foreach($data as $key => $info){
           $flag = false;
           if(array_key_exists('delete_id',$info))
           { 
               $del = \Model_Quotelines::find($info['delete_id']);
               
               if(is_object($del)){
                    $del->web = 1;
                    $del->web_updated_at = date('Y-m-d H:i:s');
                    $del->deleted = 1;
                    $del->save();
               }
               
//                unset($this->quotelines[$info['delete_id']]);
               \Log::warning('orderline '.$info['delete_id'].' is deleted!! ');
           }else{  
           if(array_key_exists('id',$info))
           {
               
               $orderline = $this->quotelines[$info['id']];
               unset($info['id']);
              
               if(isset($orderline->quantity) && isset($orderline->original_quantity) && empty($orderline->original_quantity))
                   $orderline->original_quantity = $orderline->quantity;
               
 
               $flag = true;
           }
           else {
                $orderline = new \Model_Quotelines();
                
                $info['web_updated_at'] = date('Y-m-d H:i:s');
                $info['web'] = 1 ;
           }
           
            

           
              $orderline->set($info);
              
              if(!$flag)
                  $this->quotelines[] =$orderline ;
           }
       }
       
       
   }
    
   
   public function  save_data($cascade = null, $use_transaction = false){
      
       
    return parent::save_data($cascade, $use_transaction);
    
   }
   
   
   
   function store_quotelines($data){
        $this->total_quantities = 0;
        
        if(!is_array($data)) return ; 
       foreach($data as $key => $info){
           $flag = false;
           if(array_key_exists('id',$info))
           {
              $orderline = \Model_Quotelines::find($info['id']);
               unset($info['id']);
              // $this->quotelines[] = $info;
               $flag = true;
           }
           else 
                $orderline = new \Model_Quotelines();
           
                if(key_exists('comment', $info)){
                    $comObj = new \Model_Comments();

                    $comObj->related_to = $info['product_id'];
                    $comObj->related_to_model = 'products';
                    $comObj->related_from = '';
                    $comObj->comment = $info['comment'];
                    $comObj->related_from_model = 'quotelines';
                    $comObj->visiblity = 0;
                    $comObj->date = date('Y-m-d H:i:s');
                    $comObj->save();
                    
                    //*************@todo : assign quoteline id*********/
               }
               
               
           
              $orderline->set($info);
              
                if($orderline->quantity == 0){
                         $orderline->quantity = $orderline->quanboxes;
                    }
              
             // if(!$flag)
                  $this->quotelines[] =$orderline ;
              
               $this->total_quantities += $info['quantity']; 
               
               
              if(key_exists('quanboxes', $info) && key_exists('units_of_measure', $info))
                    $this->total_quantities += $info['quanboxes']*$info['units_of_measure']; 
              
             
       }
        \Log::warning('orders total quantities : '.$this->total_quantities);
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
   
}
