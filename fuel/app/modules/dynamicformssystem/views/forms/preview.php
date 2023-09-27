<!DOCTYPE html>
<html>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <?php echo \Asset::css('formbuilder/demo.css'); ?>
    <?php echo \Asset::css('formbuilder/demoRender.css'); ?> 
  <link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.css">

  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  
  <title><?php echo $form_name; ?></title>
  <style>
    html, body {
        margin: 0; 
        height: auto; 
        overflow: hidden;   
        padding: 7px 24px;
        background: white;
        min-height: 609px;
    }
    
    html{
        overflow-y: scroll;
    }
      
    .form-overflow{        
        overflow: scroll;   
        overflow-x: hidden;
    }
    
    .rendered-form>.form-group>label{ 
        width:100%;
    }
    .rendered-form .form-group ul.fb-autocomplete-list{ 
        width:161px !important;
    }
      
       input.form-control,select.form-control{
            width: 33% !important;
        }  
  </style>
</head>

<body style="    direction: rtl;     border: 1px solid #cecacae0;overflow-y: hidden;" class=" p-5">
  <div class="content">
    
      <div class="action-buttons" style="display: none;">     
      <label>Actions</label>
      <button id="set-autocomplete" type="button">Autocomplete</button>
      <button id="set-hidden" type="button">Hidden</button>
      <button id="set-select" type="button">Select</button>
      <button id="set-checkbox-group" type="button">Checkbox Group</button>
      <button id="set-radio-group" type="button">Radio Group</button>
      <button id="set-text" type="button">Text</button>
      <button id="set-password" type="button">Password</button>
      <button id="set-email" type="button">Email</button>
      <button id="set-color" type="button">Color</button>
      <button id="set-tel" type="button">Telephone</button> 
      <button id="set-date" type="button">Date</button>
      <button id="set-number" type="button">Number</button>
      <button id="set-textarea" type="button">Textarea</button>
      <button id="set-textarea-tinymce" type="button">Textarea-TinyMCE</button> 
      <button id="showdata" type="button" class="btn btn-sm btn-info">Show Data</button>      
      
  </div>
  </div>

    <div id="renderMe"></div>

    <div id="showData"></div>

 
    <?php echo \Asset::js('formbuilder/vendor.js'); ?>
    <?php echo \Asset::js('formbuilder/form-builder.min.js'); ?>
    <?php echo \Asset::js('formbuilder/form-render.min.js'); ?>
  <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <?php echo \Asset::js('formbuilder/demoRender.js'); ?>
</body>
    <script>
      $(document).ready(function(){

        var  fbOptions = {};
        delete  fbOptions.formData 
        fbOptions.formData = <?php  
//         $str =  htmlspecialchars_decode($sysobj,ENT_QUOTES);
//                echo json_encode($str,JSON_UNESCAPED_UNICODE);
// $x =$sysobj; 
////                            $x = htmlspecialchars_decode($x,ENT_QUOTES); 
//                            $formde = json_decode($x ,true );    
//                            $jsondata = $sysobj_json ;
//                            
                            echo $sysobj_json;

        ?>;  
        frInstance = $('#renderMe').formRender(fbOptions);  
        
        });
    </script>
</body>
</html>
