<!DOCTYPE html>
<html>

<head> 
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    
<!--   <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">-->
            
    <?php echo \Asset::css('formbuilder/demo.css'); ?> 
    <!--<link rel="stylesheet" href="http://192.168.0.111/assets/css/bootstrap.min.css?1529493139"  >-->
  
   <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.0.0/css/bootstrap.min.css" integrity="sha384-P4uhUIGk/q1gaD/NdgkBIl3a6QywJjlsFJFk7SPRdruoGddvRVSwv5qFnvZ73cpz" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.css">
<!--<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">-->
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <title><?php echo \Lang::get('label.forms.dynamic_form_builder')?\Lang::get('label.forms.dynamic_form_builder'):'Dynamic Form Builder' ?></title>
  <style>
      #iframe_preview{
            border: none;   
            max-height: none;  
            border: 1px solid #b9b9b9;
            padding: 4px;
            background: white;
            box-shadow: 0px 0px 14px 4px #b5b5b5;
            overflow-y: scroll;
        }
        .iframe-wrap{
            text-align: -webkit-center; 
            border-right: 1px solid white;
        }
        
        .form-overflow{        
            overflow: scroll;  
            overflow-x: hidden; 
        }
        
        #div-wrap{
            
            box-shadow: 0px 6px 22px 8px #b5b5b5;
        }
        .form-wrap.form-builder .frmb li .close-field {
            color: #fff  !important;
            background-color: #ad1313  !important;
        }
        .form-wrap.form-builder .frmb .frm-holder{
            position: absolute;
            width: 430px;
            width: 95%; 
            opacity: 1;
            background-color: #c3c7ca !important;
            margin-top: 10px;
            border-radius: 17px;
            z-index: 1;
            border: 1px solid grey;
        }
        .form-wrap.form-builder .frmb .form-elements {
            margin: 17px 13px !important;
        }
        
/*        .name-wrap{
            display: none !important;
        }*/
        
        .form-body{
            direction: rtl !important;
            background-image:  url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAAUVBMVEWFhYWDg4N3d3dtbW17e3t1dXWBgYGHh4d5eXlzc3OLi4ubm5uVlZWPj4+NjY19fX2JiYl/f39ra2uRkZGZmZlpaWmXl5dvb29xcXGTk5NnZ2c8TV1mAAAAG3RSTlNAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEAvEOwtAAAFVklEQVR4XpWWB67c2BUFb3g557T/hRo9/WUMZHlgr4Bg8Z4qQgQJlHI4A8SzFVrapvmTF9O7dmYRFZ60YiBhJRCgh1FYhiLAmdvX0CzTOpNE77ME0Zty/nWWzchDtiqrmQDeuv3powQ5ta2eN0FY0InkqDD73lT9c9lEzwUNqgFHs9VQce3TVClFCQrSTfOiYkVJQBmpbq2L6iZavPnAPcoU0dSw0SUTqz/GtrGuXfbyyBniKykOWQWGqwwMA7QiYAxi+IlPdqo+hYHnUt5ZPfnsHJyNiDtnpJyayNBkF6cWoYGAMY92U2hXHF/C1M8uP/ZtYdiuj26UdAdQQSXQErwSOMzt/XWRWAz5GuSBIkwG1H3FabJ2OsUOUhGC6tK4EMtJO0ttC6IBD3kM0ve0tJwMdSfjZo+EEISaeTr9P3wYrGjXqyC1krcKdhMpxEnt5JetoulscpyzhXN5FRpuPHvbeQaKxFAEB6EN+cYN6xD7RYGpXpNndMmZgM5Dcs3YSNFDHUo2LGfZuukSWyUYirJAdYbF3MfqEKmjM+I2EfhA94iG3L7uKrR+GdWD73ydlIB+6hgref1QTlmgmbM3/LeX5GI1Ux1RWpgxpLuZ2+I+IjzZ8wqE4nilvQdkUdfhzI5QDWy+kw5Wgg2pGpeEVeCCA7b85BO3F9DzxB3cdqvBzWcmzbyMiqhzuYqtHRVG2y4x+KOlnyqla8AoWWpuBoYRxzXrfKuILl6SfiWCbjxoZJUaCBj1CjH7GIaDbc9kqBY3W/Rgjda1iqQcOJu2WW+76pZC9QG7M00dffe9hNnseupFL53r8F7YHSwJWUKP2q+k7RdsxyOB11n0xtOvnW4irMMFNV4H0uqwS5ExsmP9AxbDTc9JwgneAT5vTiUSm1E7BSflSt3bfa1tv8Di3R8n3Af7MNWzs49hmauE2wP+ttrq+AsWpFG2awvsuOqbipWHgtuvuaAE+A1Z/7gC9hesnr+7wqCwG8c5yAg3AL1fm8T9AZtp/bbJGwl1pNrE7RuOX7PeMRUERVaPpEs+yqeoSmuOlokqw49pgomjLeh7icHNlG19yjs6XXOMedYm5xH2YxpV2tc0Ro2jJfxC50ApuxGob7lMsxfTbeUv07TyYxpeLucEH1gNd4IKH2LAg5TdVhlCafZvpskfncCfx8pOhJzd76bJWeYFnFciwcYfubRc12Ip/ppIhA1/mSZ/RxjFDrJC5xifFjJpY2Xl5zXdguFqYyTR1zSp1Y9p+tktDYYSNflcxI0iyO4TPBdlRcpeqjK/piF5bklq77VSEaA+z8qmJTFzIWiitbnzR794USKBUaT0NTEsVjZqLaFVqJoPN9ODG70IPbfBHKK+/q/AWR0tJzYHRULOa4MP+W/HfGadZUbfw177G7j/OGbIs8TahLyynl4X4RinF793Oz+BU0saXtUHrVBFT/DnA3ctNPoGbs4hRIjTok8i+algT1lTHi4SxFvONKNrgQFAq2/gFnWMXgwffgYMJpiKYkmW3tTg3ZQ9Jq+f8XN+A5eeUKHWvJWJ2sgJ1Sop+wwhqFVijqWaJhwtD8MNlSBeWNNWTa5Z5kPZw5+LbVT99wqTdx29lMUH4OIG/D86ruKEauBjvH5xy6um/Sfj7ei6UUVk4AIl3MyD4MSSTOFgSwsH/QJWaQ5as7ZcmgBZkzjjU1UrQ74ci1gWBCSGHtuV1H2mhSnO3Wp/3fEV5a+4wz//6qy8JxjZsmxxy5+4w9CDNJY09T072iKG0EnOS0arEYgXqYnXcYHwjTtUNAcMelOd4xpkoqiTYICWFq0JSiPfPDQdnt+4/wuqcXY47QILbgAAAABJRU5ErkJggg==);
        }
        
        .form-wrap.form-builder .frmb .form-elements .input-wrap,
        .form-wrap.form-builder .frmb .sortable-options-wrap{
            width: 72.333333% !important; 
        }
        
        .form-wrap.form-builder .frmb .form-elements .false-label:first-child, .form-wrap.form-builder .frmb .form-elements label:first-child {
            width: 21.666667% !important;
        }
        
        .form-wrap.form-builder .frmb .field-actions .del-button:hover {
            background-color: #ca0600 !important;
        }
        .form-wrap.form-builder .frmb>li:hover li.ui-sortable-handle :hover {
            background: #ffffff;
        }
        
        .form-wrap.form-builder .frmb .field-actions .toggle-form:hover {
            background-color: #07b7ff !important;
        }
        .form-wrap.form-builder .frmb li.ui-sortable-handle{            
            background-color: #e4e4e4 !important;
        }
        .form-wrap.form-builder .frmb .option-actions a, .form-wrap.form-builder .frmb .option-actions button {
            background: #006516 !important;
            color: white;
        }
        
        #setLanguage{
                font-size: 21px;
    padding: 3px 10px;
    background-color: white;
        }
        
        #getJSON,#showPreview,#resetDemo{
            font-size:18px;
        }
        
        #createForm:hover,#createForm:active{
            color: white;
            background-color: #076b07; 
        }
        #createForm{
            -webkit-appearance: button;
            border: 1px solid;
            color: white;
            padding: 3px 9px;
            background-color: #004a00;
        }
        
        .prev-holder input.form-control,.prev-holder select.form-control{
            width: 33% !important;
        }
        
        #logoWrap div.span1{
            float: none !important;
        }
        
        .form-wrap.form-builder .stage-wrap{
            /*width:50% !important;*/
        }
        
        
        .icon-remove{
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-top: 1px;
            line-height: 14px;
            vertical-align: text-top;
            background-image: url(/assets/img/glyphicons-halflings.png);
            background-position: 14px 14px;
            background-repeat: no-repeat;
            background-position: -312px 0;
        }
        
        .delete-img{
            position: absolute;
    background: #fbf3f3;
    border-radius: 1px 0px 1px 7px;
    padding: 0px 2px;
        }
        
        .thumbnail{
                line-height: 20px;
    border: 1px solid #b7b5b5;
    border-radius: 4px;
        padding: 4px;
        }

        
        /*.XPosition-wrap,.YPosition-wrap,.math_value-wrap,.tooltip_text-wrap,.limit-wrap, .show_total-wrap{*/
        .XPosition-wrap,.YPosition-wrap,.tooltip_text-wrap,.limit-wrap{
            display: none !important;
        }
        /*.XPosition-wrap.hide-xy,.YPosition-wrap.hide-xy,.math_value-wrap.show,.tooltip_text-wrap.show,.limit-wrap.show, .show_total-wrap.show{*/
        .XPosition-wrap.hide-xy,.YPosition-wrap.hide-xy,.tooltip_text-wrap.show,.limit-wrap.show{
            display: block !important;
        }
.form-elements .form-group.name-wrap , .logindisabled{
    display: none !important;
}
select.fld-element,
select.fld-element option{
    width:150px;   
}
li.bankdetails-field  .label-wrap {
    /*display: none !important;*/
}
/*li[type="radio-group"] div div div div ol li .option-mapvalue ,
li[type="checkbox-group"] div div div div ol li .option-mapvalue {
    display: none;
}*/


        .form-wrap.form-builder .frmb .sortable-options input[type=text]{            
            width: calc(32% - 17px) !important;
            padding: 6px 8px !important;
        }
        input[type="checkbox"][readonly] {
  pointer-events: none;
}


div[type="phonenumber"] select {
  width: 16% !important;
  height: 30px;
}

div[type="phonenumber"] input { 
  height: 30px;
}
/* ,.form-group.phonetype-wrap,.form-group.copiedfrom-wrap */
.form-group.required-wrap {
    display: none;
}
  </style>
</head>

<body class="row m-0 form-body">
  <div class="col-sm-12">
        <div class="col-sm-5" style="float: left; ">
             
   
            <ul class="row"  style=" display: none">
                <li class="col-sm-4 resize-iframe" style="    display: block;" data-width="375" data-height="564">mobile 375 X 564 </li>
                <li class="col-sm-4 resize-iframe" style="    display: block;" data-width="1500" data-height="663">web 1500 X 663</li>
                <li class="col-sm-4 resize-iframe" style="    display: block;" data-width="768" data-height="564">tablet 768 X 564</li>
            </ul>     
        </div>
    </div>
    
  <div class="col-sm-12 row">
  <div class="col-sm-7 content pt-4" >
    <h1><?php echo \Lang::get('label.forms.title')?\Lang::get('label.forms.title'):'Form Builder' ?></h1>
    <a href="/dynamicformssystem/forms/index" style="width:100%;float:right">
        <?php echo \Lang::get('label.forms.past_form')
                            ?\Lang::get('label.forms.past_form'):'Past Form'; //צפה בדוחות קיימים//   ?>
    </a>
    <div id="stage1" class="build-wrap pl-0 col-sm-12" style="    margin-top: 33px;"></div>
    <form class="render-wrap"></form>
    <button id="edit-form">Edit Form</button> 

       
    </div> 
 
    <div class="col-sm-5 mt-1 pt-3 iframe-wrap" style="height: 610px;">
        <h1><?php echo \Lang::get('label.forms.preview_title')?\Lang::get('label.forms.preview_title'):'Form Builder' ?></h1>
        <div class=" " style=" height: 610px;" id="div-wrap">
            <iframe class="col-sm-12" id="iframe_preview" align="middle" height="600"  src="/dynamicformssystem/forms/indexRender<?php if(isset($object) && is_object($object)) echo "/".$object->id ?>" >

        </iframe>
    </div>
    </div>
      
      <div class="col-sm-12 ">
           <div class="action-buttons col-sm-6    my-2 mx-5 px-2 ">
            <h1 style="text-decoration:underline;"><?php echo \Lang::get('label.forms.configuration')?\Lang::get('label.forms.configuration'):'configuration' ?></h1>
      
        
          <button id="showData" style="display: none;"  type="button">Show Data</button>
          
      <button id="loadTinyMCE"  style="display: none;" type="button">Preview</button>
          <button id="clearFields" style="display: none;"  type="button">Clear All Fields</button>
          <button id="getData" style="display: none;" type="button">Get Data</button>
          <button id="getXML"  style="display: none;"type="button">Get XML Data</button>
          <button id="getJSON"   style="display: none;"   type="button">Get JSON Data</button>
          <button id="getJS" style="display: none;"  type="button">Get JS Data</button>
          <button id="setData" style="display: none;"  type="button">Set Data</button>
          <button id="addField" style="display: none;"  type="button">Add Field</button>
          <button id="removeField" style="display: none;"  type="button">Remove Field</button>
          <button id="testSubmit" style="display: none;" type="submit">Test Submit</button>
          <button id="resetDemo" style="display: none;" type="button">Reset Demo</button>
          
           </div>
          <form target="_blank" action="/dynamicformssystem/forms/createForm" method="post" style="display: inline;">
             
              
             
              <?php  if(isset($settings)  && !empty($settings) ){
//      $datalist = array();
//                  $settings = json_decode($object->systemsconfig, true);
        
//                  echo json_last_error ();
//                  print_r($settings); 
//                  
                  if(is_array($settings))
                  foreach ($settings as $key => $data){
                      
                      $$key  = $data;
                      
                  } 
                  
              } 
              
              
              ?>
              
              
              
              <div id ="logoWrap" style=" ">
                  <!--<label style="font-weight:bold;width: 265px;">Upload Background Image</label><br/>-->
<!--                   <input type="radio" name='formtype'  value="popup" /> Pop-Up Form
                   <br/>
                   <input type="radio" name='formtype' value="simple" /> Simple Form-->
                   <input type="hidden" name='formtype' id='formType' value="" /> 
                   <!--Simple Form-->
                </div>
              
              <?php 
              
                $jsondata = '';
                $formTitleEng = '';
                $formTitle = '';
                    if(isset($object) && is_object($object)){
                        
                     
                        if(!empty($object->currentform)){  

                            $x =$object->currentform; 
                            
                            
                            $formde = json_decode($x ,true );  
                            if(empty($formde)){
                                
                                $x = htmlspecialchars_decode($x,ENT_QUOTES); 
                                $formde = json_decode($x ,true );  
                              
                            }
                            $y = $formde['json_data']; 
                             
//                            $jsondata =htmlspecialchars($y,ENT_QUOTES);
//                            
//                            $jsondata = json_encode($jsondata) ;
//                            $jsondata = str_replace('\r\n\t\t',"",$jsondata) ;
//                            $jsondata = str_replace('\r\n\t',"",$jsondata) ;
                             
                           
                            $formTitleEng = $formde['form_title'] ;
                        }
                        if(!empty($object->name)){  

                            $formTitle =$object->name; 
                        } 
                    }
                  
                  ?> 

              
<!--          <div style="display: flex;">
          <h3><?php // echo \Lang::get('label.forms.choose_lang')?\Lang::get('label.forms.choose_lang'):'choose_lang' ?></h3>
          <select id="setLanguage" class="mx-4 my-2 " style="font-size: 1.2em;">
            <option value="en-US">English</option>
            <option value="he-IL" dir="rtl">עברית‬</option>
          </select>
        </div> -->
        <!--</div>-->
        
        <div class="accordion" id="accordionExample">
            <div class="col-sm-9 mx-0 px-0 row" >
                <div class="card-header col-sm-2" id="headingOne"  >
                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <h4>Flow</h4>
                      </button>
                    </h2>
                  </div>
                <div class="card-header col-sm-2 btn-link" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <h2 class="mb-0">
                      <button class="btn  btn-link" type="button" >
                        <h4>PDF</h4>
                      </button>
                    </h2>
                  </div>
                <div class="card-header col-sm-2 btn-link" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button">
                        <h4>Display</h4>
                      </button>
                    </h2>
                  </div>
                <div class="card-header col-sm-2 btn-link" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button">
                          <h4>Extra</h4>
                      </button>
                    </h2>
                  </div>
<div class="card-header col-sm-2 btn-link" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button">
                          <h4>Login</h4>
                      </button>
                    </h2>
                  </div>
  <div class="card-header col-sm-2 btn-link" id="headingTwo" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                    <h2 class="mb-0">
                      <button class="btn  btn-link" type="button" >
                        <h4>WhatsApp</h4>
                      </button>
                    </h2>
                  </div>
                <div class="  col-sm-4 " style="
    position: absolute;
    left: -35%;
" id=" " data-toggle="collapsex" data-target="#collapseFivex" aria-expanded="true" aria-controls="collapseFivex">
                     
                 <input type="submit" style=" float: left "class="col-sm-5 mx-2 mt-3" id="createForm"   onclick="return  submitForm();" value="<?php if(isset($object) && is_object($object)) echo "Update"; else echo \Lang::get('label.forms.create')?\Lang::get('label.forms.create'):'create' ?>" />

                    &nbsp;
                    &nbsp;
                    <button id="showPreview" style="   float: left  "class="col-sm-5 mx-2 mt-3" type="button">Preview</button>
 
                  </div>
                <div class=" col-sm-3 pull-right" id="">
<!--                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                          <h4>Extra</h4>
                      </button>
                    </h2>-->
                     
                  </div>
                <div class=" col-sm-3 pull-right" id="">
<!--                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                          <h4>Extra</h4>
                      </button>
                    </h2>-->
                    
       
                  </div>
            </div>
              
            <div id="collapseOne"  class="col-sm-12 collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
                  <div class="row">
                      <h5>Flow System &nbsp; : &nbsp;</h5>
                        <input type="checkbox" name="flowSystem" <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($flowSystem) && $flowSystem == '1') echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
                        <input type="checkbox" name="showMessageBeforePDFflow2"  <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($showMessageBeforePDFflow2) && $showMessageBeforePDFflow2 == '1') echo 'checked="checked"'; } ?> value="1" style=" display:none;"  />
<!--                        <input type="checkbox" name="flowSystem" <?php // if(isset($object) && is_object($object) && isset($settings) ){  if(isset($flowSystem) && $flowSystem == '1') echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />-->
                        <select name="pdf_mode_flow2"   class="mx-2 my-2 col-sm-2" style="display:none;">
                            <option value="2" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode_flow2) && $pdf_mode_flow2 == '2'){ echo 'selected="selected"'; } ?>>Show in Browser</option> 
                            <option value="1" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode_flow2) && $pdf_mode_flow2 == '1'){ echo 'selected="selected"'; } ?> >Download</option>
                            <option value="3" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode_flow2) && $pdf_mode_flow2 == '3'){ echo 'selected="selected"'; } ?>>Show in Browser  & Download</option> 
                            <option value="0" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode_flow2) && $pdf_mode_flow2 == '0'){ echo 'selected="selected"'; } ?>> --None-- </option> 
                        </select> 
                    </div>
                  <br/>
                    <div class="row">
                        <h5>Flow Type &nbsp; : &nbsp;</h5>
                        <select name="flowType"   class="col-sm-1 "  >
                               <option value="0" > -- </option>
                               <option value="2" <?php 
                               if(isset($object) && is_object($object) && isset($settings)) {
                                   if(isset($flowType) && $flowType == '2') echo 'selected="selected"'; 
                                   
                               } ?>>2</option> 
                         
                            <option value="1" <?php 
                            if(isset($object) && is_object($object) && isset($settings) 
                                    && isset($flowType) && $flowType == '1'){ 
                                echo 'selected="selected"'; 
                                
                                    } ?> >1</option>
                        </select> 
                    </div>

                  <br/>
              </div>
            </div>
            <div id="collapseTwo" class="col-sm-12 collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
              <div class="card-body">
                  <div class="row">
                        <h5>PDF &nbsp; : &nbsp;</h5>
                        <input type="checkbox" class="pdfCreator" name="pdf_creator" <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($pdf_creator) && $pdf_creator == '1') echo 'checked="checked"'; }else{ echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
                    </div>
                    <div class="row pdfDetails">
                        <h5>Send PDF Mail &nbsp; : &nbsp;</h5>
                        <input type="checkbox" name="send_pdfmail" value="1" <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($send_pdfmail) && $send_pdfmail == '1') echo 'checked="checked"'; }else{ echo 'checked="checked"'; } ?> style=" width: 22px; height: 24px;"/>
      
                    </div>
                    <div class="row pdfDetails">
                        <h5>Enable PDF Preview &nbsp; : &nbsp;</h5>
                        <input type="checkbox" name="enable_pdf_preview" value="1" <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($enable_pdf_preview) && $enable_pdf_preview == '1') echo 'checked="checked"'; }else{ echo 'checked="checked"'; } ?> style=" width: 22px; height: 24px;"/>
                        <input type="checkbox" name="addAccessibilityMenu" value="1" <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($addAccessibilityMenu) && $addAccessibilityMenu == '1') echo 'checked="checked"'; }else{  } ?> style=" display:none"/>
                       
                    </div>
                    <div class="row pdfDetails">
                        <h5>Download PDF/Show in Browser &nbsp; : &nbsp;</h5>
                        <select name="pdf_mode"   class="mx-2 my-2 col-sm-2" style="font-size: 1.2em;">
                            <option value="1" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode) && $pdf_mode == '1'){ echo 'selected="selected"'; } ?> >Download</option>
                            <option value="2" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode) && $pdf_mode == '2'){ echo 'selected="selected"'; } ?>>Show in Browser</option> 
                            <option value="3" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode) && $pdf_mode == '3'){ echo 'selected="selected"'; } ?>>Show in Browser  & Download</option> 
                            <option value="0" <?php if(isset($object) && is_object($object) && isset($settings) && isset($pdf_mode) && $pdf_mode == '0'){ echo 'selected="selected"'; } ?>> --None-- </option> 
                        </select> 
                    </div>
                    <div class="row pdfDetails">
                        <h5>PDF Template Name &nbsp; : &nbsp;</h5>
                          <input id=" " name="pdf_template_name" class="mx-4 my-2 " value="<?php  if(isset($pdf_template_name)) echo $pdf_template_name; ?>" style="font-size:  1.2em;" />

                    </div>
                    <div class="row pdfDetails">
                       <h5>PDF Report Name &nbsp; : &nbsp;</h5>
                          <input id=" " name="pdf_report_name" class="mx-4 my-2 " value="<?php  if(isset($pdf_report_name)) echo $pdf_report_name; ?>" style="font-size:  1.2em;" />

                    </div>
              </div>
            </div>
            <div id="collapseThree" class="col-sm-12 collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
              <div class="card-body">
                  <div style="display: flex;">
                    <h5><?php echo \Lang::get('label.forms.choose_color')?\Lang::get('label.forms.choose_color'):'Add Section color including hash';  ?> &nbsp; : &nbsp;</h5>
<!--                    <select id=" " name="color_scheme"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;">
                        <option value="green"   <?php  if(isset($object->color_scheme) && $object->color_scheme == 'green') echo 'selected'; ?> style="background-color:#BEE395;">green </option> 
                      <option value="red"    <?php if(isset($object->color_scheme) && $object->color_scheme == 'red') echo 'selected'; ?>  style="background-color:rgb(252,89,43);">red</option> 
                      <option value="yellow"     <?php if(isset($object->color_scheme) && $object->color_scheme == 'yellow') echo 'selected'; ?>  style="background-color:#f3f300;">yellow</option> 
                      <option value="yellow"     <?php if(isset($object->color_scheme) && $object->color_scheme == 'yellow') echo 'selected'; ?>  style="background-color:#f3f300;">yellow</option> 
                    </select>-->
                    <input id=" " name="color_scheme"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($object->color_scheme)) echo  $object->color_scheme ?>" />
                  </div> 
              <div style="display: flex;">
                        <h5>Remove Top Salessoft Bar &nbsp; : &nbsp;</h5>
                        <input type="checkbox" class="mx-4 my-2 col-sm-1   "    name="removesalessoftbar" <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($removesalessoftbar) && $removesalessoftbar == '1') echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
                    </div> 
                  <div id ="logoWrap" class=" my-2" style=" display: flex;">
                    <h5><?php echo \Lang::get('label.forms.upload_logo')?\Lang::get('label.forms.upload_logo'):'upload_logo' ?> &nbsp; : &nbsp;</h5>

                    <?php if(isset($object) && is_object($object) && isset($object->logoimage) && is_object($object->logoimage)) {  ?>
                          <div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> 
                              <div class="thumbnail" style="    width: 60px;display:table-cell;mat">
                                  <a class="delete-img" name="logo" data-id="<?php if(isset($object->logo_id))  echo $object->logo_id  ?>">
                                      <i class="icon-remove"></i>
                                  </a> 
                                <a href="/Model_Products/<?php if(isset($object->logoimage->name))  echo $object->logoimage->name  ?>" target="_blank">
                                   <img src="/Model_Products/<?php if(isset($object->logoimage->name))  echo $object->logoimage->name  ?>" style="width: 55px;  height: 60px;">
                                  </a>
                              </div> 
                          </div>

                      <?php } ?>
                         <input type="file" name='logo' class="form-file-upload"  <?php if(isset($object) && is_object($object) && isset($object->logoimage) && is_object($object->logoimage)) {  ?> style="display:none" <?php } ?>  data-url="/dynamicformssystem/forms/createImagex" id="formLogo" value="" />
                     <input type="hidden" name="logo" value="<?php if(isset($object) && is_object($object) && isset($object->logo_id) ) echo $object->logo_id;  ?>">
                </div>
                  <div id ="logoWrap" class=" my-2" style=" display: flex;">
                    <h5><?php echo \Lang::get('label.forms.logo_position')?\Lang::get('label.forms.logo_position'):'logo position' ?> &nbsp; : &nbsp;</h5>
                    
                       <select id=" " name="logo_position"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;">
                      <option value="center"     <?php if(isset($object->logo_position) && $object->logo_position == 'center') echo 'selected'; ?>  style="">center</option> 
                        <option value="left"   <?php  if(isset($object->logo_position) && $object->logo_position == 'left') echo 'selected'; ?> style="">left </option> 
                      <option value="right"    <?php if(isset($object->logo_position) && $object->logo_position == 'righht') echo 'selected'; ?>  style="">right</option>  
                    </select>
                  </div>   
                  <div id ="logoWrap" class=" my-2" style=" display: flex; display: none" >
                    <h5><?php echo \Lang::get('label.forms.logo_left_margin')?\Lang::get('label.forms.logo_left_margin'):'logo left margin' ?> &nbsp; : &nbsp;</h5>
                    
                       <input id=" " name="logo_left_margin"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($object->logo_left_margin)) echo  $object->logo_left_margin ?>" />
                  </div>   
                  <div id ="logoWrap" class=" my-2" style=" display: flex;display: none">
                    <h5><?php echo \Lang::get('label.forms.logo_right_margin')?\Lang::get('label.forms.logo_right_margin'):'logo right margin' ?> &nbsp; : &nbsp;</h5>
                    
                       <input id=" " name="logo_right_margin"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($object->logo_right_margin)) echo  $object->logo_right_margin ?>" />
                  </div>   
                  <div id ="logoWrap" class=" my-2" style=" display: flex; ">
                    <h5><?php echo \Lang::get('label.forms.logo_right_margin')?\Lang::get('label.forms.logo_right_margin'):'Logo Portrait Mode' ?> &nbsp; : &nbsp;</h5>
                    
<!--                       <input id=" " name="logo_portrait_mode"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php // if(isset($logo_portrait_mode)) echo  $logo_portrait_mode ?>" />-->
                   <input type="checkbox" class="autosave" name="logo_portrait_mode" <?php 
                 
                 if(isset($object->id) && !empty($object->id)){
                 if(isset($logo_portrait_mode) && 
                        $logo_portrait_mode == 1){  
                     echo 'checked="checked"'; 
                        }else 
                         echo "";
                        }else echo ''; ?> value="1" style=" width: 22px; height: 24px;"  />
                  </div>   
                  
                  
                  <div style="display: flex;">
                    <h5><?php echo \Lang::get('label.forms.logo_width')?\Lang::get('label.forms.logo_width'):'logo width';  ?> &nbsp; : &nbsp;</h5>
                    <input id=" " type="tel" name="logo_width"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($logo_width)) echo  $logo_width ?>" />
                  </div>    
                  <div style="display: flex; ">
                    <h5><?php echo \Lang::get('label.forms.logo_height')?\Lang::get('label.forms.logo_height'):'logo height';  ?> &nbsp; : &nbsp;</h5>
                    <input id=" " type="tel" name="logo_height"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($logo_height)) echo  $logo_height ?>" />
                  </div> 
<!--                  <div style="display: flex;display: none">
                    <h5><?php echo \Lang::get('label.forms.logo_width')?\Lang::get('label.forms.logo_width'):'logo width';  ?> &nbsp; : &nbsp;</h5>
                    <input id=" " name="logo_width"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($object->logo_width)) echo  $object->logo_width ?>" />
                  </div>    
                  <div style="display: flex;display: none ">
                    <h5><?php echo \Lang::get('label.forms.logo_height')?\Lang::get('label.forms.logo_height'):'logo height';  ?> &nbsp; : &nbsp;</h5>
                    <input id=" " name="logo_height"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($object->logo_height)) echo  $object->logo_height ?>" />
                  </div> -->
                  
                  <div class="row">
                        <h5>View Type &nbsp; : &nbsp;</h5>
                        <select id=" " name="view_type"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;">
                            <option value="rtl"     <?php  if(isset($view_type) && $view_type == 'rtl') echo 'selected'; ?>  style="">RTL</option> 
                            <option value="ltr"   <?php  if(isset($view_type) && $view_type == 'ltr') echo 'selected'; ?> style="">LTR</option> 
                        </select>
                    </div>   
              <div id ="logoWrap" class=" my-2" style="display: flex;">
                  <h5><?php echo \Lang::get('label.forms.upload_background')?\Lang::get('label.forms.upload_background'):'upload_background' ?> &nbsp; : &nbsp;</h5>
                   
                  <?php if(isset($object) && is_object($object) && isset($object->backgroundimg) && is_object($object->backgroundimg)) {  ?>
                        <div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> 
                            <div class="thumbnail" style="    width: 60px;display:table-cell;mat">
                                <a class="delete-img" name="backgroundimage" data-id="<?php if(isset($object->backgroundimage_id))  echo $object->backgroundimage_id  ?>">
                                    <i class="icon-remove"></i>
                                </a> 
                              <a href="/Model_Products/<?php if(isset($object->backgroundimg->name))  echo $object->backgroundimg->name  ?>" target="_blank">
                                 <img src="/Model_Products/<?php if(isset($object->backgroundimg->name))  echo $object->backgroundimg->name  ?>" style="width: 55px;  height: 60px;">
                                </a>
                            </div> 
                        </div>
                       
                    <?php } ?>  
                  <input type="file" name='backgroundimage' class="form-file-upload"  <?php if(isset($object) && is_object($object) && isset($object->backgroundimg) && is_object($object->backgroundimg)) {  ?> style="display:none" <?php } ?> accept=""data-url="/dynamicformssystem/forms/createImagex"  id="formBackgroundimage" value="" />
                       <input type="hidden" name="backgroundimage" value="<?php if(isset($object) && is_object($object) && isset($object->backgroundimage_id) ) echo $object->backgroundimage_id;  ?>">
              </div>
              </div>
            </div>


            <div id="collapseSix" class="col-sm-12 collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
              <div class="card-body">
                  
                  <div id ="logoWrap" class=" my-2" style=" display: flex;">
                    <h5><?php echo \Lang::get('label.forms.upload_logox')?\Lang::get('label.forms.upload_logox'):'WhatsApp Image' ?> &nbsp; : &nbsp;</h5>

                    <?php if(isset($object) && is_object($object) && isset($whatsapp_image)  ) { 
                        
                        $image = \Model_Image::find($whatsapp_image);
                        
                        
                        ?>
                          <div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> 
                              <div class="thumbnail" style="    width: 60px;display:table-cell;mat">
                                  <a class="delete-img" name="whatsapp_image" data-id="<?php if(isset($whatsapp_image))  echo $whatsapp_image ?>">
                                      <i class="icon-remove"></i>
                                  </a> 
                                <a href="/Model_Products/<?php if(isset($image->name))  echo $image->name  ?>" target="_blank">
                                   <img src="/Model_Products/<?php if(isset($image->name))  echo $image->name  ?>" style="width: 55px;  height: 60px;">
                                  </a>
                              </div> 
                          </div>

                      <?php } ?>
                         <input type="file" name='whatsapp_image' class="form-file-upload"  <?php if(isset($object) && is_object($object) && isset($whatsapp_image) && !empty($whatsapp_image)) {  ?> style="display:none" <?php } ?>  data-url="/dynamicformssystem/forms/createImagex" id="formLogo" value="" />
                     <input type="hidden" name="whatsapp_image" value="<?php if(isset($object) && is_object($object) && isset($whatsapp_image) ) echo $whatsapp_image;  ?>">
                </div>
                  
                  <div id ="logoWrap" class=" my-2" style=" display: flex; " >
                    <h5><?php echo \Lang::get('label.forms.logo_left_margin')?\Lang::get('label.forms.logo_left_margin'):'WhatsApp Description' ?> &nbsp; : &nbsp;</h5>
                    <textarea name="whatsapp_description"   class="mx-4 my-2 col-sm-3 " style="border-radius:5px; height: 100px;"><?php if(isset($whatsapp_description)) echo  $whatsapp_description ?></textarea>
                       <!--<input id=" " name="logo_left_margin"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($object->logo_left_margin)) echo  $object->logo_left_margin ?>" />-->
                  </div>   
                  <div id ="logoWrap" class=" my-2" style=" display: flex; " >
                    <h5><?php echo \Lang::get('label.forms.logo_left_margin')?\Lang::get('label.forms.logo_left_margin'):'WhatsApp Title' ?> &nbsp; : &nbsp;</h5>
                    <input name="whatsapp_title"   class="mx-4 my-2 col-sm-3 " style=" " value="<?php if(isset($whatsapp_title)) echo  $whatsapp_title ?>"  />
                       <!--<input id=" " name="logo_left_margin"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" value="<?php if(isset($object->logo_left_margin)) echo  $object->logo_left_margin ?>" />-->
                  </div>   
                  
              </div>
            </div>


             <div id="collapseFour" class="col-sm-12 collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
              
                        <?php if(isset($object) && is_object($object)){ ?>
                        <input type="hidden" name='formId' id="formId" value='<?php echo $object->id; ?>' />
                        <?php } ?>
                        <input type="hidden" name='json_data' id="jsonData" value='<?php // echo $jsondata; ?>' />
                        <!--<input id="formData" type='hidden' val=''>-->
                        <input type="hidden" name='form_title' id="formTitle" value='<?php echo $formTitleEng ; ?>' />
                        <input type="hidden" name='form_title_eng' id="formTitleEng" value='<?php echo $formTitle; ?>' />
                        <input type="hidden" name='formIndexTitle' id="formIndexTitle" value='<?php if(isset($formIndexTitle)) echo $formIndexTitle; ?>' />



                        <div style="display: flex;">
                      <h5>מחיקת רשומה לאחר שליחה למייל (מתאים גם לדו שלבי)  &nbsp; : &nbsp;</h5>
                        <input type="checkbox" name="dont_store_data" <?php 
                        // if(isset($object) ){


                        // if(is_object($object) && isset($settings) ){ 
                          
                        //   if(isset($dont_store_data) && $dont_store_data == '1') echo 'checked="checked"'; 
                        
                        // }
                        
                        // }else{  
                          echo 'checked="checked"';   ?> value="1" style=" width: 22px; height: 24px;"  />
                        
                    </div><br/>
                    
                    <div style="display: flex;">
                    <h5><?php echo \Lang::get('label.forms.shorten_url')?\Lang::get('label.forms.shorten_url'):'shorten url';  ?> &nbsp; : &nbsp;</h5>
                    <select id=" " name="shorten_url" class="mx-4 my-2 col-sm-1" style="font-size:  1.2em;">
                        <option value="1"     <?php if(isset($object->shorten_url) && $object->shorten_url == '1') echo 'selected'; ?>  style="background-color:#BEE395;">yes</option> 
                      <option value="0"     <?php  if(isset($object->shorten_url) && $object->shorten_url == '0') echo 'selected'; ?>  style="background-color:rgb(252,89,43);">no</option>  
                    </select>
                  </div> 
                  <div style="display: flex;">
                    <h5><?php echo \Lang::get('label.forms.bity_api_key')?\Lang::get('label.forms.bity_api_key'):'Bity API Key';  ?> &nbsp; : &nbsp;</h5>
                    <input id=" " name="bity_api_key" class="mx-4 my-2 " value="<?php  if(isset($bity_api_key)) echo $bity_api_key; ?>" style="font-size:  1.2em;" />
                  </div>

                        
                  <div style="display: flex;">
                    <h5><?php echo \Lang::get('label.forms.bity_api_key')?\Lang::get('label.forms.bity_api_key'):'URL Valid Mutiple times';  ?> &nbsp; : &nbsp;</h5>
                   
                 <input type="checkbox" class="autosave" name="mutli_url_validity" <?php if(isset($mutli_url_validity) && 
                        $mutli_url_validity == 1){   echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
                        </div> 
                         
               <div id ="logoWrap" class=" my-2" style="display: flex;">
               <h5><?php echo \Lang::get('label.forms.emailer')?\Lang::get('label.forms.emailer'):'הכנס תיבת מייל לשליחת הטופס' ?> &nbsp; : &nbsp;</h5>
               <input type="email" name="emailing" id="emailer"  value="<?php if(isset($object->email)) echo $object->email; ?>" />
                </div>
                        
                  <div style="display: flex;">
                    <h5><?php echo \Lang::get('label.forms.smssendername')?\Lang::get('label.forms.smssendername'):'SMS sender name';  ?> &nbsp; : &nbsp;</h5>
                    <input type="text" class="mx-4 my-2 col-sm-1" name="smssendername"   class="mx-4 my-2 col-sm-1 " style="font-size: 1.2em;" 
                    value="<?php if(isset($smssendername) ) echo $smssendername; ?>" />
                  </div>
                  
                  <div style="display: flex;">
                    <h5><?php echo \Lang::get('label.forms.enablesms')?\Lang::get('label.forms.enablesms'):'Enable SMS';  ?> &nbsp; : &nbsp;</h5>
                    <input type="checkbox" class="mx-4 my-2 col-sm-1" name="enablesms" value="1"   class=" mx-4 my-2 col-sm-1 " style="width: 22px; height: 24px;" 
                    value="<?php if(isset($enablesms) && $enablesms == 1) echo 'checked="checked"'; ?>" />
                  </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Autosave &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="autosave" <?php if(isset($autosave) && 
                        $autosave == 1){   echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
               <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Disable Secure System   &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="disablesecure" name="disablesecure" <?php if(isset($disablesecure) && 
                        $disablesecure == 1){   echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
 <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Show Last Draft   &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="show_last_draft" <?php if(isset($show_last_draft) && 
                        $show_last_draft == 1){   echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>

                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Show Agent On Index &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="showagentonindex" <?php if(isset($showagentonindex) && 
                        $showagentonindex == 1){   echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Show Created Date On Index &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="showcreatedonindex" <?php if(isset($showcreatedonindex) && 
                        $showcreatedonindex == 1){   echo 'checked="checked"'; }else echo 'checked="checked"'; ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Show Edit Button On Index &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="showeditbtnonindex" <?php if(isset($showeditbtnonindex) && 
                        $showeditbtnonindex == 1){   echo 'checked="checked"'; }else echo 'checked="checked"'; ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Show Delete Button On Index &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="showdeletebtnonindex" <?php if(isset($showdeletebtnonindex) && 
                        $showdeletebtnonindex == 1){   echo 'checked="checked"'; }else echo 'checked="checked"'; ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp; Created Date Filter &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="createddatefilter" <?php if(isset($createddatefilter) && 
                        $createddatefilter == 1){   echo 'checked="checked"'; }else echo 'checked="checked"'; ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp; Enable auto numbering &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="auto_numbering" <?php if(isset($auto_numbering) && 
                        $auto_numbering == 1){   echo 'checked="checked"'; } ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp; Show auto numbering On Index &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="showautonumberingonindex" <?php 
                 
                 if(isset($object->id) && !empty($object->id)){
                 if(isset($showautonumberingonindex) && 
                        $showautonumberingonindex == 1){  
                     echo 'checked="checked"'; 
                        }else 
                         echo "";
                        }else echo 'checked="checked"'; ?> value="1" style=" width: 22px; height: 24px;"  />
                 
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp; Disable Required Next field &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="disablerequirednextfield" <?php 
                 
                 if(isset($object->id) && !empty($object->id)){
                 if(isset($disablerequirednextfield) && 
                        $disablerequirednextfield == 1){  
                     echo 'checked="checked"'; 
                        }else 
                         echo "";
                     
                        }else echo 'checked="checked"'; ?> value="1" style=" width: 22px; height: 24px;"  />
                 
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp; Export CSV &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="enableExportCSV" <?php if(isset($enableExportCSV) && 
                        $enableExportCSV == 1){   echo 'checked="checked"'; }else echo ''; ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        <br/> 
                <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp;Arrange By Created Date &nbsp; : &nbsp;</h5>
                   <select id=" " name="arrangebycreated" class="mx-4 my-2 col-sm-1" style="font-size:  1.2em;">
                          <option value="0"     <?php  if(isset($arrangebycreated) && $arrangebycreated == '0') echo 'selected'; ?>  >No</option>                     
                        <option value="1"     <?php if(isset($arrangebycreated) && $arrangebycreated == '1') echo 'selected'; ?>   >Ascending order</option> 
                      <option value="2"     <?php  if(isset($arrangebycreated) && $arrangebycreated == '2') echo 'selected'; else echo 'selected'; ?>   >Descending order</option>  
                    </select>
                </div>
                        <br/> <div class="row  " class=" my-2" style="display: flex;">
                 <h5>&nbsp;&nbsp;&nbsp;&nbsp; Enable Expire &nbsp; : &nbsp;</h5>
                 <input type="checkbox" class="autosave" name="enableExpire" <?php   
              
                 if(isset($object->id) && !empty($object->id)){
                    if(isset($enableExpire) &&  $enableExpire == 1){   
                        echo 'checked="checked"'; 

                    }else 
                        echo '';
                 }else 
                     echo 'checked="checked"';
//                 }else{
//         echo 'checked="checked"';
//                 }
                        ?> value="1" style=" width: 22px; height: 24px;"  />
               </div>
                        
                  <div style="display: flex;">
                    <h5>Expire Date &nbsp; : &nbsp;</h5>
                    <input type="date" id=" " name="expiryDate" class="form-control col-6 col-lg-2 mx-4 my-2 " value="<?php  if(isset( $expiryDate ) ){ if( !empty($expiryDate)) echo $expiryDate; }else echo date('Y-m-d'); ?>" style="font-size:  1.2em;" />
                    <input type="hidden"  name="formCreatedDate" class="form-control col-6 col-lg-2 mx-4 my-2 " value="<?php  if(isset($formCreatedDate) && !empty($formCreatedDate)) echo $formCreatedDate; else echo date('Y-m-d'); ?>" style="font-size:  1.2em;" />
                    <input type="hidden"  name="expiryMessage" class="form-control col-6 col-lg-2 mx-4 my-2 " value="<?php  if(isset($expiryMessage) && !empty($expiryMessage)) echo $expiryMessage;   ?>" style="font-size:  1.2em;" />
                  </div> 
                  <br/> 
                        <div style="display: flex;">
                      <h5>Enable API&nbsp; : &nbsp;</h5>
                        <input type="checkbox" name="enableapi" <?php 
                        if(isset($object) && isset($object->enableapi) ){
                          if($object->enableapi == '1') echo 'checked="checked"';
                        } 
                         else{ echo 'checked="checked"';  } ?> value="1" style=" width: 22px; height: 24px;"  />
                         <input type="hidden"  name="apikey" id="apikey" value="<?php 
                            if(isset($object) && isset($object->apikey) ){
                               echo $object->apikey;
                            }  ?>" style="font-size:  1.2em;" />
                   
                    </div>
                        
                        <br/> 
                        <br/> 
                        <br/> 
                </div>
              </div>
             <div id="collapseFive"    class="col-sm-12 collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <h5>Login &nbsp; : &nbsp;</h5>
                        <input type="checkbox" class="pdfCreator" id="logincheck" name="login" 
                        <?php if(isset($object) && is_object($object) && isset($settings) ){  
                          if(isset($login) && $login == '1') echo 'checked="checked"'; }else{
                            echo 'checked="checked"';
                          } 
                          
                          ?> readonly checked="checked" value="1" style=" width: 22px; height: 24px;"  />
                    </div>
                      <?php 
                
                         
                            if(isset($loginMethods) && !empty($loginMethods) ){
                             
                                $loginMethods = explode(',',$loginMethods);
                            }  
                            
                         
                    ?>
                    
                    <div class="row loginmethods <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($login) && $login == '1'){ } else echo "logindisabled";  }else echo "logindisabled"; ?>logindisabled>" >
                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;Create &nbsp; : &nbsp;</h6>
                        <input type="checkbox" class="loginmethodscheck" name="loginMethods[]" <?php 
                        if(isset($object) && is_object($object) && isset($settings) && isset($create) ){  
                          if($create == '1') {

                          }else
                            echo 'checked="checked"';
                          } else{
                            if(isset($loginMethods) && is_array($loginMethods) && count($loginMethods) > 1 && in_array('create', $loginMethods) ){ 
                                echo 'checked="checked"'; 
                              }
                            
                        } ?> value="create" style=" width: 22px; height: 24px;"  />
                      </div>

                  
                    <div class="row loginmethods <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($login) && $login == '1'){ } else echo "logindisabled";  }else echo "logindisabled"; ?>">
                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;Index &nbsp; : &nbsp;</h6>
                        <input type="checkbox" class="loginmethodscheck" name="loginMethods[]" <?php if(isset($loginMethods) && is_array($loginMethods) && count($loginMethods) > 1 && in_array('listIndex', $loginMethods) ){   echo 'checked="checked"'; } ?>  readonly checked="checked"  value="listIndex" style=" width: 22px; height: 24px;"  />
                      </div>

                    <div class="row loginmethods <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($login) && $login == '1'){ } else echo "logindisabled";  }else echo "logindisabled"; ?>">
                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;Edit &nbsp; : &nbsp;</h6>
                        <input type="checkbox" class="loginmethodscheck" name="loginMethods[]" <?php 
                        if(isset($object) && is_object($object) && isset($settings) && isset($edit) ){  
                          if($edit == '1') {

                          }else
                            echo 'checked="checked"';
                          } else{
                            if(isset($loginMethods) && is_array($loginMethods) && count($loginMethods) > 1 && in_array('edit', $loginMethods) ){ 
                                echo 'checked="checked"'; 
                              }
                            
                        } ?> value="edit" style=" width: 22px; height: 24px;"  />
                      </div>

                    <div class="row loginmethods <?php if(isset($object) && is_object($object) && isset($settings) ){  if(isset($login) && $login == '1'){ } else echo "logindisabled";  }else echo "logindisabled"; ?>">
                        <h6>&nbsp;&nbsp;&nbsp;&nbsp;View &nbsp; : &nbsp;</h6>
                        <input type="checkbox" class="loginmethodscheck" name="loginMethods[]" <?php 
                        if(isset($object) && is_object($object) && isset($settings) && isset($view) ){  
                          if($view == '1') {

                          }else
                            echo 'checked="checked"';
                          } else{
                            if(isset($loginMethods) && is_array($loginMethods) && count($loginMethods) > 1 && in_array('view', $loginMethods) ){ 
                                echo 'checked="checked"'; 
                              }
                            
                        } ?> value="view" style=" width: 22px; height: 24px;"  />
                    </div>
                    <input type="hidden" class="" name="setCrudPermissions"  value="1"  />
                    <lablel>Enter menu name</label>
                    <input type="text" name="menu_title">
               <br/>
               <br/>
               <br/>
                     <table cellpadding="6" id="customerlines"  >
    <tbody>
        <tr id="itemheader">
            <th>Module Name</th> 
            <th>Translation</th> 
            <th> </th>
        </tr>
        
    <?php if(isset($menulist)){ ?>
    <?php $count = 0; foreach ($menulist as $line){ ?>

        <tr> 
            <td><input name="lines[<?php echo $count ?>][name]" class="" value="<?php echo $line['modulename'] ?>"></td>
            <td><input name="lines[<?php echo $count ?>][translation]" class="" value="<?php echo $line['translation'] ?>"></td>
              <td>
                <a id="orderlines_new-<?php echo $count;?>-delete"  class="delete_tr_line" ><i class="icon-trash" title="Delete"></i></a>
            </td>
        </tr>
    <?php $count++; } ?>
    <?php   } ?>
        <tr id="itembtn">
            <td colspan="3" id="add">
                <a id="additem" class="btn btn-primary" style="">הוסף לקוח מקושר</a>
            </td>
        </tr>
    </tbody>
</table> 
                      <a id="orderlines_delete" style="display:none;"  class="delete_tr_line" ><i class="icon-trash" title="Delete"></i></a>
            
                    <!--<a id="additem" style="display: none;"><?php echo \Lang::get('message.additem1')?\Lang::get('message.additem1'):"הוסף לקוח מקושר"; ?></a>-->
<div id="tr_info" style="display:none">
    <td style="border: 1px solid black;">
        <input   style="width:200px"   name="orderlines_new" usekey ="product_id"></input>  </td>

                 
               
 </div>

<style>
    table tr th,
    table tr td{
        border: 1px solid black;
          width: 30%;
    }
    
    .icon-trash{
        display: inline-block;
    width: 14px;
    height: 14px;
    margin-top: 1px;
    *: ;
    margin-left: .3em;
    line-height: 14px;
    vertical-align: text-top;
    background-image: url(/assets/img/glyphicons-halflings.png);
    background-position: 14px 14px;
    background-repeat: no-repeat;
    background-position: -457px 1px;
    }
    
</style> 

                </div>
              </div>

        </div>
        
                <div class="col-sm-12 mb-4" id="">
                        &nbsp;<br/>
                &nbsp;<br/>
                &nbsp;<br/>
                </div>
          </form>
          <input id="formData" type="hidden" />   
          <!--////////////////////////-->
<!--          <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>-->
      </div>
  </div>
    <?php echo \Asset::js('formbuilder/vendor.js'); ?>
              
    <?php echo \Asset::js('formbuilder/form-render.min.js'); ?>
    <?php // formbuilderminJS 
    
//    echo \Asset::js('formbuilder/form-render.min.js'); ?>
   
    <?php echo Asset::js('fileupload/jquery.fileupload.js'); ?>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/tinymce.min.js"></script>

<script type="text/javascript" src="/dynamicformssystem/forms/formbuildersystemjs"></script>

        <?php echo \Asset::js('formbuilder/demo.js'); ?> 
  <!--<script type="text/javascript" src="/assets/js/jquery-1.9.1.min.js"></script>-->
<script>
    
    var count = <?php if(isset($count)) echo $count; else echo 0; ?>;
function addCustomer(){ 
    var input = $('<input/>');
    input.attr('name','lines['+count+'][name]');
    var input2 = $('<input/>');
    input2.attr('name','lines['+count+'][translation]');
    var input3 = $('#orderlines_delete').clone();
    
    input3.removeAttr('style');
    
    
    var td = $('<td/>');
    var td2 = $('<td/>');
    var td3 = $('<td/>');
    var tr = $('<tr />');
    td.append(input);
    tr.append(td); 
    td2.append(input2);
    td3.append(input3);
    tr.append(td2); 
    tr.append(td3); 
            
    
            
        $(this).parent().parent().parent().children('#itembtn').before(tr);
        count++; 
 return;
}   

function deleteCustomer(){
    
    $(this).parent().parent().remove();
    }

$('#additem').on('click',addCustomer);
$('.addCustomer').on('click',addCustomer);
$('body').on('click','.delete_tr_line',deleteCustomer);



    function submitForm(){
      
       var  x = validateXY();
      if(x){
        var confm =  confirm('Are you sure ?');

        if(confm){
        //    var formtype =  prompt('Please Enter 1 for Simple Form or 2 for Pop-Up Form');
             
          //  if(formtype == null || formtype == '')
                formtype = 1;
            
           // $('#formType').val(formtype);
                
            var pro =  prompt('Please Enter the Form Name', $('#formTitle').val());
//            console.log(pro);
            if(pro != null && pro != ''){

                $('#formTitle').val(pro);
                var d = new Date,
                dformat = [d.getDate(),d.getMonth()+1,
               d.getFullYear()].join('')+
              [d.getHours(),
               d.getMinutes(),
               d.getSeconds()].join('');
           
                    if($('#formId').val() == undefined || $('#formId').val() == ''){
                        
                         $('#formTitleEng').val(randomStr(10)+dformat); 
                     }
               
                   return true;
                }else{ 
                    return false;
                }
            } 
        
      }
        return false;
    }
    
    function randomStr(m) {
	var m = m || 9; s = '', r = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	for (var i=0; i < m; i++) { s += r.charAt(Math.floor(Math.random()*r.length)); }
	return s;
};
       
                    function getTinymce(){
    
                        var ele = $('textarea[type="tinymce"]');
 
                        for(var i= 0; i< ele.length; i++){

                            var e = $(ele[i]);
 
                            tinymce.init({ 
                                selector: 'textarea#'+e.attr('id'), 
                                paste_as_text: true,  
    directionality : "rtl",
//                                plugins: "paste",
                                 plugins: "paste   searchreplace  textcolor  visualblocks wordcount  link image",
//  ]table template
                                toolbar: ' undo redo |  formatselect | forecolor  bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat image link',
                  
                                paste_enable_default_filters: false,
                                setup: function (editor) {
                                    editor.on('change', function () {
                                        editor.save(); 
                                        
                                       var data =  editor.getContent(); 
                                        $('#'+editor.id).val(data);
                                        $('#'+editor.id).html(data); 
                                        $('textarea#'+editor.id).trigger('keyPress'); 
                                        $('#showPreview').trigger('click');
                                    });
                            }
                            });
                        }
                        
                  }
function validateXY(){
    var data = $('.build-wrap').data('formBuilder').actions.getData(); 
    
    for (var i = 0 ; i< data.length; i++){

        var ele = data[i];
        if(ele.PDF == '3'){
            if(ele.XPosition == undefined || ele.XPosition == ''|| 
                ele.YPosition == undefined || ele.YPosition == ''){ 
                    alert('Please fill all XY Co-ordinates');
               return false;     
            }
        }
    }
    return true;     
}
function loginCheck(){
     
     if($(this).is(':checked') ==  true){
         
         $('.loginmethods').removeClass('logindisabled');
         
     }else{
           $('.loginmethods').addClass('logindisabled');
           $('.loginmethodscheck'). prop("checked", false);
     }
     
    return true;     
}

$(document).ready(function(){
    
  loaduuid();
    
    $('body').on('change','#logincheck', loginCheck);
    
//    $("#stage1 .frmb").off();
//    $("#stage1 .frmb").on("click",".close-field",function(){
//            $("#showPreview").trigger('click')
//    });  
//    $("#stage1 .frmb").on("click",".btn.icon-pencil",function(){
//        $("#showPreview").trigger('click')
//    });
//     $("#stage1 .frmb").on("click",".ui-sortable-handle",function(){
//        alert(PDFOption);
//        if(PDFOption = "3"){
//            $('.XPosition-wrap').addClass('hide-xy');
//            $('.fld-PDF').children('option[value="3"]').attr('selected','selected');
//        }
//    });
    try{
     <?php  
        $jsondata = '';
          if(isset($object) && is_object($object)){
                        if(!empty($object->currentform)){  

                            $x =$object->currentform; 
                            
                              $formde = json_decode($x ,true );  
                              
                                if(empty($formde)){
                            $x = htmlspecialchars_decode($x); 
                            $formde = json_decode($x ,true );    
                                }
                            $jsondata = $formde['json_data'] ;    
//     
//                             $formde = json_decode($x ,true );  
//                            if(empty($formde)){
//                                 $x =$object->currentform; 
//                                $x = htmlspecialchars_decode($x,ENT_QUOTES); 
//                                $formde = json_decode($x ,true );  
//                            
//                            }
//                            $jsondata = json_encode($formde['json_data']) ;
//                            $jsondata =htmlspecialchars($jsondata,ENT_QUOTES);
                            
                           
//                            $formTitleEng = $formde['form_title'] ;
                        } 
                        
                        
                    } 

        ?>;   
    var formData =  JSON.stringify(<?php echo html_entity_decode($jsondata); ?>); 
    var formData2 =   JSON.stringify(<?php echo html_entity_decode($jsondata,ENT_QUOTES); ?>); 
//    console.log(formData);
    $('.build-wrap').data('formBuilder').actions.setData(formData2); 
    $('#formData').val(formData);
//     $('body').on('click','#loadTinyMCE',getTinymce); 
     
     $('#loadTinyMCE').trigger('click');
    }catch( ex){
        console.log('Exception occured '+ex);
    }
 
    $('body').on('click','#loadTinyMCE',getTinymce); 

    getTinymce();  
    
//    var y = JSON.stringify( $('#jsonData').val());
//    alert();
    $('#jsonData').val(formData);
    if($("#formData").length < 1)
{
x= $("<input id='formData' type='hidden' val=''>");
$('body').append(x);

}
$("#formData").val(formData);
    $('#jsonData').val(formData);
    
    
    
    $('.fld-section').trigger('mouseover');
    $('.fld-element').trigger('mouseover');
    $('.fld-PDFSameLine').trigger('mouseover');
    $('.fld-ShowOnClick').trigger('mouseover');
    $('.fld-math_value').trigger('mouseover');
    $('.fld-show_total').trigger('mouseover');
    $('.fld-show_final_total').trigger('mouseover');
});
  
function uuidv4() {
  return ([1e7]+1e3+4e3+8e3+1e11).replace(/[018]/g, c =>
    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
  );
}

function loaduuid(){

  var uuid = $('#apikey').val();

  if(uuid == ''){
    uuid = uuidv4() ;
    $('#apikey').val(uuid);
  }
}
                </script>
   <script type="text/javascript" src="/dynamicformssystem/forms/formbuilderminJS"></script>
    <?php // echo \Asset::js('formbuilder/form-builder.min.js'); ?>
                <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->             
                <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></script>-->             
                <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>             
</body>

</html>
