<html>
<head>
	<meta charset="utf-8">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php  if(isset($title)) echo \Lang::get($title); ?></title>
	<?php echo Asset::css('bootstrap.min.css');
        
        #echo Asset::css('jquery-ui-1.8.20.custom.css');
        echo Asset::css('minified/jquery-ui.min.css');
        echo Asset::css('chosen.min.css');
        echo Asset::css('select/select2.css');
        //echo Asset::css('AdminLTE.css');

        ?>
        
        <?php
          if(isset($enablecategory) && $enablecategory == '1'){
        echo Asset::css('textautocomplete/textext.core.css'); 
        echo Asset::css('textautocomplete/textext.plugin.arrow.css'); 
        echo Asset::css('textautocomplete/textext.plugin.autocomplete.css'); 
        echo Asset::css('textautocomplete/textext.plugin.clear.css'); 
        echo Asset::css('textautocomplete/textext.plugin.focus.css'); 
        echo Asset::css('textautocomplete/textext.plugin.prompt.css'); 
        echo Asset::css('textautocomplete/textext.plugin.tags.css'); 
  }
?>
        <?php if(isset($base) && $base == 'reminders'){ 
             echo Asset::css('datetimepicker/jquery.datetimepicker.css'); 
             
        } ?>
        <?php   echo Asset::css('responsive.css');   ?>
        
	<style>
		body { margin: 40px; }
                label {font-weight: 900}
        
                 @media print{ 
                    #page-wrap,#page-wrap-x {
                        width:640px ; 
                    }
             }
             
             #headerlogo{
                width: 102px;
                margin-top: 9px;
                margin-right: 26%;
             }
             
             @media only screen and (max-width: 720px) and (min-width: 360px){
                .icon-trash{
                    display: inherit !important;
                }
            }
            
            .userName{
                    color: red;
                    font-weight: bold;
                    border: 1px solid red;
                padding: 0.2% 3%;
                margin-top: 7px;
            }
            
            @media only screen and (max-width: 815px) and (min-width: 200px){
                
                .userName{
                    color: red;
                    margin-left: -47%;
                    margin-top: -32px;
                    font-weight: bold;
                    border: 1px solid red;
                    padding: 0.5% 4%;
                }
            }
            
            
            
	</style>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
             <span id='subscription_alert'>
                   
                <!--<span class="pull-left span5"  style="    color: red; margin-top: -1.7%;    padding-left: 2%; ">-->  
                <span class="pull-left "  style=" color: red; ">  
                  <?php
                  \Model_Menu::return_subscription();
                  ?>
             </span>
           
            </span>
          <a class="brand">SalesSoft</a>
           
          <div class="nav-collapse collapse">  
            <ul class="nav  vertical-nav"  >
                <?php
                \Model_Menu::return_menu();
                ?>
                
                  <?php
                \Model_Menu::return_menu_mobile();
                ?>
                
                <?php
//                \Model_Menu::return_category_menu();
                ?>
                
                <li class="pull-left">
                <a href="/base/logout"><?php echo \Lang::get('menu.logout');?></a></li>
               
            </ul>
              <?php if(file_exists('assets/img/haofe/logo.jpg')){ ?>
              <img src="/assets/img/haofe/logo.jpg" id="headerlogo">
              <?php } ?>
               
                <?php 
                
                $auth = \Auth::get_user_id();
        $id = $auth[1]; 
        $query = Model_Agents::query()->where('connect_uid',$id);
        $agent = $query->get_one();
            if(is_object($agent)){
        ?>
                <div class="pull-left userName "><?php echo $agent->name; ?></div>
            <?php } ?>
           </div>
          
          
         
         </div>
               
      </div>
    </div>
    
	<div class="row-fluid show-grid">
		<div class="span12">
			<h1><?php if(isset($title))  echo $title; ?></h1>
			<hr>
<?php if (Session::get_flash('success')): ?>
			<div class="alert alert-success">
				<strong><?echo \Lang::get('message.sucess');?></strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
				</p>
			</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
			<div class="alert alert-error">
				<strong><?echo \Lang::get('message.error');?></strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
				</p>
			</div>
<?php endif; ?>
		</div>
		<div class="span12">


<?php if(isset($content))  echo $content; ?>
		</div>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			
		</footer>
	</div>
<?php echo Asset::js('jquery-1.9.1.min.js');
#echo Asset::js('jquery-ui-1.8.20.custom.min.js');
echo Asset::js('minified/jquery-ui.min.js');
echo Asset::js('additem.js');
echo Asset::js('shyam-created/autocomplete-widget.js');
echo Asset::js('shyam-created/autocomplete-widget_app.js');
//echo Asset::js('shyam-created/create_new.js');
//echo Asset::js('droparea.js');
echo Asset::js("bootstrap.min.js");
echo Asset::js("twitter-bootstrap-hover-dropdown.min.js");
//echo Asset::js('chosen.jquery.min.js');
//echo Asset::js('select/select2.min.js');
echo Asset::js('jquery.chained.remote.js');
 echo Asset::js('autopopulate-data.js'); 
?>
    
<?php 
if(isset($base)){
if(in_array($base,array('orders' ,'quotes' ,'deliverys'  ,'payments','receiptinvoices' ,'customercards','creditorders','creditpayments'))){  ?>    
<script>
    $(document).ready(function(){
        try{
        x1();
    }catch(e){
        console.log(e);
    }
    });
</script>
<?php } } ?>
<?php 
if(isset($baseobj)){
if($baseobj== 'objectval' ){ ?>    
<script>
    $(document).ready(function(){
        $('#form_submit').on('click',function(){
            var cust_key=$('input[name="customer_key"]').val(); 
            if(cust_key === '' || cust_key === null)
            {
                alert('customer key cannot be empty'); return false;
            } 
        });
    });
</script>
<?php } } ?>

  <?php if(isset($base) && $base == 'reminders'){ 
  
             echo Asset::js('datetimepicker/jquery.datetimepicker.min.js'); 
             echo Asset::js('datetimepicker/jquery.datetimepicker.full.js'); 
             ?>
<script>
    $(document).ready(function(){
        var datenow ='<?php echo date('Y/m/d H:i:s'); ?>';
        var timenow ='<?php echo date('H:i:s'); ?>';
$('#form_date').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
startDate:datenow,//2015/12/05',
minDate:'-'+datenow, // yesterday is minimum date
minTime:'-'+timenow // yesterday is minimum date
//maxDate
});

});
//var dateString = $.datepicker.formatDate("dd-mm-yy", dateObject);
</script>
<?php } ?>
<?php if(isset($content->base) && $content->base == 'products'){ ?>

<?php
  if(isset($enablecategory) && $enablecategory == 1){
 echo Asset::js('textautocomplete/textext.core.js'); 
 echo Asset::js('textautocomplete/textext.plugin.ajax.js'); 
 echo Asset::js('textautocomplete/textext.plugin.arrow.js'); 
 echo Asset::js('textautocomplete/textext.plugin.autocomplete.js'); 
 echo Asset::js('textautocomplete/textext.plugin.clear.js'); 
 echo Asset::js('textautocomplete/textext.plugin.filter.js'); 
 echo Asset::js('textautocomplete/textext.plugin.focus.js'); 
 echo Asset::js('textautocomplete/textext.plugin.prompt.js'); 
 echo Asset::js('textautocomplete/textext.plugin.suggestions.js'); 
 echo Asset::js('textautocomplete/textext.plugin.tags.js'); 
?>

<script>
$(document).ready(function(){
    
    var tags =[<?php if(isset($category) && !empty($category) && is_array($category)) foreach ($category as $cat ) { ?>'<?php echo $cat; ?>', <?php } else ?><?php echo ''; ?>];
   
      $('#form_category').textext({
        plugins : 'tags prompt focus autocomplete ajax arrow',
          <?php if(isset($category) && !empty($category) && is_array($category)){ ?>
         tagsItems : tags, //[ 'Basic', 'JavaScript', 'PHP', 'Scala' ],
        <?php } ?>
       // prompt : 'Add one...',
        ajax : {
            url : '<?php echo Uri::base(); ?>categories/listname.json',
            dataType : 'json',
            cacheResults : false
        }
    }); 
    
});
</script>

<?php } ?>
<?php } ?>
<script>
    $(document).ready(function(){
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        
        var isie11 = !!window.MSInputMethodContext && !!document.documentMode;;

        var b = (document.getElementsByTagName("body")[0]);
       if (msie > 0 || isie11) // If Internet Explorer, return version number
        {
             b.setAttribute('style', 'display:none!important');
            alert("IE browser not supported!");
            console.log(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
        }
     
        $(".dateNew").datepicker({
    dateFormat: 'dd/mm/yy' //check change 
});
    });
</script>

<script>
    


$(document).ready(function(){
    var textnew = $('#invoice_copy').val();
        
        $('.row-fluid div h1').text(textnew);
        
         $(".sortId").trigger("click"); 
         $(".sortLastId").trigger("click"); 
    });
    
    var priceZeroMessage= 1;
     function HeaderCollapsingButton(){
                	if($(this).parent().hasClass("collapsed-box")){
                        $(this).find(".icon-plus").removeClass().addClass("icon-minus");
                         $(this).parent().removeClass("collapsed-box");
                         var boxBody = $(this).parent().find(".box-body");   //.parent().find(".box-body").parent().find(".box-body");
                          boxBody .css("height","inherit")
                           boxBody.removeClass("collapse");
                         }
                         else  { 
                         $(this).parent().addClass("collapsed-box");
                         var boxBody = $(this).parent().find(".box-body");   //.parent().find(".box-body");
                         $(this).find(".icon-minus").removeClass().addClass("icon-plus");
                          boxBody.css("height","0px")
                           boxBody.addClass("collapse");
                         }
                         
                }  
    
       var  order  = {};        
        
    <?php if(isset($object->customer_id) && !empty($object->customer_id)){ ?>
        order.customer_id = <?php echo $object->customer_id ?>;
    <?php }  ?>
    <?php  
    if(isset($object->quotelines) && count($object->quotelines) > 0 ){ ?>
         order.products = [<?php $lines = $object->quotelines ;
        
 foreach ($lines as $line){
     
     $line->prodname = html_entity_decode($line->prodname);
     
     $line = $line->to_array();
         echo json_encode($line).','; 
 }
         ?>];
    <?php }else{  ?>
        order.products = [];    
    <?php }  ?>
     
        function plusquan(e){
            e.preventDefault();
            var temp = $(this).parent().children('input').val();
                temp++;
            $(this).parent().children('input').val(temp);
            
            
            var searchbox = $(this).closest('.sortgroupSearch').val();
            
            if(searchbox != undefined){
                $(this).parent().children('.prodUpdateMsg').remove();
                
                var msgBox = $('<span/>');
                msgBox.append('המוצר נוסף להזמנה');
                msgBox.addClass('prodUpdateMsg');
                
                $(this).parent().prepend(msgBox);
            }
            if(temp > 0){
                
                $(this).parent().parent().parent().children('.comment').addClass('show');
            }else{
                    $(this).parent().parent().parent().children('.comment').removeClass('show');
            
            }
            
            
            var quan_name = $(this).parent().children('input').attr('name');
            if(priceZeroMessage == 1 && quan_name == 'quantity'){ 
                var price = $(this).parent().parent().parent().children('.price').children('input').val();

                if(price == undefined) 
                    price =$(this).parent().parent().parent().children('.price').children('span').text();
                
                    $(this).parent().parent().parent().children('.price_zero').remove();
                if(parseFloat(price) == 0){ 
                    
                    var priceZero = "<div class='price_zero' style=' text-align: center;color:red;    padding: 11px 0px;'>מחיר מוצר ללקוח הוא 0</div>";

                    $(this).parent().parent().parent().children('.price').after(priceZero);
                }

            }
            
            if(quan_name == 'priceEdit' && parseFloat(temp) != 0){ 
                $(this).parent().parent().children('.price_zero').remove();
            }else{
                if(quan_name == 'priceEdit' && parseFloat(temp) == 0){ 
            $(this).parent().parent().children('.price_zero').remove();
                    
                var quan = $(this).parent().parent().children().children('.quan').children('.quantity').val();
              
                    if(parseFloat(quan) != 0){ 

                       var priceZero = "<div class='price_zero' style=' text-align: center;color:red;    padding: 11px 0px;'>מחיר מוצר ללקוח הוא 0</div>";

                       $(this).parent().parent().children('.price').after(priceZero);
                    }
                }
            }
            
            order.customer_id = $('#customerId').val();
            var product_id = $(this).parent().parent().parent().find('.product_id').val();
            var comment = $(this).parent().parent().parent().find('.commentcss').val();
            var quantity = temp;
            var product_name = $(this).parent().parent().parent().find('.item_name').text();
            var price = $(this).parent().parent().parent().find('.price').val();
                price = parseFloat(price);
            var total = price *quantity;
             $(this).parent().parent().parent().find('.total_amt').val(total);
            
            var flag  = 1;
            
            
            if(order.products != undefined){ 
                
                var prods = order.products;
                
                if(prods.length > 0){
                    
                    for(var i= 0; i< prods.length; i++ ){
                        
                        var prod = prods[i];
                    
                        if(prod != undefined && prod != ''){
                            if(prod.product_id != undefined && prod.product_id == product_id){
                                order.products[i]['quantity'] = parseFloat(quantity); 
                                order.products[i]['price'] = parseFloat(price); 
                                order.products[i]['total_amt'] = parseFloat(total); 
                                order.products[i]['comment'] = comment; 
                                flag = 0;
                            }
                        }
                    }
                } 
            }
            
            if(flag == 1){
                  var product = {
                                'product_id' : product_id,
                                'comment' : comment,
                                'quantity' : quantity,
                                'price' : price,
                                'total_amt' : total,
                                'product_name' : product_name,
                                'prodname' : product_name,
                                };
                                
                    if("products" in order)
                        order.products.push(product);
                    else{
                         var prod = {'products':product};
                         order.push(prod);
                     }
            }
            
            enableFinishBtn();
            $('#saveOrder').trigger('click');
//            $(this).parent().children('input').trigger('change');
        } 
        
        function enableSendBtn(){
         
            if(order.products != undefined && order.products != ''){ 
            
                var prodsx = order.products;

                if(prodsx.length > 0){
                    $('#sendOrder').removeAttr('disabled');
                }else{
                     $('#sendOrder').attr('disabled','disabled');
                }
            }else{
                $('#sendOrder').attr('disabled','disabled');
            }
        }
        
        function enableFinishBtn(){
         
            if(order.products != undefined && order.products != ''){ 
            
                var prodsx = order.products;

                if(prodsx.length > 0){
                    $('#finish').removeAttr('disabled');
                }else{
                     $('#finish').attr('disabled','disabled');
                }
            }else{
                $('#finish').attr('disabled','disabled');
            }
        }
        
        function showTopMsg(msg,color,time=9000){
         
            var h3 = $('<h3/>');
            h3.addClass('text-center');
            h3.attr('style','margin-right: 10% !important;color: '+color+';'); 
            h3.attr('id','topNotification'); 
            h3.append(msg); 
            
            $('h2').before(h3);
            
            if(time > 0){
                setTimeout(function(){
                    if ($('#topNotification').length > 0) {
                      $('#topNotification').remove();
                    }
                }, 9000);
            }
        }
        
        function minusquan(e){
            e.preventDefault();
            var temp = $(this).parent().children('input').val();
                temp--;
                
            var searchbox = $(this).closest('.sortgroupSearch').val();
            
            if(searchbox != undefined){
                $(this).parent().children('.prodUpdateMsg').remove();
                
                var msgBox = $('<span/>');
                msgBox.append('המוצר נוסף להזמנה');
                msgBox.addClass('prodUpdateMsg');
                
                $(this).parent().prepend(msgBox);
            }
            var minimum_price = $(this).parent().parent()
                                .children('.prod-div').children('#minimum_price').val();
            
             
            
//            if(temp < minimum_price){
            if(temp < 0){
//                alert('Price cannot be less than minimum price');
                return false;
            }
            
            if(temp > 0){
                
                $(this).parent().parent().parent().children('.comment').addClass('show');
            }else{
                    $(this).parent().parent().parent().children('.comment').removeClass('show');
            
            }
            
            var quan_name = $(this).parent().children('input').attr('name');
            if(priceZeroMessage == 1 && quan_name == 'quantity'){ 
                var price = $(this).parent().parent().parent().children('.price').children('input').val();

                if(price == undefined) 
                    price =$(this).parent().parent().parent().children('.price').children('span').text();
                
                    $(this).parent().parent().parent().children('.price_zero').remove();
                if(parseFloat(price) == 0){ 
                    
                    var priceZero = "<div class='price_zero' style=' text-align: center;color:red;    padding: 11px 0px;'>מחיר מוצר ללקוח הוא 0</div>";

                    $(this).parent().parent().parent().children('.price').after(priceZero);
                }

            }
            
            if(quan_name == 'priceEdit' && parseFloat(temp) != 0){ 
                $(this).parent().parent().children('.price_zero').remove();
            }else{
                if(quan_name == 'priceEdit' && parseFloat(temp) == 0){ 
            $(this).parent().parent().children('.price_zero').remove();
                    
                var quan = $(this).parent().parent().children().children('.quan').children('.quantity').val();
              
                    if(parseFloat(quan) != 0){ 

                       var priceZero = "<div class='price_zero' style=' text-align: center;color:red;    padding: 11px 0px;'>מחיר מוצר ללקוח הוא 0</div>";

                       $(this).parent().parent().children('.price').after(priceZero);
                    }
                }
            }
            
            order.customer_id = $('#customerId').val();
            var product_id = $(this).parent().parent().parent().find('.product_id').val();
            var comment = $(this).parent().parent().parent().find('.commentcss').val();
            var quantity = temp;
            var product_name = $(this).parent().parent().parent().find('.item_name').text();
            var price = $(this).parent().parent().parent().find('.price').val();
                price = parseFloat(price);
            var total = price *quantity;
             $(this).parent().parent().parent().find('.total_amt').val(total);
            
            var flag  = 1;
            
            
            if(order.products != undefined){ 
                
                var prods = order.products;
                
                if(prods.length > 0){
                    
                    for(var i= 0; i< prods.length; i++ ){
                        
                        var prod = prods[i];
                    
                        if(prod != undefined && prod != ''){
                            if(prod.product_id != undefined && prod.product_id == product_id){
                                order.products[i]['quantity'] = parseFloat(quantity); 
                                order.products[i]['price'] = parseFloat(price); 
                                order.products[i]['total_amt'] = parseFloat(total); 
                                order.products[i]['comment'] = comment; 
                                flag = 0;
                            }
                        }
                    }
                } 
            }
            
            if(flag == 1){
                  var product = {
                                'product_id' : product_id,
                                'comment' : comment,
                                'quantity' : quantity,
                                'price' : price,
                                'total_amt' : total,
                                'product_name' : product_name,
                                'prodname' : product_name,
                                };
                                
                    if("products" in order)
                        order.products.push(product);
                    else{
                         var prod = {'products':product};
                         order.push(prod);
                     }
            }
            
            
                
            $(this).parent().children('input').val(temp);
            
            enableFinishBtn();
            
            $('#saveOrder').trigger('click');
               
//            if(temp > 0){
//                $(this).parent().parent().parent().find('.comment').addClass('show');
//            }else{
//                $(this).parent().parent().parent().find('.comment').removeClass('show');
//            }
            
            
//            $(this).parent().children('input').trigger('change');
        }
      
      var prodUrl = '/haofeorders/products/listx?per_page=100';
      
      function GetProducts(){
         
         var ref = $(this);
         var sortcodeid = ref.val();
         
         var urlx = prodUrl+'&prodcategory='+sortcodeid;
         
         $.get(urlx, function(e){
             
            var data = JSON.parse(e);
        
            var prods = data.cars;
               
            if(prods != undefined && prods.length > 0 ){
                $.each(prods, function (idx,val){
                    
                    var li = $('#prodLi').children().clone();
                    
                    li.find('.product_id').val(val.id);
                    li.find('.item_name').text(val.item_name);
                    li.find('.price').val(val.sale_price);
                    
                    var pro =  order.products; 
                    
                    for(var i=0; i< pro.length; i++){
                        var pline  = pro[i];
                        var pid = pline.product_id;
                        
                        if(pid == val.id)
                            li.find('.quantity').val(pline.quantity);
                        
                    }
                    ref.parent().parent().children('#lab').append(li);
                })
            }
             
         });
          
          
      }
        
        var lastUrl = '/importcustomercards/lastreceiptinvoicecards/listx?per_page=10&filter[customer_id]=';
      function GetLastProducts(){
         
         var ref = $(this);
         var customer = $('#customerId').val();
         
         var urlx = lastUrl+customer;
         
         $.get(urlx, function(e){
             
            var data = JSON.parse(e);
        
            var ords = data.cars;
               
            if(ords != undefined && ords.length > 0 ){
                $.each(ords, function (idx,ord){
                    
                    var ordlines = ord.orderlinecards;

                    if(ordlines != undefined && ordlines.length > 0 ){
                        $.each(ordlines, function (idx,val){

                            var li = $('#prodLi').children().clone();

                            li.find('.product_id').val(val.product_id);
                            li.find('.item_name').text(val.prodname);
                            li.find('.price').val(val.price);

                            ref.parent().parent().children('#lab').append(li);
                        });
                    }
                });
            }
             
         });
          
          
      }
      
      function updateComment(){
           var comment = $(this).val();
           
           var product_id = $(this).parent().parent().find('.product_id').val();
           
           if(order.products != undefined){ 
                
                var prods = order.products;
                
                if(prods.length > 0){
                    
                    for(var i= 0; i< prods.length; i++ ){
                        
                        var prod = prods[i];
                                            
                        if(prod != undefined && prod != ''){
                            if(prod.product_id != undefined && prod.product_id == product_id){ 
                                order.products[i]['comment'] = comment; 
                                flag = 0;
                            }
                        }
                    }
                } 
            }
            
            
            $('#saveOrder').trigger('click');
      }
      
      function createOrderSummary(){
          
          if(order != undefined && order.products != undefined){ 
                
                var prods = order.products;
                var amount_total = 0;
                var amount_totalbeforetax = 0;
                
                $('#orderId').val(order.id);
                
                if(prods.length > 0){
                    
                    for(var i= 0; i< prods.length; i++ ){
                        
                        var prod = prods[i];
                        
                        if(prod != undefined && prod != ''){
                    
                            var prodli = $('#lineLi').children().clone();
                            var count = $('#lineLi').attr('count');
                            var name = $('#lineLi').attr('name');

                            prodli.find('.item_name').text(prod.prodname);

                            var mapper =  prodli.find('.product_id').attr('mapper');
                            var mappername = name+'['+count+']['+mapper+']';
                            prodli.find('.product_id').attr('name',mappername);
                            prodli.find('.product_id').val(prod.product_id);

                            mapper =  prodli.find('.commentcss').attr('mapper');
                            mappername = name+'['+count+']['+mapper+']'
                            prodli.find('.commentcss').attr('name',mappername);
                            prodli.find('.commentcss').val(prod.comment);

                            prodli.find('.comment').addClass('show');

                            mapper =  prodli.find('.quantity').attr('mapper');
                            mappername = name+'['+count+']['+mapper+']';
                            prodli.find('.quantity').attr('name',mappername);
                            prodli.find('.quantity').val(prod.quantity);

                            mapper =  prodli.find('.total_amt').attr('mapper');
                            mappername = name+'['+count+']['+mapper+']';
                            prodli.find('.total_amt').attr('name',mappername);
                            prodli.find('.total_amt').val(prod.total_amt);

                            mapper =  prodli.find('.price').attr('mapper');
                            mappername = name+'['+count+']['+mapper+']';
                            prodli.find('.price').attr('name',mappername);
                            prodli.find('.price').val(prod.price);

                            mapper =  prodli.find('.prodname').attr('mapper');
                            mappername = name+'['+count+']['+mapper+']';
                            prodli.find('.prodname').attr('name',mappername);
                            prodli.find('.prodname').val(prod.prodname);

                            count++;
                            $('#lineLi').attr('count',count);

                            amount_totalbeforetax += parseFloat(prod.total_amt);

                            $('.orderSummary').children().children('#lab').append(prodli);
                        }
                    }
                }
                
                var tax = (amount_totalbeforetax *17)/100;
                amount_total =  amount_totalbeforetax +tax;
                
                $('#amount_totalbeforetax').val(amount_totalbeforetax);
                $('#amount_total').val(amount_total);
            }
            
            $('.alert').remove();
            $('.sortgroup').addClass('hide');
            $('#finish').hide();
            $('#saveOrder').hide();
            $('.orderSummary').addClass('show');
            $('#myFormId').addClass('show');
            
            enableSendBtn();
      }
        
        
        function closeOrderSummary(e){
            e.preventDefault();
            //
             $('.orderSummary').children().children('#lab').children().remove();
            $('.sortgroup').removeClass('hide');
            $('.orderSummary').removeClass('show');
            $('#finish').show();
            $('#saveOrder').show();
            $('#myFormId').removeClass('show');
            
        }
        
        function getProduct(){
         var ref = $(this);
             ref.parent().parent().children('#prodList').children().remove();
         var productid = $('#hidden_product_id').val();
         
         var urlx = prodUrl+'&filter[id]='+productid;
         
         $.get(urlx, function(e){
             
            var data = JSON.parse(e);
        
            var prods = data.cars;
               
            if(prods != undefined && prods.length > 0 ){
                $.each(prods, function (idx,val){
                    
                    var li = $('#prodLi').children().clone();
                    
                    li.find('.product_id').val(val.id);
                    li.find('.item_name').text(val.item_name);
                    li.find('.price').val(val.sale_price);
                    
                    
                    ref.parent().parent().children('#prodList').append(li);
                })
            }
             
         });
          
            
        }
        
//      var prodUrl = '/products/listx?per_page=100';
        function getProductSimilar(){
         var ref = $(this);
        ref.parent().parent().children('#prodList').children().remove();
        
         var productid = $('#hidden_product_id').val();
         var productname = ref.val();
         
        if(productname != undefined && productname != ''){
            var urlx = prodUrl+'&prodname='+productname;

            $.get(urlx, function(e){
ref.parent().parent().children('#prodList').children().remove();
               var data = JSON.parse(e);

               var prods = data.cars;

               if(prods != undefined && prods.length > 0 ){
                   $.each(prods, function (idx,val){

                       var li = $('#prodLi').children().clone();

                       li.find('.product_id').val(val.id);
                       li.find('.item_name').text(val.item_name);
                       li.find('.price').val(val.sale_price);


                       ref.parent().parent().children('#prodList').append(li);
                   })
               }

            });
        }
            
        }
        
        
        function saveOrder(){
            
            var ordid = $('#orderId').val();
            
            if(ordid != undefined && ordid != '')
            order.id = ordid;
            
            var data = {
                'data' : order
            };
            
            var ref= $(this);
            
            var url = '/haofeorders/quotes/createOrder';
            
            $.post(url,data, function(e){
                
                order.id = e;
                
                var msg = '<span id="savedMsg" style="    text-align: left;    color: red;    font-size: 15px;">טיוטה נשמרה</span>';
                
                ref.parent().append(msg);
                
                setTimeout(function(){
                    if ($('#savedMsg').length > 0) {
                      $('#savedMsg').remove();
                    }
                }, 9000);
            
                
            });
            
        }
        
        function quantityUpdate(e){
            e.preventDefault();
            var quan = $(this).val();
            
              var prev = $(this).data('val'); 
            var product_id = $(this).parent().parent().parent().find('.product_id').val();
            
            quan = parseFloat(quan);
            
            var searchbox = $(this).closest('.sortgroupSearch').val();
            
            if(searchbox != undefined){
                $(this).parent().children('.prodUpdateMsg').remove();
                
                var msgBox = $('<span/>');
                msgBox.append('המוצר נוסף להזמנה');
                msgBox.addClass('prodUpdateMsg');
                
                $(this).parent().prepend(msgBox);
            }
            
            
//            var pro =  $('.sortgroupCode').find('.product_id[value="'+product_id+'"]');
//           
//            if(pro != undefined){
//                 
//                 
//                $('.sortgroupCode').find('.product_id[value="'+product_id+'"]')
//                        .parent().parent().find('.quantity').val(quan);  
//            }
            
//            var temp = $(this).parent().children('input').val();
//                temp--;
                
            var minimum_price = $(this).parent().parent()
                                .children('.prod-div').children('#minimum_price').val();
            
             
            
            if(quan < minimum_price){
                alert('Price cannot be less than minimum price');
                return false;
            }
            
            if(quan > 0){
                
                $(this).parent().parent().parent().children('.comment').addClass('show');
            }else{
                    $(this).parent().parent().parent().children('.comment').removeClass('show');
            
            }
            
            var quan_name = $(this).parent().children('input').attr('name');
            if(priceZeroMessage == 1 && quan_name == 'quantity'){ 
                var price = $(this).parent().parent().parent().children('.price').children('input').val();

                if(price == undefined) 
                    price =$(this).parent().parent().parent().children('.price').children('span').text();
                
                    $(this).parent().parent().parent().children('.price_zero').remove();
                if(parseFloat(price) == 0){ 
                    
                    var priceZero = "<div class='price_zero' style=' text-align: center;color:red;    padding: 11px 0px;'>מחיר מוצר ללקוח הוא 0</div>";

                    $(this).parent().parent().parent().children('.price').after(priceZero);
                }

            }
            
            if(quan_name == 'priceEdit' && parseFloat(quan) != 0){ 
                $(this).parent().parent().children('.price_zero').remove();
            }else{
                if(quan_name == 'priceEdit' && parseFloat(quan) == 0){ 
            $(this).parent().parent().children('.price_zero').remove();
                    
                var quan = $(this).parent().parent().children().children('.quan').children('.quantity').val();
              
                    if(parseFloat(quan) != 0){ 

                       var priceZero = "<div class='price_zero' style=' text-align: center;color:red;    padding: 11px 0px;'>מחיר מוצר ללקוח הוא 0</div>";

                       $(this).parent().parent().children('.price').after(priceZero);
                    }
                }
            }
            
            order.customer_id = $('#customerId').val();
            var comment = $(this).parent().parent().parent().find('.commentcss').val();
            var quantity = quan;
            var product_name = $(this).parent().parent().parent().find('.item_name').text();
            var price = $(this).parent().parent().parent().find('.price').val();
                price = parseFloat(price);
            var total = price *quantity;
             $(this).parent().parent().parent().find('.total_amt').val(total);
            
            var flag  = 1;
            
            
            if(order.products != undefined){ 
                
                var prods = order.products;
                
                if(prods.length > 0){
                    
                    for(var i= 0; i< prods.length; i++ ){
                        
                        var prod = prods[i];
                    
                        if(prod != undefined && prod != ''){
                            if(prod.product_id != undefined && prod.product_id == product_id){
                                order.products[i]['quantity'] = parseFloat(quantity); 
                                order.products[i]['price'] = parseFloat(price); 
                                order.products[i]['total_amt'] = parseFloat(total); 
                                order.products[i]['comment'] = comment; 
                                flag = 0;
                            }
                        }
                    }
                } 
            }
            
            if(flag == 1){
                  var product = {
                                'product_id' : product_id,
                                'comment' : comment,
                                'quantity' : quantity,
                                'price' : price,
                                'total_amt' : total,
                                'product_name' : product_name,
                                'prodname' : product_name,
                                };
                                
                    if("products" in order)
                        order.products.push(product);
                    else{
                         var prod = {'products':product};
                         order.push(prod);
                     }
            }
            
            
                
            $(this).parent().children('input').val(quan);
            
            enableFinishBtn();
            
            $('#saveOrder').trigger('click');
//            $(this).parent().children('input').trigger('change');
            
        }
        
        
        function quantityUpdatex(){
            
            $(this).data('val', $(this).val());
        }
        
        function clearSearchBox(){
            
            $(".productSearch").val('');
        }
        function deleteItem(e){
            
            e.preventDefault();
            
            var ref = $(this);
            var prod_id = $(this).parent().parent().find('.product_id').val();
            
            if(prod_id != undefined){
                
                if(order.products !== undefined && order.products.length !== 0){
                    $.each(order.products,function(idx,val){
                        if(val !== undefined) {   
 

                            if(parseInt(prod_id) === parseInt(val.product_id)){
                                delete order.products[idx];

                                ref.parent().parent().remove();
                                console.log('deleted product ');
                            } 
                       }
                    });
                }
            }
            
            
            enableFinishBtn();
            enableSendBtn();
            
            $('#saveOrder').trigger('click');
        }
        
        function cancelOrder(e){
            
            e.preventDefault();
            
            
            $('.orderSummary').children().children('#lab').children().remove();
            $('.sortgroup').removeClass('hide');
            $('.orderSummary').removeClass('show');
            $('#finish').show();
            $('#saveOrder').show();
            $('#myFormId').removeClass('show');
            
            order.products  = []; 
            
            enableSendBtn();
            enableFinishBtn();
            showTopMsg('ההזמנה התבטלה בהצלחה','red');
            
            $('#saveOrder').trigger('click');
            return false;
        }
        
        function sendOrder(e){
            
//            e.preventDefault();
            
            
            $(this).attr('style','cursor: not-allowed; pointer-events: none;');  
            $('#editOrder').attr('disabled','disabled');  
            $('#cancelOrder').attr('disabled','disabled');  
            $('.deleteItem').attr('style','cursor: not-allowed; pointer-events: none;');  
            
            showTopMsg('ההזמנה נוצרה בהצלחה','red',0); 
        }
        
        $("html").off("click",".box-header",HeaderCollapsingButton); 
        $("html").on("click",".box-header", HeaderCollapsingButton); 
        $('body').on('click','.plusquan', plusquan);
        $('body').on('click','.minusquan', minusquan);
        $('body').on('change','.commentcss', updateComment);
        $("body").on("click",".sortId",GetProducts); 
        $("body").on("click",".sortLastId",GetLastProducts); 
        $("body").on("click","#finish",createOrderSummary); 
        $("body").on("click","#editOrder",closeOrderSummary);  
        $("body").on("change",".productSearch",getProductSimilar); 
        $("body").on("keyUp",".productSearch",getProductSimilar); 
//        $("body").on("keyDown",".productSearch",getProductSimilar);  
        $("body").on("focus",".productSearch",clearSearchBox);  
        $("body").on("change",".productSearchHidden",getProduct);  
        $("body").on("focusin",".quantityUpdate",quantityUpdatex);  
        $("body").on("change",".quantityUpdate",quantityUpdate);  
        $("body").on("keyUp",".quantityUpdate",quantityUpdate);  
        $("body").on("click","#saveOrder",saveOrder);  
        $("body").on("click",".deleteItem",deleteItem);  
        $("body").on("click","#cancelOrder",cancelOrder);  
        $("body").on("click","#sendOrder",sendOrder);  
       
      
//    (function($){
//	$(document).ready(function(){
//		$('li.mob-menu [data-hover="dropdown"]').on('click', function(event) {
//                    alert();
//			event.preventDefault(); 
//			event.stopPropagation(); 
//			$(this).parent().siblings().removeClass('open');
//			$(this).parent().toggleClass('open');
//		});
//	});
//})(jQuery);
</script>
 

</body>

</html>
