
<!-- <h3>הגדרת שדות טופס לגיבוי</h3>
 -->
 <div dir="rtl" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><u>הגדרת שדות שנשמרים בבסיס הנתונים - מתאים רק ללקוחות עם מערכת ניהול</u></div>
<div dir="rtl" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;">באופן דיפולטיבי כל השדות נשמרים, ניתן לסמן וי על הגדרה זו&nbsp; (Set Save Fields) במידה ורוצים לשמור רק חלק מהשדות(שדות רגישים) ואז יש לסמן את השדות שיישמרו, ברגע שמפעילים אפשרות זו תתבצע מחיקה לאחור ברשומות הקיימות</div>
<div dir="rtl" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;">*יש לשים לב שבמידה והשדות האלה מסומנים ונשלח מייל ללקוח בנוסף למערכת ניהול&nbsp;המייל יישלח&nbsp;ללא השדות המסומנים</div>
<div><br></div>
 <form method="post" >

<div class="span12 " style="text-align:center;"  >
<div class="span4">
</div>
<div class="span2">
    <label>Set Save Fields</label>
</div>
<div class="span2" >
    <input type="checkbox" style="width:24px;height:24px;" value="1" name="setsavefields"
     <?php if(isset($setsavefields) && $setsavefields == 1) echo "checked='checked'"; ?> />
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
    <input type="checkbox" style="width:24px;height:24px;" value="1" name="<?php echo $key ?>" <?php if(isset($fieldstobesaved) && key_exists($key,$fieldstobesaved) && $fieldstobesaved[$key] == 1) echo "checked='checked'"; ?> />
</div>
</div>
<br/>
<br/>
<br/>
<?php } ?>
<?php } ?>
<input type="submit" value="Submit" class="btn btn-primary" />
</form>
