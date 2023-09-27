<?php

namespace emailmonitor;

class Controller_Objectemails extends \Controller_Base{

    public $title = "Objectemails";    
    public $model = "emailmonitor\Model_Objectemails";
    public $base = "emailmonitor/objectemails";

    public function action_index() {
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
        $this->template->content = \View::forge('objectemails/index', $data);

    }
    
    public function action_send($id) {
        $model = $this->model;
        
        $object = $model::find($id);
        
        
        if(is_object($object)){
            try{
                
                $type  = $object->type;
                
                switch ($type){
                    case 'orders': $this->sendQuoteMail($object->quote_id, $object->customer_id,'Model_Orders','ganli/orderreceipt','new invoice');
                                    break;
                    case 'quotes': $this->sendQuoteMail($object->quote_id, $object->customer_id,'Model_Quotes','ganli/quotereceipt','new zilber order');
                                    break;
//                    case 'reciptinvoices':
//                                    break;
//                    case 'deliverys':
//                                    break;
//                    case 'payments':
//                                    break;
                }
                
                
            } catch (Exception $ex) {

            }
        }
        
        \Response::redirect('emailmonitor/objectemails');
    }
    
    
    /**
     * @abstract send email per quote
     * @depends jsonQuotecomplete, confirm
     * @param int $id quote id
     * @param int $customerid customer id
     * @return string empty
     */
    public function sendQuoteMail($id = null, $customerid = null,$model = null,$view = 'ganli/quotereceipt',$subject='new zilber order')//action_receiptView()
    {
          if(is_null($id)){ return "empty order id";}

//          $model = $this->model;
          $status = 0;

          \Package::load('attachment');

          $data2['cars'] = $model::find($id);

          $infostatus = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();

          $flagarr = array(   'enablequotecustomeremail','enablequotelinecomment','enablequoteadminemail',
                              'enablequotebcc','enablequotealert','setemailsendername','enableagentmail','bcc_email',
                              );
          if(is_object($infostatus))
          {
              $info_value = json_decode($infostatus->value, true);

              foreach($flagarr as $flag)
              {
                  if(key_exists($flag, $info_value))
                  {
                      $$flag = $info_value["$flag"];

                      if($flag == 'bcc_email')
                      {
                          if(strpos($$flag, ','))
                          {
                              $bcc_email= explode(',', $$flag);
                          }
                      }
                  }
                  else 
                      \Log::warning("$flag does not exist in enablemodule");
              }            
          }

          $email = array();
          $from = '';
         $cusname= '';
            $res = \Model_Customers::find($customerid);
            if(is_object($res))
            {
                if(isset($enablequotecustomeremail) && $enablequotecustomeremail == 1 && !empty($customerid))
                {
                    if(isset($res->email))
                    {
                        $email[] = $res->email;                         
                    }
                }
                    $cusname = $res->name;
            }
            
          $info = \Model_Systemconfig::query()->where('name','distroinfo')->get_one();

          if(is_object($info)){

              $info = json_decode($info->value,true); 
              if(key_exists("distroemail", $info))
              { 
                  if(isset($enablequoteadminemail) && $enablequoteadminemail == 1)
                  {
                      $email[] = $info["distroemail"]; 
                  }
                  $from = $info["distroemail"]; 

              }
          }

          if(isset($email) && is_array($email))    
              $errors = array_filter($email);

           if(!isset($email) || isset($errors) && empty($errors)) 
           {
               if(isset($enablequotealert) && $enablequotealert == 1)
               { 
                   \Log::warning("email id array: ");
                   if(isset($bcc_email))
                   { 
                      if(is_array($bcc_email))
                      {
                          $email = $bcc_email;
                          $from = $bcc_email[0];
                      }
                      else
                      {
                          $email[] = $bcc_email;
                          $from = $bcc_email;
                      }
                      unset($bcc_email);
                   }
               }
           }

          $enableagentmail = $data2['cars']->agent?$data2['cars']->agent->enableagentmail:'0';
          if($enableagentmail == 1)
          {
              $email[] = \Auth::get('email');
          }        
         
          $cusobj = \Model_Customers::find($customerid);
          $info['view'] = $view;
          $info['option'] = 'S';
          $msg = '';
          if(isset($enablequotebcc) && $enablequotebcc == 1 )
                          if(isset($bcc) && !empty($bcc))
                          {
                              if(is_array($bcc))
                              {
                                  foreach ($bcc as $bc)
                                      $email[] = $bc;
                              }
                              else
                                  $email[] = $bcc;
                          }
                                          
                
                    
                  
                  $subject1 = $subject;
                  if(is_object($data2['cars']))
                    $subject1 .= ' - '.$data2['cars']->name;
                  if(isset($cusname)){
                    $subject1 .= " - ".$cusname;
                  }
                  
                
                  $body = '';
                  
                  \Log::warning("email id : ");
                  try
                  {
                      
                      $mailx = new \Email;
                      $mail = $mailx::forge();

                      
                      $mail->to($email);
                      if(isset($setemailsendername) && !empty($setemailsendername))
                          $mail->from($from,$setemailsendername);
                      else 
                          $mail->from($from);

                      
                        $subject = $subject1;
                      $mail->subject($subject);
                      $mail->string_attach((\Attachment::index($data2,$info)), 'quotereceipt.pdf');
                      $mail->send();
                      $msg="Email Sent Successfully";
                      $status = 1;

                  }
                  catch(\Exception $e)
                  {
                          $msg =$e->getMessage();
                          $status = 0;
                  }

                  if(\Module::exists('emailmonitor'))
                  {
                      \Module::load('emailmonitor');
                      $obj = new \emailmonitor\Model_Emailstatus();
                      if(is_object($obj))
                      {
                           $obj->status = $status;
                           $obj->quote_id = $data2['cars']->id;
                           $obj->name = $data2['cars']->name;
                           $obj->type = $model;
                           $obj->email = json_encode($email);
                           if($obj->save())
                               \Log::warning("EmailStatus saved successfully ".$obj->id);
                           else 
                               \Log::error("EmailStatus not saved !");
                      }
                  }
                  else 
                      \Log::warning("Module emailmonitor does not exists !");

                  \Log::warning("Email Status :" .$msg);
                  echo $msg;
                  
      }


}
