
<form method="post" />
<?php if(isset($properties) && count($properties) > 0){ ?>
<?php foreach($properties as $key=>$prop){ ?>

<div class="span12"  >
<div class="span4">
    <label><?php 
    $label =key_exists('label',$prop)?$prop['label']:"";
    
    echo \Lang::get($label)?\Lang::get($label):"" ?><br/> {<?php echo $key ?>}</label>
</div>
<div class="span3" >
    <input type="checkbox" style="width:24px;height:24px;" value="1" name="<?php echo $key ?>" <?php if(isset($csvproperties) && key_exists($key,$csvproperties) && $csvproperties[$key] == 1) echo "checked='checked'"; ?> />
</div>
</div>
<br/>
<br/>
<br/>
<?php } ?>
<?php } ?>
<input type="submit" value="Submit" class="btn btn-primary" />
</form>
