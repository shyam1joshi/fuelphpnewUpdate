
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
        <count  id ="count" style="display:none">	<?php echo count($object->deliverylines);?>
        </count>
        <?php  echo Fuel\Core\Asset::css('orders/style.css'); ?>
        <?php echo Fuel\Core\Asset::css('orders/print.css'); ?>
              
        <script>
            <?php echo " var tax = {$distroinfo['distrotax']}; " ?>
        </script>
        
        <style>
            
     @media only screen and (min-width: 336px) and (max-width: 720px){
            td input[lower-level="quantity"]{
                    width: 100% !important;
            }
            
            .icon-trash{
                display: block !important;
            }
          


            
            
        }
            
      #header { 
    width: 98%;
      }
      
      input[type="text"], input[type="number"], select { 
    width: 100%;
}

    @media  only screen and (max-width: 815px) and (min-width: 200px){
       .span12 a.btn.productSupplied,.span12 a.btn.productSuppliedRestore{
               display: inherit !important;
            }
            
            /*@media only screen and (max-width: 815px) and (min-width: 620px)*/
            #items td:first-child, #items th:first-child {
                width: 5%;
            }
            #items td:nth-child(2), #items th:nth-child(2) {
                width: 25%;
            }
            #items td:nth-child(4), #items th:nth-child(4) {
                width: 14%;
            }
            #items td:nth-child(5), #items th:nth-child(5) {
                width: 14%;
            }
            #items td:nth-child(8), #items th:nth-child(8) {
                width: 28%;
            }
/*            #items td:first-child, #items th {
                width: 21%;
            }*/
            
}
        </style>
        
</head>

<body>
    
    <?php echo Form::open(array(
        'id' => 'edit_article_form',
        'name' => 'edit_article',
        'enctype'=>"multipart/form-data",
        'method'=>'POST',
        'action'=>$base."/edit/{$object->id}",
        'style' => 'width: 96%;'
        ));?>
        <div id="customer">

            <p id="header"><?php echo \Lang::get('base.deliverys')?\Lang::get('base.deliverys'):"Quote"?></p>
		
<!--            <div id="identity">
                <p id="address"></p>
            </div>
-->            <div id="logo">
            </div>
		
        <!--</div>-->
		
        <div style="clear:both">

        </div>
		
        <div id="customer" style="display:none;">
            <?php echo \Lang::get('label.customers.name')?\Lang::get('label.customers.name'):"label.customers.name";?><br/>
            <input class="popup-autocomplete hidden_customer_id " <?php if(isset($warehouse) && $warehouse == 1){ ?> readonly="readonly" <?php } ?> id="customer_id" map-controller="customers" mapper="name" href="/customers/listkey.json" style="width:200px" id="form_customer_name" name="customer_name" value="<?php if( is_object($object)&& is_object($object->customer)) echo  $object->customer->name; ?>"</input><br/>
            <?php echo \Lang::get('label.customers.customer_key')?\Lang::get('label.customers.customer_key'):"label.customers.customer_key";?><br/>
            <input class="popup-autocomplete hidden_customer_id" id="customer_id" <?php if(isset($warehouse) && $warehouse == 1){ ?> readonly="readonly" <?php } ?>  map-controller="customers" mapper="customer_key" href="/customers/listkey.json" style="width:200px" id="form_customer_key" name="customer_key" value="<?php if( is_object($object)&& is_object($object->customer)) echo  $object->customer->customer_key;?>" />
            <input class="popup-autocomplete updateflag"  map-controller="customers" mapper="customer_key" href="/customers/listkey.json" style="width:200px" id="hidden_customer_id" type="hidden" name="customer_id" value =" <?php if( is_object($object)&& is_object($object->customer)) echo  $object->customer->id;?>"></input><br/>
            <label for='extra4'> <?php echo \Lang::get('label.agents.name')?\Lang::get('label.agents.name'):"Agent Name";?></label>
            <input class="popup-autocomplete hidden_agent_id " id="agent_id" map-controller="agents" mapper="name" <?php if(isset($warehouse) && $warehouse == 1){ ?> readonly="readonly" <?php } ?>  href="/agents/listkey.json" style="width:200px" id="form_agent_name" name="agent_name" value="<?php echo \Input::get("agent_name");?>"></input><br/><br/>

            <input class="popup-autocomplete updateflag"  map-controller="agents" id="hidden_agent_id" type="hidden" name="agent_id" value="<?php echo \Input::get("agent_id");?>">
        </div>
        <div id="customer">
            <?php echo \Lang::get('label.customers.name')?\Lang::get('label.customers.name'):"label.customers.name";?><br/>
            <?php if( is_object($object)&& is_object($object->customer)) echo  $object->customer->name; ?>
           <br/>  <br/> <?php echo \Lang::get('label.customers.customer_key')?\Lang::get('label.customers.customer_key'):"label.customers.customer_key";?><br/>
          
            <?php if( is_object($object)&& is_object($object->customer)) echo  $object->customer->customer_key;?>
            <input class="popup-autocomplete updateflag"  map-controller="customers" mapper="customer_key" href="/customers/listkey.json" style="width:200px" id="hidden_customer_id" type="hidden" name="customer_id" value =" <?php if( is_object($object)&& is_object($object->customer)) echo  $object->customer->id;?>"></input><br/>
<!--            <label for='extra4'> <?php echo \Lang::get('label.agents.name')?\Lang::get('label.agents.name'):"Agent Name";?></label>
            <input class="popup-autocomplete hidden_agent_id " id="agent_id" map-controller="agents" mapper="name" <?php if(isset($warehouse) && $warehouse == 1){ ?> readonly="readonly" <?php } ?>  href="/agents/listkey.json" style="width:200px" id="form_agent_name" name="agent_name" value="<?php echo \Input::get("agent_name");?>"></input><br/><br/>

            <input class="popup-autocomplete updateflag"  map-controller="agents" id="hidden_agent_id" type="hidden" name="agent_id" value="<?php echo \Input::get("agent_id");?>">-->
        </div>
        
           
        <table id="meta">
            <tbody>
                <tr>
                    <td class="meta-head"> <?php echo \Lang::get('base.deliverys')?\Lang::get('base.deliverys'):"INVOICE"; ?></td>
                    <td><?php if( is_object($object)) echo  $object->name;?></td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo \Lang::get("label.orders.created_at")?\Lang::get('label.orders.created_at'):"label.orders.created_at"?></td>
                    <td><?php if( is_object($object)) echo  $object->created_at;  ?></td>                      
                </tr>

            </tbody>
        </table>
        <br/><br/><br/><br/>
        <table id="items">
            <tr id="itemheader">
                  <th></th>
                           <th><?php 
                    echo \Lang::get("label.products.item_name")?\Lang::get('label.products.item_name'):"label.products.item_name";?></th>
                            <th  style="display:none;"><?php 
                    echo \Lang::get("label.products.item_key")?\Lang::get('label.products.item_key'):"label.products.item_key";?></th>
                   
                               <th><?php 
                    echo \Lang::get("label.orderline.original_quantity")?\Lang::get('label.orderline.original_quantity'):"label.orderline.original_quantity";?></th>
                           
                               <th><?php 
                    echo \Lang::get("label.orderline.quantity_new")?\Lang::get('label.orderline.quantity_new'):"label.orderline.quantity_new";?></th>
                           
                             
                               <th   <?php if(isset($warehouse) && $warehouse == 1){ ?> style="display:none;" <?php } ?>  ><?php 
                    echo \Lang::get("label.orderline.price")?\Lang::get('label.orderline.price'):"label.orderline.price";?></th>
                         <?php if(isset($enabledeliverylinediscount) && $enabledeliverylinediscount == 1 ){  ?>
                    <th  <?php if(isset($warehouse) && in_array($warehouse, array('',0))){ ?> style="display:none;" <?php } ?> ><?php 
                    echo \Lang::get("label.orders.discount")?\Lang::get('label.orders.discount'):"label.orderline.discount";?></th>
                            <?php } ?>     <th  <?php if(isset($warehouse) && $warehouse == 1){ ?> style="display:none;" <?php } ?> ><?php 
                    echo \Lang::get("label.orderline.total_amt")?\Lang::get('label.orderline.total_amt'):"label.orderline.total_amt";?></th>
                         <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment== 1 ){ ?>
                               <th ><?php 
                    echo \Lang::get("label.orderline.comment")?\Lang::get('label.orderline.comment'):"remark";?></th>
                     <?php } ?> 
                     <?php if(isset($warehouse) && in_array($warehouse, array('',0))){ ?>  
                    <th  ></th>
                     <?php }else{ ?>
                           <th></th>
                     <?php } ?>
                    
            </tr>
                        
            <?php 
            $count = 0;

            foreach($object->deliverylines as $key=> $line) { 

            ?>
            <tr id="row<?php echo $count;?>" >
                <td><?php if( $line->supplied == 1 ){ ?> <span><i class="icon-ok "></i></span> <?php } ?> </td>
                <td>
                     <input type="hidden"  count="<?php echo $count;?>" name="orderlines_new[<?php echo $count;?>][id]" lower_level="id" value="<?php echo $line->id;?>">


                     <input   class="popup-autocomplete hidden_form_orderlines_new-<?php echo $count;?>-product_id" href="/products/listkey.json" mapper="item_name" style="width:200px; <?php if(isset($warehouse) && $warehouse == 1){ ?> display:none; <?php } ?>" id="form_orderlines_new-<?php echo $count;?>-product_id" lower-level="prodname" map-controller="products" name="orderlines_new[<?php echo $count;?>][prodname]" usekey="product_id"  count="<?php echo $count;?>"  value="<?php echo is_object($line->product)?$line->prodname:'deleted';?>">
                 
                     <?php if(isset($warehouse) && $warehouse == 1){ ?> <?php echo is_object($line->product)?$line->product->item_name:'deleted';?> <?php } ?>
                </td>
                <td style="display:none;">
                     <input   class="popup-autocomplete hidden_form_orderlines_new-<?php echo $count;?>-product_id" href="/products/listkey.json" mapper="item_key" style="width:200px;<?php if(isset($warehouse) && $warehouse == 1){ ?> display:none; <?php } ?>" id="form_orderlines_new-<?php echo $count;?>-product_id" lower-level="product_key" map-controller="products" name="orderlines_new[<?php echo $count;?>][product_key]" usekey="product_id"  value="<?php echo is_object($line->product)?$line->product->item_key:'deleted';?>" count="<?php echo $count;?>" >
                     
                     <?php if(isset($warehouse) && $warehouse == 1){ ?> <?php echo is_object($line->product)?$line->product->item_key:'deleted';?> <?php } ?>
                </td>
                  
                <td><input type="text" id="orderlines_new-<?php echo $count;?>-quantity" class=" " name="orderlines_new[<?php echo $count;?>][original_quantity]" lower-level="quantity" value="<?php echo $line->original_quantity;?>" readonly="readonly" count="<?php echo $count;?>">


                    </td>
               <td><input type="text" id="orderlines_new-<?php echo $count;?>-quantity" class="change_total" name="orderlines_new[<?php echo $count;?>][quantity]" lower-level="quantity" value="<?php echo $line->quantity;?>" count="<?php echo $count;?>">


                    </td>
                 <td  <?php if(isset($warehouse) && $warehouse == 1){ ?> style="display:none;" <?php } ?> >
                    <input type="text" id="orderlines_new-<?php echo $count;?>-price" name="orderlines_new[<?php echo $count;?>][price]" lower-level="price" value="<?php echo $line->price; ?>" mapper="sale_price" count="<?php echo $count;?>"  class="change_price hidden_form_orderlines_new-<?php echo $count;?>-product_id"></td>


                  <?php if(isset($enabledeliverylinediscount) && $enabledeliverylinediscount == 1 ){ ?>
                   <td  <?php if(isset($warehouse) && $warehouse == 1){ ?> style="display:none;" <?php } ?> > 
                        <input type="text" id="orderlines_new-<?php echo $count;?>-discount" name="orderlines_new[<?php echo $count;?>][discount]" lower-level="discount" value="<?php echo $line->discount; ?>"  count="<?php echo $count;?>"  class="change_discount hidden_form_orderlines_new-<?php echo $count;?>-discount">
         
                    </td>
                    <?php } ?>     
<?php if(isset($enableTaxPerProduct) && $enableTaxPerProduct == 1 ){ ?>
                   
                        <input type="hidden" id="orderlines_new-<?php echo $count;?>-untaxed" name="orderlines_new[<?php echo $count;?>][untaxed]" lower-level="untaxed" value="<?php echo $line->product?$line->product->untaxed:0; ?>"  count="<?php echo $count;?>"  class="hidden_form_orderlines_new-<?php echo $count;?>-untaxed">
         
                     
                    <?php } ?>  
                <td  <?php if(isset($warehouse) && $warehouse == 1){ ?> style="display:none;" <?php } ?> >
                    <input type="text" id="orderlines_new-<?php echo $count;?>-total_amt" class="add_to_total" name="orderlines_new[<?php echo $count;?>][total_amt]" lower-level="total_amt" value="<?php  echo $line->total_amt;?>" count="<?php echo $count;?>">

                    </td>
                 <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment== 1 ){ ?>
                <td >
                    <input type="text"   id="orderlines_new-<?php echo $count;?>-comment"  name="orderlines_new[<?php echo $count;?>][comment]" lower-level="comment" value="<?php echo $line->comment;?>" count="<?php echo $count;?>">

                    </td>
                <?php } ?>  
                    
                    <?php if(isset($warehouse) && in_array($warehouse, array('',0))){ ?>  
                <td >
                    <a   id="orderlines_new-<?php echo $count;?>-delete"  name="orderlines_new[<?php echo $count;?>][delete]" lower-level="delete" class="delete_line" href="" onclick="return false;" count="<?php echo $count;?>"><i class="icon-trash" title="Delete"></i></a>
                </td>  
                    <?php }else{ ?>
                <td >
                    <input   type="hidden"    name="orderlines_new[<?php echo $count;?>][supplied]" value="<?php echo  $line->supplied; ?>" count="<?php echo $count;?>"  >
                    <a class="btn <?php if( $line->supplied == 1 ){ ?>  btn-success  productSuppliedRestore  <?php }else{ ?> btn-danger productSupplied <?php } ?>" count="<?php echo $count;?>" > <?php if( $line->supplied == 1 ){ ?> המוצר לא סופק  <?php }else{ ?> המוצר סופק <?php } ?></a></td>
                    
                    <?php } ?> 
                <div style="display: none;"><input class="updateflag" type="hidden" href="/products/listkey.json" mapper="item_key" style="width:200px" id="hidden_form_orderlines_new-<?php echo $count;?>-product_id" lower-level="product_id" map-controller="products" name="orderlines_new[<?php echo $count;?>][product_id]" key="product_id" value="<?php echo is_object($line->product)?$line->product->id:'deleted';?>" count="<?php echo $count;?>" hidden_id="orderlines_new-1-product_id"></div>
            </tr>
            <?php

            $count ++;

            }?>
            <?php if(isset($warehouse) && in_array($warehouse, array('',0))){ ?>  
            <tr><td colspan="7"> <a id="additem"><?php echo \Lang::get('message.additem')?\Lang::get('message.additem'):"Add item"; ?></a></td></tr>
            <?php } ?>
        </table>
        
        
         <div  id='items' style="border:none; margin-top: auto;  <?php if(isset($warehouse) && $warehouse == 1){ ?>  display:none; <?php } ?> " >   
             <?php if(isset($motekExtrafields) && $motekExtrafields == 1){ ?>
                <div class="span6" style="display: inline-flex;margin-top: 70px;">
                    <div class="span5">
                        <label><?php echo \Lang::get('label.customers.last_visit_date')?\Lang::get('label.customers.last_visit_date'):"label.customers.last_visit_date";?></label>
                        <input type="date"  name="last_visit_date" value="<?php if( is_object($object) && isset($object->last_visit_date)) echo  $object->last_visit_date; ?>" style="width: 192px;height: 30px;" />
                    </div>
                    <div class="span5">
                        <label><?php echo \Lang::get('label.customers.last_order_by_phone')?\Lang::get('label.customers.last_order_by_phone'):"label.customers.last_order_by_phone";?></label>
                        <input type="date"  name="last_order_by_phone" style="width: 192px;" value="<?php if( is_object($object) && isset($object->last_order_by_phone)) echo  $object->last_order_by_phone; ?>"/>
                    </div>
                </div>    
            <?php } ?>      
            <table id="meta" style="  float: left;">
                <tbody>
                    <?php if(isset($enableQuoteDiscount) && $enableQuoteDiscount == 1){ ?>
                    <tr>
                        <td class="meta-head">
                            <?php echo \Lang::get('label.orders.discount')?\Lang::get('label.orders.discount'):"label.orders.discount";?>
                        </td>
                        <td>
                            <input type="text" id="form_discount_all" class="calculate_discount_all" style="width: 192px;" value="<?php if( is_object($object)) echo  $object->discount_all; ?>" name="discount_all">
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="meta-head"><?php echo \Lang::get("label.orders.amount_totalbeforetax")?\Lang::get('label.orders.amount_totalbeforetax'):"label.orders.amount_totalbeforetax";?></td>
                        <td> <input id="form_amount_totalbeforetax" style="width: 192px;" value="<?php if( is_object($object)) echo  $object->amount_totalbeforetax; ?>" name="amount_totalbeforetax" ></div></td>
                    </tr>
                    <tr>
                        <td class="meta-head"><?php echo \Lang::get("label.orders.amount_total")?\Lang::get('label.orders.amount_total'):"label.orders.amount_total";?></td>
                        <td><input name="amount_total" id="amount_total" style="width: 192px;" value="<?php if( is_object($object)) echo  $object->amount_total; ?>" ></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="clear:both;"></div> 
          <?php if(isset($enableTaxPerCustomer) && $enableTaxPerCustomer == 1 ){ ?>
            <div style="display: -webkit-box;float: left;padding: 10px;  margin-top: 5.3%;">
                <input type="checkbox" id="form_no_tax" name="untaxed" value="1"<?php if( is_object($object) && isset($object->untaxed) && $object->untaxed == 1) echo "checked"  ?> style="  width: 18px;height: 17px;">  
                <label style="padding-right: 8px; font-size: 15px;">
                    <?php echo \Lang::get('label.orders.no_tax')?\Lang::get('label.orders.no_tax'):"no Tax"; ?>
                </label>
            </div>
     <?php } ?>
        <br/><br/><br/><br/>
        <?php if(isset($enableviewdeliverycomments) && $enableviewdeliverycomments== 1 ){ ?>
            <hr style="  border-top: 1px solid #000; border-bottom: 1px solid #000;">
            <div style="/*float:right;  padding-top: 3%;*/">
                <label for="extra4"><?php echo \Lang::get('label.orders.comment')?\Lang::get('label.orders.comment'):"Comment";?></label>
                <textarea name="comment" id="comment" style="border: 1px solid;background: none; width:100%;" rows="5" ><?php if(isset($object->comment)) echo $object->comment; ?></textarea>
            </div>    
        <?php } ?>
        <input type="submit" value="<?php echo \Lang::get('message.save')?\Lang::get('message.save'):'שמור'; ?>" class="btn btn-primary" id="form_submit" name="submit">   
  </div>    <?php echo Form::close(); ?>
          
        
        
        
        <div id="tr_info" style="display:none">
            <td>&nbsp;<input class="popup-autocomplete" href="/products/listkey.json" mapper="item_name" style="width:200px" id="form_orderlines_new-0-product_name" lower-level="prodname" map-controller="products" name="orderlines_new" usekey ="product_id"></input>  </td>
            <td>
                <input class="popup-autocomplete" href="/products/listkey.json" mapper="item_key" style="width:200px" id="form_orderlines_new-0-product_key" lower-level="product_key" map-controller="products" name="orderlines_new" usekey ="product_id"> </input>



                </input>
            </td>
           <?php if(isset($enablecategories) && $enablecategories== 1 ){ ?>
            <td>&nbsp;<input  type='text' mapper="categories" style="width:200px" id="form_orderlines_new-0-categories" lower-level="categories" name="orderlines_new" value=''></input>  </td>
            <?php } ?> 

            <!--<td>&nbsp;<input type="text" id="form_orderlines_new-0-price"  name="orderlines_new" mapper="sale_price" lower-level="price" value=""> </td>-->
            <td>&nbsp;<input type="text" id="form_orderlines_new-0-quantity" class="change_total" name="orderlines_new" lower-level="quantity" value=""> </td>
         
 <?php if(isset($enableTaxPerProduct) && $enableTaxPerProduct == 1){ ?>
                    <td>  <input type="hidden" id="form_orderlines_new-0-untaxed"  name="orderlines_new" mapper="untaxed" lower-level="untaxed" value=""></td>
              
                    <?php }  ?>
   <?php if(isset($enablepriceedit) && $enablepriceedit == 1){ ?>
            <td>&nbsp;<input type="text" id="form_orderlines_new-0-price"  name="orderlines_new" class="change_price" mapper="sale_price" lower-level="price" value=""> </td>
            <?php }else{ ?>
            <td>&nbsp;<input type="text" id="form_orderlines_new-0-price"  name="orderlines_new" mapper="sale_price" lower-level="price" value=""> </td>
            <?php } ?>
                 <?php if(isset($enabledeliverylinediscount) && $enabledeliverylinediscount == 1 ){ ?>
                             <td>&nbsp;<input type="text" id="form_orderlines_new-0-discount"  name="orderlines_new" class="change_discount"  mapper="discount" lower-level="discount" value=""> </td>
                <?php } ?>
            <td>&nbsp;<input type="text" id="form_orderlines_new-0-total_amt" class="add_to_total" name="orderlines_new" lower-level="total_amt" value=""> </td>
             <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment== 1 ){ ?>

            <td>&nbsp;<input type="text" id="form_orderlines_new-0-comment"  style="width:200px" name="orderlines_new" lower-level="comment" value="" /> </td>
            <?php } ?> 

            <td>
            <td>
                <a id="form_orderlines_new-0-delete" lower-level="delete"  name="delete"  href="" onclick="return false;" class="delete_line"><i class="icon-trash" title="Delete"></i></a>
            </td>
                        
            <input class="updateflag" type="hidden" href="/products/listkey.json" mapper="item_key" style="width:200px" id="hidden_form_orderlines_new-0-product_id" lower-level="product_id" map-controller="products" name="orderlines_new" key="product_id"></td>
            <td><?php echo \Lang::get('message.remove')?\Lang::get('message.remove'):"remove"; ?></td>
        </div>
                            

 <?php echo Asset::js('jquery-1.9.1.min.js'); ?>  
  <script>
   
 
 
function productSupplied(){
    $(this).addClass('productSuppliedRestore');
    $(this).addClass('btn-success');
    $(this).removeClass('productSupplied');
    var count = $(this).attr('count');
     
    
    $('input[name="orderlines_new['+count+'][supplied]"]').val(1);
    $(this).text('המוצר לא סופק');
    var tr = $(this).parent().parent();
    
    tr.children('td:first-child span').remove();
    tr.children('td:first-child').append("<span><i class='icon-ok '></i></span>");
    
    $(this).parent().parent().parent().children('.quantotal').before(tr);
}

function productSuppliedRestore(){
    
    $(this).removeClass('btn-success');
    $(this).removeClass('productSuppliedRestore');
    $(this).addClass('btn-danger');
    $(this).addClass('productSupplied');
    
    $(this).text('המוצר סופק');
    var tr = $(this).parent().parent();
    console.log(tr);
 
    var count = $(this).attr('count');
    
    $('input[name="orderlines_new['+count+'][supplied]"]').val(0);
    
    var lineid = tr.attr('line-id');
    var linenum = parseInt(lineid) + 1;
    var linenumminus = parseInt(lineid) - 1;
    var lines =$(this).parent().parent().parent().children('.line');
     
    if($('#quoteline-'+linenum).val() == undefined){
           tr.children('td:first-child').text('');
    }else{ 
        if($('#quoteline-'+linenum).val() != undefined){
            tr.children('td:first-child').text('');
            $('#quoteline-'+linenum).before(tr);
    
        }else{
            if($('#quoteline-'+linenumminus).val() != undefined){
                tr.children('td:first-child').text('');
                $('#quoteline-'+linenum).after(tr);
            }

        }
    }
    
//    for(var i= 0; i< lines.length; i++ ){
//        
//        var linetr = $(lines[i]);
//        
//        var lid= lines.attr('line-id');
//        
//        if(lid < lineid){
//            linetr.after(tr);
////            return;
//        }else{
//            linetr.before(tr);
////            return;
//        }
//    }
    
//    $(this).parent().parent().parent().children('.quantotal').before(tr);
}
 

function scrollPage(){
    var y = $(this).offset();  //your current y position on the page
    console.log(y.top);
    $(window).scrollTop(y.top-90);
}



    $(document).ready(function(){
$('body').on('click','input[lower-level="prodname"]',scrollPage);
$('body').on('click','input[lower-level="product_key"]',scrollPage);
$('body').on('click','.productSupplied',productSupplied);
$('body').on('click','.productSuppliedRestore',productSuppliedRestore);
    });
     </script>
