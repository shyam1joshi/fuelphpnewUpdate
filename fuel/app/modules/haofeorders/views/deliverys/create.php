
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Editable Invoice</title>

    <?php 
        echo Fuel\Core\Asset::css('orders/style.css');
        echo Fuel\Core\Asset::css('orders/print.css'); 
    ?>              
    <script>
        <?php 
        echo "var tax=".$distroinfo["distrotax"];
        ?>
    </script>        
<style>
      body { 
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
      }
      #header { 
    width: 98%;
      }
      
      input[type="text"], input[type="number"], select { 
    width: 100%;
}
      
</style>
</head>


<body>
    
    <?php echo Form::open(array(
        'id' => 'edit_article_form',
        'name' => 'edit_article',
        'enctype'=>"multipart/form-data",
        'method'=>'POST',
        'action'=>$base."/create",
        'style' => 'width: 96%;'
        ));?>
    
        <div id="customer"> 
	<!--<div id="page-wrap">-->

		<p id="header"><?php echo \Lang::get('base.quotes')?\Lang::get('base.deliverys'):"Quote"?></p>
	<!--</div>-->
		
            <div id="identity">
                <p id="address"></p>
            </div>
            <div id="logo">
            </div>
		
        <div style="clear:both">

        </div>
		
        <!--<div id="customer">-->           
<!--            <?php echo \Lang::get('label.customers.name')?\Lang::get('label.customers.name'):"label.customers.name";?><br/>
            <input class="popup-autocomplete hidden_customer_id " id="customer_id" map-controller="customers" mapper="name" href="/customers/listkey.json" style="width:200px" id="form_customer_name" name="customer_name"></input><br/>
            <?php echo \Lang::get('label.customers.customer_key')?\Lang::get('label.customers.customer_key'):"label.customers.customer_key";?><br/>
            <input class="popup-autocomplete hidden_customer_id" id="customer_id" map-controller="customers" mapper="customer_key" href="/customers/listkey.json" style="width:200px" id="form_customer_key" name="customer_key"></input>

            <input class="popup-autocomplete updateflag"  map-controller="customers" mapper="customer_key" href="/customers/listkey.json" style="width:200px" id="hidden_customer_id" type="hidden" name="customer_id"></input><br/><br/>
        
            <label for='extra4'> <?php echo \Lang::get('label.agents.name')?\Lang::get('label.agents.name'):"Agent Name";?></label>
            <input class="popup-autocomplete hidden_agent_id " id="agent_id" map-controller="agents" mapper="name" href="/agents/listkey.json" style="width:200px" id="form_agent_name" name="agent_name" value="<?php echo \Input::get("agent_name");?>"></input><br/>

            <input class="popup-autocomplete updateflag"  map-controller="agents" id="hidden_agent_id" type="hidden" name="agent_id" value="<?php echo \Input::get("agent_id");?>">-->
        </div>  
    
        <table id="meta">
            <tbody>
                <tr>
                    <td class="meta-head"> 
                        <?php echo \Lang::get('label.deliverys.name')?\Lang::get('label.deliverys.name'):"label.deliverys.name";?>
                    </td>
                    <td>
                        <input type="text" value="#" id="form_name" name="name" disabled>
                    </td>
                </tr>
                <tr>
                    <td class="meta-head">
                        <?php echo \Lang::get('label.orders.created_at')?\Lang::get('label.orders.created_at'):"label.orders.created_at";?>
                    </td>
                    <td>
                        <?php echo date('Y / M / j  '); ?>
                    </td>
                </tr>                    
            </tbody>
        </table>
        <br/><br/><br/><br/>
        <table id="items">
            <tr id="itemheader">
                           <th><?php 
                    echo \Lang::get("label.products.item_name")?\Lang::get('label.products.item_name'):"label.products.item_name";?></th>
                            <th><?php 
                    echo \Lang::get("label.products.item_key")?\Lang::get('label.products.item_key'):"label.products.item_key";?></th>
                     <?php if(isset($enablecategories) && $enablecategories== 1 ){ ?>
                               <th><?php 
                    echo \Lang::get("label.products.category")?\Lang::get('label.products.category'):"label.products.category";?></th>
                     <?php } ?>     
                               <th><?php 
                    echo \Lang::get("label.orderline.quantity")?\Lang::get('label.orderline.quantity'):"label.orderline.quantity";?></th>
                            <th><?php 
                    echo \Lang::get("label.orderline.price")?\Lang::get('label.orderline.price'):"label.orderline.price";?></th>
                          <?php if(isset($enabledeliverylinediscount) && $enabledeliverylinediscount == 1 ){  ?>
                             <th><?php 
                    echo \Lang::get("label.orders.discount")?\Lang::get('label.orders.discount'):"label.orderline.discount";?></th>
                            <?php } ?>      <th><?php 
                    echo \Lang::get("label.orderline.total_amt")?\Lang::get('label.orderline.total_amt'):"label.orderline.total_amt";?></th>
                            <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment== 1 ){ ?>
                               <th><?php 
                    echo \Lang::get("label.orderline.comment")?\Lang::get('label.orderline.comment'):"remark";?></th>
                     <?php } ?> 
                               <th></th>
            </tr>
            <tr><td colspan="8"> <a id="additem"><?php echo \Lang::get('message.additem')?\Lang::get('message.additem'):"Add item"; ?></a></td></tr>
        </table>    
        <div  id='items' style="border:none; margin-top: auto;">   
            <?php if(isset($motekExtrafields) && $motekExtrafields == 1){ ?>
                <div class="span6" style="display: inline-flex;margin-top: 70px;">
                    <div class="span5">
                        <label><?php echo \Lang::get('label.customers.last_visit_date')?\Lang::get('label.customers.last_visit_date'):"label.customers.last_visit_date";?></label>
                        <input type="date"  name="last_visit_date" style="width: 192px;height: 30px;" />
                    </div>
                    <div class="span5">
                        <label><?php echo \Lang::get('label.customers.last_order_by_phone')?\Lang::get('label.customers.last_order_by_phone'):"label.customers.last_order_by_phone";?></label>
                        <input type="date"  name="last_order_by_phone" style="width: 192px;" />
                    </div>
                </div>    
            <?php } ?> 
            <table id="meta" style="  float: left; ">
                <tbody>   
                    <?php if(isset($enableQuoteDiscount) && $enableQuoteDiscount == 1){ ?>
                    <tr>
                        <td class="meta-head">
                            <?php echo \Lang::get('label.orders.discount')?\Lang::get('label.orders.discount'):"label.orders.discount";?>
                        </td>
                        <td>
                            <input type="text" value="#" id="form_discount_all" class="calculate_discount_all" style="width: 192px;" name="discount_all">
                        </td>
                    </tr>
                    <?php } ?>                
                    <tr>
                        <td class="meta-head">
                            <?php echo \Lang::get('label.orders.amount_totalbeforetax')?\Lang::get('label.orders.amount_totalbeforetax'):"label.orders.amount_totalbeforetax";?>
                        </td>
                        <td>
                            <input type="text" value="#" id="form_amount_totalbeforetax" style="width: 192px;" name="amount_totalbeforetax">
                        </td>
                    </tr>
                    <tr>
                        <td class="meta-head">
                            <?php echo \Lang::get('label.orders.amount_total')?\Lang::get('label.orders.amount_total'):"label.orders.amount_total";?>
                        </td>
                        <td>
                            <input type="text" value="#" id="amount_total" style="width: 192px;" name="amount_total">
                        </td>
                    </tr>
                </tbody>
            </table>
        <!--</div>-->
        </div>
        
        <div style="clear:both;"></div>  
          <?php if(isset($enableTaxPerCustomer) && $enableTaxPerCustomer == 1 ){ ?>
            <div style="display: -webkit-box;float: left;padding: 10px;  margin-top: 5.3%;">
                <input type="checkbox" id="form_no_tax" name="untaxed" value="1" style="  width: 18px;height: 17px;">  
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
                <textarea name="comment" id="comment" style="border: 1px solid;background: none; width:100%;" rows="5" ></textarea>
            </div>            
        <?php } ?>
                    
        <input type="submit" value="<?php echo \Lang::get('message.save')?\Lang::get('message.save'):'שמור'; ?>" class="btn btn-primary" id="form_submit" name="submit">   
    <?php echo Form::close();?>
                    
    <div id="tr_info" style="display:none">
                        
        <td>&nbsp;<input class="popup-autocomplete " href="/products/listkey.json" mapper="item_name" style="width:200px" id="form_orderlines_new-0-product_name" lower-level="prodname" map-controller="products" name="orderlines_new" usekey ="product_id"></input>  </td>
        <td>
            <input class="popup-autocomplete" href="/products/listkey.json" mapper="item_key" style="width:200px" id="form_orderlines_new-0-product_key" lower-level="product_key" map-controller="products" name="orderlines_new" usekey ="product_id"> </input>
            </input>
        </td>
        <?php if(isset($enablecategories) && $enablecategories== 1 ){ ?>
        <td>&nbsp;<input  type='text' mapper="categories" style="width:200px" id="form_orderlines_new-0-categories" lower-level="categories" name="orderlines_new" value=''></input>  </td>
        <?php } ?>
        <td>&nbsp;<input type="text" id="form_orderlines_new-0-quantity" class="change_total" name="orderlines_new" lower-level="quantity" value=""> </td>
        <!--<td>&nbsp;<input type="text" id="form_orderlines_new-0-price"  name="orderlines_new" mapper="sale_price" lower-level="price" value=""> </td>-->
        
                   <?php if(isset($enableTaxPerProduct) && $enableTaxPerProduct == 1){ ?>
                    <td>  <input type="hidden" id="form_orderlines_new-0-untaxed"  name="orderlines_new" mapper="untaxed" lower-level="untaxed" value=""></td>
              
                    <?php }  ?><?php if(isset($enablepriceedit) && $enablepriceedit == 1){ ?>
        <td>&nbsp;<input type="text" id="form_orderlines_new-0-price"  name="orderlines_new" class="change_price" mapper="sale_price" lower-level="price" value=""> </td>
        <?php }else{ ?>
        <td>&nbsp;<input type="text" id="form_orderlines_new-0-price"  name="orderlines_new" mapper="sale_price" lower-level="price" value=""> </td>
        <?php } ?>        
        <?php if(isset($enabledeliverylinediscount) && $enabledeliverylinediscount == 1 ){ ?>
                     <td>&nbsp;<input type="text" id="form_orderlines_new-0-discount"  name="orderlines_new" class="change_discount"  lower-level="discount" value=""> </td>
        <?php } ?>
        <td>&nbsp;<input type="text" id="form_orderlines_new-0-total_amt" class="add_to_total" name="orderlines_new" lower-level="total_amt" value=""> </td>
          <?php if(isset($enabledeliverylinecomment) && $enabledeliverylinecomment== 1 ){ ?>
          <td>&nbsp;<input type="text" id="form_orderlines_new-0-comment"  style="width:200px" name="orderlines_new" lower-level="comment" value="" /> </td>
        <?php } ?>  
        <td>
        <td>
            <a id="form_orderlines_new-0-delete" lower-level="delete"  name="delete" href="" onclick="return false;" class="delete_line"><i class="icon-trash" title="Delete"></i></a>
        </td>          
        <input class="updateflag" type="hidden" href="/products/listkey.json" mapper="item_key" style="width:200px" id="hidden_form_orderlines_new-0-product_id" lower-level="product_id" map-controller="products" name="orderlines_new" key="product_id"></td>
        <td><?php echo \Lang::get('message.remove')?\Lang::get('message.remove'):"remove"; ?></td>
    </div>
                            


