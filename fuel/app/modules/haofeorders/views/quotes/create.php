<div class="col-lg-1"></div>
<h2 class="text-center" style="    margin-right: 10% !important;text-decoration: underline;">יצירת הזמנה</h2>
 
<form method='post' action="<?php // echo $base;/create ?>" id="myFormId" js-url="/vqk20202141439uyw/vqk20202141439uyws/<?php if(isset($jsurl) && !empty($jsurl)) echo $jsurl; else echo 'jsonOrdercomplete'; ?>" enctype='multipart/form-data' role="form" class="span12 col-lg-10  " >
  <input type="hidden" name="customer_id" id="customerId" value="<?php echo $customer_id; ?>" />
    <div class="span12 mx-lg-1 mx-xl-0 px-0 card rounded-0 form-group section-col sortgroup orderSummary" style="border: 1px solid rgb(183,161,135) !important;margin-bottom: 8%" >
      <div class="span12 px-0 box box- section-border-top " style="direction: rtl;border-top: 1px solid rgb(183,161,135) !important;" >
         <div class="card-title text-center pt-3  box-header  with-border bg- section-color" style="background-color:rgb(183,161,135) !important;border-bottom:1px solid rgb(183,161,135) !important;" data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
            <h4 class="box-title" >
             <img src="/assets/img/haofe/sectionlabel.png" style="float: left;"/>
<!--                <span class="headerChangePlus">+</span>
                <span class="headerChangeMinus">&nbsp;&nbsp;-&nbsp;&nbsp;</span>-->
                <span class="title">סיכום הזמנה</span></h4>
            </div>
          <div id="lab" class="span12 box-body" style="    padding-top: 30px;" data-inset="true" data-theme="e" data-content-theme="d" >
                  
                </div>
         </div>
         </div>
  
            <input type="hidden" name="amount_totalbeforetax" id="amount_totalbeforetax" value="" />
            <input type="hidden" name="amount_total"  id="amount_total" value="" />
            <input type="hidden" name="id"  id="orderId" value="" />
            <div class="span12 text-center" style="    text-align: right;
    padding: 15px 10%;" > 
        <button  id="editOrder" class="btn btn-primary"  >הוסף פריטים להזמנה</button>
    </div>
    <div class="span12 text-center"  style="    padding: 15px 10%; text-align: right;"> 
        <button  id="cancelOrder" class="btn btn-danger"  >בטל הזמנה</button>
    </div>
            <div class="span12 " style="    padding: 15px 10%;" >
        <input type="submit" id="sendOrder" class="btn btn-primary pull-left" value="שלח הזמנה" /> 
    </div>

</form>



<div class="span10 sortgroup sortgroupSearch" style="    margin-right: 10% !important;">
    <div class="">
        <label style="font-size: 16px;">הקלד שם מוצר לחיפוש</label>
               <input type="text" style="    width: 80%;
    height: 30px;" class="popup-autocomplete hidden_product_id  ui-autocomplete-input productSearch" id="product_id" map-controller="products" mapper="item_name" href="/haofeorders/products/listkey.json" name="product_name"   autocomplete="off"/>
       
    <input   class="popup-autocomplete updateflag ui-autocomplete-input hidden productSearchHidden" map-controller="products" mapper="item_key" href="/haofeorders/products/listkey.json" style="width:200px" id="hidden_product_id" type="hidden"    autocomplete="off">
    
    </div>

    <div  id="prodList">
        
    </div>

    <div class="span12">
        <label>  ניתן לבחור קטגוריה </label> 
    </div>
    
    </div>
   <div class="span12 mx-lg-1 mx-xl-0 px-0 card rounded-0 form-group section-col sortgroup lastgroupCode" style="border: 1px solid rgb(183,161,135) !important;margin-bottom: 8%" >
      
       
       <div class="span12 px-0 box box- section-border-top" style="direction: rtl;border-top: 1px solid rgb(183,161,135) !important;" >
         <div class="card-title text-center pt-3  box-header  with-border bg- section-color" style="background-color:rgb(183,161,135) !important;border-bottom:1px solid rgb(183,161,135) !important;" data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
            <h4 class="box-title" >
             <img src="/assets/img/haofe/sectionlabel.png" style="float: left;"/>
<!--                <span class="headerChangePlus">+</span>
                <span class="headerChangeMinus">&nbsp;&nbsp;-&nbsp;&nbsp;</span>-->
                <span class="title">מוצרים שקניתי לאחרונה</span>
                <span class="headerChange"></span></h4>
            
            <input type="hidden" name="" class="sortLastId" value="" />
          </div>
         <div id="lab" class="span12 box-body" data-inset="true" data-theme="e" data-content-theme="d" >
 
            <br/>
            <br/> 
         </div>
      </div>
   </div>   
    
    <?php if(isset($sortcodes) && count($sortcodes) > 0){ ?>
    <?php     foreach ($sortcodes as $code){ ?>
           <div class="span12 mx-lg-1 mx-xl-0 px-0 card rounded-0 form-group section-col sortgroup sortgroupCode" style="border: 1px solid rgb(183,161,135) !important;margin-bottom: 8%" >
      <div class="span12 px-0 box box- section-border-top" style="direction: rtl;border-top: 1px solid rgb(183,161,135) !important;" >
         <div class="card-title text-center pt-3  box-header  with-border bg- section-color" style="background-color:rgb(183,161,135) !important;border-bottom:1px solid rgb(183,161,135) !important;" data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
            <h4 class="box-title" >
             <img src="/assets/img/haofe/sectionlabel.png" style="float: left;"/>
<!--                <span class="headerChangePlus">+</span>
                <span class="headerChangeMinus">&nbsp;&nbsp;-&nbsp;&nbsp;</span>-->
                <span class="title"><?php echo $code->name; ?></span><span class="headerChange"></span>
            </h4>
            <input type="hidden" name="" class="sortId" value="<?php echo $code->id ?>" />
            
          </div>
         <div id="lab" class="span12 box-body" data-inset="true" data-theme="e" data-content-theme="d" >
 
            <br/>
            <br/>
            
         </div>
      </div>
   </div>
    
    <?php } ?>
    <?php } ?>

<div class="span12 text-center" >

<button  id="saveOrder" class="btn btn-primary"  >שמור טיוטה</button>
<button id="finish" disabled="disabled" class="btn btn-primary">הצג סיכום</button>

</div>


<div style="display:none;" id="prodLi">
    <li class="span12 outerProdList resProdList">
                <!--<div class="prod-div1" style="text-align: -webkit-center;"><img src="/assets/img/shopify-logo.png" onerror="this.onerror=null;this.src='/assets/img/shopify-logo.png';" alt="Product Image Comming Soon" height="150" width="150"></div>-->
                <div class="prod-div span5"   data-target="#quantity0" data-toggle="collapse">
                   <div class="item_name" name="item_name"  ></div>
                   <input   class="product_id" type="hidden" value="">
                   <input class="price" id="price" type="hidden">
                   <input class="total_amt" id="total_amt" type="hidden">
                  
                </div>
               
<!--                <div class="span1"  >
                    &nbsp;
                </div>-->
                <div class="span7"  style="text-align: left;">
                <div class="quan">
                     <!--כמות :--> 
                    <button class="btn-info plusquan quanbtn">+</button>&nbsp;
                    <input type="tel"  pattern="[0-9]+(\.[0-9][0-9][0-9]?)?" class="span3 quantity quantityUpdate">&nbsp;<button class="btn-info minusquan quanbtn">-</button></div>
                </div>
                  
                  <div class="span12 comment">הערות : &nbsp;&nbsp;&nbsp;
                      <input type="text" class="commentcss" /></div>
                 
                
            </li>
</div>

<div style="display:none;" id="lineLi"  count="0" name="orderlines_new">
    <li class="span12 outerProdList resProdList">
                <!--<div class="prod-div1" style="text-align: -webkit-center;"><img src="/assets/img/shopify-logo.png" onerror="this.onerror=null;this.src='/assets/img/shopify-logo.png';" alt="Product Image Comming Soon" height="150" width="150"></div>-->
                <div class="prod-div span5"   data-target="#quantity0" data-toggle="collapse">
                   <div class="item_name" name="item_name"  ></div>
                   <input   class="product_id" type="hidden"  count="0" mapper="product_id" value="">
                   <input class="prodname" id="prodname" type="hidden" mapper="prodname" />
                   <input class="minimum_price" id="minimum_price" type="hidden">
                   <input class="price" id="price" type="hidden" mapper="price">
                   <input class="total_amt" id="total_amt" mapper="total_amt" type="hidden">
                  
                </div>
               
                <div class="span2" >
                    <a class="deleteItem"><img src="/assets/img/haofe/deletelogo.png" style="float: left;"></a>
                </div>
                <div class="span4"  style="text-align: left;">
                <div class="quan">
                     <!--כמות :--> 
                    <button class="btn-info plusquan quanbtn">+</button>&nbsp;
                    <input type="tel"  pattern="[0-9]+(\.[0-9][0-9][0-9]?)?" class="span5 quantity quantityUpdate"  count="0" mapper="quantity" >&nbsp;<button class="btn-info minusquan quanbtn">-</button></div>
                </div>
                  
                  <div class="span12 comment">הערות : &nbsp;&nbsp;&nbsp;
                      <input type="text" class="commentcss"    count="0" mapper="comment" /></div>
                 
                
            </li>
</div>
<div class="col-lg-1"></div>
<input id="uploadUrl" type="hidden" value="/vqk20202141439uyw/vqk20202141439uyws/createImagex" />

<style>
    
    h4{
        margin: 0;
        padding: 6px;
        padding: 3px;
        padding: 14px 0px;
    }
    
    .quanbtn{
        font-size: 29px;
        font-weight: bold;
        padding: 4px 2%;
        margin-top: -10px;
    }
    
    .row-fluid [class*="span"].section-col{
        margin-right: 0;
    }
    
    
    .section-border-top.collapsed-box{
        min-height: 49px !important;
        height: 0;
    }
    .section-border-top.collapsed-box .section-color{
        padding: 0px 0px;
    }
    
    .resProdList{
        margin-bottom: 15px;
    }
    .comment,.orderSummary, .sortgroup.hide, #myFormId{
        display: none !important;
    }
    .comment.show, .orderSummary.show, #myFormId.show{
        display: initial !important;
        margin-right: 0;
    }
    
    .commentcss{
        height: 26px !important;
        width: 68%;
    }
    
    .row-fluid li.span12:first-child{
        margin-right: 2.127659574468085% !important;
            margin-top: 2px;
    }
    .row-fluid div li.span12:first-child{
        margin-right: 2.127659574468085% !important;
            margin-top: 2px;
    }
    .row-fluid div li.span12 {
        margin-right: 2.127659574468085% !important; 
    }
    
    
    
    body {
        margin: 0;
    }
    .row-fluid .span12 {
            margin-right: 0 !important;
    }
    
    .item_name {
        font-size: 16px;
    }
    
    .quanbtn:hover, .quanbtn:active, .quanbtn:hover, .quanbtn:focus {
       outline: none;
        box-shadow: none; 
    }
    
    .headerChange{
        padding: 2px 10px;
        font-size: 19px;
    }
    
    .collapsed-box .headerChangePlus{
        display: initial;
    }
    .headerChangePlus, .collapsed-box .headerChangeMinus{
        display: none;
    }
    
    .prodUpdateMsg{
        width: 70px;
        float: right;
        color: red;
        text-align: center;
    }
    
    .lastgroupCode div div li div.span7,
    .sortgroupCode div div li div.span7{
        width: 54% !important;
    }
    
            body {
  /* Disables pull-to-refresh but allows overscroll glow effects. */
  overscroll-behavior-y: contain;
}
</style>