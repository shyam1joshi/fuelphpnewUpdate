<?php 



$header =<<<HEADER

        <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
                {$whatsApp} 
                {$css}
        <title><?php  if(isset(\$title)) echo \Lang::get(\$title); ?></title>
	    <style>
            .form-group .span12{
                margin-right:0 !important;
            }
         
            .background-image{
                background-image: <?php if(isset(\$backgroundimage) && !empty(\$backgroundimage)) { echo "url('".\$backgroundimage."')";   }else{ ?> url('{$objbackgroud}') <?php } ?> ;
                background: <?php if(isset(\$backgroundimage) && !empty(\$backgroundimage)) { echo "url('".\$backgroundimage."')";   }else{ ?> url('{$objbackgroud}') <?php } ?>  no-repeat fixed center;
                 background-size: cover;
                    zoom: unset !important;
            }
            {$background}
            div.box-header.section-color{
                background-color:  <?php if(isset(\$color_scheme)){  
                    echo \$color_scheme;
        } ?> !important; 
                color: black !important;
            /*    border-bottom: 1px solid <?php if(isset(\$color_scheme)){  
                 //   echo \$color_scheme;
        } ?> !important;*/
            }
            div.box-header-section.section-color{
              /*   background-color:  <?php if(isset(\$color_scheme)){  
                    echo \$color_scheme;
        } ?> !important; */
                color: black !important;
              /*   border-bottom: 1px solid <?php if(isset(\$color_scheme)){  
                 //   echo \$color_scheme;
        } ?> !important;*/
            }
            div.box.section-border-top {
             /*    border-top: 1px solid <?php if(isset(\$color_scheme)){  
               //     echo \$color_scheme;
        } ?> !important; */
            }
            .icon-chevron-up,.icon-chevron-down {
                color:<?php if(isset(\$iconcolor)){  
                    echo \$iconcolor;
        } ?> !important;
            }

            .section-border-top div.box-header.section-color{
                border-bottom:3px solid <?php if(isset(\$bordercolor)){  
                    echo \$bordercolor;
        } ?> !important;
            }

                
            .button {
                display: inline-block; 
                display: inline;
                padding: 4px 12px;
                margin-bottom: 0; 
                margin-right: .3em;
                font-size: 14px;
                line-height: 20px;
                color: #333;
                text-align: center;
                text-shadow: 0 1px 1px rgba(255,255,255,0.75);
                vertical-align: middle;
                cursor: pointer;   
                    box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 1px 2px rgba(0,0,0,0.05);
    border-radius: 4px;
            }
            div img#header-logo{
                <?php if(isset(\$logo_position) && !empty(\$logo_position)){  ?>
                    float: <?php echo \$logo_position ?>; 
                <?php } ?>
                <?php if(isset(\$logo_portrait_mode) && \$logo_portrait_mode == 1){  ?>
                    <?php if(isset(\$logo_height) && isset(\$logo_width) && !empty(\$logo_height) 
                        && !empty(\$logo_width)){ ?>
                     <?php      if(\$logo_width  < \$logo_height){  ?> 
                        height: <?php echo \$logo_height ?>px;  
                        width: <?php echo \$logo_width ?>px; 
                        <?php }else{ ?>

                     height: <?php echo \$logo_width ?>px;  
                        width: <?php echo \$logo_height ?>px; 
                       <?php } ?> 
                    <?php }else{ ?>
                        height: auto;  
                              width: auto; 
                    <?php } ?>
                <?php }else{ ?> 
                     <?php if(isset(\$logo_height) && isset(\$logo_width) && !empty(\$logo_height) 
                        && !empty(\$logo_width)){ ?>
                     <?php      if(\$logo_width  > \$logo_height){  ?> 
                        height: <?php echo \$logo_height ?>px;  
                        width: <?php echo \$logo_width ?>px; 
                        <?php }else{ ?>

                     height: <?php echo \$logo_width ?>px;  
                        width: <?php echo \$logo_height ?>px; 
                       <?php } ?> 
                    <?php }else{ ?>
                        height: auto;  
                              width: auto; 
                    <?php } ?>
                <?php } ?>
            }
        </style>
    </head>
HEADER;

echo $header;