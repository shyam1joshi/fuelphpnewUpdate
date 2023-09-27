<?php 


$fielddata = <<<SECTION
              <div class=" box-body form-group appendData"> 
            <?php 
           
                   if(isset(\$order->{$liname}) && count(\$order->{$liname}) > 0){ 
                   
                  \$count_{$field['name']}_line = count(\$order->{$liname})+1;
                   \$i=1;
                    foreach(\$order->{$liname} as \$key=>\$line){   

               ?>
       <div class="span12 box-body form-group " style="margin-right:0px;">
       <div class="box box-gray" >
           <div class="box-header box-header-section  with-border bg-gray" data-widget="collapse" data-target="#lab" data-mini="true" data-theme="b">
            {$removeButtonCode}
                <h4 class="box-title text-right"><span class="title">{$field['label']} <?php echo \$i ?></span></h4>
                       <a class="chevronBtnUp pull-left" data-widget="collapse"><span class="icon-chevron-up icon-large" ></span></a>                                    
                   </div>
                   <div id="lab" class="box-body" data-inset="true" data-theme="e" style="text-align:right" data-content-theme="d" >
                   {$fieldsData} 
               </div>
               </div>
               </div>
                     <?php 
                         
                       \$i++;
                           } ?>
                     <?php } ?>
               </div>
   <div class=" box-body form-group">
       <div class="span12">
           <label></label>
       </div>
       <div class= "span12 form-control">
SECTION;


echo $fielddata;