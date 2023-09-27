<form id="edit_article_form" class="form-horizontal" name="edit_article" enctype="multipart/form-data" action="" accept-charset="utf-8" method="post" style="
" role="form">
    <fieldset>
    <div class="control-group ">
        <label id="label_username" for="form_username" class="control-label">שם משתמש <span style="color:red">*</span></label>
        <div class="controls ">
            <?php if(isset($car->user)) echo $car->user?$car->user->username:'' ?> <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_password" for="form_password" class="control-label">סיסמה <span style="color:red">*</span></label>
        <div class="controls ">
           <?php if(isset($car->user)) echo '****' ?>
                <span></span>  
        </div>
    </div>
     
    <div class="control-group ">
        <label id="label_email" for="form_email" class="control-label">אמייל<span style="color:red">*</span></label>
        <div class="controls ">
            <?php if(isset($car->user)) echo $car->user?$car->user->email:'' ?>
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_clearance" for="form_clearance" class="control-label">clearance</label>
        <div class="controls ">
           <?php if(isset($car->user)) echo $car->user?$car->user->clearance:'' ?>
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_name" for="form_name" class="control-label">שם סוכן<span style="color:red">*</span></label>

        <div class="controls ">
           <?php if(isset($car->name)) echo $car->name ?>
            <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_agent_code" for="form_agent_code" class="control-label">מספר סוכן</label>
        <div class="controls ">
            <?php if(isset($car->agent_code)) echo $car->agent_code ?>
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_allowupdate" for="form_allowupdate" class="control-label"><?php echo \Lang::get('label.agents.manager')?\Lang::get('label.agents.manager'):'Admin'; ?></label>

        <div class="controls ">
            <input type="checkbox" disabled="disabled" class="span1" autocomplete="off"  value="1" id="form_allowupdate" name="allowupdate" <?php if(isset($car->allowupdate) &&  $car->allowupdate == 1) echo "checked" ?>>
            <span></span>  
        </div>
    </div>     
   
    <input type="hidden" class="span4" value="1" id="form_allow_web" name="allow_web">
    <input type="hidden" class="span4" value="1" id="form_allow_mobile" name="allow_mobile">
             
    <div class="control-group ">

       
    </div> 
    </fieldset>
</form>
