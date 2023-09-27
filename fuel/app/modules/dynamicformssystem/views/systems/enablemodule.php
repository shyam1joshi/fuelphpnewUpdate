<?php
/*
 * jsonrenderenablemodule 
 */
?>

<h3><a href="/dynamicformssystem/forms/getImportLinks/<?php echo $module ?>">Import Data Links</a></h3>
<h3><a href="/<?php echo $module ?>/<?php echo $module ?>s/setExportCSVFields">Set Export CSV Fields Link</a></h3>
<h3><a href="/<?php echo $module ?>/<?php echo $module ?>s/setFieldstobeSaved" style="color:#0b3cb3">הגדרת שדות טופס לגיבוי</a></h3>
<h3><a href="/<?php echo $module ?>/<?php echo $module ?>s/setfieldstobereset" style="color:#0b3cb3">Set Delete data after Mail sent</a></h3>
<!--<h3><a href="/<?php echo $module ?>/<?php echo $module ?>s/addMenuLinks">Add Menu Links</a></h3>-->
 
<style>

.fieldDisabled{
    opacity :0.6;
}
</style>

<script>

 function addAllColumnHeaders()
 {
    var myList=<?php echo json_encode($formray); ?>;     
    var myValues=<?php echo json_encode($inforay); ?>; 
     
    var grp = {};
    
    <?php $formgpay = array(array('id'=> 1 , 'name'=>'a')); foreach ($formgpay as $gp){  ?>
 
         grp["<?php echo $gp['id'] ?>"] = "<?php echo \Lang::get('label.setenablegroup.'.$gp['name'])?\Lang::get('label.setenablegroup.'.$gp['name']):'' ?>";
       
    <?php }  ?>
    
    for (var i = 0 ; i < myList.length ; i++) 
    {    
        var rowHash = myList[i];
        
        if(rowHash['group_id'] != null && rowHash['group_id'] != '' && rowHash['group_id'] != 0)
        {           
             var headerTr$3 = $('<div/>');           
             
             if(rowHash['title'] == '' || rowHash['title'] == null)
            {
                if(rowHash['type'] == 'checkbox')
                   headerTr$3.append($('<div/>').html(rowHash['name']).attr('class', 'span10').attr('style','font-weight:bold'));
                else
                    headerTr$3.append($('<div/>').html(rowHash['name']).attr('class', 'span6').attr('style','font-weight:bold'));
            }
            else
            {
                if(rowHash['type'] == 'checkbox'  )
                    headerTr$3.append($('<div/>').html(rowHash['title']).attr('class', 'span10').attr('style','font-weight:bold'));
                else
                    if(rowHash['type'] == 'textarea' )
                        headerTr$3.append($('<div/>').html(rowHash['title']).attr('class', 'span12').attr('style','font-weight:bold;padding: 12px 0px;'));
                    else
                        headerTr$3.append($('<div/>').html(rowHash['title']).attr('class', 'span6').attr('style','font-weight:bold'));
            }
            var cellValue = myValues[rowHash['name']];
            
           if(rowHash['type'] === 'textarea'){
                var new1 = $('<textarea/>');
                
                
                 new1.attr('type', rowHash['subtype']);
                 new1.attr('id', rowHash['elementid']);
                 new1.attr('name', rowHash['name']);
                 
                  var headernew1 = $('<div/>');           
                  headernew1.addClass('span10');
                 new1.append(myValues[rowHash['name']]);
                  
                  headernew1.append(new1);  
                  
                  new1 = headernew1;
             } else{
                if(rowHash['type'] === 'select'){ 
                    var new1 = $('<select/>');
                                     
                    if (rowHash['options'] != undefined){ 
                        
                        $.each(rowHash['options'],function(val, idx){
                            var opt = $('<option/>');
                    
                            opt.append(idx);
                            
                            if(myValues[rowHash['name']] == val)
                                opt.attr('selected','selected');
                        
                            opt.attr('value',val);
                            new1.append(opt);
                        });
                    }
                     
                 } else{
                    var new1 = $('<input/>');

                    if(rowHash['disabled'] == 'disabled'){
                new1.attr('style','pointer-events:none;');
            }   
                    if(rowHash['type'] == 'checkbox')
                        new1.val('1');   
                    else
                        if(rowHash['type'] == 'textbox'|| rowHash['type'] == 'date')
                            new1.val(myValues[rowHash['name']]);  
                new1.attr('type', rowHash['type']);

                }
            }
            new1.attr('name', rowHash['name']);
            
            
            if(cellValue == '1')
                new1.attr('checked', 'checked');  
           
            headerTr$3.append(new1);
            
            if(rowHash['name'] == 'apikey'){
                
                headerTr$3.append('&nbsp;&nbsp;<button id="generateUUid" class="btn btn-info"> Generate API Key</button>');
                }
//            console.log(document.getElementById(rowHash['group_id'])); 
            if(document.getElementById(rowHash['group_id']) == null)
            {
                var headerTr$2 = $('<div/>');
                headerTr$2.attr('class', 'span5');
                
               
                var headerTr$ = $('<div/>');
                headerTr$.attr('class', 'span12');
                headerTr$.attr('id', rowHash['group_id']);
                headerTr$.attr('style', 'border:3px solid black');
             
                var title = $('<label/>');
                title.append(grp[rowHash['group_id']]);
                 
                title.attr('style', 'padding:1% 2% 1% 0%');
                headerTr$.append(title); 
                
                if(i == 0)
                   headerTr$2.attr('style', ' margin-right: 2.1%;');    
                    
                if(rowHash['visible'] == 0){
                    headerTr$3.attr('style','display:none;padding:3% 2% 2% 0%');
                }else      
                headerTr$3.attr('style', 'padding:3% 2% 2% 0%');
                
                if(rowHash['disabled'] == 'disabled'){
                    headerTr$3.addClass('fieldDisabled');
                } else{
                    
                    headerTr$3.removeClass('fieldDisabled');
                }

                headerTr$.append(headerTr$3);
            }
            else{
                            
                if(rowHash['visible'] == 0){
                    headerTr$3.attr('style','display:none;padding:3% 2% 2% 0%');
                }else            
                 headerTr$3.attr('style', 'padding:3% 2% 2% 0%');

                 if(rowHash['disabled'] == 'disabled'){
                    headerTr$3.addClass('fieldDisabled');
                } else{
                    
                    headerTr$3.removeClass('fieldDisabled');
                }

             
                $('#'+rowHash['group_id']).append(headerTr$3);
                
            }

            headerTr$2.append(headerTr$); 
            
        }else{
            var headerTr$2 = $('<div/>');
            headerTr$2.attr('class', 'span5');
      
            var headerTr$ = $('<div/>');

            headerTr$.attr('class', 'span12'); 
        
            if(i == 0)
                headerTr$.attr('style', 'border:6px solid black; padding:5px;margin-right: 2.1%;');    
            else
                headerTr$.attr('style', 'border:6px solid black; padding:5px;');

            if(rowHash['title'] == '' || rowHash['title'] == null)
            {
                if(rowHash['type'] == 'checkbox')
                   headerTr$.append($('<div/>').html(rowHash['name']).attr('class', 'span10').attr('style','font-weight:bold'));
                else
                    headerTr$.append($('<div/>').html(rowHash['name']).attr('class', 'span6').attr('style','font-weight:bold'));
            }
            else
            {
                if(rowHash['type'] == 'checkbox')
                    headerTr$.append($('<div/>').html(rowHash['title']).attr('class', 'span10').attr('style','font-weight:bold'));
                else
                    headerTr$.append($('<div/>').html(rowHash['title']).attr('class', 'span6').attr('style','font-weight:bold'));
            }
              
            var cellValue = myValues[rowHash['name']];
         
            var new1 = $('<input/>');
            new1.attr('type', rowHash['type']);
            new1.attr('name', rowHash['name']);
            if(rowHash['disabled'] == 'disabled'){
                new1.attr('style','pointer-events:none;');
            } 

            if(rowHash['type'] == 'checkbox')
                new1.val('1');   
            else
                if(rowHash['type'] == 'textbox'|| rowHash['type'] == 'date')
                    new1.val(myValues[rowHash['name']]);  
            
            if(cellValue == '1')
                new1.attr('checked', 'checked');  
           
            headerTr$.append(new1);
            if(rowHash['visible'] == 0){
                headerTr$.attr('style','display:none');
            }
            if(rowHash['disabled'] == 'disabled'){
                headerTr$2.addClass('fieldDisabled');
            }  else{
                
                headerTr$2.removeClass('fieldDisabled');
            }
            headerTr$2.append(headerTr$); 
        }
       
        
//            $("#excelDataTable").append(headerTr$2);
            $("#excelDataTable").prepend(headerTr$2);
            
            try{  
        
                $('#loadTinyMCE').trigger('click');
          }catch( ex){
              console.log('Exception occured '+ex);
          }
 
    }
     
     $("#excelDataTable").append("<div class= 'span12' style = 'padding:20px;' ><input type ='submit' class= 'btn btn-primary' value='submit' name = 'submit'/></div>");
 
 }
 
    
    
  </script>    
 
<body onLoad="addAllColumnHeaders();">
    <form id="excelDataTable" method="post" >
        
        
        
        
        
        <div id ="logoWrap" class="span5 my-2" style=" display: flex;border: 3px solid black; margin-right: 2.1%;">
            <h5 style="padding:3% 2% 2% 0%"><?php echo \Lang::get('label.forms.upload_logo')?\Lang::get('label.forms.upload_logo'):'upload_logo' ?> &nbsp; : &nbsp;</h5>

          <?php if(isset($logo) && is_object($logo)) {  ?>
                <div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> 
                    <div class="thumbnail" style="    width: 60px;display:table-cell;mat">
                        <a class="delete-img" name="logo" data-id="<?php if(isset($logo->id))  echo $logo->id  ?>">
                            <i class="icon-remove"></i>
                        </a> 
                      <a href="/Model_Products/<?php if(isset($logo->name))  echo $logo->name  ?>" target="_blank">
                         <img src="/Model_Products/<?php if(isset($logo->name))  echo $logo->name  ?>" style="width: 55px;  height: 60px;">
                        </a>
                    </div> 
                </div>

            <?php } ?>
            <input type="file" name='logo' class="form-file-upload"  <?php if(isset($logo) && is_object($logo) ) {  ?> style="display:none" <?php }else{ ?>style="padding:3% 2% 2% 0%" <?php } ?>  data-url="/dynamicformssystem/forms/createImagex" id="formLogo" value="" />
           <input type="hidden" name="logo" value="<?php if(isset($logo) && is_object($logo) ) echo $logo->id;  ?>">
      </div> 
        <div id ="logoWrap" class="span5 my-2" style=" display: flex;border: 3px solid black; margin-right: 2.1%;">
            <h5 style="padding:3% 2% 2% 0%"><?php echo \Lang::get('label.forms.upload_logo1')?\Lang::get('label.forms.upload_logo1'):'העלה תמונת רקע' ?> &nbsp; : &nbsp;</h5>

          <?php if(isset($backgroundimage) && is_object($backgroundimage)) {  ?>
                <div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> 
                    <div class="thumbnail" style="    width: 60px;display:table-cell;mat">
                        <a class="delete-img" name="backgroundimage" data-id="<?php if(isset($backgroundimage->id))  echo $backgroundimage->id  ?>">
                            <i class="icon-remove"></i>
                        </a> 
                      <a href="/Model_Products/<?php if(isset($logo->name))  echo $backgroundimage->name  ?>" target="_blank">
                         <img src="/Model_Products/<?php if(isset($backgroundimage->name))  echo $backgroundimage->name  ?>" style="width: 55px;  height: 60px;">
                        </a>
                    </div> 
                </div>

            <?php } ?>
            <input type="file" name='backgroundimage' class="form-file-upload"  <?php if(isset($backgroundimage) && is_object($backgroundimage) ) {  ?> style="display:none" <?php }else{ ?>style="padding:3% 2% 2% 0%" <?php } ?>  data-url="/dynamicformssystem/forms/createImagex" id="formLogo" value="" />
           <input type="hidden" name="backgroundimage" value="<?php if(isset($backgroundimage) && is_object($backgroundimage) ) echo $backgroundimage->id;  ?>">
      </div> 
        <div id ="logoWrap" class="span5 my-2" style=" display: flex;border: 3px solid black; margin-right: 2.1%;">
            <h5 style="padding:3% 2% 2% 0%"><?php echo \Lang::get('label.forms.upload_logo1')?\Lang::get('label.forms.upload_logo1'):'WhatsApp Image ' ?> &nbsp; : &nbsp;</h5>

          <?php if(isset($whatsapp_image) && is_object($whatsapp_image)) {  ?>
                <div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> 
                    <div class="thumbnail" style="    width: 60px;display:table-cell;mat">
                        <a class="delete-img" name="backgroundimage" data-id="<?php if(isset($whatsapp_image->id))  echo $whatsapp_image->id  ?>">
                            <i class="icon-remove"></i>
                        </a> 
                      <a href="/Model_Products/<?php if(isset($whatsapp_image))  echo $whatsapp_image->name  ?>" target="_blank">
                         <img src="/Model_Products/<?php if(isset($whatsapp_image))  echo $whatsapp_image->name  ?>" style="width: 55px;  height: 60px;">
                        </a>
                    </div> 
                </div>

            <?php } ?>
            <input type="file" name='whatsapp_image' class="form-file-upload"  <?php if(isset($whatsapp_image) && is_object($whatsapp_image) ) {  ?> style="display:none" <?php }else{ ?>style="padding:3% 2% 2% 0%" <?php } ?>  data-url="/dynamicformssystem/forms/createImagex" id="formLogo" value="" />
           <input type="hidden" name="whatsapp_image" value="<?php if(isset($whatsapp_image) && is_object($whatsapp_image) ) echo $whatsapp_image->id;  ?>">
      </div> 
    </form>
    <div class="span12">
    <div class="span4">
        <a class="btn btn-success" style="margin-top: -50px;float:left;" href="/dynamicformssystem/<?php echo $module; ?>/<?php echo $module; ?>s/labelers">Labelers</a>
    </div>
    </div>
    <div class="span12" style="padding: 1% 0%;">
    
    <!--<a class="btn " href="/printsizes/systems/setFontsizes"><?php echo \Lang::get('label.system.setprint')?\Lang::get('label.system.setprint'):"label.system.setprint";?></a>-->
  
  </div>
  
   
</body>​

