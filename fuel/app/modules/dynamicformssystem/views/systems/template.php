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
                
                input[name="logo"]{
                        padding: 5% 2% 2% 0%;
                }
                
                
        #logoWrap div.span1{
            float: none !important;
        }
        
        .form-wrap.form-builder .stage-wrap{
            /*width:50% !important;*/
        }
        
        
        .icon-remove{
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-top: 1px;
            line-height: 14px;
            vertical-align: text-top;
            background-image: url(/assets/img/glyphicons-halflings.png);
            background-position: 14px 14px;
            background-repeat: no-repeat;
            background-position: -312px 0;
        }
        
        .delete-img{
            position: absolute;
    background: #fbf3f3;
    border-radius: 1px 0px 1px 7px;
    padding: 0px 2px;
        }
        
        .thumbnail{
                line-height: 20px;
    border: 1px solid #b7b5b5;
    border-radius: 4px;
        padding: 4px;
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
         
          <a class="brand">SalesSoft</a>
           
          <div class="nav-collapse collapse">  
            <ul class="nav  vertical-nav"  >
               
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
                       <button id="loadTinyMCE"  style="display: none;" type="button">Preview</button>
                    
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
<?php } }  ?>

    <?php echo Asset::js('fileupload/jquery.fileupload.js'); ?>  
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/tinymce.min.js"></script>

<script type="text/javascript" src="/dynamicformssystem/forms/formbuilder"></script>
<script type="text/javascript" src="/dynamicformssystem/forms/formbuildersystemjs"></script>

<script>
    
window.matchMedia('print').addListener(function(mql) {
     if (mql.matches) {
            print();    
    }
});

$(document).ready(function(){
    var textnew = $('#invoice_copy').val();
        
        $('.row-fluid div h1').text(textnew);
      try{  
        
          $('#loadTinyMCE').trigger('click');
    }catch( ex){
        console.log('Exception occured '+ex);
    }
 
    $('body').on('click','#generateUUid',generateUUid); 
    $('body').on('click','#loadTinyMCE',getTinymce); 

    getTinymce();  
    }); 
    
    function generateUUid(e){

e.preventDefault();

uuid = uuidv4() ;
$('input[name="apikey"]').val(uuid);

}


function uuidv4() {
return ([1e7]+1e3+4e3+8e3+1e11).replace(/[018]/g, c =>
(c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
);
}


      function getTinymce(){
 
                        var ele = $('textarea[type="tinymce"]');
 
                        for(var i= 0; i< ele.length; i++){

                            var e = $(ele[i]);
 
                            tinymce.init({ 
                                selector: 'textarea#'+e.attr('id'), 
                                paste_as_text: true,  
//                                plugins: "paste",
                                 plugins: "paste, searchreplace table template textcolor  visualblocks wordcount",
//  ]
                                toolbar: ' undo redo |  formatselect | forecolor  bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                paste_enable_default_filters: false,
                                setup: function (editor) {
                                    editor.on('change', function () {
                                        editor.save(); 
                                        
                                       var data =  editor.getContent(); 
                                        $('#'+editor.id).val(data);
                                        $('#'+editor.id).html(data); 
                                        $('textarea#'+editor.id).trigger('keyPress'); 
                                        $('#showPreview').trigger('click');
                                    });
                            }
                            });
                        }
                        
                  } 
 
   function form_fileupload(){ 
        var ref = $(this);
        
        
        var name =ref.attr('name');
        var fieldval = $("input[name='"+name+"'][type='hidden']").val();
        if(fieldval === undefined){

            var ipt = '<input type="hidden" name="'+name+'"  />';
              ref.parent().append(ipt);
            fieldval = $("input[name='"+name+"'][type='hidden']").val();
        }
        var limit = parseInt(ref.attr('maxlimit'));
        
        if(Number.isNaN(limit) || limit == 0)
           $(this).attr('maxlimit','1');
        
        
        var filelen = fieldval.split(',');
         
        if(fieldval != '' &&  filelen.length >= limit){
            var msg = 'Only '+limit;
            if(limit >1){
               msg +=' files allowed'; 
            }else{
               msg +=' file allowed'; 
            }
            alert(msg);
            
            return false;
        }else{
          
            
            $(this).fileupload({
               dataType: 'json',
                maxFileSize: 1000,
                success:function(response){   
                    $("input[name='"+name+"'][type='file']").hide();
                    console.log(response);
                   if(response != ''){
                       
                       if(response.error != undefined){
                           alert(response.msg);
                           return false;
                       }
                       
                    fieldval = $("input[name='"+name+"'][type='hidden']").val();
                    if(fieldval === ''){ 
                       fieldval = response.id;
                    }else{ 
                        fieldval += ','+response.id;
                    }

                    $("input[name='"+name+"'][type='hidden']").val(fieldval);
                    $("input[name='"+name+"'][type='file']").removeAttr('required');
                    
                     var a= '';
                        if( $("input[name='"+name+"'][type='file']").val() != undefined)
                            
                         a += '<div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n'
                             a +=  '<a class="delete-img" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                               a +='    <a href="/Model_Products/'+response.name+'" target="_blank">\n\
                                 <img src="/Model_Products/'+response.name+'" style="width: 55px;  height: 60px;" />\n\
                                </a>';

                            a += ' </div>';
                            a += ' </div>'; 
                    $("input[name='"+name+"'][type='hidden']").parent().append(a);
                         //   scrollWin($("input[name='"+name+"'][type='hidden']").parent());

                    if(ref.hasClass('file-upload-defect')){
                        $("input[name='"+name+"'][type='hidden']").parent().parent().parent().parent().children().first().after(a);
                    }
                }
               }
           });
       }
    }
    
    
    
    function progressBar(){
       
        var div_percent = $('<div/>');
            div_percent.addClass('percent');
            div_percent.text('0%');
        var div_bar = $('<div/>');
            div_bar.addClass('bar'); 
            div_bar.addClass('barData'); 
        var div_progress = $('<div/>');
            div_progress.addClass('span6');
            div_progress.addClass('progress');
            div_progress.addClass('progress-bar-mycom'); 
            div_progress.addClass('pull-left'); 
            
        var div_progress12 = $('<div/>');
            div_progress12.addClass('span12'); 
            div_progress12.addClass('progress-12'); 
            
            div_progress.append(div_bar);
            div_progress.append(div_percent);
            div_progress12.append(div_progress);
            
        return div_progress12;
   } 
</script>
 

</body>

</html>
