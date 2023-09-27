<?php
$css = <<<EOT
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                                    
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">                  
                <style>
                @media only screen and (max-width: 500px) and (min-width: 320px) {
                    .modal.fade.in{
                        width:96%;
                        right:76%;
                        }
                }
                </style>

                <script1 @editlater
                src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js" 
                integrity="sha512-a6ctI6w1kg3J4dSjknHj3aWLEbjitAXAjLDRUxo2wyYmDFRcz2RJuQr5M3Kt8O/TtUSp8n2rAyaXYy1sjoKmrQ==" 
                crossorigin="anonymous" referrerpolicy="no-referrer">
                </script> 
                {$ltrcss} 
EOT;

$css1 =<<<EOTX

<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
            
        
        <?php echo Asset::css('bootstrap.min.css');
                ?>
                   
                <?php
        
            #echo Asset::css('jquery-ui-1.8.20.custom.css');
            echo Asset::css('minified/jquery-ui.min.css');
            echo Asset::css('chosen.min.css');
            echo Asset::css('select/select2.css'); 
        ?><style>
                 @media only screen and (max-width: 500px) and (min-width: 320px) {
   		.modal.fade.in{
   		width:96%;
   		right:76%;
   		
   		}
   
   }
                </style>
                
        <?php echo \Asset::css('formbuilder/formbuilder.css'); ?> 
        <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/assets/css/checkbox-x.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.snow.min.css">
                 
   <link rel="stylesheet" href="/{$filename}/{$controller}/formcss">
                <link rel="stylesheet" href="/{$filename}/{$controller}/newformcss">
                <link rel="stylesheet" href="/{$filename}/{$controller}/formcsstwo">
                <link rel="stylesheet" href="/{$filename}/{$controller}/formbuildercss">
                <link rel="stylesheet" href="/{$filename}/{$controller}/responsive">
                <link rel="stylesheet" href="/{$filename}/{$controller}/sectioncss">
                <link rel="stylesheet" href="/{$filename}/{$controller}/formcssresponsive">
                {$ltrcss}
EOTX;

echo $css;