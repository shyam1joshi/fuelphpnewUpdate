
 <html>
<head>
	<meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php  if(isset($title)) echo \Lang::get($title); ?></title>
	<?php echo Asset::css('bootstrap.min.css'); 
        echo Asset::css('minified/jquery-ui.min.css');
        echo Asset::css('chosen.min.css');
        echo Asset::css('select/select2.css'); 

        ?>
       
        <?php   echo Asset::css('responsive.css');   ?>
        <?php if(isset($form_css)) echo $form_css;    ?>
        
	<style>
		body { margin: 40px; }
                label {font-weight: 900}
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
                 <span class="pull-left "  style=" color: red; ">  
                  <?php
                  \Model_Menu::return_subscription();
                  ?>
             </span>
           
            </span>
          <a class="brand"><?php if(isset($form_title)) echo $form_title; else echo 'Tofsy' ?></a>
           
          <div class="nav-collapse collapse">  
            <ul class="nav  vertical-nav"  > 
                <li class="pull-left">
                    <a href="<?php if(isset($module)) echo '/'.$module ?>/base/logout"><?php echo \Lang::get('menu.logout');?></a></li>
            </ul>
           </div>
          
          
         
         </div>
               
      </div>
    </div>
    
	<div class="row-fluid show-grid">
		<div class="span12 text-center">
                     <div id="img-div"  style="    margin-top: 20px;">
                        <?php if(isset($logo_link) && !empty($logo_link)){ ?>
                             
                         <img src="<?php echo $logo_link ?>" style= 'height: 100px;     width: 377px;' />
                    
                        <?php } ?>
                        <?php if(isset($logo_string)){ ?>
                             
                       
                            <h4 style="    margin: 0;"><?php echo $logo_string ?></h4> 
                        <?php } ?>
                     </div>
                    <br/> 
                    <br/>
                    <br/>
		 
<?php if (Session::get_flash('success')): ?>
			<div class="alert alert-success">
				<strong><?php echo \Lang::get('message.sucess');?></strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
				</p>
			</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
			<div class="alert alert-error">
				<strong><?php echo \Lang::get('message.error');?></strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
				</p>
			</div>
<?php endif; ?>
		</div>
		<div class="span12">


  
<?php 
    $redirect_url  =  \Input::get('ab_url','0'); 

    if(!empty($redirect_url) && $redirect_url !== '0')
        $newUrl = '?ab_url='.$redirect_url;
    else 
        $newUrl = '';
?> 
  <?php echo Form::open(array('action' => $newUrl, 'method' => 'post','style' => "text-align-center;direction:rtl;")); ?>

	<?php if (isset($_GET['destination'])): ?>
		<?php echo Form::hidden('destination',$_GET['destination']); ?>
	<?php endif; ?>
          
	

	<div class="row" >
            <label for="email" class="span4"><?php echo \Lang::get('label.elmor.fill_username')?\Lang::get('label.elmor.fill_username'):'label.elmor.fill_username'; ?>:</label>
                <div class="input span3" style="text-align: center;"><?php echo Form::input('email', Input::post('email'),array("class"=>"span12",'style'=>'    width: 200px;    text-align: center;')); ?></div>
		
		<?php if ($val->error('email')): ?>
			<div class="error"><?php echo $val->error('email')->get_message('You must provide a username or email'); ?></div>
		<?php endif; ?>
	</div>
                    <br/> 

                    <div class="row" >

            
            
		<label for="password"  class="span4"><?php echo \Lang::get('label.elmor.fill_password')?\Lang::get('label.elmor.fill_password'):'label.elmor.fill_password'; ?>:</label>
		<div class="input span3" style="text-align: center;"><?php echo Form::password('password','',array("class"=>"span12",'style'=>'    width: 200px;    text-align: center;')); ?></div>
		
		<?php if ($val->error('password')): ?>
			<div class="error"><?php echo $val->error('password')->get_message(':label cannot be blank'); ?></div>
		<?php endif; ?>
	</div>
<?php echo Form::checkbox('remember_me',1, array('style' => 'display:none;', 'checked' => 'checked')); ?>

                    <br/> 
	<div class="actions" style="text-align: center;">
		<?php echo Form::submit(array('value'=>\Lang::get('message.'.'Login1'), 'name'=>'submit','id'=>'submit2',"class"=>"span6 btn btn-danger","style"=>"    background-image: -webkit-linear-gradient(top,#797979,#101010);  width: 130px; background-color: black;  width: 130px;")); ?>
	</div>

<?php echo Form::close(); ?>

		</div> 
	</div>
<?php echo Asset::js('jquery-1.9.1.min.js'); 
echo Asset::js('minified/jquery-ui.min.js');
echo Asset::js('additem.js');
echo Asset::js('shyam-created/autocomplete-widget.js');
echo Asset::js('shyam-created/autocomplete-widget_app.js'); 
echo Asset::js("bootstrap.min.js");
echo Asset::js("twitter-bootstrap-hover-dropdown.min.js"); 
echo Asset::js('jquery.chained.remote.js');
 echo Asset::js('autopopulate-data.js'); 
?>
 
 
 
 
</body>

</html>
