<?php 

echo 
    '<?php  $whatsAppArray = array("whatsapp_title"=>"title","whatsapp_image"=>"image","whatsapp_description"=>"description");'.
    "\n".'foreach($whatsAppArray as $variable=>$key)'.

    "\n".'if(isset( $$variable) && !empty($$variable)) {?>'.


    "\n".'<meta property="og:<?php  echo $key ?>" content="<?php  echo $$variable ?>"> '.
    "\n".' <?php } ?>';



        
              

              
        
              
        
             