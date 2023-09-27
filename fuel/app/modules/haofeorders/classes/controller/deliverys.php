<?php

namespace haofeorders;

class Controller_Deliverys extends \Controller_Deliverys{
    public $model = "\haofeorders\Model_Deliverys";
    public $base = "deliverys";
    
    
        
    public function action_index() {
        
        $auth = \Auth::get_user_id();
                $auth = $auth[1];
                $queryagent = \Model_User::query();
                $queryagent->where('id','=',$auth);
                
                $user = $queryagent->get_one();
                if(is_object($user) && $user->group <=1){
                    \Response::redirect('quotes/create');
                }
        
        
        
            
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
      
        $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
        
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
                if(key_exists('enableviewdeliverycomments', $info_val))
                    $data['enableviewdeliverycomments'] = $info_val["enableviewdeliverycomments"]; //enableviewdeliverycomments
                else 
                    \Log::warning('enableviewdeliverycomments does not exist in enablemodule');
                
                if(key_exists('enablesyncbackdelivery', $info_val))
                    $data['enablesyncbackdelivery'] = $info_val["enablesyncbackdelivery"];
                else 
                    \Log::warning('enablesyncbackdelivery does not exist in enablemodule');
                
                 if(key_exists('enablefilterprint', $info_val))
                    $enablefilterprint = $info_val["enablefilterprint"];
                else 
                    \Log::warning('enablefilterprint does not exist in enablemodule');
                
            }
             if(isset($name) && !empty($name))
                $query->where('name','like',"%$name%");
             
            $query->order_by('confirm','asc');
            $query->order_by('created_at','desc');
            
           
                  $agent_flag = 0;
             if($warehouse == 1){ 
            
            
        }else{
            if(is_object($agentw) && $agentw->allowupdate == 1){

            }else{
                  $query->where('agent_id',$agentw->id);
                  
                  $agent_flag = 1;
            }
        }
            
            // Create a pagination instance named 'mypagination'
            {
                $pagination = \Pagination::forge('mypagination', $config);
                $data['paginate'] = $pagination;
                $pagination->total_items = $query->count() ;
                $data['cars']= $query->rows_limit($pagination->per_page)->rows_offset($pagination->offset);
                $data['page'] = 'mypagination';
            }
          
            $data['filter'] = $filter;
            
            if($agent_flag == 1)
            $data['cars'] = array();
            else
            $data['cars'] = $query->get();
            
            
        $data['agent'] = $agentw;
        $data['warehouse'] = $warehouse; 
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['base'] = $this->base;
            $this->template->base = $this->base;
           
            $this->template->content = \View::forge('deliverys/index', $data);

	}
        
        
        
           public function action_view($id = null)
	{
                    $model= $this->model;
                    
		is_null($id) and \Response::redirect($this->base);

		if ( ! $data['order'] = $model::find($id))
		{
			\Session::set_flash('error', 'Could not find car #'.$id);
			\Response::redirect($this->base);
		}
                
                 $agent = $this->getAgent();
        
                $agent_id = is_object($agent)?$agent->id:"";

                \Module::load('yogurtsloadingdata');
                $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

                $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
                
                 $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
            
                if(is_object($info))
                {
                    $info_val = json_decode($info->value, true);
                    if(key_exists('enablewebcategories', $info_val))
                        $data['enablecategories'] = $info_val["enablewebcategories"];
                    else 
                        \Log::warning('enablewebcategories does not exist in enablemodule');
                    if(key_exists('enableviewdeliverycomments', $info_val))
                        $data['enableviewdeliverycomments'] = $info_val["enableviewdeliverycomments"];
                    else 
                        \Log::warning('enableviewdeliverycomments does not exist in enablemodule');
                    if(key_exists('enabledeliverylinecomment', $info_val))
                        $data['enabledeliverylinecomment'] = $info_val["enabledeliverylinecomment"];
                    else 
                        \Log::warning('enabledeliverylinecomment does not exist in enablemodule');
                }

        $data['agent'] = $agentw;
        $data['warehouse'] = $warehouse; 
		 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
                 $data['model'] = $this->base;
                 $data['base'] = $this->base;    
	   	 $this->template->content = \View::forge('deliverys/view', $data);

	}
        
        public function action_create() {
                $redirect = $this->base;
            
           $model = $this->model;
           $modellines = "Model_Deliverylines";
            $query = $this->query;
         $orderlines = null;
            $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
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
                $objectline = new \Model_Deliverylines();
                $form1->add_model($objectline);
                $object->GenerateAutoFields($form);
                $objectline->GenerateAutoFields($form1);
                  
                 $form->add('submit', '',array( 'type' => 'submit', 'value' => 'Submit' ,'class'=>'btn btn-primary'));
		if (\Input::method() == 'POST')
		{   $full_amount = null;
                    
                        $orderlines = \Input::post('orderlines_new');
                        $objectlines =  array();
                        $val =  $form->validation();
			if ($val->run())
			{
				$object = $model::forge($form->validation()->input());
                                
                                $object->total_quantities =0; 
                                                             
                                
                        if(is_array($orderlines) && count($orderlines)>0)
                            foreach($orderlines as $id => $values){
                                 $objectlinetemp = new $modellines;
                               
                                 foreach($values as $key => $value){
                                    $objectlinetemp->$key = $value;
                                }
                                if(!is_numeric($objectlinetemp->quantity)) $object->total_quantities +=0;
                                else $object->total_quantities += $objectlinetemp->quantity;
                                
                                if(!is_numeric($objectlinetemp->quantity)) $objectlinetemp->quantity =0;
                                  if(!is_numeric($objectlinetemp->price))   $objectlinetemp->price=0;
                                
                                  $objectlinetemp->total_amt = $objectlinetemp->quantity *  $objectlinetemp->price;
                                   $object->deliverylines[] = $objectlinetemp;                 
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
                            
                            
                            $agent_update_id = '';
                            
                            $agentObj = $this->getAgent();
                            
                            if(is_object($agentObj))
                                $agent_update_id = $agentObj->id;
                            
                            $object->agent_update_id = $agent_update_id;
                            
				if ($object and $object->save())
				{
                                    
                                    
                                    
                                	\Session::set_flash('success', \Lang::get("message.done.caradd").$object->id.'.');

					\Response::redirect($redirect);
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
                    if(key_exists('enableviewdeliverycomments', $info_val))
                        $data['enableviewdeliverycomments'] = $info_val["enableviewdeliverycomments"]; //enableviewdeliverycomments
                    else 
                        \Log::warning('enableviewdeliverycomments does not exist in enablemodule');
                    if(key_exists('enabledeliverylinecomment', $info_val))
                        $data['enabledeliverylinecomment'] = $info_val["enabledeliverylinecomment"];
                    else 
                        \Log::warning('enabledeliverylinecomment does not exist in enablemodule');
                }

		 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
		
                 $data['name']=  $form->build();
                 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
                 $data['model'] = $this->base;
                 $data['base'] = $this->base;    
                  $this->template->baseobj = 'objectval';
                  
                  
                $auth = \Auth::get_user_id();
                $auth = $auth[1];
                $queryagent = \Model_Agents::query();
                $queryagent->where('connect_uid','=',$auth);
                $agent = $queryagent->get_one();
                if(is_object($agent))
                    $data['enablepriceedit'] =$agent->enabledeliverypriceedit;

        $data['agent'] = $agentw;
        $data['warehouse'] = $warehouse; 
	   	 $data["distroinfo"] = Controller_Systems::distroinfo();
                 $this->template->content = \View::forge('deliverys/create', $data,false);
                 
        }
        
        
         public function action_edit($id = null)
	{ 
             
          
            $redirect = $this->base;
		is_null($id) and \Response::redirect($redirect);
                  $model = $this->model;
        
            $agent = $this->getAgent();
        
        $agent_id = is_object($agent)?$agent->id:"";
        
        \Module::load('yogurtsloadingdata');
        $agentw =  \yogurtsloadingdata\Model_Agents::find($agent_id);

        $warehouse  = is_object($agentw)?$agentw->warehouseuser:"0";
                 $form = \Fuel\Core\Fieldset::forge('Autofield', array(
                                'form_attributes' => array(
                                    'id' => 'edit_article_form',
                                    'name' => 'edit_article',
                                    'enctype'=>"multipart/form-data"
                                    )));
                $object = new $model();
                $form->add_model($object);
                
                $object->GenerateAutoFields($form);
                $form->add(\Fieldset::forge('tabular')->set_tabular_form('Model_Deliverylines', 'deliverylines', $object)->set_fieldset_tag(false));
                if ( ! $object = $model::find($id))
		{
			\Session::set_flash('error', 'Could not find car #'.$id);
			\Response::redirect('deliverys');
		}
                
                if($object->confirm == 1)
                    \Response::redirect("deliverys/view/$id");
                
                
                $name = $object->name;
                $create_uid = $object->create_uid;
                $created_at = $object->created_at;
                
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
		if (\Input::method() == 'POST')
		{
                     
                    $data = \Input::post("orderlines_new","0");
                    
               
                    
                    $val =  $form->validation();


			if ($val->run())
			{
	
                            $object->set($val->input());
                            
                             if(is_array($data))
                                   $object->editdeliverylines($data);
                             
                             
                            
                             if(is_array($data))
                                foreach ($data as $line)
                                {
                                   if(key_exists('quantity', $line))
                                        $object->total_quantities += $line['quantity'];
                                }
                               
                                     
                                     
                            $object->name = $name;
                            
                            $agent_update_id = '';
                            
                            $agentObj = $this->getAgent();
                            
                            if(is_object($agentObj))
                                $agent_update_id = $agentObj->id;
                            
                            $object->agent_update_id = $agent_update_id;
                            $object->create_uid = $create_uid;
                            $object->created_at = $created_at;
				if ($object->save())
				{
					\Session::set_flash('success', \Lang::get("edit complete for this").$object->id.'.');

					\Response::redirect($redirect);
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
            else {$form->populate($object);}

             $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
            
                if(is_object($info))
                {
                    $info_val = json_decode($info->value, true);
                    if(key_exists('enablewebcategories', $info_val))
                        $data['enablecategories'] = $info_val["enablewebcategories"];
                    else 
                        \Log::warning('enablewebcategories does not exist in enablemodule');
                    if(key_exists('enableviewdeliverycomments', $info_val))
                        $data['enableviewdeliverycomments'] = $info_val["enableviewdeliverycomments"]; //enableviewdeliverycomments
                    else 
                        \Log::warning('enableviewdeliverycomments does not exist in enablemodule');
                    if(key_exists('enabledeliverylinecomment', $info_val))
                        $data['enabledeliverylinecomment'] = $info_val["enabledeliverylinecomment"];
                    else 
                        \Log::warning('enabledeliverylinecomment does not exist in enablemodule');
                }
			 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
		
                 $data['name']=  $form->build();
                 $data['object'] =$object;
                 
                       $auth = \Auth::get_user_id();
                $auth = $auth[1];
                $queryagent = \Model_Agents::query();
                $queryagent->where('connect_uid','=',$auth);
                $agent = $queryagent->get_one();
                if(is_object($agent))
                    $data['enablepriceedit'] =$agent->enableorderpriceedit;
        $data['agent'] = $agentw;
        $data['warehouse'] = $warehouse; 
                 $data["distroinfo"] = \Controller_Systems::distroinfo();
                 $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
                 $data['model'] = $this->base;
                 $data['base'] = $this->base;  
	   	 $this->template->content = \View::forge('deliverys/edit', $data,false);
        }
        
     
    public function action_confirm($id){
       
        $base = $this->base;
        $model = $this->model;

        $order = $model::find($id);

        if (is_object($order)) 
        {
             if($order->confirm == 1)
                        \Response::redirect("deliverys/view/$id");


        if (is_object($order)) 
        {
            $order->calculate_total();

            
            $order = $this->createNewCopy($id);
            $id = $order->id;
            
            $order->sendtocodebina = 1;

            $order->save();
        }
        else
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
          
        $order = new Model_Deliverys();
        $orderlines = $obj->deliverylines;
         
        $data =$obj->to_array();

        unset($data['id']);
        unset($data['customer']);
        unset($data['created_at']);
        unset($data['deliverylines']);
        $order->set($data); 
         foreach ( $orderlines as $line){
 
            $templine  = new Model_Deliverylines();
            $line_arr = $line->to_array();
            unset($line_arr['delivery_id']); 
            unset($line_arr['product']); 
            unset($line_arr['id']);
            $templine->set($line_arr);
            
            $order->deliverylines[]=  $templine;
            
        }
             
        $obj->name = $obj->name."_draft_copy";
        $obj->deleted = 1;
        $obj->save();
              
        
        $order->deleted = 0; 
        $order->save();
        
        $qut = Model_Quotes::query()->where('delivery_id',$id)->get_one();
        
        if(is_object($qut)){
            $qut->delivery_id = $order->id;
            
            $qut->save_data();
        }
       
        return $order;    
    }
    

     public function action_exportDocumentToPdf($id = null) {
                    
            $model= $this->model;
                    
            is_null($id) and \Response::redirect($this->base);

            if ( ! $data['order'] = $model::find($id))
            {
                    \Session::set_flash('error', 'Could not find car #'.$id);
                    \Response::redirect($this->base);
            }

                   
            $data['order']->document_type= 5;
            $orderlines= $data['order']->deliverylines; 
            unset($data['order']->deliverylines);
            
            
//            $data['order']->to_array();
            $order =$data['order']; 
            $customer_name =$order->customer?$order->customer->name:""; 
            $customer_key =$order->customer?$order->customer->customer_key:"";
            $address =$order->customer?$order->customer->address():"";
            $authorized_dealer_id =$order->customer?$order->customer->authorized_dealer_id:"";
            $agent_name =$order->agent?$order->agent->name:"";
            $agent_code =$order->agent?$order->agent->agent_code:"";
            
            unset($order->customer);
            unset($order->agent);
            $order =$order->to_array(); 
            
            $temp =  array();
            foreach ($orderlines as $line){
                $prodname = $line->product?$line->product->item_name:"deleted";
                $linex =  $line->to_array();
                $linex['item_name'] =  $prodname;
                $temp[] = $linex;
            }
            $order['orderlines']= $temp; 
            $order['customer_name']= $customer_name; 
            $order['customer_key']= $customer_key; 
            $order['address']= $address; 
            $order['authorized_dealer_id']= $authorized_dealer_id; 
            $order['agent_name']= $agent_name; 
            $order['agent_code']= $agent_code; 
            
//            echo json_encode($order); die();
            
            $datetime = date('YmdHis');
            $filename = 'delivery'.$datetime;
            $reporttemplate = 'haofedelivery';   
              
            $datax = $this->printReport("https://pdfcreatortest.dira2.co.il/albums/reporter/runWithName",$reporttemplate,$order);
      
            $this->pdfString = file_get_contents(urldecode( $datax));
            
            
//            header('Content-type: application/pdf');
//
//            header("Content-disposition:inline;filename={$filename}.pdf");
//            
//
//            echo file_get_contents(urldecode( $datax)); die();
            
             $this->createFile($id, 'original');
            
            
            $reporttemplate = 'haofedeliverycopy';   
              
            $dataxy = $this->printReport("https://pdfcreatortest.dira2.co.il/albums/reporter/runWithName",$reporttemplate,$order);
      
            $this->pdfString = file_get_contents(urldecode( $dataxy));
             $this->createFile($id, 'copy');
            
             $original =0;
            
            if(isset($data['order']->printcopyweb) && $data['order']->printcopyweb == 1){
//                $data['order']->copytype = "העתק ";
            }else{
              
                    $original =1;
                    $this->setprintcopy($id);
                
            }
//            if(isset($data['order']->mobile) && $data['order']->mobile == 1){
////                $data['order']->copytype = "העתק ";
//            }else{
//                if(isset($data['order']->confirm) && $data['order']->confirm == 1 && isset($data['order']->printcopyweb) && $data['order']->printcopyweb == 1 ){
////                    $data['order']->copytype = "העתק "; 
//                     
//                }else{
//                    $original =1;
//                    $this->setprintcopy($id);
////                    $data['order']->copytype = " מקור";
//                }
//                
//            }
             
            
            if($original == 1){
                $outputpath = DOCROOT."/haofemergedpdf/$filename.pdf";
              

                $filepath = array(
                     DOCROOT."/haofemergedpdf/original_$id.pdf",
                     DOCROOT."/haofemergedpdf/copy_$id.pdf"
                 );

//                $redirectpdf = "/haofemergedpdf/delivery_$id.pdf";
                $redirectpdf = DOCROOT."/haofemergedpdf/$filename.pdf";
                \Package::load('Fpdfmerge');
                \Fpdfmerge::index($filepath,$outputpath);    

//                \Response::redirect($redirectpdf); 
                $handler = \File::download($redirectpdf); 
            }else{
//                $infox['headerData'] = '<div style="width:100%;margin-top:-120px; text-align:center;"><img src="/assets/img/haofe/haofe_subheader_copy.png" '
//                    . ' height="55" width="640" ></div>';
//                        
//                $infox['option'] = 'D';
//                $infox['view'] = 'deliverys/pdfcopy';
//                \Attachment::indexWithFooterHeader($data,$infox, TRUE, true);
                
                $reporttemplate = 'haofedeliverycopy';   
              
            $dataxy = $this->printReport("https://pdfcreatortest.dira2.co.il/albums/reporter/runWithName",$reporttemplate,$order);
      
            $this->pdfString = file_get_contents(urldecode( $dataxy));
             
            
            header('Content-type: application/pdf');

            header("Content-disposition:inline;filename={$filename}.pdf");
            
            echo $this->pdfString; 

            }
            
            die();
        }
     
    function printReport($url,$report,$data){

        $pdfData = array(
            "outputFormat"=>"pdf"
        );

        $handle = curl_init();

        $pdfData["data"]= json_encode($data);

        $pdfData["report"] = $report;

        $req = curl_init();
        curl_setopt_array($req, [
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => "PUT",
            CURLOPT_POSTFIELDS     => http_build_query($pdfData),
            CURLOPT_HTTPHEADER     => [ "Content-Type" => "application/json" ],
            CURLOPT_RETURNTRANSFER=>true
        ]);

        $response = curl_exec($req);

        $header_size = curl_getinfo($req, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $key = substr($response, 4);
        $getdata = http_build_query(
                        array(
                            'outputFormat' => 'pdf',
                            'key' => $key,
                         )
                    );



        return "$url?$getdata";   
    } 
   

     public function action_exportDocumentToPdfxx($id = null) {
                    
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

                if(key_exists('enabledeliverylinecomment', $info_val))
                    $data['enabledeliverylinecomment'] = $info_val["enabledeliverylinecomment"];
                else 
                    \Log::warning('enabledeliverylinecomment does not exist in enablemodule');
            }
                   
            $data['order']->document_type= 5;
            $data['order']->orderlines= $data['order']->deliverylines; 
            \Package::load('attachment'); 
            $datetime = date('YmdHis');
            $filename = 'delivery'.$datetime;
            
            $infox['filename'] = $filename; 
//            $infox['filename'] = 'delivery';
            $infox['view'] = 'deliverys/pdf';
            $infox['option'] = 'S';
            $infox['footerImageHeight'] = '140px';
            $infox['headerImageHeight'] = '48px';
            $infox['headerImageWidth'] = '250px';
            $infox['footerY'] = '-30';
            $infox['headerY'] = '+0';
            
            $infox['footerpath'] = '/assets/img/haofe/footer.png';
//            $infox['headerpath'] = '/assets/img/haofe/logo.jpg';
            $infox['headerpath'] = '/assets/img/haofe/logo.png';
            
            $original =0;
            
            if(isset($data['order']->mobile) && $data['order']->mobile == 1){
                $data['order']->copytype = "העתק ";
            }else{
                if(isset($data['order']->confirm) && $data['order']->confirm == 1 && isset($data['order']->printcopyweb) && $data['order']->printcopyweb == 1 ){
                    $data['order']->copytype = "העתק "; 
                     
                }else{
                    $original =1;
                    $this->setprintcopy($id);
                    $data['order']->copytype = " מקור";
                }
                
            }
            
//            \Attachment::indexWithFooterHeader($data,$infox, false, true);
            
            if($original == 1){
                $outputpath = DOCROOT."/haofemergedpdf/$filename.pdf";
              
            $infox['headerData'] = '<div style="width:100%;margin-top:-120px; text-align:center;"><img src="/assets/img/haofe/haofe_subheader_original.png" '
                    . ' height="30" width="640" ></div>';
                        
                
                $this->pdfString = \Attachment::indexWithFooterHeader($data,$infox, TRUE, true);
                $this->createFile($id, 'original');

                
                $infox['headerData'] = '<div style="width:100%;margin-top:-120px; text-align:center;"><img src="/assets/img/haofe/haofe_subheader_copy.png" '
                    . ' height="55" width="640" ></div>';
                        
                $infox['view'] = 'deliverys/pdfcopy';
                $this->pdfString = \Attachment::indexWithFooterHeader($data,$infox, TRUE, true);

                $this->createFile($id, 'copy');

                $filepath = array(
                     DOCROOT."/haofemergedpdf/original_$id.pdf",
                     DOCROOT."/haofemergedpdf/copy_$id.pdf"
                 );

//                $redirectpdf = "/haofemergedpdf/delivery_$id.pdf";
                $redirectpdf = DOCROOT."/haofemergedpdf/$filename.pdf";
                \Package::load('Fpdfmerge');
                \Fpdfmerge::index($filepath,$outputpath);    

//                \Response::redirect($redirectpdf); 
                $handler = \File::download($redirectpdf); 
            }else{
                $infox['headerData'] = '<div style="width:100%;margin-top:-120px; text-align:center;"><img src="/assets/img/haofe/haofe_subheader_copy.png" '
                    . ' height="55" width="640" ></div>';
                        
                $infox['option'] = 'D';
                $infox['view'] = 'deliverys/pdfcopy';
                \Attachment::indexWithFooterHeader($data,$infox, TRUE, true);

            }
            
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
        
    
    
    function createFile($id = null ,$module = null)  {
        
            if(is_null($this->pdfString)) return false;
            
             $clear = \Input::get('clear');
             $clear = 1;
                
            
            if(!is_dir(DOCROOT.'/haofemergedpdf'))
                \File::create_dir(DOCROOT, 'haofemergedpdf', 0755);
            
            $path = DOCROOT.'/haofemergedpdf/'.$module."_$id.pdf";
            
            if($clear == 1 && file_exists($path)){
                 \File::delete(DOCROOT.'/haofemergedpdf/'.$module."_$id.pdf"); 
            }
            
            if(!file_exists($path))
                \File::create(DOCROOT.'/haofemergedpdf/', $module."_$id.pdf",  $this->pdfString); 
        
            return true;
    }
  
}