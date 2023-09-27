<?php echo Fuel\Core\Asset::css('orders/style.css'); ?>
        <?php echo Fuel\Core\Asset::css('orders/print.css'); ?>

<!-- <head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
	
    
      
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>
        >
</head> -->

<!-- <body> -->
<script>
            var count = <?php echo count($order->deliverylines);?>
            </script>
              <style>
                body{
                    font-family: 'Open Sans', sans-serif;
                }
      #header { 
    width: 98%;
      }
      
      input[type="text"], input[type="number"], select { 
    width: 100%;
}

@media only screen and (max-width: 815px) and (min-width: 200px){
 a.btn.btn-danger.productSuppliedRestore,
 a.btn.btn-danger.productSupplied{
    display: inherit !important;
}
}
            </style>
    <div id="img-div"   style="float:left;">
        <?php if(file_exists('assets/img/haofeorders/logo.png')){ ?>
            <?php echo \Asset::img('haofeorders/logo.png', array('id' => 'logo', 'alt'=>"img", 'style'=>'margin: -80px 0px; height: 100px; width: 300px;display: none;')); ?>
        <?php } ?>
    </div>
	<div id="customer">

		<p id="header"><?php echo \Lang::get('base.deliverys')?\Lang::get('base.deliverys'):"Quote"?></p>
		
		<div id="identity">
                </div>
		
		<div style="clear:both"></div>
		
		<!--<div id="customer">-->
                    

            <?php 
            if(isset($order) && isset($order->customer) && is_object($order->customer)){
            echo $order->customer->name."<br>";
            echo $order->customer->customer_key."<br>";
            }
            
        if(isset($order) && isset($order->agent) && is_object($order->agent)){
        echo $order->agent->name."<br>";
        echo $order->agent->agent_code."<br>";
        }

        
            ?>
                <!--</div>-->
                    <br>
                    <br>
                    
                     <!--<p id="address"><?php //  if(isset($order) && isset($order->customer) && is_object($order->customer) && method_exists($order->customer, 'address')) echo $order->customer->address(); ?></p>-->
                     <table><tr><td id="address" style="float: none;border: none;  height: auto;  "><?php  if(isset($order) && isset($order->customer) && is_object($order->customer) && method_exists($order->customer, 'address')) echo $order->customer->address(); ?></td></tr></table>

<table id="meta" class="meta-order-total" style="  margin: 0px 0px 30px 0; width: 350px;">
            <tbody>
                <tr>
                    <td class="meta-head"> 
                         <?php if(isset($order->printcopyweb) && $order->printcopyweb != 1 ){ ?>
                        <?php echo \Lang::get("base.deliverys")?\Lang::get("base.deliverys"):"Invoice"?>
                        <?php }else{ ?>
                        <?php echo \Lang::get("base.deliverys")?\Lang::get("base.deliverys"):"עותק חשבונית"?>
                        <?php }  ?>

                    </td>    
                    <td>
                        <?php echo $order->name; ?>
                    </td>            
                </tr>
                <tr>
                    <td class="meta-head">
                        <?php echo \Lang::get("label.orders.created_at")?\Lang::get('label.orders.created_at'):"label.orders.created_at"?>
                    </td>
                    <td>
                        <?php echo $order->created_at; ?>
                    </td>
                </tr>
                    <tr>
                        <td class="meta-head">
                            מטבע
                        </td>
                        <td>
                            ש"ח
                        </td>
                    </tr>
                

            </tbody>
</table>
                    <br/><br/><br/><br/>
                    <table id="items" class="btn items-orderlines" style="display:inline-table; padding: 0px;">
                        <tr id="itemheader">
                          
                               <th><?php 
                    echo \Lang::get("label.products.item_name")?\Lang::get('label.products.item_name'):"label.products.item_name";?></th>
<!--                            <th><?php 
                    echo \Lang::get("label.products.item_key")?\Lang::get('label.products.item_key'):"label.products.item_key";?></th>-->
               
                                    <th><?php 
                    echo \Lang::get("label.orderline.original_quantity")?\Lang::get('label.orderline.original_quantity'):"label.orderline.original_quantity";?></th>
                            
                               <th><?php 
                    echo \Lang::get("label.orderline.quantity_new")?\Lang::get('label.orderline.quantity_new'):"label.orderline.quantity_new";?></th>
                           <?php 
                                 
                                 $name = \Auth::get_user_id(); 
                                         
                                        $user = \Model_User::query()->where(array(
                                                       array("id","=",$name[1]),
                                                       ))->get_one();
                                        if(is_object($user) && $user->clearance == 7 ){
                                        ?>
                                    <th><?php 
                    echo \Lang::get("label.orderline.price")?\Lang::get('label.orderline.price'):"label.orderline.price";?></th>
                                        <?php } ?>     
                  <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment== 1 ){ ?>
                               <th ><?php 
                    echo \Lang::get("label.orderline.comment")?\Lang::get('label.orderline.comment'):"remark";?></th>
                     <?php } ?>
                        
                    </tr>
<tr class="item-row"><?php 

if(is_array($order->deliverylines) and !empty($order->deliverylines))
    foreach($order->deliverylines as $orderline){
?>
<tr>
    
                    <td>
                    <?php  
                    
                    
//                    echo is_object($orderline->product)? $orderline->product->item_name:"deleted";
                    $prod  = \Model_Products::clearQueryNew()->where('id', $orderline->product_id)->get_one();
                    if(is_object($prod)){
                        
                        echo $prod->item_name;
                    }
                            
                    
                    
                    ?>
                    </td>
<!--                    <td>
                    <?php // echo is_object($orderline->product)? $orderline->product->item_key:"deleted";?>
                    </td>-->
                    <td>
                    <?php  echo $orderline->original_quantity;?>
                    </td>
                    <td>
                    <?php  echo $orderline->quantity;?>
                    </td>
                      <?php 
                                 
                                 $name = \Auth::get_user_id(); 
                                         
                                        $user = \Model_User::query()->where(array(
                                                       array("id","=",$name[1]),
                                                       ))->get_one();
                                        if(is_object($user) && $user->clearance == 7 ){
                                        ?>
                                <td >
                    <?php  echo $orderline->price; ?>
                    </td>   
                                            
                                <?php } ?>
                    <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment == 1 ){ ?>
                   <td >
                    <?php  echo $orderline->comment;?>
                    </td>
                    <?php } ?>
                     </tr> 
                        
                    

<?php 
    }
    ?>
</tr>

                        </table>
       <?php 
                                 
                                 $name = \Auth::get_user_id(); 
                                         
                                        $user = \Model_User::query()->where(array(
                                                       array("id","=",$name[1]),
                                                       ))->get_one();
                                        if(is_object($user) && $user->clearance == 7 ){
                                        ?>    
                    <table id="meta" style="  float: left;" class="order_total">
            <tbody>
               <tr>
                    <td class="meta-head">
                        <?php echo \Lang::get("label.orders.amount_totalbeforetax")?\Lang::get('label.orders.amount_totalbeforetax'):"label.orders.amount_totalbeforetax";?>
                    </td>
                    <td style="  text-align: center;width: 155px; ">
                        <div class="due" style="display: inline;">
                            <?php echo $order->amount_totalbeforetax; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="meta-head">
                        <?php echo \Lang::get("label.orders.amount_total")?\Lang::get('label.orders.amount_total'):"label.orders.amount_total";?>
                    </td>
                    <td style="  text-align: center;width: 155px; ">
                        <div class="due" style="display: inline;">
                            <?php echo $order->amount_total; ?>
                        </div>
                    </td>
                </tr>

            </tbody>
</table>

                    
          <?php } ?>
                        <br/><br/>
                            
          <?php if(isset($order->comment) || isset($order->supplydate)) { ?>
        
          <?php if(isset($order->comment) ) { ?>
 <div style="padding-bottom: 2%;/*float:right;  padding-top: 3%;*/margin-top: 16%;" >
        <hr style="  border-top: 1px solid #000; border-bottom: 1px solid #000;">
        <label for="extra4"><?php echo \Lang::get('label.orders.comment')?\Lang::get('label.orders.comment'):"Comment";?></label>
        <?php if(!empty($order->comment)) { ?><table><tr><td style="padding: 15px; border: none;"><?php echo $order->comment; ?></td></tr></table>
        
          <?php } ?>
 </div> 
          <?php } ?>
         
          <?php } ?>
          <?php if(isset($order->syncdate)) { ?> <div style="padding-bottom: 2%;/*float:right;  padding-top: 3%;*/">

      
          </div> 
          <?php } ?>
                    
                    
  	     
                </div>               
<?php if(!$order->confirm){ ?> 

<!--    <a  class="btn btn-success "  href="<?php echo "/haofeorders/$model/confirm/".$order->id;?>"><?php
    echo \Lang::get("message.confirm")?\Lang::get("message.confirm"):"message.confirm";
    ?></a>-->

<?php }else{   ?>
    <a class="btn btn-success " style="  display: inherit!important;  padding: 8px 20px;
    width: 30%;" href="/haofeorders/deliverys/exportDocumentToPdf/<?php echo $order->id ?>">הדפס</a> 
<!-- <?php   if(isset($order->printcopyweb) && $order->printcopyweb == 1 ){ ?>
        <input type="hidden" value="העתק הזמנות‎"  name="invoice_copy" id="invoice_copy" /> 
        <a class="btn" onclick="printX()" ><?php echo \Lang::get('message.print')?\Lang::get('message.print'):'Print'; ?></a>

<?php }else{ ?>
         <input type="hidden" value="העתק הזמנות‎"  name="invoice_copy" id="invoice_copy" /> 
        <a class="btn" id="print-click" onclick="printX()" ><?php echo \Lang::get('message.print')?\Lang::get('message.print'):'Print'; ?></a>
        <script>
        
        function setPrint(){
               $.post("/haofeorders/deliverys/setjsonprintcopy/<?php echo $order->id ?>",{"printcopyweb":"1"},function(e)
               { console.log(e);
                   $('#invoice_copy').val('העתק הזמנות‎');
                    createCopy();
                });
        }
        
        function createCopy(){
                var textnew = $('#invoice_copy').val();

                    $('.row-fluid div h1').text(textnew);
                     if($('.items-orderlines tr').length < 3)
                    {
                       $('.items-orderlines').hide();
                   }

                    if($('.items-cashs tr').length < 3)
                        $('.items-cashs').hide();

                    if($('.items-creditcards tr').length < 3)
                        $('.items-creditcards').hide();

                    if($('.items-cheques tr').length < 3)
                        $('.items-cheques').hide();

                    if(parseFloat($('.items-pay-total td').text()) === parseFloat("0"))
                    {   $('.items-pay-total').hide();
                        $('.items-pay-total').parent().hide();
                    }
                    if(parseFloat($('.meta-orderline-total td .due').text()) === parseFloat("0"))
                    {   $('.meta-orderline-total').hide();
                        $('.meta-orderline-total').parent().hide();
                    }
                    $('.meta-orderline-total').parent().attr("style","border:none;  padding: 0%!important;margin-top: auto;");

            }
        </script> -->
<?php }} ?>
                           
               
     
   <script>
     function printX(){
         print();
         try {
            setPrint();
        }
        catch(err)
        {
            console.log('error : '+err);
        }


 }
 
  
     </script>
     <style>
         
        
        @media print{
            body{
                font-size: 8px !important;
            }
              #customer {
                   font-size: large !important;
                   margin-bottom: -5%;
             }
             #page-wrap {
                 width:640px;
             }
             .navbar, footer p, #syncdate-div, a.btn{
                 display: none;
             }
             
          #img-div img{
              display: block !important;
                 margin-top: -127px  !important;
             }             
                hr{
                   margin-top: 56px;
             }
                h1{
                    font-size: 28.5px;
             }
             
             .meta-order-total{
                   margin: -85px 0 0 0 !important;
                 float: left !important;
             }
             #header{
                 display: none;
             }
             table td, table th{
                    padding: 0px 5px 0px 5px;
             }
             
             .items-orderlines{
                   margin: 18px 0px 10px 0!important;
             }
             .items-cashs{
                 margin: 5px 0 0 0 !important;
             }
             .items-creditcards,.items-cheques{
                   margin: 0px !important;
             }
             .items-pay-total{
                 margin-bottom: 2%;
             }
             .orderline-prodname{
                   text-align: right;
             }
            @page {
                    margin-bottom: 0.5cm;   
                    margin-top: 0.5cm;                      
                  }
                  
            table { page-break-inside:avoid;
                    empty-cells: hide; }
            
         }
         
         @media only screen and (max-width: 815px) and (min-width: 200px){
            .span12 a.btn {
                display: initial !important;
            }
        }
         
         </style>
      
        <?php
/*  











1. Order info 
    Invoiced to     
    Invoiced date
    Invoiced amount
    Invoiced tax
    
   Details
       Foreach Child
        1. Product info
        2. Discription
        3. Rate
        4. QUantities
        5. total_amt (Derived not needed per say)


<?php echo Html::anchor('receipts/edit/'.$receipt->id, 'Edit'); ?> |
<?php echo Html::anchor('receipts', 'Back'); ?>
                     * 
                     * 
                     */