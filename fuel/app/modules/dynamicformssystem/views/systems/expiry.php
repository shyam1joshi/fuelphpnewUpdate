
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
               
                
            </ul>
           </div>
          
          
         
         </div>
               
      </div>
    </div>
    
	<div class="row-fluid show-grid">
		
		  


<?php 

if(isset($expiryMessage) && !empty($expiryMessage)){
   ?><div class="span12 text-center" style="margin-top: 90px;"><h2><?php echo htmlspecialchars_decode($expiryMessage); ?></h2><?php
}else{
    ?>
       <div class="span12 text-center" >
   <?php 
    echo \Asset::img('expire_message.jpg');
}


?> 

		</div> 
	</div>
 
 
 
 
 
</body>

</html>
