<?php

namespace haofeorders;
\Module::load('hashmapping');

class Controller_Systems extends \hashmapping\Controller_Systems{
    
    
       
     public function get_imovein() {

        
        
        /*
         * Notes for Namrata.
         * 
         * 1. No payment header in imovein 
         * 2. if Imovein is taken then kupain will not have any lines, saperate
         * the latestids for receipts and receiptinvoices for systemconfig so 
         * this does not happen
         * 3. Check the decimals , now that i have seen the systems controller 
         * simply do a strfomat to get the number in the form of 6.3 , for example
         * 0 would become 0.000 , 12.12 will be 12.120 and so on same with 2.2 
         * 0 would be 0.00 (this is mentioned in the file of systems
         *     
         * 
         */

        // We'll be outputting a txt
        $this->response->set_header('Content-Type', 'application/txt');

        // It will be called imovein.doc
        $this->response->set_header('Content-Disposition', 'attachment; filename="imovein.doc"');
        $this->response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');

        $this->response->forge();

        $data = array();
        $ord_type = 3;
        $rinvoice_type = 87;
        $quo_type = 31; // 6;
        $quo_ret_type = 74; // 6;
        $del_type = 21;
        
        $pay_type = 0;
        $rreceipt_type = 2;
               
        $sequencestart  = \Input::get('sequencestart',0);
        $sequenceend  = \Input::get('sequenceend',0);   
        $fromdate = \Input::get('fromdate',null);
        $todate = \Input::get('todate',null);
        
        $enablequotelinecomment= 0;
        $enableorderlinecomment = 0;
        $enabledeliverylinecomment = 0;
        $enablereceiptorderlinecomment = 0;
        $enablereceiptcashcomment = 0;
        $enablereceiptchequecomment = 0;
        $enablecashlinecomment = 0;
        $enablechequelinecomment = 0;
        
        $enablequotecomment= 0;
        $enableordercomment = 0;
        $enabledeliverycomment = 0;
        $enablereceiptinvoicecomment = 0;
        $enablepaymentcomment = 0;
        set_time_limit(0);
        if($fromdate != null)
          $fromdate = date ("Y-m-d",strtotime(date($fromdate)));

        if($todate != null)
          $todate = date ("Y-m-d",strtotime(date($todate))+3600*24);


        $infoset = \Model_Systemconfig::query()->where("name","imoveinkupainids")->get_one();
        if(is_object($infoset)){
            //Show info
            $info_val = json_decode($infoset->value,true);

           if(key_exists('latestquoteid', $info_val))
                $latestquoteid = $info_val["latestquoteid"]; 
            else 
                \Log::info('latestquoteid does not exist in enablemodule');
            if(key_exists('latestdeliveryid', $info_val))
                $latestdeliveryid= $info_val["latestdeliveryid"]; 
            else 
                \Log::info('latestdeliveryid does not exist in enablemodule');
            if(key_exists('latestorderid', $info_val))
                $latestorderid = $info_val["latestorderid"]; 
            else 
                \Log::info('latestorderid does not exist in enablemodule');
            if(key_exists('latestireceiptinvoiceid', $info_val))
                $latestireceiptinvoiceid = $info_val["latestireceiptinvoiceid"]; 
            else 
                \Log::info('latestireceiptinvoiceid does not exist in enablemodule');       
            if(key_exists('latestimoveinrreceiptinvoiceid', $info_val))
                $latestimoveinrreceiptinvoiceid = $info_val["latestimoveinrreceiptinvoiceid"]; 
            else 
                \Log::info('latestimoveinrreceiptinvoiceid does not exist in enablemodule');       
            if(key_exists('latestimoveinpaymentid', $info_val))
                $latestimoveinpaymentid = $info_val["latestimoveinpaymentid"]; 
            else 
                \Log::info('latestimoveinpaymentid does not exist in enablemodule');       
        }

        $info = \Model_Systemconfig::query()->where("name","systemsettings")->get_one();

        if(is_object($info))
        {
            $info_val = json_decode($info->value, true);
            if(key_exists('enablechequefields', $info_val))
                $set = $info_val["enablechequefields"]; 
            else 
                \Log::info('enablechequefields does not exist in enablemodule');
            if(key_exists('enablelatestrecords', $info_val))
                $enablelatestrecords = $info_val["enablelatestrecords"]; 
            else 
                \Log::info('enablelatestrecords does not exist in enablemodule');
            if(key_exists('enableimoveinquotes', $info_val))
                $enableimoveinquotes = $info_val["enableimoveinquotes"]; 
            else 
                \Log::info('enableimoveinquotes does not exist in enablemodule');
            if(key_exists('enableimoveindeliverys', $info_val))
                $enableimoveindeliverys = $info_val["enableimoveindeliverys"]; 
            else 
                \Log::info('enableimoveinorders does not exist in enablemodule');
            if(key_exists('enableimoveinorders', $info_val))
                $enableimoveinorders = $info_val["enableimoveinorders"]; 
            else 
                \Log::info('enableimoveinorders does not exist in enablemodule');
            if(key_exists('enableimoveinreceiptinvoices', $info_val))
                $enableimoveinreceiptinvoices = $info_val["enableimoveinreceiptinvoices"]; 
            else 
                \Log::info('enableimoveinreceiptinvoices does not exist in enablemodule');
            if(key_exists('enableimoveinreceiptinvoicespayment', $info_val))
                $enableimoveinreceiptinvoicespayment = $info_val["enableimoveinreceiptinvoicespayment"]; 
            else 
                \Log::info('enableimoveinreceiptinvoicespayment does not exist in enablemodule');
            if(key_exists('enableimoveinpayments', $info_val))
                $enableimoveinpayments = $info_val["enableimoveinpayments"]; 
            else 
                \Log::info('enableimoveinpayments does not exist in enablemodule');
        }
         $infomod = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();

        if(is_object($infomod))
        {
            //////////////////////////////////////////////////////////////
            $info_val = json_decode($infomod->value, true);
            if(key_exists('enablequotelinecomment', $info_val))
                $enablequotelinecomment= $info_val["enablequotelinecomment"]; 
            else 
                \Log::info('enablequotelinecomment does not exist in enablemodule');
            if(key_exists('enableorderlinecomment', $info_val))
                $enableorderlinecomment = $info_val["enableorderlinecomment"]; 
            else 
                \Log::info('enableorderlinecomment does not exist in enablemodule');
            if(key_exists('enabledeliverylinecomment', $info_val))
                $enabledeliverylinecomment = $info_val["enabledeliverylinecomment"]; 
            else 
                \Log::info('enabledeliverylinecomment does not exist in enablemodule');
            if(key_exists('enablereceiptorderlinecomment', $info_val))
                $enablereceiptorderlinecomment = $info_val["enablereceiptorderlinecomment"]; 
            else 
                \Log::info('enablereceiptorderlinecomment does not exist in enablemodule');
            
            if(key_exists('enableviewquotecomments', $info_val))
                $enablequotecomment= $info_val["enableviewquotecomments"]; 
            else 
                \Log::info('enableviewquotecomments does not exist in enablemodule');
            if(key_exists('enableviewordercomments', $info_val))
                $enableordercomment = $info_val["enableviewordercomments"]; 
            else 
                \Log::info('enableviewordercomments does not exist in enablemodule');
            if(key_exists('enableviewdeliverycomments', $info_val))
                $enabledeliverycomment = $info_val["enableviewdeliverycomments"]; 
            else 
                \Log::info('enableviewdeliverycomments does not exist in enablemodule');
            if(key_exists('enableviewreceiptinvoicecomments', $info_val))
                $enablereceiptordercomment = $info_val["enableviewreceiptinvoicecomments"]; 
            else 
                \Log::info('enableviewreceiptinvoicecomments does not exist in enablemodule');
            if(key_exists('enableviewpaymentcomments', $info_val))
                $enablepaymentcomment = $info_val["enableviewpaymentcomments"]; 
            else 
                \Log::info('enableviewpaymentcomments does not exist in enablemodule');
            if(key_exists('enablePriceWithoutTaxImovein', $info_val))
                $enablePriceWithoutTaxImovein = $info_val["enablePriceWithoutTaxImovein"]; 
            else 
                \Log::info('enablePriceWithoutTaxImovein does not exist in enablemodule');
            if(key_exists('enableImoveinDiscountCombine', $info_val))
                $enableImoveinDiscountCombine = $info_val["enableImoveinDiscountCombine"]; 
            else 
                \Log::info('enableImoveinDiscountCombine does not exist in enablemodule');
       
        }
        
        $enableImoveinDiscountCombine = 0;

         $tax = $this->tax;

        if(isset($enableimoveinorders) && $enableimoveinorders == 1){
            try{ 
                $queryord = \Model_Orders::query();
                $queryord->where('confirm','=',1);
                
               if(isset($fromdate) && !empty($fromdate))
                    {
                        $queryord->where('created_at','>=',date ("Y-m-d H:i:s", strtotime($fromdate)));
                    }
                    if(isset($todate) && !empty($todate))
                    {
                        $queryord->where('created_at','<=',date ("Y-m-d H:i:s", strtotime($todate)));
                    }
                    if(isset($sequencestart) && !empty($sequencestart))
                    {
                         $queryord->where('name','>=',$sequencestart);
                    }
                    if(isset($sequenceend) && !empty($sequenceend) )
                    {
                         $queryord->where('name','<=',$sequenceend);
                    }
                        
                    if(isset($enablelatestrecords) && $enablelatestrecords ==  1)
                        if(isset($latestorderid))
                            $queryord->where ('id','>',$latestorderid);
                        
                $ordset = $queryord->get();

                $ordid= 0;
                foreach($ordset as $ord){
                    $i=1;
                     foreach ($ord->orderlines as $line){  
                    
                         $this->processimoveinalbert($ord,$ord_type, $line, $enableorderlinecomment,$enableordercomment,$i,$enablePriceWithoutTaxImovein,$enableImoveinDiscountCombine);
                    
                    if(isset($ordid) && $ordid < $ord->id)
                        $ordid= $ord->id;
                    
                        $i++;
                     }
                }
                if($ordid != 0)
                    $data['latestorderid']= $ordid;
            }  
            catch (\Exception $e){
                \Log::warning("moving one ".$e->getMessage());
            }
        }
        
        if(isset($enableimoveinreceiptinvoices) && $enableimoveinreceiptinvoices == 1){
           try{
                $queryord = \Model_Receiptinvoices::query();

                $queryord->where('confirm','=',1);
                 
                if(isset($fromdate) && !empty($fromdate))
                    {
                        $queryord->where('created_at','>=',date ("Y-m-d H:i:s", strtotime($fromdate)));
                    }
                    if(isset($todate) && !empty($todate))
                    {
                        $queryord->where('created_at','<=',date ("Y-m-d H:i:s", strtotime($todate)));
                    }
                    if(isset($sequencestart) && !empty($sequencestart))
                    {
                         $queryord->where('name','>=',$sequencestart);
                    }
                    if(isset($sequenceend) && !empty($sequenceend) )
                    {
                         $queryord->where('name','<=',$sequenceend);
                    }
                        
                    if(isset($enablelatestrecords) && $enablelatestrecords ==  1)
                        if(isset($latestireceiptinvoiceid))
                            $queryord->where ('id','>',$latestireceiptinvoiceid);
                        
                 $ordset = $queryord->get();

                 $rid= 0;
                foreach($ordset as $ord){
                     $i=1;
                    foreach ($ord->receiptorderlines as $line){  
                    $this->processimoveinalbert($ord, $rinvoice_type, $line, $enablereceiptorderlinecomment, $enablereceiptinvoicecomment,$i,$enablePriceWithoutTaxImovein,$enableImoveinDiscountCombine);
                    
                    if(isset($rid) && $rid < $ord->id)
                        $rid= $ord->id;
                    
                        $i++;
                    }
                }   
                if($rid != 0)
                        $data['latestireceiptinvoiceid']= $rid;
            }                
            catch (\Exception $e){
              \Log::warning("moving one ".$e->getMessage());
            }
        }
        
        if(isset($enableimoveinreceiptinvoicespayment) && $enableimoveinreceiptinvoicespayment == 1){
           try{
                $queryord = \Model_Receiptinvoices::query();
                 $queryord->where('confirm','=',1);
                 
                if(isset($fromdate) && !empty($fromdate))
                    {
                        $queryord->where('created_at','>=',date ("Y-m-d H:i:s", strtotime($fromdate)));
                    }
                    if(isset($todate) && !empty($todate))
                    {
                        $queryord->where('created_at','<=',date ("Y-m-d H:i:s", strtotime($todate)));
                    }
                    if(isset($sequencestart) && !empty($sequencestart))
                    {
                         $queryord->where('name','>=',$sequencestart);
                    }
                    if(isset($sequenceend) && !empty($sequenceend) )
                    {
                         $queryord->where('name','<=',$sequenceend);
                    } 
                    if(isset($enablelatestrecords) && $enablelatestrecords ==  1)
                        if(isset($latestimoveinrreceiptinvoiceid))
                            $queryord->where ('id','>',$latestimoveinrreceiptinvoiceid);
                        
                 $ordset = $queryord->get();

                 $rpayid= 0;
                foreach($ordset as $ord){
                    $i=1;
                   foreach ($ord->receiptcashs as $line){  
                    $this->processimoveinalbert($ord, $rreceipt_type, $line, $enablereceiptcashcomment, $enablereceiptinvoicecomment,$i);
                                      
                        $i++;                         
                   }
                   foreach ($ord->receiptcheques as $line){  
                    $this->processimoveinalbert($ord, $rreceipt_type, $line, $enablereceiptchequecomment, $enablereceiptinvoicecomment,$i);
                                       
                        $i++;                    
                   }
                    if(isset($rpayid) && $rpayid < $ord->id)
                            $rpayid= $ord->id;                    
                }   
                if($rpayid != 0)
                        $data['latestimoveinrreceiptinvoiceid']= $rid;
            }                
            catch (\Exception $e){
              \Log::warning("moving one ".$e->getMessage());
            }
        }
        
        if(isset($enableimoveindeliverys) && $enableimoveindeliverys == 1){
            try{
                $queryord = Model_Deliverys::query();

                $queryord->where('confirm','=',1);
                
                if(isset($fromdate) && !empty($fromdate))
                    {
                        $queryord->where('created_at','>=',date ("Y-m-d H:i:s", strtotime($fromdate)));
                    }
                    if(isset($todate) && !empty($todate))
                    {
                        $queryord->where('created_at','<=',date ("Y-m-d H:i:s", strtotime($todate)));
                    }
                    if(isset($sequencestart) && !empty($sequencestart))
                    {
                         $queryord->where('name','>=',$sequencestart);
                    }
                    if(isset($sequenceend) && !empty($sequenceend) )
                    {
                         $queryord->where('name','<=',$sequenceend);
                    }
                        
                    if(isset($enablelatestrecords) && $enablelatestrecords ==  1)
                        if(isset($latestdeliveryid))
                            $queryord->where ('id','>',$latestdeliveryid);
                        
                    $queryord->where ('sendtocodebina','=',1);
                    $queryord->where_open ();
                    $queryord->or_where ('senttocodebina','is',null);
                    $queryord->or_where ('senttocodebina','=',0);
                    $queryord->where_close ();
                        
                $ordset = $queryord->get();
               
                $did=0;
                foreach($ordset as $ord){
                    $i=1;
                    foreach ($ord->deliverylines as $line){  
               
                    $this->processimoveinalbert($ord, $del_type, $line, $enabledeliverylinecomment, $enabledeliverycomment, $i,$enablePriceWithoutTaxImovein,$enableImoveinDiscountCombine);
                    if(isset($did) && $did < $ord->id)
                        $did= $ord->id;
                                        
                        $i++;
                    }
                    
                    $ord->senttocodebina = 1;
                     
                    $ord->save_data();
                }
                if($did != 0)
                         $data['latestdeliveryid']= $did;
   
            }  
            catch (\Exception $e){

                \Log::warning("moving one ".$e->getMessage());

            }
        }

        if(isset($enableimoveinquotes) && $enableimoveinquotes == 1){
            
            
            
            
            
            try{
                $queryord = Model_Quotes::query();

                $queryord->where('confirm','=',1);
                
                if(isset($fromdate) && !empty($fromdate))
                    {
                        $queryord->where('created_at','>=',date ("Y-m-d H:i:s", strtotime($fromdate)));
                    }
                    if(isset($todate) && !empty($todate))
                    {
                        $queryord->where('created_at','<=',date ("Y-m-d H:i:s", strtotime($todate)));
                    }
                    if(isset($sequencestart) && !empty($sequencestart))
                    {
                         $queryord->where('name','>=',$sequencestart);
                    }
                    if(isset($sequenceend) && !empty($sequenceend) )
                    {
                         $queryord->where('name','<=',$sequenceend);
                    }
                        
                    if(0 ==  1){
                        if(isset($enablelatestrecords) && $enablelatestrecords ==  1)
                            if(isset($latestquoteid))
                                $queryord->where ('id','>',$latestquoteid);
                    }
                        
                    $queryord->where ('sendtocodebina','=',1);
                    $queryord->where_open ();
                    $queryord->or_where ('senttocodebina','is',null);
                    $queryord->or_where ('senttocodebina','=',0);
                    $queryord->where_close ();
                        
                $ordset = $queryord->get();

                $qid=0;
                foreach($ordset as $ord){
                 $i=1;
                    foreach ($ord->quotelines as $line){  
                     
                            
                            if(isset($ord->order_type) && $ord->order_type == 'return')  
                                $this->processimoveinalbert($ord, $quo_ret_type, $line, $enablequotelinecomment, $enablequotecomment,$i,$enablePriceWithoutTaxImovein,$enableImoveinDiscountCombine);
                            else 
                                $this->processimoveinalbert($ord, $quo_type, $line, $enablequotelinecomment, $enablequotecomment,$i,$enablePriceWithoutTaxImovein,$enableImoveinDiscountCombine);


                            if(isset($qid) && $qid < $ord->id)
                                $qid= $ord->id;
                            
                            $i++; 
                    }
                    
//                    $ord->sendtocodebina = 0;
                    $ord->senttocodebina = 1;
                    $ord->save_data();
//                     \Log::warning("quote sendtocodebina set to 0  id: ".$ord->id);
                } 
                if($qid != 0)
                $data['latestquoteid'] = $qid;           
            }  
            catch (\Exception $e){
                \Log::warning("moving one ".$e->getMessage());
            }
        }
        
        if(isset($enableimoveinpayments) && $enableimoveinpayments == 1){
            try{
                $queryord = \Model_Payments::query();

                $queryord->where('confirm','=',1);
                
               if(isset($fromdate) && !empty($fromdate))
                    {
                        $queryord->where('created_at','>=',date ("Y-m-d H:i:s", strtotime($fromdate)));
                    }
                    if(isset($todate) && !empty($todate))
                    {
                        $queryord->where('created_at','<=',date ("Y-m-d H:i:s", strtotime($todate)));
                    }
                    if(isset($sequencestart) && !empty($sequencestart))
                    {
                         $queryord->where('name','>=',$sequencestart);
                    }
                    if(isset($sequenceend) && !empty($sequenceend) )
                    {
                         $queryord->where('name','<=',$sequenceend);
                    }
                        
                    if(isset($enablelatestrecords) && $enablelatestrecords ==  1)
                        if(isset($latestimoveinpaymentid))
                            $queryord->where ('id','>',$latestimoveinpaymentid);
                        
                $ordset = $queryord->get();

                $pid=0;
                foreach($ordset as $ord){
                   $i=1;
                    foreach ($ord->cashs as $line){  
                        $this->processimoveinalbert($ord, $pay_type, $line, $enablecashlinecomment, $enablepaymentcomment, $i);
                    
                        $i++;
                       }
                       foreach ($ord->cheques as $line){  
                        $this->processimoveinalbert($ord, $pay_type, $line, $enablechequelinecomment, $enablepaymentcomment, $i);
                    
                        $i++;
                       }
                       
                    if(isset($pid) && $pid < $ord->id)
                        $pid= $ord->id;
                } 
                if($pid != 0)
                $data['latestimoveinpaymentid'] = $pid;           
            }  
            catch (\Exception $e){

                \Log::warning("moving one ".$e->getMessage());
            }
        }
        
        $this->setLatestids($data); 
        
        return $this->response;          
    }
    
    public function processimoveinalbert($order, $doc_type, $line, $enablelinecomment, $enablecomment, $i,$enablePriceWithoutTaxImovein = 0,$enableImoveinDiscountCombine = 0 ) {
        
        $tax = ($this->tax*100);
         
        $infomod = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();

        if(is_object($infomod))
        { 
            $info_val = json_decode($infomod->value, true);
            if(key_exists('addTaxToImoveinPrice', $info_val))
                $addTaxToImoveinPrice= $info_val["addTaxToImoveinPrice"]; 
            else 
                \Log::info('addTaxToImoveinPrice does not exist in enablemodule');
        }
         
//         $i= 1;
        if(isset($order))
        {
            
            $customer = $this->getCustomerDetails($order->customer_id);
            $product = $this->getProductDetails($line->product_id);
                
            if(isset($line) && $line['quantity'] != 0 && is_object($customer) && !empty($customer->customer_key) && is_object($product))
            {
                                        
                    if(is_object($customer)){                      
                        if(strlen($customer->customer_key) < 15 )
                            echo str_pad(substr(str_pad (iconv('UTF-8','Windows-1255',$customer->customer_key),15, " ",STR_PAD_LEFT),0,15),15," ",STR_PAD_LEFT);
                        else
                            echo str_pad(substr(iconv('UTF-8','Windows-1255',$customer->customer_key),0,15),15," ",STR_PAD_LEFT);
                    }
                    else 
                        echo str_pad("",15," ",STR_PAD_LEFT);
//                    if(is_object($order->customer)){                      
//                        if(strlen($order->customer->customer_key) < 15 )
//                            echo str_pad(substr(str_pad ($order->customer->customer_key,15, " ",STR_PAD_LEFT),0,15),15," ",STR_PAD_LEFT);
//                        else
//                            echo str_pad(substr($order->customer->customer_key,0,15),15," ",STR_PAD_LEFT);
//                    }
//                    else 
//                        echo str_pad("",15," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    echo str_pad(substr($order->name,0,9),9," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    echo str_pad(substr($doc_type,0,2),2," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                     if(is_object($customer)){                      
                        if(strlen($customer->name) < 50 )
                            echo str_pad(substr(str_pad (iconv('UTF-8','Windows-1255',$customer->name),50, " ",STR_PAD_LEFT),0,50),50," ",STR_PAD_LEFT);
                        else
                            echo str_pad(substr(iconv('UTF-8','Windows-1255',$customer->name),0,50),50," ",STR_PAD_LEFT);
                    }
                    else 
                        echo str_pad(" ",50," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                     if(is_object($customer)){                      
                        if(strlen($customer->address()) < 50 )
                            echo str_pad(substr(str_pad (iconv('UTF-8','Windows-1255',$customer->address()),50, " ",STR_PAD_LEFT),0,50),50," ",STR_PAD_LEFT);
                        else
                            echo str_pad(substr(iconv('UTF-8','Windows-1255',$customer->address()),0,50),50," ",STR_PAD_LEFT);
                    }
                    else 
                        echo str_pad("",50," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                     if(is_object($customer)){                      
                        if(strlen($customer->city) < 50 )
                            echo str_pad(substr(str_pad (iconv('UTF-8','Windows-1255',$customer->city),50, " ",STR_PAD_LEFT),0,50),50," ",STR_PAD_LEFT);
                        else
                            echo str_pad(substr(iconv('UTF-8','Windows-1255',$customer->city),0,50),50," ",STR_PAD_LEFT);
                    }
                    else 
                        echo str_pad("",50," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',9," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    
                    
                    
                    
                    echo str_pad(substr(strftime("%d%m%y",strtotime($order->created_at)),0,10),10," ",STR_PAD_LEFT);  //Asmchta2date  
                  
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',10," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    if(is_object($order->agent)){                    
                        if(strlen($order->agent->agent_code) < 9 )
                            echo str_pad(substr(str_pad ($order->agent->agent_code,9," ",STR_PAD_LEFT),0,50),9," ",STR_PAD_LEFT);
                        else
                            echo str_pad(substr($order->agent->agent_code,0,9),9," ",STR_PAD_LEFT);
                    }
                    else 
                        echo str_pad("",9," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    echo str_pad("",9," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    try{
                        if(isset($line['comment'])){                 
                                echo str_pad(substr(str_pad (iconv('UTF-8','Windows-1255',$line['comment']),20, " ",STR_PAD_LEFT),0,20),20," ",STR_PAD_LEFT);                      
                        }
                        else 
                            echo str_pad("",20," ",STR_PAD_LEFT);
                    }catch(\Exception $ex){
                              \Log::warning('Exception occured '.$ex->getMessage().' at '.$ex->getLine());
                           
                        echo str_pad("",20," ",STR_PAD_LEFT);
                    }
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    
                    if(isset($enableImoveinDiscountCombine) && $enableImoveinDiscountCombine ==1){                    
                        if(isset($order->discount)){                 
                            echo str_pad(number_format(substr(sprintf("%01.2f", $order->discount),0,4), 2, '', ''),4," ",STR_PAD_LEFT);                      
                        }
                        else 
                            echo str_pad("",4," ",STR_PAD_LEFT);
                    }else{ 
                        if(isset($order->discount_all)){                 
                        echo str_pad(number_format(substr(sprintf("%01.2f", $order->discount_all),0,4), 2, '', ''),4," ",STR_PAD_LEFT);                      
                        }
                        else 
                            echo str_pad("",4," ",STR_PAD_LEFT);
                    }
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                                   
                    echo str_pad(number_format(substr(sprintf("%01.2f", $tax),0,4), 2, '', ''),4," ",STR_PAD_LEFT);                      
                  
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    echo str_pad(' ',2," ",STR_PAD_LEFT);
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    
                    echo str_pad(' ',4," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    echo str_pad(' ',9," ",STR_PAD_LEFT);
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                   if(!empty($line->product_id)){
//                        if(isset($line->product) && is_object($line->product))
//                            echo str_pad(substr($line->product->item_key,0,20),20," ",STR_PAD_LEFT);
//                        else 
//                            echo str_pad(" ",20," ",STR_PAD_LEFT);
                       
                       $prod = \Model_Products::clearQueryNew()
                               ->where('id',$line->product_id )->get_one();
                       
                        if(isset($prod) && is_object($prod))
                            echo str_pad(substr($prod->item_key,0,20),20," ",STR_PAD_LEFT);
                        else 
                            echo str_pad(" ",20," ",STR_PAD_LEFT);
                   }else
                        echo str_pad(" ",20," ",STR_PAD_LEFT);
                    
                      echo str_pad(' ',1," ",STR_PAD_LEFT);
                      
                    
//                    $mida = is_object($line->product)? $line->product->mida:0;
                    
//                    $mida = floatval($mida);
//                    if($mida ==0) $mida =1;
                    
//                    $total =$line->quantity * $mida;
                    
                    
//                    $total =$line->total_quantity;
                    
//                    if(empty($total))
                        $total =$line->quantity; // * $mida;
//                        $total =$line->quantity * $mida;
                    
                    echo str_pad(number_format(substr(sprintf("%01.3f", $total),0,9), 3, '', ''),9," ",STR_PAD_LEFT);
                   
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    $noprice = 1;
                    
                    if($noprice == 1){
                        
                        echo str_pad(' ',9," ",STR_PAD_LEFT);

                    }else{
                    
                        if(isset($line['price'])){
                            $price = $line['price'];
                            if($enablePriceWithoutTaxImovein == 1){
                                $tax = $tax/100;
                                $divsor = 1+ $tax;
                                $saleprice = $price/$divsor;
                                $price = $saleprice;
                            } 
                            
                            if(isset($addTaxToImoveinPrice) && $addTaxToImoveinPrice == 1){
                                $tax = $tax/100;
                                $divsor = 1+ $tax;
                                $saleprice = $price*$divsor;
                                $price = $saleprice;
                            }
                            
                            echo str_pad(number_format(substr(sprintf("%01.3f", $price),0,10), 3, '', ''),9," ",STR_PAD_LEFT);
                            
                        }else 
                            echo str_pad(number_format(substr(sprintf("%01.3f","0"),0,9), 3, '', ''),9," ",STR_PAD_LEFT);
                    }
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    if(isset($line->product) && is_object($line->product) && isset($line->product->currencycode)){
                         
                        if(isset($order->customer_id) && isset($line->product_id)){
                            try{
                            \Module::load('aabakery');
                            
                            $custprice = \aabakery\Model_Customerpricelists::query()
                                            ->where('customer_id',$order->customer_id)
                                            ->where('product_id',$line->product_id)
                                            ->get_one();
                            
                            }catch(\Exception $ex){
                                \Log::warning('Exception occured '.$ex->getMessage().' at '.$ex->getLine());
                            }
                        }
                        if(isset($custprice) && is_object($custprice) && isset($custprice->currencycode) && !empty($custprice->currencycode))
                            $currency = $custprice->currencycode;
                        else
                             $currency = $line->product->currencycode;
                        
                        echo str_pad(substr(iconv('UTF-8','Windows-1255',$currency),0,4),4," ",STR_PAD_LEFT);
                    }else 
                        echo str_pad(" ",4," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    if(isset($enableImoveinDiscountCombine) && $enableImoveinDiscountCombine ==1){                    
                           
                        if(isset($order->discount_all)){

                            if(isset($line['discount'])){
                                $disc = $order->discount_all+$line['discount'];
                                echo str_pad(number_format(substr(sprintf("%01.2f", $disc),0,4), 2, '', ''),4," ",STR_PAD_LEFT);
                            }else 
                                echo str_pad(number_format(substr(sprintf("%01.2f",$order->discount_all),0,4), 2, '', ''),4," ",STR_PAD_LEFT);
                        }else {
                            if(isset($line['discount'])){

                                if(isset($order->discount_all)){
                                    $disc = $order->discount_all+$line['discount'];
                                    echo str_pad(number_format(substr(sprintf("%01.2f", $disc),0,4), 2, '', ''),4," ",STR_PAD_LEFT);
                                }else 
                                    echo str_pad(number_format(substr(sprintf("%01.2f",$line['discount']),0,4), 2, '', ''),4," ",STR_PAD_LEFT);
                            }else 
                                echo str_pad(number_format(substr(sprintf("%01.2f","0"),0,4), 2, '', ''),4," ",STR_PAD_LEFT);
                        }
                    }else{
                        
                        if(isset($line['discount']))
                            echo str_pad(number_format(substr(sprintf("%01.2f", $line['discount']),0,5), 2, '', ''),4," ",STR_PAD_LEFT);
                        else 
                            echo str_pad(number_format(substr(sprintf("%01.2f","0"),0,5), 2, '', ''),4," ",STR_PAD_LEFT);
                    }
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                     
                    if(isset($line->product) && is_object($line->product) && isset($line->product->currencycode)){
                                
                        if(isset($currency))
                        $exRate = \Model_Exchangerates::query()->where('currencycode',$currency)->get_one();

                        if(isset($exRate) && is_object($exRate))
                                echo str_pad(number_format(substr(sprintf("%01.4f", $exRate->rate),0,9), 4, '', ''),9," ",STR_PAD_LEFT);
                        else
                            echo str_pad(' ',9," ",STR_PAD_LEFT);
                    }else
                        echo str_pad(' ',9," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    if(isset($product) && is_object($product))
                        echo str_pad(substr(iconv('UTF-8','Windows-1255',$product->item_name),0,100),100," ",STR_PAD_LEFT);
                    else 
                        echo str_pad(" ",100," ",STR_PAD_LEFT);
                    
                      echo str_pad(' ',1," ",STR_PAD_LEFT);
                                        
                    echo str_pad(' ',80," ",STR_PAD_LEFT);
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    if(isset($order->comment))
                        echo str_pad(substr(iconv('UTF-8','Windows-1255',$order->comment),0,250),250," ",STR_PAD_LEFT);
                    else 
                        echo str_pad(" ",250," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    echo str_pad(' ',100," ",STR_PAD_LEFT);
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    if(is_object($order->customer) && isset($order->customer->authorized_dealer_id)){         
                        echo str_pad(substr($order->customer->authorized_dealer_id,0,9),9," ",STR_PAD_LEFT);
                       
                    }
                    else 
                        echo str_pad("",9," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',49," ",STR_PAD_LEFT);
                    
                    echo str_pad(' ',1," ",STR_PAD_LEFT);
                    
                    if(isset($line['quantity']))
                        echo str_pad(number_format(substr(sprintf("%01.3f", $line['quantity']),0,10), 3, '', ''),10," ",STR_PAD_LEFT);
                    else 
                        echo str_pad(number_format(substr(sprintf("%01.3f","0"),0,10), 3, '', ''),10," ",STR_PAD_LEFT);
//               
//                    echo str_pad('u',10,"u",STR_PAD_LEFT);
                     
                     echo "\r\n";    
                }

        }
        
    }
    
         
    public function getCustomerDetails($customer_id = null){
        
        if(!empty($customer_id)){
            
            $customer = \Model_Customers::clearQueryNew()->where('id', $customer_id)->get_one();
            
            return $customer;
        }
    }
     
    public function getProductDetails($product_id = null){
        
        if(!empty($product_id)){
            
            $product = \Model_Products::clearQueryNew()->where('id', $product_id)->get_one();
            
            return $product;
        }
    }

}