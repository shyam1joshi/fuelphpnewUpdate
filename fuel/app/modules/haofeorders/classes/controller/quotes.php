<?php

namespace haofeorders;


class Controller_Quotes extends \Controller_Quotes{
    public $model = "\haofeorders\Model_Quotes";
    
    public function action_index() {
            
            
        $name = \Input::get('name',null);
        $fromdate = \Input::get('fromdate',null);
        $todate = \Input::get('todate',null);
        
         if($fromdate != null)
            $fromdate = date ("Y-m-d",strtotime(date($fromdate)));
        
        if($todate != null)
            $todate = date ("Y-m-d",strtotime(date($todate))+3600*24);
       // print_r($todate);
       
        if($fromdate !=null && $fromdate===$todate)
               $todate = date ("Y-m-d",strtotime(date($fromdate))+3600*24);
     
        
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
                    else $per_page = 20; //$per_page = 5;
           
            
            
            if($fromdate!=null){
                $query->where("created_at",">",date ("Y-m-d H:i:s", strtotime(date($fromdate))));
                $uri .="&fromdate=$fromdate";
            }
            
            if($todate !=null){
                $query->where("created_at","<",date ("Y-m-d H:i:s", strtotime(date($todate))));
               $uri .="&todate=$todate";
            }
             $config = array(
               'pagination_url' => "$uri",
               'per_page'       => $per_page,
               'uri_segment'    => 'page',
            );
             
            $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
            
            if(is_object($info))
            {
                $info_val = json_decode($info->value, true);
                if(key_exists('enableviewquotecomments', $info_val))
                    $data['enableviewquotecomments'] = $info_val["enableviewquotecomments"];
                else 
                    \Log::warning('enableviewquotecomments does not exist in enablemodule');
               
                if(key_exists('enablesyncbackquote', $info_val))
                    $data['enablesyncbackquote'] = $info_val["enablesyncbackquote"];
                else 
                    \Log::warning('enablesyncbackquote does not exist in enablemodule');
            }
            if(isset($name) && !empty($name))
                $query->where('name','like',"%$name%");
             
            
            

        $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
        
        if(is_object($agentw) && isset($agentw->warehouseuser) && $agentw->warehouseuser <1){
            
            $warehouse = 0;
        }
              
              
        if($warehouse == 1){ 
            
            $query->where('confirm',1);
             $data['warehouseUser'] = $agentw->warehouseuser;
        }else{
            if(is_object($agentw) && $agentw->allowupdate == 1){

            }else{
                  $query->where('agent_id',$agentw->id);
            }
        }

//          $query->order_by('update_order_time','desc');
//          $query->order_by('confirm','asc');
          $query->order_by('created_at','desc');
        // Create a pagination instance named 'mypagination'
        $pagination = \Pagination::forge('mypagination', $config);

        $data['paginate'] = $pagination;
        $pagination->total_items = $query->count() ;
        $data['cars']= $query->rows_limit($pagination->per_page)->rows_offset($pagination->offset);
        $data['page'] = 'mypagination';
        $data['filter'] = $filter;
        $data['cars'] = $query->get();

        $data['agent'] = $agentw;
        $data['warehouse'] = $warehouse; 

        $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
        $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
        $data['base'] = $this->base;
        $this->template->base = $this->base;
           
        $this->template->page = 'index';
        $this->template->updated_at = $this->getmaxValue();

           
            $this->template->content = \View::forge('quotes/index', $data);

    }
              
    public function action_edit($id = null) {
            
        $redirect = $this->base;
        is_null($id) and \Response::redirect($redirect);
        $model = $this->model;
        if ( ! $object = $model::find($id))  {
                \Session::set_flash('error', 'Could not find car #'.$id);
                \Response::redirect('quotes');
        }

       
        $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
        
        if(is_object($agentw) && isset($agentw->warehouseuser) && $agentw->warehouseuser <1){
            
            $warehouse = 0;
        }
        
        
        if($object->confirm == 1 &&   $object->sendtocodebina == 1 && $warehouse == 0) //sendtocodebina or hash
           \Response::redirect("quotes/view/$id");
        else{
            
        if($object->confirm == 1 &&   $object->sendtocodebinawarehouse == 1 && $warehouse == 1) //sendtocodebina or hash
           \Response::redirect("quotes/view/$id");
        }
        
        $name = $object->name;
        $create_uid = $object->create_uid;
        $created_at = $object->created_at;
        $confirm = $object->confirm;

        $form = \Fuel\Core\Fieldset::forge('Autofield', array(
                       'form_attributes' => array(
                           'id' => 'edit_article_form',
                           'name' => 'edit_article',
                           'enctype'=>"multipart/form-data"
                           )));
        $object2 = new $model();
        $form->add_model($object2);

        $object->GenerateAutoFields($form);
        $form->add(\Fieldset::forge('tabular')->set_tabular_form('Model_Quotelines', 'quotelines', $object)->set_fieldset_tag(false));
        $form->populate($object);
        $fields = $form->field();

        foreach($fields as $field){
            if(property_exists($field, 'type')  && 'select' === $field->type)
            { 
                $rel = $model::ReturnRelation($field->name);

                if(empty($rel) or !$rel or !isset($rel) or !is_string($rel))
                    continue;

                if(is_object($object->$rel)){
                $arr = array( $object->$rel->id => 
                                    $object->$rel->name);
                $field->set_options($arr);
                }
            }
        }
 
        $form->add('submit', '',array( 'type' => 'submit', 'value' => \Lang::get('message.save')?\Lang::get('message.save'):'שמור' ,'class'=>'btn btn-primary'));

        if (\Input::method() == 'POST') {
            
//            if($warehouse == 1)                $this->createDeliverySlip($object);
//
//            else{
                $data = \Input::post("orderlines_new","0");
  if(isset($object->quotelines) && count($object->quotelines) > 0 ){
                                    unset($object->quotelines);
                                }
                if(is_array($data))
                    $object->editquotelines($data);

                $val =  $form->validation();


                 if ($val->run()){

                    $object->set($val->input());

                     $object->total_quantities =0;

                    if(is_array($data))
                        foreach ($data as $line)
                        {
                           if(key_exists('quantity', $line))
                                $object->total_quantities += $line['quantity'];
                        }

                    $object->name = $name;
                    $object->create_uid = $create_uid;
                    $object->created_at = $created_at;
                    $object->confirm = $confirm;

                     $warehouseuser  = 0;

                     $agent = $this->getAgent();


                     if(is_object($agent)){
                         \Module::load('yogurtsloadingdata');
                       $agentw =  \yogurtsloadingdata\Model_Agents::find($agent->id);

                       if(is_object($agentw)){ 
                             $warehouseuser  = $agentw->warehouseuser;
                       } 
                     }

                     
                       $object->update_order_time = date("Y-m-d H:i:s");
                                    
                                    
                                    $object->calculate_total();


                                    $object = $this->createNewCopy($id);
                                    $id = $object->id;
                                    
                                    
                                    $object->sendtocodebina = 1; 
                     $object->warehouseview = 0;

                     if($object->mobile == 1 && $warehouseuser == 1)
                        $save = $object->save_data();
                     else 
                        $save = $object->save();


                        if ($save) {
                            
                                    $this->createDeliverySlip($object->id);
                                    
//                                    
                if(method_exists($this, 'sendQuoteMail'))
                {
                    $res = $this->sendQuoteMail($object->id, $object->customer_id);
                }
                else 
                     \Log::warning("sendQuoteMail method does not exists");
                 
//                            if($object->confirm == 1 ){
//                                 $object->update_order_time = date("Y-m-d H:i:s");
//
//                                 if( $warehouseuser == 1){                                        
//                                     $object->save_data();
//                                 }else{                                         
//                                     $object->save();
//                                }
//                            }

//                               if($warehouse == 1)                $this->createDeliverySlip($object);


                               \Session::set_flash('success', \Lang::get("edit complete for this").$object->id.'.');

//                                \Response::redirect($redirect);
                               
                               \Response::redirect("/haofeorders/quotes/showDocumentToPdf/{$object->id}");
                                       
                        }

                        else{
                                \Session::set_flash('error', \Lang::get("message.failed.caradd"));
                        }
                }
                else
                {
                        \Session::set_flash('error', $val->error());
                }
//            }
        } else {
            $form->populate($object);}

        $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();

           if(is_object($info))
           {
               $info_val = json_decode($info->value, true);
               if(key_exists('enablewebcategories', $info_val))
                   $data['enablecategories'] = $info_val["enablewebcategories"];
               else 
                   \Log::warning('enablewebcategories does not exist in enablemodule');
             if(key_exists('enableviewquotecomments', $info_val))
                   $data['enableviewquotecomments'] = $info_val["enableviewquotecomments"];
               else 
                   \Log::warning('enableviewquotecomments does not exist in enablemodule');
                if(key_exists('enablequotelinecomment', $info_val))
                   $data['enablequotelinecomment'] = $info_val["enablequotelinecomment"];
               else 
                   \Log::warning('enablequotelinecomment does not exist in enablemodule');
           }
                    $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;

            $data['name']=  $form->build();
            $data['order'] =$object;
            $data['agent'] = $agentw;
             $data['sortcodes'] = \Model_Categories::query()->get();
            $data['warehouse'] = $warehouse; 
           
            $data["distroinfo"] = \Controller_Systems::distroinfo();
            $this->template->object = $object;
                    
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = $this->base;
            $data['base'] = $this->base;  
            $this->template->content = \View::forge('quotes/edit', $data,false);
    }
            
    public function action_setcodebinaflag($id = null) {
         $redirect = $this->base;
           is_null($id) and \Response::redirect($redirect);
             $model = $this->model;
            $object = $model::find($id);
            
            if (is_object($object))
           {
                $object->sendtocodebina = 1;
                $object->save_data();
                
                    \Log::warning("quote sendtocodebina set to 1  id: ".$id);
           }else{
                  \Session::set_flash('error', 'Could not find car #'.$id);
           }
           
              \Response::redirect('quotes');
    }
    
    
      
           public function action_view($id = null)
	{
                    $model= $this->model;
                    
		is_null($id) and \Response::redirect($this->base);

		if ( !$data['order'] = $model::find($id))
		{
			\Session::set_flash('error', 'Could not find car #'.$id);
			\Response::redirect($this->base);
		}

                 $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
            
                if(is_object($info))
                {
                    $info_val = json_decode($info->value, true);
                    if(key_exists('enablewebcategories', $info_val))
                        $data['enablecategories'] = $info_val["enablewebcategories"];
                    else 
                        \Log::warning('enablewebcategories does not exist in enablemodule');
                    if(key_exists('enablequotelinecomment', $info_val))
                        $data['enablequotelinecomment'] = $info_val["enablequotelinecomment"];
                    else 
                        \Log::warning('enablequotelinecomment does not exist in enablemodule');
                    if(key_exists('enableviewquotecomments', $info_val))
                        $data['enableviewquotecomments'] = $info_val["enableviewquotecomments"];
                    else 
                        \Log::warning('enableviewquotecomments does not exist in enablemodule');
//                    if(key_exists('enablequotelinediscount', $info_val))
//                        $data['enablequotelinediscount'] = $info_val["enablequotelinediscount"];
//                    else 
//                        \Log::warning('enablequotelinediscount does not exist in enablemodule');
                
                }
                
               $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
         
        if(is_object($agentw) && isset($agentw->warehouseuser) && $agentw->warehouseuser <1){
            
            $warehouse = 0;
        }
        
                
        $data['agent'] = $agentw;
        $data['warehouse'] = $warehouse; 
                
                $data['order']->save_data();
                
                $agent = $this->getAgent();
            
                if(is_object($agent)){
                    \Module::load('yogurtsloadingdata');
                  $agentw =  \yogurtsloadingdata\Model_Agents::find($agent->id);

                  if(is_object($agentw) && $agentw->warehouseuser == 1){ 
                       $data['warehouseUser'] = $agentw->warehouseuser;
                       
                       $data['order']->warehouseview = 1;
                  }else{
                      if(is_object($agentw) && $agentw->allowupdate == 1){

                      }else{
//                            $query->where('agent_id',$agentw->id);
                      }
                  }

                   $data['agent'] = $agentw;
                }
//                echo   $data['  $data['warehouseUser']']; die();
                
		 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
                 $data['model'] = $this->base;
                 $data['base'] = $this->base;    
	   	 $this->template->content = \View::forge('quotes/view', $data);

	}
        
        
        public function action_checkDB() {
              
            echo $this->getmaxValue();
            
            die();
        }
        
        
        public function getmaxValue() {
             
            $query = "Select max(updated_at) from quotes where ( deleted = 0 or  deleted is null )";
            
            $res = \DB::query($query)->execute();
            $res2 = $res->as_array();
            return $res2[0]['max(updated_at)']; 
        }
    
     public function action_exportDocumentToPdf($id = null) {
                    
            $model= $this->model;
                    
            is_null($id) and \Response::redirect($this->base);

            if ( ! $data['order'] = $model::find($id))
            {
                    \Session::set_flash('error', 'Could not find car #'.$id);
                    \Response::redirect($this->base);
            }

             $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();

            if(is_object($info))
            {
                $info_val = json_decode($info->value, true);
                if(key_exists('enablewebcategories', $info_val))
                    $data['enablecategories'] = $info_val["enablewebcategories"];
                else 
                    \Log::warning('enablewebcategories does not exist in enablemodule');
                if(key_exists('enablecreditcards', $info_val))
                       $data['enablecreditcards'] = $info_val["enablecreditcards"];
                else 
                       \Log::warning('enablecreditcards does not exist in enablemodule');
                if(key_exists('enableviewreceiptinvoicecomments', $info_val))
                    $data['enableviewreceiptinvoicecomments'] = $info_val["enableviewreceiptinvoicecomments"];
                else 
                    \Log::warning('enableviewreceiptinvoicecomments does not exist in enablemodule');

                if(key_exists('enablequotelinecomment', $info_val))
                    $data['enablequotelinecomment'] = $info_val["enablequotelinecomment"];
                else 
                    \Log::warning('enablereceiptorderlinecomment does not exist in enablemodule');
            }
                   
            $data['order']->document_type= 9;
            $data['order']->orderlines= $data['order']->quotelines; 
            \Package::load('attachment'); 
            
            $datetime = date('YmdHis');
            $filename = 'quote'.$datetime;
            
            $infox['filename'] = $filename; 
            $infox['footerImageHeight'] = '140px';
            $infox['headerImageHeight'] = '33px';
            $infox['headerImageWidth'] = '250px';
            $infox['footerY'] = '-33';
            $infox['headerY'] = '+4';
            
//            $infox['footerpath'] = '/assets/img/haofe/footer.png';
//            $infox['headerpath'] = '/assets/img/haofe/logo.jpg';
            $infox['headerpath'] = '/assets/img/haofe/logo.png';
            
            $infox['view'] = 'quotes/pdf';
            $infox['option'] = 'D';
//            $infox['footerImageHeight'] = '120px';
//            $infox['footerY'] = '-28';
            
            $infox['footerpath'] = '/assets/img/haofe/footer.png';
            
            
             $agent = $this->getAgent();
            
            if(is_object($agent)){
                \Module::load('yogurtsloadingdata');
              $agentw =  \yogurtsloadingdata\Model_Agents::find($agent->id);
              
              if(is_object($agentw) && $agentw->warehouseuser == 1){ 
                    $data['order']->warehouseprint =1;
                    $data['order']->save_data();
              } 
            }
             
            if(isset($data['order']->mobile) && $data['order']->mobile == 1){
                $data['order']->copytype = "העתק ";
            }else{
                if(isset($data['order']->confirm) && $data['order']->confirm == 1 && isset($data['order']->printcopyweb) && $data['order']->printcopyweb == 1 ){
                    $data['order']->copytype = "העתק "; 
                    $this->setprintcopy($id);
                }else{
                    $data['order']->copytype = " מקור";
                }
                
            }
            
            
            $infox['headerData'] = '<div style="width:100%;margin-top:-120px; text-align:center;"><img src="/assets/img/haofe/haofe_subheader_quote.png" '
                    . ' height="43" width="640" ></div>';   
            
            \Attachment::indexWithFooterHeader($data,$infox, true, true);
            
            die();
        }
      
    
     public function action_showDocumentToPdf($id = null) {
                    
            $model= $this->model;
                    
            is_null($id) and \Response::redirect($this->base);

            if ( ! $data['order'] = $model::find($id))
            {
                    \Session::set_flash('error', 'Could not find car #'.$id);
                    \Response::redirect($this->base);
            }

             $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();

            if(is_object($info))
            {
                $info_val = json_decode($info->value, true);
                if(key_exists('enablewebcategories', $info_val))
                    $data['enablecategories'] = $info_val["enablewebcategories"];
                else 
                    \Log::warning('enablewebcategories does not exist in enablemodule');
                if(key_exists('enablecreditcards', $info_val))
                       $data['enablecreditcards'] = $info_val["enablecreditcards"];
                else 
                       \Log::warning('enablecreditcards does not exist in enablemodule');
                if(key_exists('enableviewreceiptinvoicecomments', $info_val))
                    $data['enableviewreceiptinvoicecomments'] = $info_val["enableviewreceiptinvoicecomments"];
                else 
                    \Log::warning('enableviewreceiptinvoicecomments does not exist in enablemodule');

                if(key_exists('enablequotelinecomment', $info_val))
                    $data['enablequotelinecomment'] = $info_val["enablequotelinecomment"];
                else 
                    \Log::warning('enablereceiptorderlinecomment does not exist in enablemodule');
            }
                   
            $data['order']->document_type= 9;
            $data['order']->orderlines= $data['order']->quotelines; 
            \Package::load('attachment'); 
            $datetime = date('YmdHis');
            $filename = 'quote'.$datetime;
            
            $infox['filename'] = $filename; 
//            $infox['filename'] = 'quote'; 
//            $infox['view'] = 'deliverys/pdf';
//            $infox['option'] = 'S';
            $infox['footerImageHeight'] = '140px';
            $infox['headerImageHeight'] = '33px';
            $infox['headerImageWidth'] = '250px';
            $infox['footerY'] = '-33';
            $infox['headerY'] = '+4';
            
            $infox['footerpath'] = '/assets/img/haofe/footer.png';
//            $infox['headerpath'] = '/assets/img/haofe/logo.jpg';
            $infox['headerpath'] = '/assets/img/haofe/logo.png';
            
            $infox['view'] = 'quotes/pdf';
            $infox['option'] = 'I';
//            $infox['footerImageHeight'] = '120px';
//            $infox['footerY'] = '-28';
            
//            $infox['footerpath'] = '/assets/img/haofe/footer.png';
            
             $agent = $this->getAgent();
            
            if(is_object($agent)){
                \Module::load('yogurtsloadingdata');
              $agentw =  \yogurtsloadingdata\Model_Agents::find($agent->id);
              
              if(is_object($agentw) && $agentw->warehouseuser == 1){ 
                    $data['order']->warehouseprint =1;
                    $data['order']->save_data();
              } 
            }
             
            if(isset($data['order']->mobile) && $data['order']->mobile == 1){
                $data['order']->copytype = "העתק ";
            }else{
                if(isset($data['order']->confirm) && $data['order']->confirm == 1 && isset($data['order']->printcopyweb) && $data['order']->printcopyweb == 1 ){
                    $data['order']->copytype = "העתק "; 
                    $this->setprintcopy($id);
                }else{
                    $data['order']->copytype = " מקור";
                }
                
            }
            
            
            
            $infox['headerData'] = '<div style="width:100%;margin-top:-120px; text-align:center;"><img src="/assets/img/haofe/haofe_subheader_quote.png" '
                    . ' height="43" width="640" ></div>'; 
            \Attachment::indexWithFooterHeader($data,$infox, true, true);
            
            die();
        }
      
        
         /**
         * 
         * @param type $id
         */
        public function setprintcopy($id = null)	{
            $model= $this->model;

            $order = $model::find($id);
    
            if (is_object($order)) 
            {
                if(isset($order->printcopyweb))
                {
                    if($order->printcopyweb == 1)
                        return true;
                    else 
                    {
                        try{
                            $order->printcopyweb = 1;
                            $order->save_data();
                            return true;
                        }catch(\Exception $ex){
                            \Log::warning('Exception occured '.$ex->getMessage().' at line '.$ex->getLine());
                        }
                    }
                }

            }
	}
        
        
             public function post_setjsonprintcopy($id = null)
	{
              $data = \Input::post('printcopyweb','0');
              $model = $this->model;

                $status = json_decode($data,true);
             
                if(isset($status))
                {
                    $order = $model::find($id);

                    if (is_object($order)) 
                    {
                        if(isset($order->warehouseprint))
                        {
                            if($order->warehouseprint == 1)
                            {
                                $order->warehouseprint = 1;
                                $order->save_data();
                                echo 'updated :'.$id;
                                die();
                            }else{
                                $order->userprint = 1;
                                $order->save_data();
                                echo 'updated :'.$id;
                                die();
                            }
                        }
                        
                    }
                }
	}
  
        
            
        public function action_create() {
                $redirect = $this->base;
            
           $model = $this->model;
           $modellines = "Model_Quotelines";
            $query = $this->query;
         $quoteliness = null;
         
         
         
        $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"";
           
        if(is_object($agentw) && isset($agentw->warehouseuser) && $agentw->warehouseuser <1){
            
            $warehouse = 0;
        }
        
                $form = \Fuel\Core\Fieldset::forge('Autofield', array(
    'form_attributes' => array(
        'id' => 'edit_article_form',
        'name' => 'edit_article',
        'enctype'=>"multipart/form-data"
        )));
                
                $form1 = \Fuel\Core\Fieldset::forge('AutoSubfield', array(
                    'form_attributes' => array(
                        'id' => 'edit_article_form',
                        'name' => 'edit_article',
                        'enctype'=>"multipart/form-data"
                        )));
                $object = new $model();

                $form->add_model($object);
                $objectline = new \Model_Quotelines();
                $form1->add_model($objectline);
                $object->GenerateAutoFields($form);
                $objectline->GenerateAutoFields($form1);
                  
                 $form->add('submit', '',array( 'type' => 'submit', 'value' => 'Submit' ,'class'=>'btn btn-primary'));
		if (\Input::method() == 'POST')
		{   $full_amount = null;
                      $orderid = \Input::post('id');
                        $quoteliness = \Input::post('orderlines_new');
                        $objectlines =  array();
                        $val =  $form->validation();
			if ($val->run())
			{
                            $object = '';
                            if(!empty($orderid)){
                                $object = $model::find($orderid);
                            }
                            
                            if(is_object($object)){
                                $object->set($form->validation()->input());
                            }else{
                            
				$object = $model::forge($form->validation()->input());
                            }
                                $object->total_quantities = 0;
                                if(isset($object->suppliedstatus) && $object->suppliedstatus ='' || $object->suppliedstatus == null)
                                    $object->suppliedstatus = 0;
                                
                                if(isset($object->quotelines) && count($object->quotelines) > 0 ){
                                    unset($object->quotelines);
                                }
                        if(is_array($quoteliness) && count($quoteliness)>0)
                            foreach($quoteliness as $id => $values){
                                 $objectlinetemp = new $modellines;
                               
                                 foreach($values as $key => $value){
                                    $objectlinetemp->$key = $value;
                                }
                                
                                 if(!is_numeric($objectlinetemp->quantity)) $object->total_quantities +=0;
                                else $object->total_quantities += $objectlinetemp->quantity;
                                                                
                                if(!is_numeric($objectlinetemp->quantity)) $objectlinetemp->quantity =0;
                                  if(!is_numeric($objectlinetemp->price))   $objectlinetemp->price=0;
                                
                                  $objectlinetemp->total_amt = $objectlinetemp->quantity *  $objectlinetemp->price;
                                   $object->quotelines[] = $objectlinetemp;                 
                                   $full_amount = $full_amount + $objectlinetemp->total_amt;
                                   $object->amount_total = $full_amount;
                                   $customer_query = \Model_Customers::query();
                                   $customer_query->where('id',$object->customer_id);
                                   $customer = $customer_query->get_one();
                                   $discount = 0;
                                   if(is_object($customer) && is_numeric($customer->fixed_discount))
                                       $discount = $customer->fixed_discount;
                                   
                                   $tax = \Controller_Systems::distroinfo();
                                    $tax = $tax['distrotax'];

                                    $object->amount_totalbeforetax = $full_amount - ( $discount  * $full_amount/100);
                                   
                                    $object->amount_total =  $object->amount_totalbeforetax +( $tax * $object->amount_totalbeforetax);
       
                            }
//                             $object->confirm = 1 ;//@todo remove this line , for now create means confirm
//                            $info = Controller_Systems::quotesequenceaddone();
//                                    $object->name = $info['distroqsequence'];
                                    $object->update_order_time = date("Y-m-d H:i:s");
                                    
                                    
                                    $object->calculate_total();

                                    

                                    $object->sendtocodebina = 1; 
                
				if ($object and $object->save())
				{
                                  //  $object = $this->createNewCopy($object->id);
                                    $id = $object->id;
                                    
//                                    $this->createDeliverySlip($object->id);
                                    $this->createDeliverySlip($id);
                                    
                                    if(method_exists($this, 'sendQuoteMail'))
                {
                    $res = $this->sendQuoteMail($object->id, $object->customer_id);
                }
                else 
                     \Log::warning("sendQuoteMail method does not exists");
                                    
                                	\Session::set_flash('success', \Lang::get("message.done.caradd").$object->id.'.');

//					\Response::redirect($redirect);
					\Response::redirect("/haofeorders/quotes/showDocumentToPdf/{$object->id}");
                                        die();
				}

				else
				{
					\Session::set_flash('error', \Lang::get("message.failed.caradd"));
				}
			}
			else
			{
				\Session::set_flash('error', $val->error());
			}
		}

                 $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
            
                if(is_object($info))
                {
                    $info_val = json_decode($info->value, true);
                    if(key_exists('enablewebcategories', $info_val))
                        $data['enablecategories'] = $info_val["enablewebcategories"];
                    else 
                        \Log::warning('enablewebcategories does not exist in enablemodule');
                    if(key_exists('enableviewquotecomments', $info_val))
                        $data['enableviewquotecomments'] = $info_val["enableviewquotecomments"];
                    else 
                        \Log::warning('enableviewquotecomments does not exist in enablemodule');
                     if(key_exists('enablequotelinecomment', $info_val))
                        $data['enablequotelinecomment'] = $info_val["enablequotelinecomment"];
                    else 
                        \Log::warning('enablequotelinecomment does not exist in enablemodule');
                }
                
                
                $data['sortcodes'] = \Model_Categories::query()->get();
                
                $customer = Model_Customers::query()->where('agent_id',$agent_id)->get_one();
                
                $data['customer_id'] = is_object($customer)?$customer->id:"";
                
		 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
		
                 $data['name']=  $form->build();
                 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
                 $data['model'] = $this->base;
                 $data['base'] = $this->base;    
                 $this->template->baseobj = 'objectval';
                  
                $data['agent'] = $agentw;
                $data['warehouse'] = $warehouse; 
                 
	   	 $data["distroinfo"] = \Controller_Systems::distroinfo();
                 $this->template->content = \View::forge('quotes/create', $data,false);
                 
                 $data['title']   = "Example Page";
                 $data['content'] = "Don't show me in the template";

        // returned Response object takes precedence and will show content without template
            //    return new Response(View::forge('receipts/create', $data));
        }

//    public function createDeliverySlip($object = null) {
    public function createDeliverySlip($id = null) {
        
        $redirect = $this->base;
        $model = $this->model;
        
        $object = $model::find($id);
        
        if(is_object($object)){
            
            $delobj = \haofeorders\Model_Deliverys::query()->where('quote_id',$object->id)->get_one();
            
            if(!is_object($delobj)){
                
               $delobj = new  \haofeorders\Model_Deliverys;
                
            }
            
            $quotelines = $object->quotelines;
            $id = $object->id;

            $customer_id = $object->customer_id;
                      
            $arr = $object->to_array();
            unset($arr['quotelines']); 
            unset($arr['customer']);          
            unset($arr['name']);          
            unset($arr['id']);          
            $delobj->set($arr);

            $amount_totalbeforetax = 0;
           
            foreach ($quotelines as $line){
                $lineobj = new \haofeorders\Model_Deliverylines();
                 
                $linearr =$line->to_array();
                
                $linearr['original_quantity'] = $linearr['quantity'];
                
                unset($linearr['id']);   
                unset($linearr['quote_id']); 
                unset($linearr['product']); 
                
                $lineobj->set($linearr);
                
                $lineobj->price = $this->getProductPrice($customer_id, $lineobj->product_id);

                $lineobj->total_amt = $lineobj->quantity *$lineobj->price;
               
                $amount_totalbeforetax += $lineobj->total_amt ;

                $delobj->deliverylines[] = $lineobj;
            }
            
            $delobj->amount_totalbeforetax = $amount_totalbeforetax;

            $tax = $amount_totalbeforetax *0.17;

            $amount_total = $amount_totalbeforetax + $tax;

            $delobj->amount_total = $amount_total;

            $delobj->quote_id = $id;
            $delobj->sendtocodebina = 0;
            $delobj->senttocodebina = 0;
            $delobj->confirm = 0;
            $delobj->warehouseprint = 0;
            $delobj->userprint = 0;
            
            $delobj->save();
            
            $object->delivery_id = $delobj->id;
            $object->save();
          
        }
        
//         \Response::redirect($redirect);
        
        
    }

    public function getProductPrice($customer_id, $product_id){

        $price = '';

        $custp = $this->getCustomerpricelistPrice($customer_id, $product_id);

        if(is_object($custp)){
            $price = $custp->price;
        }else{

            $hashpricelist = $this->getHashpricelistPrice($customer_id, $product_id);
          
            if(is_object($hashpricelist))
                $price = $hashpricelist->price;
            else{
                
                $prod = \Model_Products::query()->where('id', $product_id) ->get_one();

                if(is_object($prod)){
                        $price = $prod->sale_price;
                }
            }  
        }

        return $price;
    }
   
    public function getCustomerpricelistPrice($customer_id, $product_id){
 

        $custp = \Model_Customerpricelists::query()
        ->where('customer_id', $customer_id)
        ->where('product_id',$product_id )
        ->get_one();
 
        return $custp  ;
    }

   
    public function getHashpricelistPrice($customer_id, $product_id){
 
        \Module::load('hashpricelists');

        $hashdiscounts = \hashpricelists\Model_Hashdiscount::query()->where('customer_id', $customer_id)->get_one();
            
        $pricelistnumber = '';
        $hashpricelist = '';

        if(is_object($hashdiscounts)){

            $pricelistnumber = $hashdiscounts->pricelistnumber;
        }

        if(!empty($pricelistnumber)){
             
         $hashpricelist = \hashpricelists\Model_Hashpricelist::query()
                 ->where('pricelistnumber',$pricelistnumber)
                     ->where('product_id',$product_id)->get_one();
        }

 
        return $hashpricelist  ;
    }

    public function action_convertToDelivery($id = null){
        
        $model = $this->model; 

        $object = $model::find($id);
        
        $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
        
        if(is_object($agentw) && isset($agentw->warehouseuser) && $agentw->warehouseuser <1){
            
            $warehouse = 0;
        }
        
        if($warehouse == 1)               
            $this->createDeliverySlip($object);
        
    }
    
    
    public function action_confirm($id = null){
        
        $model = $this->model;
        $base = $this->base;

        $order = $model::find($id);

        if(is_object($order)) {
            
            if($order->confirm == 1)
                \Response::redirect("quotes/view/$id");

            if (is_object($order))   {
                $order->calculate_total();

                
            $order = $this->createNewCopy($id);
            $id = $order->id;

                $order->sendtocodebina = 1;
               
                $order->save();
                
                $this->createDeliverySlip($order->id);
                
                if(method_exists($this, 'sendQuoteMail'))
                {
                    $res = $this->sendQuoteMail($order->id, $order->customer_id);
                }
                else 
                     \Log::warning("sendQuoteMail method does not exists");
                 
            } else
                die(json_encode(array("response"=>false,"error"=>"no Id provided"))); 

        }

        \Response::redirect($base);
    }     
    
    
    /**
     * 
     * @param type $id
     * @return $order
     */
    public function createNewCopy($id) {
        
        $model = $this->model;
        
        $obj = $model::query()->where('id',$id)->get_one(); 
          
        $order = new Model_Quotes();
        $orderlines = $obj->quotelines;
         
        $data =$obj->to_array();

        unset($data['id']);
        unset($data['customer']);
        unset($data['created_at']);
        unset($data['quotelines']);
        $order->set($data); 
         foreach ( $orderlines as $line){
 
            $templine  = new \Model_Quotelines();
            $line_arr = $line->to_array();
            unset($line_arr['quote_id']); 
            unset($line_arr['product']); 
            unset($line_arr['id']);
            $templine->set($line_arr);
            
            $order->quotelines[]=  $templine;
            
        }
             
        $obj->name = $obj->name."_draft_copy";
        $obj->deleted = 1;
        $obj->save();
              
        
        $order->deleted = 0; 
        $order->save(); 
       
        return $order;    
    }
    
    
    
        
     /**
     * create the invoice from the cart data
     */
    public function post_createOrder() {
             
        $cartdata = \Input::post('data');
        
        $cart = $cartdata;
        
        
        if(!isset($cart) || !is_array($cart) ) return false;    
     
        $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
        $flagarray = array('enablepriceswithtax','enableProductPriceUpdateFromCart');

        if(is_object($info)){
            $info_val = json_decode($info->value, true);
            foreach ($flagarray as $flag)                   
                if(key_exists("$flag", $info_val))
                    $$flag = $info_val["$flag"];

        }  
        
        $id = '';
        $order = '';
        
        if(key_exists('id', $cart)){
            $id = $cart['id'];
        }
        
        if(!empty($id)){
            $order =  Model_Quotes::find($id);
        }
        
        if(!is_object($order)){
            $order = new Model_Quotes();
        }else{
            
            if(isset($order->quotelines) && count($order->quotelines) > 0 ){
                unset($order->quotelines);
            }
            
        }
        
        if(is_object($order)){
               
             
            if(key_exists('comment', $cart))
                $order->comment = $cart['comment'];
             
            if(!isset($cart['customer_id']) || empty($cart['customer_id']) || $cart['customer_id'] == 0){
                return false;    
            }
            if(!isset($cart['products']) || empty($cart['products']) || $cart['products'] == 0){
                return false;    
            }
            
            if(key_exists('discount_all', $cart))
                $order->discount_all = $cart['discount_all'];
            
            if(key_exists('customer_id', $cart))
                $order->customer_id = $cart['customer_id'];
            else {
                \Log::warning('customer id was not set');
                return false;      
            }
             
            if(key_exists('products', $cart))
                $orderlines = $cart['products'];
            else{
                return false;      
            }
            
            $full_amount = 0;
            foreach ($orderlines as $ord) {
                if(key_exists('total_amt', $ord) && is_numeric($ord['total_amt'])){ 
                    $full_amount += $ord['total_amt']; 
                }
                
            } 
             
             
            
            $discount = 0;
            if(isset($order->discount_all))
                $discount = $order->discount_all;
            
            
            $total_amt = $full_amount - ( $discount  * $full_amount/100);
            
            
            $tax = \Controller_Systems::distroinfo();
            $tax = $tax['distrotax'];
            
            if($tax > 1){
                $tax = $tax/100;
            }
       
            if(isset($enablepriceswithtax) && $enablepriceswithtax == 1){
                $order->amount_total = $total_amt;
                $divisor = 1+$tax;
                $order->amount_totalbeforetax = $total_amt/$divisor;
            }else{
                 $order->amount_totalbeforetax = $total_amt;
                 $taxadd = $total_amt*$tax;
                 $order->amount_total = $order->amount_totalbeforetax + $taxadd;
            }
            
            $order->amount_totalbeforetax = number_format($order->amount_totalbeforetax,2,'.','');
            $order->amount_total = number_format($order->amount_total,2,'.','');
 
            
            $order->store_quotelines($orderlines);
             
            $order->created_at = \Date::time()->format('mysql');
          
            
            if($order->save()){
               
                echo $order->id;
            }  
            
        }
        
        die();
    }
    
    
  
  public function sendQuoteMail($id = null, $customerid = null)//action_receiptView()
  {
      if(is_null($id)){ return "empty order id";}
     
      $redirect = $this->base;
      $base = $this->base;
      $model = $this->model;
      $status = 0;
            \Package::load('attachment');
            
       $data['order'] = $model::find($id);
//      $this->template = \View::forge('quotes/quotereceipt', $data);
          
       $infostatus = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
            
        $email = array();
        if(is_object($infostatus))
        {
            $info_value = json_decode($infostatus->value, true);
            if(key_exists('enablequotecustomeremail', $info_value))
                $enablecustomeremail = $info_value["enablequotecustomeremail"];
            else 
                \Log::warning('enablequotecustomeremail does not exist in enablemodule');
            
            if(key_exists('enablequotelinecomment', $info_value))
                 $data['linecomment'] = $info_value["enablequotelinecomment"];
            else 
                \Log::warning('enablequotelinecomment does not exist in enablemodule');
             
            if(key_exists('enablequoteadminemail', $info_value))
                $enableadminemail = $info_value["enablequoteadminemail"];
            else 
                \Log::warning('enablequoteadminemail does not exist in enablemodule');
            
            if(key_exists('enablequotebcc', $info_value))
                $enablequotebcc = $info_value["enablequotebcc"];
            else 
                \Log::warning('enablequotebcc does not exist in enablemodule');
            
            if(key_exists('enablequotelinecomment', $info_value))
                $data['enablequotelinecomment'] = $info_value["enablequotelinecomment"];
              
            if(key_exists('enablequotealert', $info_value))
                $enablequotealert = $info_value["enablequotealert"];
            else 
                \Log::warning('enablequotealert does not exist in enablemodule');
            
            if(key_exists('bcc_email', $info_value))
            {
                $bcc = $info_value["bcc_email"];
                if(strpos($bcc, ','))
                {
                    $bcc= explode(',', $bcc);
                }
            }
            else 
                \Log::warning('bcc_email does not exist in enablemodule');
            
            if(key_exists('quoteemailto', $info_value))
            {
                $cc = $info_value["quoteemailto"];
                if(strpos($cc, ','))
                {
                    $email= explode(',', $cc);
                }else{
                    $email[]= $cc;
                }
            }
            else 
                \Log::warning('quoteemailto does not exist in enablemodule');
            
        }
         $from = '';
        
        if(isset($email) && is_array($email))    
            $errors = array_filter($email);
        
         
         $order_name =  $data['order']->name;
         $customer_name =  is_object($data['order']->customer)?$data['order']->customer->name:"";
         $data['order']->document_type= 9;
            $data['order']->orderlines= $data['order']->quotelines; 
            \Package::load('attachment'); 
//            $infox['filename'] = 'quote'; 
            $datetime = date('YmdHis');
            $filename = 'quote'.$datetime;
            
            $infox['filename'] = $filename; 
            $infox['footerImageHeight'] = '140px';
            $infox['headerImageHeight'] = '58px';
            $infox['headerImageWidth'] = '250px';
            $infox['footerY'] = '-33';
            $infox['headerY'] = '+4';
            
//            $infox['footerpath'] = '/assets/img/haofe/footer.png';
//            $infox['headerpath'] = '/assets/img/haofe/logo.jpg';
            $infox['headerpath'] = '/assets/img/haofe/logo.png';
            
            $infox['view'] = 'quotes/pdf';
            $infox['option'] = 'S';
//            $infox['footerImageHeight'] = '120px';
//            $infox['footerY'] = '-28';
            
            $infox['footerpath'] = '/assets/img/haofe/footer.png';
            
            
           
             
            if(isset($data['order']->mobile) && $data['order']->mobile == 1){
                $data['order']->copytype = "העתק ";
            }else{
                if(isset($data['order']->confirm) && $data['order']->confirm == 1 && isset($data['order']->printcopyweb) && $data['order']->printcopyweb == 1 ){
                    $data['order']->copytype = "העתק ";  
                }else{
                    $data['order']->copytype = " מקור";
                }
                
            }
            
           
            $infox['headerData'] = '<div style="width:100%;margin-top:-120px; text-align:center;"><img src="/assets/img/haofe/haofe_subheader_quote.png" '
                    . ' height="43" width="640" ></div>';  
         
         
         
         
             
//        $info['view'] = 'ganli/quotereceipt';
                $msg = '';
        if(isset($email) && !empty($email))
        {
            foreach ($email as $to )
            {  
               
                \Log::warning("email id : ".$to);
                $from = 'test_dummy@parikrama-tech.in';
//                $subject = 'הזמנה גן - לי';
                $subject = "הזמנה מספר  {$order_name} שם לקוח {$customer_name}";
                $body = '';
                try
                {
                    $mail = \Email::forge();

                    $mail->to($to);
                    $mail->from($from);
                    
                    if(isset($enablequotebcc) && $enablequotebcc == 1 )
                        if(isset($bcc) && !empty($bcc))
                        {
                            if(is_array($bcc))
                            {
                                foreach ($bcc as $bc)
                                    $mail->bcc($bc);
                            }
                            else
                                $mail->bcc($bcc);
                        }
                   
                    $mail->subject($subject);
                      
//                                $mail->html_body(\View::forge('quotes/quotereceipt', $data));
                     $mail->string_attach((\Attachment::indexWithFooterHeader($data,$infox, true, true)), 'quote.pdf');
                    $mail->send();
                    
                   
                    $msg="Email Sent Successfully";
                        $status = 1;
//
                }
                catch(\Exception $e)
                {
                        $msg =$e->getMessage();
                        $status = 0;
                }
                \Log::warning("Email Status :" .$msg);
                
            }
        
        }
        else
        echo " ";
        
      return ;
  }
        
        
  public function action_sendmailto($id =null) {
      $this->sendQuoteMail($id);
      die();
  }  
}