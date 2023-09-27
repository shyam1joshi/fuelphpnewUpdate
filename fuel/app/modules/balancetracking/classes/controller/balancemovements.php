<?php 

namespace balancetracking;

class Controller_Balancemovements extends \Controller_Base{
    public $model = 'balancetracking\Model_Balancemovements';
    public $base = 'balancemovements';
    
    /**
     * 
     * @param type $oldcus
     * @param type $customer
     * @return boolean
     */
    public static function addBalance($oldcus,$customer, $doc_type='customer'){
        
        $model = 'balancetracking\Model_Balancemovements';
        
        $object = new $model;
        
        if(!empty($oldcus)){
            $object->balance_before = $oldcus['balance'];
            $object->transaction_type = 'update';
            $object->balance_difference = $customer->balance-$oldcus['balance'];
        }else{
            $object->balance_before = 0;
            $object->transaction_type = 'create';
            $object->balance_difference = $customer->balance;
        }
        
        $object->document_type = $doc_type;
        
        \Log::warning('new customer id : '.$customer->id);
          
        if(isset($customer->ordername))
            $object->ordername = $customer->ordername;

            
        if(isset($customer->created_at))
        $object->created_at = $customer->created_at;

        
        if(isset($customer->update_uid))
            $object->update_uid = $customer->update_uid;

            
        if(isset($customer->create_uid))
        $object->create_uid = $customer->create_uid;

        
        if(isset($customer->agent_id))
            $object->agent_id = $customer->agent_id;
        
        $object->customer_id = $customer->id;
        $object->current_balance = $customer->balance;
        $agent= static::getAgent();
        if(is_object($agent))
        $object->agent_id = $agent->id;
        $object->save(); 
        return true;
    }
    
    
    /**
     * 
     * @return type
     */
    public static function getAgent() {
          
        $auth = \Auth::get_user_id();
        $auth = $auth[1];
        $queryagent = \Model_Agents::query();
        $queryagent->where('connect_uid','=',$auth);
        $agentob = $queryagent->get_one();
        
        return $agentob;
    }
    
    /**
     * reset the customer balance before delete
     * 
     * @param int $id
     */
    public function action_deleteWithReset($id) {
      
        $redirect = $this->base;
        $model = $this->model;
        is_null($id) and \Response::redirect($redirect);
        
        if ($object =  $model::find($id))
        {
            if(isset($object->customer)){
                $object->customer->balance = $object->customer->balance -  $object->balance_difference;
                $object->customer->save();
                               
                
                \Response::redirect('/balancemovements/?filter[customer_id]='.$object->customer->id);
            }
          

            \Session::set_flash('success', 'Deleted order #'.$id);
        }
        else
        {
            \Session::set_flash('error', 'Could not delete order #'.$id);
        }

        \Response::redirect($redirect);
    }

    
    
    public function action_index()
    {
            $query = $this->query;
            $data['mode_select'] = $query->get_one();
            $filter = \Input::get('filter');
            $uri = "/{$this->base}/index/?";
            if(is_array($filter))
                foreach($filter as $where => $value)
                    if($value != 0 && !empty($value))
                    {
                        $query->where($where, $value);
                        $uri .="&filter[$where]=$value";
                    }   
            $per_page = \Input::get('per_page');
                    if(!empty($per_page) && intval($per_page)  != 0 )
                    {
                        $per_page = intval($per_page);
                    }
                    else $per_page = 20;
            $config = array(
               'pagination_url' => "$uri",
               'per_page'       => $per_page,
               'uri_segment'    => 'page',
            );
            
            
            // Create a pagination instance named 'mypagination'
            $pagination = \Pagination::forge('mypagination', $config);
            $data['paginate'] = $pagination;
            $pagination->total_items = $query->count() ;
            $data['cars']= $query->rows_limit($pagination->per_page)->rows_offset($pagination->offset);
            $data['page'] = 'mypagination';
            $data['filter'] = $filter;
            $data['cars'] = $query->get();
            
    
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['base'] = $this->base;
            $this->template->content = \View::forge('balancemovements/index', $data);

    }
    
    
    public function action_image64() {
      
        $redirect = $this->base;
        $model = $this->model;
        
        $x= "data:image/png;base64,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";
        $v = 'data:image/png;base64,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';

        echo "<img src='".$v."'/>";
        die();
    }
        
}
