<a href="/<?php  echo $modulename ?>/<?php  echo \Inflector::pluralize($modulename); ?>/confirmDelete" id="confirmData" 
 class="btn btn-danger" >Mark All data deleted</a>

<h3>מחיקת שדות לאחר שליחת מייל (חוק הגנת הפרטיות)</h3>
<form method="post" >

<div class="span12 " style="text-align:center;"  >
  
<div class="span6">
    <label>נא לסמן במידה ויש צורך לבצע את המחיקה לאחר שליחת המייל כמו כן יש לסמן את השדות שיש למחוק לאחר שליחת המייל עם ה PDF ללקוח</label>
</div>
<div class="span2" >
    <input type="checkbox" style="width:24px;height:24px;" value="1" name="setresetfields"
     <?php if(isset($setresetfields) && $setresetfields == 1) echo "checked='checked'"; ?> />
</div>
</div>

<div class="col-12 " style="text-align:center;"  >
  
<div class="col-6">
    <h5>מחק גם את הנתונים ברשומות הקיימות</h5>
</div>
<div class="col-2" >
    <input type="checkbox" style="width:24px;height:24px;" value="1" name="deleteExistingfields"
     <?php if(isset($deleteExistingfields) && $deleteExistingfields == 1) echo "checked='checked'"; ?> />
</div>
</div>
<br/>
<br/><br/>
<?php if(isset($properties) && count($properties) > 0){ ?>
<?php foreach($properties as $key=>$prop){ 
    
    if(in_array($key, array('created_at','id','name'))) continue;
    
    ?>

<div class="span12" style="color:#555;" >
<div class="span4">
    <label><?php 
    $label =key_exists('label',$prop)?$prop['label']:"";
    
    echo \Lang::get($label)?\Lang::get($label):"" ?><br/> {<?php echo $key ?>}</label>
</div>
<div class="span3" >
    <input type="checkbox" style="width:24px;height:24px;" value="1" name="<?php echo $key ?>" <?php if(isset($fieldstobereset) && key_exists($key,$fieldstobereset) && $fieldstobereset[$key] == 1) echo "checked='checked'"; ?> />
</div>
</div>
<br/>
<br/>
<br/>
<?php } ?>
<?php } ?>
<input type="submit" value="Submit" class="btn btn-primary" />
</form>

<input type="hidden" value="/<?php  echo $modulename ?>/<?php  echo \Inflector::pluralize($modulename); ?>" id="urlpath" />