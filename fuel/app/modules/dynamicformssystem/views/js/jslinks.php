<?php 

$js =<<<JS

                
<!--       <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> 
	-->  <?php 
echo Asset::js('jquery-1.9.1.min.js'); ?>
    <?php // echo \Asset::js('formbuilder/vendor.js'); ?>
    <?php // echo \Asset::js('bootstrap.min.js'); ?>
    <?php // echo \Asset::js('formbuilder/demoRender.js'); ?>  
    <?php 
 
echo Asset::js('minified/jquery-ui.min.js');
echo Asset::js('shyam-created/autocomplete-widget.js');
echo Asset::js("bootstrap.min.js"); ?>
        
    <?php // echo \Asset::js('formbuilder/bcPaint.js'); ?>	
      <?php // echo \Asset::js('formbuilder/render.js'); ?>
    <?php // echo \Asset::js('formbuilder/formbuilder.js'); ?>
                
        <?php
echo Asset::js("twitter-bootstrap-hover-dropdown.min.js");
echo Asset::js('jquery.chained.remote.js');
echo Asset::js('shyam-created/autocomplete-widget_app.js'); ?>
    <?php echo Asset::js('fileupload/jquery.fileupload.js'); ?>    
      <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

<script type="text/javascript" src="/{$filename}/{$controller}/clipboardJS"></script>
<script type="text/javascript" src="/{$filename}/{$controller}/sinatureJS?id=<?php echo time()?>"></script>

<script type="text/javascript" src="/{$filename}/{$controller}/formbuildernewjs"></script>
<script type="text/javascript" src="/{$filename}/{$controller}/showhidejstwo"></script>
<script type="text/javascript" src="/{$filename}/{$controller}/mathjs"></script>
<script type="text/javascript" src="/{$filename}/{$controller}/autosave"></script>
<script type="text/javascript" src="/{$filename}/{$controller}/edittextjs"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/tinymce.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.min.js"></script>
 
                
JS;

//<script type="text/javascript" src="/{$filename}/{$controller}/formbuilderjs"></script>
echo $js;

?>