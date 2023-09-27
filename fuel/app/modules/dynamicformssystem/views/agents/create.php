<form id="edit_article_form" class="form-horizontal" name="edit_article" enctype="multipart/form-data" action="" accept-charset="utf-8" method="post" style="
" role="form">
    <fieldset>
    <div class="control-group ">
        <label id="label_username" for="form_username" class="control-label">שם משתמש <span style="color:red">*</span></label>
        <div class="controls ">
            <input type="text"class="span4" autocomplete="off" placeholder="שם משתמש" required="required"  value="<?php if(isset($car->user)) echo $car->user?$car->user->username:'' ?>" <?php if(isset($car->user)) echo "disabled='disabled'" ?> id="form_username" name="username"> 
            
            <?php if(isset($car->user)) {  ?>
            <input type="hidden"class="span4" autocomplete="off" placeholder="שם משתמש" required="required"  value="<?php if(isset($car->user)) echo $car->user?$car->user->username:'' ?>"  id="form_username" name="username"> 
             
            <?php } ?>   <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_password" for="form_password" class="control-label">סיסמה <span style="color:red">*</span></label>
        <div class="controls ">
            <input type="password" autocomplete="off" class="span4"  placeholder="סיסמה" required="required"  value="<?php if(isset($car->user)) echo '****' ?>" id="form_password" name="password"> 
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_repeat_password" for="form_repeat_password" class="control-label">Repeat Password <span style="color:red">*</span></label>
        <div class="controls ">
            <input type="password"class="span4" autocomplete="off" placeholder="Repeat Password" required="required" value="<?php if(isset($car->user)) echo '****' ?>" id="form_repeat_password" name="repeat_password"> 
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_email" for="form_email" class="control-label">אמייל<span style="color:red">*</span></label>
        <div class="controls ">
            <input type="email"class="span4" autocomplete="off" placeholder="אמייל" required="required"  value="<?php if(isset($car->user)) echo $car->user?$car->user->email:'' ?>" id="form_email" name="email"> 
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_clearance" for="form_clearance" class="control-label">clearance</label>
        <div class="controls ">
            <input type="text"class="span4" autocomplete="off" placeholder="clearance" value="<?php if(isset($car->user)) echo $car->user?$car->user->clearance:'' ?>" id="form_clearance" name="clearance"> 
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_name" for="form_name" class="control-label">שם סוכן<span style="color:red">*</span></label>

        <div class="controls ">
            <input type="text" class="span4" autocomplete="off" placeholder="שם סוכן" required="required"  value="<?php if(isset($car->name)) echo $car->name ?>" id="form_name" name="name"> 
            <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_agent_code" for="form_agent_code" class="control-label">מספר סוכן</label>
        <div class="controls ">
            <input type="text"class="span4" autocomplete="off" placeholde r="מספר סוכן" value="<?php if(isset($car->agent_code)) echo $car->agent_code ?>" id="form_agent_code" name="agent_code"> 
                <span></span>  
        </div>
    </div>
    <div class="control-group ">
        <label id="label_allowupdate" for="form_allowupdate" class="control-label"><?php echo \Lang::get('label.agents.manager')?\Lang::get('label.agents.manager'):'Admin'; ?></label>

        <div class="controls ">
            <input type="checkbox" class="span1" autocomplete="off"  value="1" id="form_allowupdate" name="allowupdate" <?php if(isset($car->allowupdate) &&  $car->allowupdate == 1) echo "checked" ?>>
            <span></span>  
        </div>
    </div>   
    <div class="control-group ">
        <label id="label_allow_web" for="form_allow_web" class="control-label"><?php echo \Lang::get('label.agents.manager')?\Lang::get('label.agents.manager'):'Allow Agent view/edit his records'; ?></label>

        <div class="controls ">
            <input type="checkbox" class="span1" autocomplete="off"  value="1" id="form_allowonlyagentdata" name="allowonlyagentdata" <?php if(isset($car->allowonlyagentdata) &&  $car->allowonlyagentdata == 1) echo "checked" ?>>
            
            <span></span>  
        </div>
       
    </div>   
    <div class="control-group ">
        <label id="label_sendemail" for="form_sendemail" class="control-label"><?php echo \Lang::get('label.agents.manager')?\Lang::get('label.agents.manager'):'Send Email'; ?></label>

        <div class="controls ">
            <input type="checkbox" class="span1" autocomplete="off"  value="1" id="form_sendemail" name="sendemail" <?php if(isset($car->sendemail) &&  $car->sendemail == 1) echo "checked" ?>>
            
            <span></span>  
        </div>
    </div> 
    <div class="control-group ">
        <label id="label_receiveAllEmail" for="form_receiveAllEmail" class="control-label"><?php echo \Lang::get('label.agents.manager')?\Lang::get('label.agents.manager'):'Get All Emails'; ?></label>

        <div class="controls ">
            <input type="checkbox" class="span1" autocomplete="off"  value="1" id="form_receiveAllEmail" name="receiveAllEmail" <?php if(isset($car->receiveAllEmail) &&  $car->receiveAllEmail == 1) echo "checked" ?>>
            
            <span></span>  
        </div>
    </div>  
    <div class="control-group ">
        <label id="label_allowonlyagentdata" for="form_allowonlyagentdata" class="control-label"><?php echo \Lang::get('label.agents.manager')?\Lang::get('label.agents.manager'):'Enable Login'; ?></label>
        <div class="controls ">
            <input type="checkbox" class="span1" autocomplete="off"  value="1" id="form_allow_web" name="allow_web" <?php if(isset($car->allow_web)){ if($car->allow_web == 1) echo "checked"; } else echo "checked";  ?>>
            
            <span></span>  
        </div>
    </div>    
    
    <div class="span12 box-body form-group mainimgHolder" style='display: inline-flex;'  >
        <div  class="span2"><label><p>Agent Signature&nbsp;&nbsp;&nbsp;</p>        </label>  <br/>
    </div>
        <div  >

        <input type="file" class="file-upload-control span6  file-upload-control" label="File Upload" placeholder="" autocomplete="off" attr-name="signimage" name="signimage" multiple="" maxlimit="1" readonly="" data-url="/bootstrapformsystemconverted/forms/createImagex" style="    opacity: 0;
    z-index: 111; 
    width: 98px;
    margin-right: 25%;" />
            <input type="hidden" class="file-upload-control span6  file-upload-control" label="File Upload" placeholder="" autocomplete="off" attr-name="signimage" name="signimage" value="<?php if(isset($car->signimage)) echo $car->signimage ?>" id="signimage" multiple="" maxlimit="1" readonly="" data-url="/bootstrapformsystemconverted/forms/createImagex" style="    opacity: 0;
    z-index: 111; 
    width: 98px;
    margin-right: 25%;" />    <button type="hidden" class=" pull-left file-upload-button file-upload-control" placeholder="" autocomplete="off" attr-name="signimage" name="signimage" multiple="" maxlimit="1" readonly="" data-url="/bootstrapformsystemconverted/forms/createImagex" style="padding: 6px 13px;border-radius: 4px;" onclick="return false;">העלאה</button> 
        

            <!-- <input type="text" style="    direction: ltr;" readonly="readonly" value="<?php // if(isset($order->name)) echo $order->name ?>" class="form-control inputfield" label="&lt;p&gt;אימייל לקבלת האישור (1)&lt;/p&gt;" placeholder="" autocomplete="off" name="exam_name" id="" /> -->
        </div> 
        <div class="row progressbar"></div>
                        <div class="span12 row showfiles my-3 mx-2">
    </div> 
    </div> 
    <div class="control-group ">
        <label id="label_disableindex" for="form_disableindex" class="control-label"><?php echo \Lang::get('label.agents.disableindex')?\Lang::get('label.agents.disableindex'):'Disable listindex'; ?></label>

        <div class="controls ">
            <input type="checkbox" class="span1" autocomplete="off"  value="1" id="form_disableindex" name="disableindex" <?php if(isset($car->disableindex) &&  $car->disableindex == 1) echo "checked" ?>>
            <span></span>  
        </div>
    </div>     
    <?php if(isset($formsallowed) && count($formsallowed) > 0  && 1==0){ 
        
        if(isset($car->formsallowed)){
        $carformsallowed = $car->formsallowed;
        $carformsallowed = json_decode($carformsallowed);
        }
        ?>
        
        <div class="control-group ">
        <label id="label_disableindex" for="form_disableindex" class="control-label"><?php echo \Lang::get('label.agents.disableindex')?\Lang::get('label.agents.disableindex'):'Choose Forms Allowed'; ?></label>

        <?php foreach($formsallowed as $formallowed){ ?>
        <div class="controls ">
            <input type="checkbox" 
               <?php     if(isset($car->formsallowed)){
        $carformsallowed = $car->formsallowed;
        $carformsallowed = json_decode($carformsallowed);
        
        if(is_array($carformsallowed) && key_exists($formallowed['modulename'],$carformsallowed))
                echo 'checked="checked"';
        } 
        ?>
                   class="span1" autocomplete="off"  value="1" id="form_disableindex" name="formsallowed[<?php echo $formallowed['modulename'] ?>]" <?php if(isset($car->disableindex) &&  $car->disableindex == 1) echo "checked" ?>>
            <span><?php echo $formallowed['modulename'] ?></span>  
        </div>
        <?php } ?> 
    </div>    
        <?php } ?> 
   
    <input type="hidden" class="span4" value="1" id="form_allow_mobile" name="allow_mobile">
    
    
    
    <div class="control-group ">

        <div class="controls ">
            <input type="submit" value="שמור" class="btn btn-primary" id="form_submit" name="submit">
            <span></span> 
        </div>
    </div> 
    </fieldset>
</form>
