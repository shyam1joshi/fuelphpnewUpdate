<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(1==0){
      //this line is for IDE support

    ?>
<script>
        <?php
}
?>

$(document).ready(function(){
    
    var TagForChangeOnly = [
        "select"
        
    ] ; 

        function showMoreOption(event){


//skip on click  by checking tag Name 

            var tagName = $(this).prop("tagName").toLowerCase();
            if(TagForChangeOnly.indexOf(tagName)>-1 && event.type != "change" )
            {
                 $(this).trigger("change");
                return;
            }
            
            var radioname = $(this).attr('name');
            
           

               if( radioname.indexOf("[]") > -1){

                                radioname =	radioname.replace("[]","");
               }


                if($(this).attr("multiple") =="multiple"){
                      var radioval = $(this).val();



                $('div[data-parent-name="'+radioname+'"]').hide();

//                $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeAttr('required');
                $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').addClass('nonrequiredfield');
                $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeClass('requiredfield');
                 
                 
                if( typeof($(this).val()) == typeof([])){
                    
                    var dat = $(this).val();
                    $.each(dat,function(i,index){ 



                        $('div[data-parent-name="'+radioname+'"][data-val="'+index+'"]').show();

                    });
                 }


                }else{

                var radioval = $(this).val();
 
                if($(this).attr('type') != undefined && $(this).attr('type') != 'select'  ){
                    if( $(this).attr('type') == 'radio'){

                         if($(this).prop("checked") == false){
                             $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide(); 
//                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');
                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');
                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');
                         }else{  
                             $('div[data-parent-name="'+radioname+'"][data-val]').hide();   
//                             $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeAttr('required');
                             $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').addClass('nonrequiredfield');
                             $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeClass('requiredfield');
                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield'); 
                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield');
                         }
                         
                        return true;
                    }else{
                        if( $(this).attr('type') == 'checkbox'){

                             if($(this).prop("checked") == false){
                                 $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide();   
//                                 $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');   
                                 $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');   
                                 $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');  
                             }else{
                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield'); 
                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                             }

                            return true;
                        }else{

                            if(radioval != '')
                                if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required');   
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield');  
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                }else{
                                    $('div[data-parent-name="'+radioname+'"][data-val]').show();
//                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').attr('required','required');   
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').addClass('requiredfield'); 
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                                }
                            else{
                                 if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide();
//                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');
                                } else
                                    $('div[data-parent-name="'+radioname+'"][data-val]').hide();
//                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeAttr('required');
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').addClass('nonrequiredfield');
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeClass('requiredfield');
                            }
                        }
                    }
                }else{   
                     if($(this).prop("tagName") == 'SELECT' ){  
                       
                        $('div[data-parent-name="'+radioname+'"]').hide();
//                        $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeAttr('required');
                        $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').addClass('nonrequiredfield');
                        $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeClass('requiredfield');
                        
                        if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required');   
                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield'); 
                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                        }else{
                            $('div[data-parent-name="'+radioname+'"][data-val=""]').show();
//                            $('div[data-parent-name="'+radioname+'"][data-val=""]').find('.nonrequiredfield').attr('required','required');   
                            $('div[data-parent-name="'+radioname+'"][data-val=""]').find('.nonrequiredfield').addClass('requiredfield'); 
                            $('div[data-parent-name="'+radioname+'"][data-val=""]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                        }
                     }else{
                         
                        if(radioval != '')
                            if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required');   
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield');   
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield');   
                            }else{
                                $('div[data-parent-name="'+radioname+'"][data-val]').show();
//                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').attr('required','required');   
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').addClass('requiredfield');   
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                            }
                        else{
                             if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide();
//                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');
                            }else{
                                $('div[data-parent-name="'+radioname+'"][data-val]').hide();
//                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeAttr('required');
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').addClass('nonrequiredfield');
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeClass('requiredfield');
                            }
                        }
                    }
                }
 
            }

        }

        function showMoreOptionMulti(event){
// alert();
            var radioname = $(this).attr('name');
//            return false;
            
               var tagName = $(this).prop("tagName").toLowerCase();
            if(TagForChangeOnly.indexOf(tagName)>-1 && event.type != "change" ){
                $(this).trigger("change");
                return;
            }
            
           $('div[data-parent-name="'+radioname+'"]').hide();
 
               if( radioname.indexOf("[]") > -1){

                                radioname =	radioname.replace("[]","");
               }


                if($(this).attr("multiple") =="multiple"){
                      var radioval = $(this).val();



                $('div[data-parent-name="'+radioname+'"]').hide();

//                $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeAttr('required');
                $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').addClass('nonrequiredfield');
                $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeClass('requiredfield');
                 
                 
                if( typeof($(this).val()) == typeof([])){
                    
                    var dat = $(this).val();
                    
                    if(dat != null && dat.length > 0)
                    $.each(dat,function(i,index){ 



                        $('div[data-parent-name="'+radioname+'"][data-val="'+index+'"]').show();
                        
                    });
                    
                                  
                 }


                }else{

                var radioval = $(this).val();   
 
                if($(this).attr('type') != undefined && $(this).attr('type') != 'select' ){
                    if( $(this).attr('type') == 'radio'){

                         if($(this).prop("checked") == false){
                             
                                
//                                var radiovaldata = $('div[data-parent-name="'+radioname+'"]');
                             
                                if( $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide(); 
       //                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');
                                     $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');
                                     $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');
                              }else{
                                    var radiovaldata = $('div[data-parent-name="'+radioname+'"]');
                                    
                                    if(radiovaldata.length > 0){
                                        
                                        for(var i = 0; i< radiovaldata.length ; i++){
                                         
                                            var radiovalAll = $(radiovaldata[i]).attr('data-val');

                                            if(radiovalAll.indexOf(radioval) > -1){
                                                 radiovalAll = $('div[data-parent-name="'+radioname+'"]').attr('data-val');

                                                $(radiovaldata[i]).hide();
                //                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                $(radiovaldata[i]).find('.requiredfield').addClass('nonrequiredfield');   
                                                $(radiovaldata[i]).find('.requiredfield').removeClass('requiredfield');  
                                            }else{
                                                
                                            }
                                        }
                                    }
                                   
                                    checkIfCheckedMulti($(this));
                                }
                         }else{  
                                if( $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                 
                                    $('div[data-parent-name="'+radioname+'"][data-val]').hide();   
       //                             $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeAttr('required');
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').addClass('nonrequiredfield');
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeClass('requiredfield');
                                     $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
       //                              $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                     $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield'); 
                                     $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield');
                         
                                       checkIfCheckedMulti($(this));
                                }else{
                                    var radiovaldata = $('div[data-parent-name="'+radioname+'"]');
                                    
                                    if(radiovaldata.length > 0){
                                        
                                        for(var i = 0; i< radiovaldata.length ; i++){
                                         
                                            var radiovalAll = $(radiovaldata[i]).attr('data-val');

                                            if(radiovalAll.indexOf(radioval) > -1){
                                                 radiovalAll = $('div[data-parent-name="'+radioname+'"]').attr('data-val');

                                                $(radiovaldata[i]).show();
                //                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                $(radiovaldata[i]).find('.nonrequiredfield').addClass('requiredfield'); 
                                                $(radiovaldata[i]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                            }else{
                                                
                                            }
                                        }
                                    }
                                    
                                    checkIfCheckedMulti($(this));
                                }
                        } 
                         
                        return true;
                    }else{
                        if( $(this).attr('type') == 'checkbox'){
//                            return false;
//alert(radioname);
                             if($(this).prop("checked") == false){
                                 
                                if( $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                 
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide();   
   //                                 $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');   
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');   
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');  
                                }else{
                                    var radiovaldata = $('div[data-parent-name="'+radioname+'"]');
                                    
                                    if(radiovaldata.length > 0){
                                        
                                        for(var i = 0; i< radiovaldata.length ; i++){
                                         
                                            var radiovalAll = $(radiovaldata[i]).attr('data-val');

                                            if(radiovalAll.indexOf(radioval) > -1){
                                                 radiovalAll = $('div[data-parent-name="'+radioname+'"]').attr('data-val');

                                                $(radiovaldata[i]).hide();
                //                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                $(radiovaldata[i]).find('.requiredfield').addClass('nonrequiredfield');   
                                                $(radiovaldata[i]).find('.requiredfield').removeClass('requiredfield');  
                                            }else{
                                                
                                            }
                                        }
                                    }
                                    
                                    checkIfCheckedMulti($(this));
                                }
                                
                             }else{ 
                                if( $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                 
                                   
                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield'); 
                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                }else{
                                    var radiovaldata = $('div[data-parent-name="'+radioname+'"]');
                                    
                                    if(radiovaldata.length > 0){
                                        
                                        for(var i = 0; i< radiovaldata.length ; i++){
                                         
                                            var radiovalAll = $(radiovaldata[i]).attr('data-val');

                                            if(radiovalAll.indexOf(radioval) > -1){
                                                 radiovalAll = $('div[data-parent-name="'+radioname+'"]').attr('data-val');
/** needs to check this**/
                                     //           $(radiovaldata[i]).show();
                                                
                //                                  $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                $(radiovaldata[i]).find('.nonrequiredfield').addClass('requiredfield'); 
                                                $(radiovaldata[i]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                            }else{
                                                
                                            }
                                        }
                                    }
                                    
                                    checkIfCheckedMulti($(this));
                                }
                                
                            }

                            return true;
                        }else{

                            if(radioval != '')
                                if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required');   
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield');  
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                }else{
                                    $('div[data-parent-name="'+radioname+'"][data-val]').show();
//                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').attr('required','required');   
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').addClass('requiredfield'); 
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                                }
                            else{
                                 if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide();
//                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');
                                    $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');
                                } else
                                    $('div[data-parent-name="'+radioname+'"][data-val]').hide();
//                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeAttr('required');
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').addClass('nonrequiredfield');
                                    $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeClass('requiredfield');
                            }
                        }
                    }
                }else{   
          
                     if($(this).prop("tagName") == 'SELECT' ){  
                       
                        $('div[data-parent-name="'+radioname+'"]').hide();
//                        $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeAttr('required');
                        $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').addClass('nonrequiredfield');
                        $('div[data-parent-name="'+radioname+'"]').find('.requiredfield').removeClass('requiredfield');
                        
                        if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required');   
                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield'); 
                            $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                        }else{
                            $('div[data-parent-name="'+radioname+'"][data-val=""]').show();
//                            $('div[data-parent-name="'+radioname+'"][data-val=""]').find('.nonrequiredfield').attr('required','required');   
                            $('div[data-parent-name="'+radioname+'"][data-val=""]').find('.nonrequiredfield').addClass('requiredfield'); 
                            $('div[data-parent-name="'+radioname+'"][data-val=""]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                        }
                        
                         checkIfCheckedMulti($(this));
                     }else{
                         
                        if(radioval != '')
                            if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').show();
//                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required');   
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').addClass('requiredfield');   
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').removeClass('nonrequiredfield');   
                            }else{
                                $('div[data-parent-name="'+radioname+'"][data-val]').show();
//                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').attr('required','required');   
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').addClass('requiredfield');   
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.nonrequiredfield').removeClass('nonrequiredfield');  
                            }
                        else{
                             if(radioval != '' && $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').val() != undefined ){
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').hide();
//                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeAttr('required');
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').addClass('nonrequiredfield');
                                $('div[data-parent-name="'+radioname+'"][data-val="'+radioval+'"]').find('.requiredfield').removeClass('requiredfield');
                            }else{
                                $('div[data-parent-name="'+radioname+'"][data-val]').hide();
//                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeAttr('required');
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').addClass('nonrequiredfield');
                                $('div[data-parent-name="'+radioname+'"][data-val]').find('.requiredfield').removeClass('requiredfield');
                            }
                        }
                    }
                }
 
            }

        }
        
        
        function checkIfCheckedMulti(ref){
           
            if(ref != ''){
                
                var flag = 0;
                
                var radioname = ref.attr('name');
                var radiotype = ref.attr('type');
                var radioval = ref.attr('value');
                var tagName = ref.prop("tagName");
                 
                
                if(radiotype == 'checkbox' || radiotype == 'radio' ){
                    
                    var radioipts = $('input[name="'+radioname+'"]');
                
                    if(radioipts.length > 0){

                        for(var i = 0; i< radioipts.length ; i++){
                            
                            if($(radioipts[i]).prop("checked") == true){
                              
                                var radioiptval = $(radioipts[i]).attr('value');
                                
                                
                                var radioiptname = $(radioipts[i]).attr('name');
                                 
                                if( radioiptname.indexOf("[]") > -1){

                                    radioiptname =	radioiptname.replace("[]","");
                                }
                                
                                var radiovaldata = $('div[data-parent-name="'+radioiptname+'"]');
   console.log(radiovaldata);
                                if(radiovaldata.length > 0){
 
                                    for(var j = 0; j< radiovaldata.length ; j++){
                                        
//                                        if(radiovaldata.prop("checked") == true){
                                            var radiovalAll = $(radiovaldata[j]).attr('data-val');
                                         
//                                    try{
                                    var radiovalAllparse = JSON.parse(radiovalAll);
                                            var arryval = Array.isArray(radiovalAllparse);
                                              
                                            if(arryval == true){
                                               radioiptvalx =  '"'+radioiptval+'"';
                                              // alert(radioiptvalx);
                                    console.log('radiovalAll');
                                    console.log(arryval);
                                    console.log(radioiptvalx);
                                         console.log('radiovalAll**');
                                    console.log(radiovalAll.indexOf(radioiptvalx));
                               
//                                                radioiptval =  String(radioiptval);
//                                                if(radiovalAll.indexOf(radioiptval) > -1){
                                                if(radiovalAll.indexOf(radioiptvalx) == true){
                                    console.log(radiovaldata[j]);
                                                     flag = 0;
                                                    $(radiovaldata[j]).show();
                    //                                  $('div[data-parent-name="'+radioiptname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').addClass('requiredfield'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 
//                                                    return true;
                                                } else{
//                                                    $(radiovaldata[j]).hide();  
                                                    $(radiovaldata[j]).find('.requiredfield').addClass('nonrequiredfield');
                                                    $(radiovaldata[j]).find('.requiredfield').removeClass('requiredfield');

                                                     flag = 1;
                                                }
                                            }else{

                                                if(radiovalAll == radioiptval){
                                                     
                                                     flag = 0;
                                                    $(radiovaldata[j]).show();
                    //                                  $('div[data-parent-name="'+radioiptname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').addClass('requiredfield'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                                     
                                                } else{

                                                     flag = 1;
                                                }
                                            }
//                                        } catch (e) {
//                                        return false;
//                                        }
                                    }
                                }
                                    
                            }
                        }
                    }
                    
                    if(flag == 0){
                    
                        if( radioname.indexOf("[]") > -1){

                            radioname =	radioname.replace("[]","");
                        }

                        var radiovaldata = $('div[data-parent-name="'+radioname+'"]');

                        if(radiovaldata.length > 0){

                            for(var j = 0; j< radiovaldata.length ; j++){

                                var radiovalAll = $(radiovaldata[j]).attr('data-val');

                                if(radiovalAll.indexOf("null") > -1){

                                    $(radiovaldata[j]).show();
    //                                  $('div[data-parent-name="'+radioiptname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                    $(radiovaldata[j]).find('.nonrequiredfield').addClass('requiredfield'); 
                                    $(radiovaldata[j]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 

                                } 
                            }
                        }
                    }
                }else{
                    
                   if(tagName == 'SELECT'){
                    
                    var radioipts = $('select[name="'+radioname+'"]');
              
                    if(radioipts.length > 0){

                        for(var i = 0; i< radioipts.length ; i++){
                            
                              
                                var radioiptval = $(radioipts[i]).val();
                                
                                
                                var radioiptname = $(radioipts[i]).attr('name');
                                 
                                if( radioiptname.indexOf("[]") > -1){

                                    radioiptname =	radioiptname.replace("[]","");
                                }
                                
                                var radiovaldata = $('div[data-parent-name="'+radioiptname+'"]');
   
                                            console.log(radiovaldata);
                                if(radiovaldata.length > 0){
 
                                    for(var j = 0; j< radiovaldata.length ; j++){
                                        
                                            console.log(radiovaldata[j]);
//                                        if(radiovaldata.prop("checked") == true){
                                            var radiovalAll = $(radiovaldata[j]).attr('data-val');
                                         
                                    console.log('radiovalAll');
                                    console.log(radiovalAll);
                                    console.log('radiovalAll**');
                                    try{
                                    var radiovalAllparse = JSON.parse(radiovalAll);
                                            var arryval = Array.isArray(radiovalAllparse);
                                              
                                    console.log(radiovalAllparse);
                                            if(arryval == true){
                                               radioiptvalx =  '"'+radioiptval+'"';
//                                                console.log(radioiptval);
                                                console.log(radiovalAll.indexOf(radioiptval));
                                                if(radiovalAll.includes(radioiptvalx)== true){
                                                     flag = 0;
                                                    $(radiovaldata[j]).show();
                    //                                  $('div[data-parent-name="'+radioiptname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').addClass('requiredfield'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                                   continue;
                                                } else{
                                                    $(radiovaldata[j]).hide();  
                                                    $(radiovaldata[j]).find('.requiredfield').addClass('nonrequiredfield');
                                                    $(radiovaldata[j]).find('.requiredfield').removeClass('requiredfield');

                                                     flag = 1;
                                                }
                                            }else{

                                                if(radiovalAll == radioiptval){
                                                     
                                                     flag = 0;
                                                    $(radiovaldata[j]).show();
                    //                                  $('div[data-parent-name="'+radioiptname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').addClass('requiredfield'); 
                                                    $(radiovaldata[j]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 
                                                     
                                                } else{

                                                     flag = 1;
                                                }
                                            }
                                        } catch (e) {
                                            
                                            console.log('error');
                                            console.log(e);
                                           return false;
                                        }
                                    }
                                }
                                 
                        }
                    }
                    
                    if(flag == 0){
                    
                        if( radioname.indexOf("[]") > -1){

                            radioname =	radioname.replace("[]","");
                        }

                        var radiovaldata = $('div[data-parent-name="'+radioname+'"]');

                        if(radiovaldata.length > 0){

                            for(var j = 0; j< radiovaldata.length ; j++){

                                var radiovalAll = $(radiovaldata[j]).attr('data-val');

                                if(radiovalAll.indexOf("null") > -1){

                                    $(radiovaldata[j]).show();
    //                                  $('div[data-parent-name="'+radioiptname+'"][data-val="'+radioval+'"]').find('.nonrequiredfield').attr('required','required'); 
                                    $(radiovaldata[j]).find('.nonrequiredfield').addClass('requiredfield'); 
                                    $(radiovaldata[j]).find('.nonrequiredfield').removeClass('nonrequiredfield'); 

                                } 
                            }
                        }
                    }
                }
                    
                }
            }            
            
            return true;
        }
        
        
       $('body').on('click','.showMoreOption',showMoreOption  );   
       $('body').on('change','.showMoreOption',showMoreOption  );  
       $('body').on('click','.showMoreOptionMulti',showMoreOptionMulti  );   
       $('body').on('change','.showMoreOptionMulti',showMoreOptionMulti  );   
    
});
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(1==0){
      //this line is for IDE support

    ?>
</script>
        <?php
}
?>