<!DOCTYPE html>
<html>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <?php echo \Asset::css('formbuilder/demo.css'); ?>
    <?php echo \Asset::css('formbuilder/demoRender.css'); ?> 
    <!--<link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.css">

    <?php echo \Asset::css('formbuilder/render.css'); ?> 
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  
    <title>jQuery formBuilder/formRender Demo</title>
   
</head>

<body class="render-body-wrap p-5">
  <style>
div[type="phonenumber"] select {
  width: 16% !important;
  height: 30px;
}
div[type="phonenumber"] input { 
  height: 30px;
}
</style>
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
   
<div class="modal fade"  id="myModal" tabindex="-1" role="dialog">
</div> 

<div class="sinature-box hidesignature" id="sinatureCanvasBox" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Signature</h4>
        </div>
        <div class="modal-body">
              <div id="middle">
                  <!--<div id="bcPaint" ></div>-->
              </div>
        </div>
            <button type="button" class="btn btn-default" id="close-modal" style="display:none" data-dismiss="modal">Close</button>

      </div> 
    </div> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.js"  crossorigin="anonymous"></script> 
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--> 
	
    <?php echo \Asset::js('formbuilder/vendor.js'); ?>
    <?php echo \Asset::js('bootstrap.min.js'); ?>
    <?php echo \Asset::js('formbuilder/form-builder.min.js'); ?>
    <?php echo \Asset::js('formbuilder/form-render.min.js'); ?>
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <?php echo \Asset::js('formbuilder/demoRender.js'); ?>  	
    <?php // echo \Asset::js('formbuilder/bcPaint.js'); ?>
    <?php echo \Asset::js('formbuilder/render.js'); ?>
</body>
<script>
      $(document).ready(function(){

        var  fbOptions = {};
        delete  fbOptions.formData 
        fbOptions.formData = <?php  
        $jsondata = '';
          if(isset($object) && is_object($object)){
                        if(!empty($object->currentform)){  

                            $x =$object->currentform; 
                            $x = htmlspecialchars_decode($x,ENT_QUOTES); 
                            $formde = json_decode($x ,true );    
                            $jsondata = $formde['json_data'] ;    
                        } 
                    }
                    
              if(!empty($jsondata))  echo $jsondata;
              else echo '{}';

        ?>;  
        frInstance = $('#renderMe').formRender(fbOptions);  
        
        });
    </script>
</body>
</html>
