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
	</style>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top"  <?php 
         if(isset($removesalessoftbar) && $removesalessoftbar == 1){ ?>
            style='display:none !important'
       <?php  }        ?>>
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
          <a class="brand">Tofsy</a>
           
          <div class="nav-collapse collapse">  
            <ul class="nav  vertical-nav"  >
            
                <?php
//                \Model_Menu::return_category_menu();
                ?>
                
                <li class="pull-left">
                <a href="/base/logout"><?php echo \Lang::get('menu.logout');?></a></li>
            </ul>
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
    
    <script src="/assets/js/fileupload/jquery.fileupload.js"></script>
    <script src="/assets/js/dynamicforms/formbuildernew.js"></script>

<?php 
if(isset($base)){
if(in_array($base,array('orders' ,'quotes' ,'deliverys'  ,'payments','receiptinvoices' ,'customercards','creditorders','creditpayments'))){  ?>    
<script>
    $(document).ready(function(){
        x1();
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
    
window.matchMedia('print').addListener(function(mql) {
     if (mql.matches) {
            print();    
    }
});

$(document).ready(function(){
    var textnew = $('#invoice_copy').val();
        
        $('.row-fluid div h1').text(textnew);
    });
    
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
