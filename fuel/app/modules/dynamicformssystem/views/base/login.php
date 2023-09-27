  
<?php 
    $redirect_url  =  \Input::get('ab_url','0'); 

    if(!empty($redirect_url) && $redirect_url !== '0')
        $newUrl = '?ab_url='.$redirect_url;
    else 
        $newUrl = '';
?>
  <?php echo Form::open(array('action' => $newUrl, 'method' => 'post')); ?>

	<?php if (isset($_GET['destination'])): ?>
		<?php echo Form::hidden('destination',$_GET['destination']); ?>
	<?php endif; ?>
          
	

	<div class="row">
		<label for="email"><?php echo \Lang::get('message.'.'Email or Username'); ?>:</label>
		<div class="input"><?php echo Form::input('email', Input::post('email')); ?></div>
		
		<?php if ($val->error('email')): ?>
			<div class="error"><?php echo $val->error('email')->get_message('You must provide a username or email'); ?></div>
		<?php endif; ?>
	</div>

	<div class="row">

            
            
		<label for="password"><?php echo \Lang::get('message.'.'Password'); ?>:</label>
		<div class="input"><?php echo Form::password('password'); ?></div>
		
		<?php if ($val->error('password')): ?>
			<div class="error"><?php echo $val->error('password')->get_message(':label cannot be blank'); ?></div>
		<?php endif; ?>
	</div>
<div class="row" style="display: inline-flex;">

            
            
		<label for="remember_me"><?php echo \Lang::get('message.'.'remember_me')?\Lang::get('message.'.'remember_me'):'Remember me'; ?>:</label>
                &nbsp;&nbsp;   <?php echo Form::checkbox('remember_me',1); ?> 
		 
	</div>

	<div class="actions">
		<?php echo Form::submit(array('value'=>\Lang::get('message.'.'Login'), 'name'=>'submit')); ?>
	</div>

<?php echo Form::close(); ?>

 