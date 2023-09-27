

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Editable Invoice</title>

    <style>
        body{
            font-family: 'Open Sans', sans-serif;
             font-size: 8px !important;
        }

        table tr td,table tr th{
            border: 1px solid black;
            padding:30px 0px !important; 
        }
    </style>
</head>

<body>

<!--    <table cellpadding="5" style="border:none;"  >
        <tr style="border:none;">
            <td style="border:none;"> <div id="img-div"   style="margin-right:0;">
        <?php  if(file_exists('assets/img/haofe/logo.jpg')){ ?>
            <?php echo \Asset::img('haofe/logo.jpg', array('id' => 'logo', 'alt'=>"img", 'style'=>'margin: -80px 0px; height: 180px; width: 656px;')); ?>
        <?php } ?>
         
    </div> </td>
            <td style="border:none;">
            </td>
        </tr>
    </table> -->
    <!--<label style="text-align:right; text-decoration: underline; font-size: 16px;font-weight: bold;">מקור</label>-->
    <br/>
    <div id="page-wrap-x">
<!--        <table style="width:100%;border:none" >
            <tr style="border:none">
                <td style="background-color: black;text-align:center;font-size: 15px;color: white; letter-spacing: 10px; font-weight:bold;border:none">
                <td> 
                    <?php 

                    if(isset($order->title) && !empty($order->title)){
                        echo $order->title;
                    }else{
                        if($order->document_type == 7)
                            echo \Lang::get('message.receiptinvoice')?\Lang::get('message.receiptinvoice'):"receiptinvoices";
                        if($order->document_type == 6)
                            echo \Lang::get('menu.orders')?\Lang::get('menu.orders'):"orders";
                        if($order->document_type == 9)
                            echo \Lang::get('menu.quotes')?\Lang::get('menu.quotes'):"הזמנה";
                        if($order->document_type == 8)
                            echo \Lang::get('menu.payments')?\Lang::get('menu.payments'):"payments";
                        if($order->document_type == 5)
                            echo \Lang::get('menu.deliverys')?\Lang::get('menu.deliverys'):"deliverys";
                    }
                ?>
                </td>
            </tr>
        </table>-->
        <br/>
        <br/>
        
        
        <table>
            <tr>
                <td style="border:none;">
                       <table id="meta" cellpadding="4"  class="meta-order-total" style="float:right;display:block; width:100%;font-size: 12px; text-align: right;border:none">
                <tbody>
                    <tr style="border:none;">                    
                        <td style="border:none;">
                            <?php 
                                echo " ".$order->name;
                            ?>
                        </td>
                        <td class="meta-head" style="font-weight:bold;padding:30px 0px !important;border:none;"> 
                            <?php 
                            if($order->document_type == 7)
                                echo \Lang::get('message.receiptinvoicecopy')?\Lang::get('message.receiptinvoicecopy'):"message.receiptinvoicecopy";
                            if($order->document_type == 6)
                                echo \Lang::get('message.Invoicecopyx')?\Lang::get('message.Invoicecopyx'):"מספר חשבונית";
                            if($order->document_type == 9)
                                echo \Lang::get('message.Quotecopy')?\Lang::get('message.Quotecopy'):"הזמנה";
                            if($order->document_type == 8)
                                echo \Lang::get('message.Receiptcopy')?\Lang::get('message.Receiptcopy'):"message.Receiptcopy";
                            if($order->document_type == 5)
                                echo \Lang::get('message.Deliverycopy')?\Lang::get('message.Deliverycopy'):"מספר תעודה";
                            if($order->document_type == 3)
                                echo \Lang::get('menu.customerbalances')?\Lang::get('menu.customerbalances'):'שינוי יתרה ידני';  ?>

                        </td>
                    </tr>
                    <tr style="border:none;">
                        <td style="border:none;">
                            <?php if(!is_null($order->created_at)) echo date('d-m-Y H:i:s', strtotime($order->created_at)); ?>
                        </td>  
                        <td class="meta-head"  style="font-weight:bold; border:none;">
                            <?php echo \Lang::get("label.orders.created_at")?\Lang::get('label.orders.created_at'):"Created at"?>
                        </td>                   
                    </tr>
                     <tr style="border:none;">
                            <td style="border:none;">
                                  ש"ח
                            </td >
                            <td class="meta-head" style="text-align: right;  font-weight:bold;border:none;">
                                מטבע
                            </td>
                    </tr>
                </tbody>
            </table>
                </td>
                <td style="border:none;">
                </td>
                <td style="border:none;">
                    <div id="customer"  style="font-size: 13px;text-align: right;" >
            מספר לקוח : <?php 

                 if(isset($order) && isset($order->customer) && is_object($order->customer)){
                        echo $order->customer->customer_key."<br>"; 
                } 
            ?> 
            <?php 

                 if(isset($order) && isset($order->customer) && is_object($order->customer)){
                        echo $order->customer->name."<br>"; 
                } 
            ?> 
                    
                    <?php  if(isset($order) && isset($order->customer) && is_object($order->customer) && method_exists($order->customer, 'address') && !empty($order->customer->address())){ ?>
        <table><tr><td id="address" style="float: none;border: none;  height: auto;font-size: 12px;text-align: right;" >&nbsp;&nbsp;&nbsp;<?php  if(isset($order) && isset($order->customer) && is_object($order->customer) && method_exists($order->customer, 'address')) echo $order->customer->address(); ?></td></tr></table>
           <?php   } 
            ?> 
            <?php  
              if(isset($order) && isset($order->customer) && is_object($order->customer)){
                  echo "<br>";    
                  echo "מספר עוסק:"; 
                        echo $order->customer->authorized_dealer_id."<br>";
                        echo "<br>";
                }

                if(isset($order) && isset($order->agent) && is_object($order->agent)){
                echo $order->agent->name."<br>";
                echo $order->agent->agent_code."<br>";
                }
            ?>
            
        </div>
                    
                </td>
            </tr>
        </table>
        
        
    </div>
    <?php $i=1; ?>
    <?php if($order->document_type != 8 && $order->document_type != 3) {  ?>

        <table nobr="true" id="items" cellpadding="4"  class="items-orderlines" style="display:inline-table; margin: 18px 0px 30px 0;font-size: 13px; text-align: right;border:none">
           <tr  id="itemheader" style="border:none">
                   <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment == 1 ){ ?>
               <th  style="font-weight:bold;border:none"><?php 
                   echo \Lang::get("label.orderline.comment")?\Lang::get('label.orderline.comment'):"label.orderline.comment";?></th>
               <?php } ?>
                <th style="font-weight:bold; border:none"><?php 
                   echo \Lang::get("label.orderline.quantity_new")?\Lang::get('label.orderline.quantity_new'):"label.orderline.quantity";?></th>
                <th style="font-weight:bold; border:none"><?php 
                   echo \Lang::get("label.orderline.original_quantity")?\Lang::get('label.orderline.original_quantity'):"label.orderline.quantity";?></th>
                <th style="font-weight:bold;border:none"><?php 
                   echo \Lang::get("label.products.item_name")?\Lang::get('label.products.item_name'):"label.products.item_name";?></th>
                     
           </tr>
           <hr>  

           <?php  
           
           
$total =0;
           if(is_array($order->orderlines) and !empty($order->orderlines))
                   foreach($order->orderlines as $orderline){   
               ?>
           <tr style="<?php if($i%2 != 0){ ?>background-color: #dedddd;<?php } ?>;text-align:right;border:none">
                <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment == 1 ){ ?>
               <td style="border:none">
               <?php if(isset($orderline->comment))  echo $orderline->comment;?>
                   
               </td>
               
               <?php } ?>
                
               <td style="border:none">
               <?php  echo floatval($orderline->quantity); ?>
               </td>
               <td style="border:none">
               <?php  echo floatval($orderline->original_quantity); ?>
               </td>
               <td style="border:none">
               <?php   echo is_object($orderline->product)? $orderline->product->item_name:"deleted";?>
               </td>
              
           </tr> 
           <?php  $i++;   } ?>

       </table>
        <br/>
        <br/>
 
    <?php } ?>  
 
    <br>
    <br>
    <br>
    <br>
    <div style="margin-bottom: 60px;"></div>
    <?php if(isset($order->comment) && !empty($order->comment) ) {  ?>
       <!--<hr style="  border-top: 1px solid #000; border-bottom: 2px solid #000;">-->        
       <div style="padding-bottom: 2%;text-align: right;font-size: 12px;">
           <label for="extra4" style="font-weight:bold;"><?php echo \Lang::get('label.orders.comment')?\Lang::get('label.orders.comment'):"Comment";?></label>
           <br/>
           <br/>
           <?php if(!empty($order->comment)) { ?>
               <table style="width:100%"><tr><td style="padding: 15px; border: none;"><?php echo $order->comment; ?></td></tr></table>
           <?php } ?>
       </div> 

   <?php }   ?>
       <br/>
 <style>
       
    body{
        font-size: 13px !important;
    }
</style>
        

</body>
  