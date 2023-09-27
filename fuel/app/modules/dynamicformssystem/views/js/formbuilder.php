<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(1== 0){
    ?>
<script> 
    <?php
    
}



?>

$(document).ready(function(){


var hidebar =  <?php if(isset($hidebar) && !empty($hidebar)) echo $hidebar; else echo 0;  ?>;
var locked =  <?php if(isset($locked) && !empty($locked)) echo $locked; else echo 0;  ?>;
var removeSubmit =  <?php if(isset($removesubmit) && !empty($removesubmit)) echo $removesubmit; else echo 0;  ?>;
var disablerequirednextfield =  <?php if(isset($disablerequirednextfield) && !empty($disablerequirednextfield)) echo $disablerequirednextfield; else echo 0;  ?>;
 
if(removeSubmit == 1){
    $('button[type="submit"]').parent().parent().remove();
}

var alertMessage = 'טופס נוצר בהצלחה';

if(hidebar == 1){
    $('.navbar.navbar-inverse.navbar-fixed-top').hide();
}
if(locked == 1){
    $('body').attr('style','margin-top: 0px; pointer-events: none;');
}


//$('input[type="submit"]').on('click',function(){
//    
//    //alert(alertMessage);
//    
//});


    $('input.file-upload-control').each(function(){ 
        var ref = $(this);
        var name =ref.attr('name');
        if($(this).attr("type") == "hidden"){
            
            var fieldval = $("input[name='"+name+"'][type='hidden']").val();

            var limit = parseInt(ref.attr('maxlimit'));
 
            if(Number.isNaN(limit) || limit == 0)
               $(this).attr('maxlimit','5');
            if(fieldval !== undefined){
                
                 var filelen = fieldval.split(',');

                $.each(filelen, function(i,v){

                    if(v !== ''){
                        
                        $.get('/dynamicforms/image/viewx/'+v,function(e){
                        var data = JSON.parse(e);
                       
                        if(data.car != undefined && data.car.name != ''){
                            
                            var ext = data.car.name.split('.').pop();
//                            var img_ext = ['PNG','JPEG','JPG','GIF','png','jpeg','jpg','gif'];
                            var img_ext = ['PDF','DOC','DOCX','XLS','TXT','ODT','PPT','XLSX','pdf','doc','docx','xls','txt','odt','ppt','xlsx'];
                            if(img_ext.indexOf(ext) != -1){
                            
                                var pdf_ext = ['PDF','pdf' ];

                                if(pdf_ext.indexOf(ext) != -1){

                                    var a= '<div  style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                            <iframe style="width:144px;" src="/Model_Products/'+data.car.name+'" target="_blank">\n\
                                                 </iframe>';

                                            if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                                a +=  '<a class="delete-img" name="'+name+'" data-id="'+data.car.id+'"><i class="icon-remove"></i></a>';
                                            a += ' </div>';
                                            a += ' </div>';
                                }else{
                            
                            
                                    var a= '<div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                              <a href="/Model_Products/'+data.car.name+'" target="_blank">\n\
                                                 '+ext+'\n\
                                                 </a>';

                                                if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                                    a +=  '<a class="delete-img" name="'+name+'" data-id="'+data.car.id+'"><i class="icon-remove"></i></a>';
                                                a += ' </div>';
                                                a += ' </div>';
                                }
                            }else{
                                var a= '<div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                      <a href="/Model_Products/'+data.car.name+'" target="_blank">\n\
                                         <img src="/Model_Products/'+data.car.name+'" style="width: 55px;  height: 60px;" />\n\
                                        </a>';
                                    if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                        a +=  '<a class="delete-img" name="'+name+'" data-id="'+data.car.id+'"><i class="icon-remove"></i></a>';
                                    a += ' </div>';
                                    a += ' </div>';
                            }
                            $('input[disable_file]').parent().children().children('.thumbnail').children('a.delete-img').hide();
                            $("input[name='"+name+"'][type='hidden']").parent().append(a);
                        }
                    });
                    }
                });
            }
        }
        
    });
    
  
    $(document).ready(function(){ 
        try{ 
            $('textarea[type="tinymce"]').tinymce({
                plugins:'directionality',
                directionality : 'rtl',  
            });
        }catch(err)
        {
            console.log('error : '+err);
        }
        
        
//        $('input[type="submit"]').on('click',function(){
//           
//           if(enableIndividualEmail == "1" && false){
//           
//                var con = confirm('Want to send Mail ?');
//
//                if(con){
//
//                     var emailid =  prompt('Please Enter Email ID');
//
//                     if(emailid != null && emailid != ''){
//
//                         $('#enterEmail').val(emailid);  
//                         return true;
//                     }else{ 
//                         return false;
//                     } 
//
//                }else{
//                    return true;
//                }
//            }else return true;
//            
//        });

    });
      
    function progressBar(){
       
        var div_percent = $('<div/>');
            div_percent.addClass('percent');
            div_percent.text('0%');
        var div_bar = $('<div/>');
            div_bar.addClass('bar'); 
            div_bar.addClass('barData'); 
        var div_progress = $('<div/>');
            div_progress.addClass('span6');
            div_progress.addClass('progress');
            div_progress.addClass('progress-bar-mycom'); 
            div_progress.addClass('pull-left'); 
            
        var div_progress12 = $('<div/>');
            div_progress12.addClass('span12'); 
            div_progress12.addClass('progress-12'); 
            
            div_progress.append(div_bar);
            div_progress.append(div_percent);
            div_progress12.append(div_progress);
            
        return div_progress12;
   } 
   function form_fileupload(){  
        var ref = $(this);
        
//        ref.parent().parent().children('.progress-12').remove();
        
//        ref.attr('data-url',$('#uploadUrl').val());
        var name =ref.attr('name');
        var fieldval = $("input[name='"+name+"'][type='hidden']").val();
        if(fieldval === undefined){

            var ipt = '<input type="hidden" name="'+name+'"  />';
              ref.parent().append(ipt);
            fieldval = $("input[name='"+name+"'][type='hidden']").val();
        }
        var limit = parseInt(ref.attr('maxlimit'));
        
        if(Number.isNaN(limit) || limit == 0)
           $(this).attr('maxlimit','5');
        
        
        var filelen = fieldval.split(',');
         
        if(fieldval != '' &&  filelen.length >= limit){
            var msg = 'Only '+limit;
            if(limit >1){
               msg +=' files allowed'; 
            }else{
               msg +=' file allowed'; 
            }
            alert(msg);
            
            return false;
        }else{
        
            $('.progress-12').remove();
            var progress_bar =    progressBar();
            ref.parent().after(progress_bar);
             
            $(this).fileupload({
               dataType: 'json',
                maxFileSize: 1000,
                submit:function(e){
//                    alert('Please wait while uploading...');
                },
                progress: function (e, data) {
                     
                    var percentVal = data.progressInterval+'%';
                    var bar = $('.bar');
                    var percent = $('.percent');

                    bar.width(percentVal);
//                    bar.text('Uploading File'+percentVal);
                    bar.text('Uploading File');
                    percent.html(percentVal);
                },
                done: function (e, data) {
                     
                    var percentVal = data.progressInterval+'%';
                    var bar = $('.bar');
                    var percent = $('.percent');

                    bar.width(percentVal);
                    bar.text('Uploaded File');
                    percent.html(percentVal);
                    console.log(ref.parent().parent().children('.progress-12'));
                    $('.progress-12').remove();
                    
                    if($('#mycomform_id').val() != undefined && $('#mycomform_id').val() != '')
                        createDraftOrder();
                },
               success:function(response){   
                    console.log(response);
                   if(response != ''){
                       
                       if(response.error != undefined){
                           alert(response.msg);
                           return false;
                       }
                       
                    fieldval = $("input[name='"+name+"'][type='hidden']").val();
                    if(fieldval === ''){ 
                       fieldval = response.id;
                    }else{ 
                        fieldval += ','+response.id;
                    }

                    $("input[name='"+name+"'][type='hidden']").val(fieldval);
                    $("input[name='"+name+"'][type='file']").removeAttr('required');
 
                        var a= '<div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                              <a href="/Model_Products/'+response.name+'" target="_blank">\n\
                                 <img src="/Model_Products/'+response.name+'" style="width: 55px;  height: 60px;" />\n\
                                </a>';

                            if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                a +=  '<a class="delete-img" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                            a += ' </div>';
                            a += ' </div>'; 
                    $("input[name='"+name+"'][type='hidden']").parent().append(a);
                         //   scrollWin($("input[name='"+name+"'][type='hidden']").parent());

                    if(ref.hasClass('file-upload-defect')){
                        $("input[name='"+name+"'][type='hidden']").parent().parent().parent().parent().children().first().after(a);
                    }
                }
               }
           });
       }
    }
    
   function fileuploadx_open(){ 
    var ref = $(this);
        var name =ref.attr('name');
      
        
        $('input[type="file"][name="'+name+'"]').click();
    } 
   function fileuploadx_new(){ 
        var ref = $(this);
        
        ref.parent().parent().children('.progress-12').remove();
        
        ref.attr('data-url',$('#uploadUrl').val());
        var name =ref.attr('name');
        var fieldval = $("input[name='"+name+"'][type='hidden']").val();
    
        if(fieldval === undefined){

            var ipt = '<input type="hidden" name="'+name+'"  />';
              ref.parent().append(ipt);
            fieldval = $("input[name='"+name+"'][type='hidden']").val();
        }
        var limit = parseInt(ref.attr('maxlimit'));
        
        if(Number.isNaN(limit) || limit == 0)
           $(this).attr('maxlimit','5');
       
        
        var filelen = fieldval.split(',');
         
        if(fieldval != '' &&  filelen.length >= limit){
            var msg = 'Only '+limit;
            if(limit >1){
               msg +=' files allowed'; 
            }else{
               msg +=' file allowed'; 
            }
            alert(msg);
            
            return false;
        }else{
        
            $('.progress-12').remove();
            var progress_bar =    progressBar();
            ref.parent().after(progress_bar);
             
            $(this).fileupload({
               dataType: 'json',
                maxFileSize: 1000,
                submit:function(e){
//                    alert('Please wait while uploading...');
                },
                progress: function (e, data) {
                     
                    var percentVal = data.progressInterval+'%';
                    var bar = $('.bar');
                    var percent = $('.percent');

                    bar.width(percentVal);
//                    bar.text('Uploading File'+percentVal);
                    bar.text('Uploading File');
                    percent.html(percentVal);
                },
                done: function (e, data) {
                     
                    var percentVal = data.progressInterval+'%';
                    var bar = $('.bar');
                    var percent = $('.percent');

                    bar.width(percentVal);
                    bar.text('Uploaded File');
                    percent.html(percentVal);
                    console.log(ref.parent().parent().children('.progress-12'));
                    $('.progress-12').remove();
                    
                    if($('#mycomform_id').val() != undefined && $('#mycomform_id').val() != '')
                        createDraftOrder();
                },
               success:function(response){   
                    console.log(response);
                    if(response == '102'){
                        alert('This file type cannot be uploaded');
                        $('.progress-12').remove();
                    }
                   if(response != ''){
                       
                       if(response.error != undefined){
                           alert(response.msg);
                           return false;
                       }
                       
                    fieldval = $("input[name='"+name+"'][type='hidden']").val();
                    if(fieldval === ''){ 
                       fieldval = response.id;
                    }else{ 
                        fieldval += ','+response.id;
                    }

                    $("input[name='"+name+"'][type='hidden']").val(fieldval);
                    $("input[name='"+name+"'][type='file']").removeAttr('required');

                    var ext =response.name;
                    
                    var extn = ext.split('.').pop();
                    
                    var img_ext = ['PDF','DOC','DOCX','XLS','TXT','ODT','PPT','XLSX','pdf','doc','docx','xls','txt','odt','ppt','xlsx'];
                   
                    if(extn != undefined && img_ext.indexOf(extn) != -1){
                        var pdf_ext = ['PDF','pdf' ];

                        if(pdf_ext.indexOf(extn) != -1){
                                        
                            var a= '<div  style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                    <iframe style="width:144px;" src="/Model_Products/'+response.name+'" target="_blank">\n\
                                         </iframe>';

                                    if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                        a +=  '<a class="delete-img" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                                    a += ' </div>';
                                    a += ' </div>';
                        }else{
                            var a= '<div  style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                      <a href="/Model_Products/'+response.name+'" target="_blank">\n\
                                         '+extn+'\n\
                                        </a>';

                                    if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                        a +=  '<a class="delete-img" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                                    a += ' </div>';
                                    a += ' </div>';
                        }

                    }else{
                        var a= '<div style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                              <a href="/Model_Products/'+response.name+'" target="_blank">\n\
                                 <img src="/Model_Products/'+response.name+'" style="width: 55px;  height: 60px;" />\n\
                                </a>';

                            if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                a +=  '<a class="delete-img" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                            a += ' </div>';
                            a += ' </div>';
                    }
                    $("input[name='"+name+"'][type='hidden']").parent().append(a);
                         //   scrollWin($("input[name='"+name+"'][type='hidden']").parent());

                    if(ref.hasClass('file-upload-defect')){
                        $("input[name='"+name+"'][type='hidden']").parent().parent().parent().parent().children().first().after(a);
                    }
                }
               }
           });
       }
    }

         function deleteImage(){
             
          //  $(this).parent().parent().parent().children('.form-file-upload').show();
         //   var varname = $(this).parent().parent().parent().children('.form-file-upload').attr('name');
            
        //    $('input[name="'+varname+'"][type="hidden"]').val('');
        //    $(this).parent().parent().remove();

           
            var varname = $(this).parent().parent().parent().children('.file-upload-control').attr('name');
            
            var imageId = $(this).attr('data-id');
            var imageValues = $('input[name="'+varname+'"][type="hidden"]').val();
            
            if(imageValues != undefined && imageValues.indexOf(',')){
            
            $(this).parent().parent().parent().children('.file-upload-control').show();
            imageValues = imageValues.split(',');
        
            var imgLen = 0;
            if(imageValues.length > 0){
            
                var index =imageValues.indexOf(imageId);

                if (index > -1) {
                    imageValues.splice(index, 1);
                }
                imageValues = imageValues.join(',');
            } 
            
            var imageValues = $('input[name="'+varname+'"][type="hidden"]').val(imageValues);
            }else{
            var varname = $(this).parent().parent().parent().children('.form-file-upload').attr('name');
            $(this).parent().parent().parent().children('.form-file-upload').show();
             $('input[name="'+varname+'"][type="hidden"]').val('');
             $(this).parent().parent().remove();
            }
            $(this).parent().parent().remove();
 
        }
         function deleteImagePDF(){
             
          //  $(this).parent().parent().parent().children('.form-file-upload').show();
         //   var varname = $(this).parent().parent().parent().children('.form-file-upload').attr('name');
            
        //    $('input[name="'+varname+'"][type="hidden"]').val('');
        //    $(this).parent().parent().remove();

           
            var varname = $(this).parent().parent().parent().children('.file-upload-control-pdf').attr('name');
            
            var imageId = $(this).attr('data-id');
            var imageValues = $('input[name="'+varname+'"][type="hidden"]').val();
            
            if(imageValues != undefined && imageValues.indexOf(',')){
            
            $(this).parent().parent().parent().children('.file-upload-control-pdf').show();
            imageValues = imageValues.split(',');
        
            var imgLen = 0;
            if(imageValues.length > 0){
            
                var index =imageValues.indexOf(imageId);

                if (index > -1) {
                    imageValues.splice(index, 1);
                }
                imageValues = imageValues.join(',');
            } 
            
            var imageValues = $('input[name="'+varname+'"][type="hidden"]').val(imageValues);
            }else{
            var varname = $(this).parent().parent().parent().children('.form-file-upload-pdf').attr('name');
            $(this).parent().parent().parent().children('.form-file-upload-pdf').show();
             $('input[name="'+varname+'"][type="hidden"]').val('');
             $(this).parent().parent().remove();
            }
            $(this).parent().parent().remove();
 
        }

    $('body').on('change','.form-file-upload',form_fileupload);
    $('body').on('click','input.file-upload-control',fileuploadx_new);
    $('body').on('change','input.file-upload-control',fileuploadx_new);
    $('body').on('click','button.file-upload-control',fileuploadx_open);
    $('body').on('change','button.file-upload-control',fileuploadx_open);
 $('body').on('click','.delete-img', deleteImage);
 $('body').on('click','.delete-img-pdf', deleteImagePDF);
    
     function HeaderCollapsingButton(){
                	if($(this).parent().hasClass("collapsed-box")){
                        $(this).find(".icon-plus").removeClass().addClass("icon-minus");
                         $(this).parent().removeClass("collapsed-box");
                         var boxBody = $(this).parent().find(".box-body");   //.parent().find(".box-body").parent().find(".box-body");
                          boxBody .css("height","inherit")
                           boxBody.removeClass("collapse");
                         }
                         else  { 
                         $(this).parent().addClass("collapsed-box");
                         var boxBody = $(this).parent().find(".box-body");   //.parent().find(".box-body");
                         $(this).find(".icon-minus").removeClass().addClass("icon-plus");
                          boxBody.css("height","0px")
                           boxBody.addClass("collapse");
                         }
                         
                }  
     
      function addShoeLines(e){
                
            e.preventDefault();
            var cloneid = $(this).attr('clone-id');
            var clone = $('#'+cloneid).children().clone();
            
            var count = $('#'+cloneid).attr('count');
            
            console.log(clone);
            var elements = clone.find('.form-fields');
            var appendele = $(this).parent().parent().parent().children('.appendData');
            var title = clone.find('.box-title .title').text();
            
            clone.find('.box-title .title').text(title+" "+count);
            mapElements(elements,appendele,clone,count);
            count++;
            count = $('#'+cloneid).attr('count',count);
        }

        function mapElements(elements,appendele,clone,count){
            
            
            if(elements.length > 0){
                
                for(var i = 0; i <elements.length; i++){
                    
                    var ele =  $(elements[i]);
                    var eleid =  ele.attr('id');
                    
                    var name = ele.attr('name');
   
   
                    name = name.replace('count',count); 
               
                    clone.find('#'+eleid).removeAttr('name');
                    clone.find('#'+eleid).attr('name',name); 
                }
                
                appendele.append(clone);
            } 
        }

function validateId(){

    var ssnid = $(this).val();  
    
    var result =  false;
    
    var id = String(ssnid).trim();
    if (id.length > 9 || id.length < 5 || isNaN(id)) {
        result = false;
    }else{

        // Pad string with zeros up to 9 digits
        id = id.length < 9 ? ("00000000" + id).slice(-9) : id;

        result =  Array.from(id, Number)
                    .reduce((counter, digit, i) => {
                        const step = digit * ((i % 2) + 1);
                        return counter + (step > 9 ? step - 9 : step);
                    }) % 10 === 0;
     }
     
    var msg = 'מספר ת.ז. לא תקין';
     
    updateErrorMessage($(this),result, msg);
    
}

function validateCellPhone(){
  
    var phoneno = $(this).val();   
    var re=/^0(5[^7]|[2-4]|[8-9]|7[0-9])[0-9]{7}$/; 
    var result = re.test(phoneno);
    var msg = 'מספר פלאפון לא תקין';
    
    updateErrorMessage($(this),result, msg);
}

function validateEmail(){
  
    var email = $(this).val();
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    var result = re.test(String(email).toLowerCase());
    
    var msg = 'אימייל לא תקין';
    
    updateErrorMessage($(this),result, msg);
 
}

function updateErrorMessage(ref,result, msg){

    var errDiv = $('<div/>');
        errDiv.addClass('span12');
        errDiv.addClass('error-email');
        errDiv.addClass('errorMsg');
        errDiv.append(msg);
    
    ref.parent().parent().children('.errorMsg').remove();
     
    
     
    if(result == false){
        
        ref.addClass("validationFailedFocus");
         
         
        ref.parent().parent().append(errDiv);
        
        
        
    }else{
        ref.removeClass("validationFailedFocus"); 
    }
}

  
                function disableSubmit(e){
               
                    var data  = $(this).closest("form").find(".requiredfield");
                    var flag = 0
                    
                    if(data != undefined && data.length > 0){
                        for(var i=0; i< data.length; i++){
                           var field = $(data[i]);
                           if( field.attr('type') == 'file'  && field.is(':visible')){
                               
                               var fieldname = field.attr('name');
                               
                               if($('input[type="hidden"][name="'+fieldname+'"]').val() == ''){
                                   
                                        flag = 1;
                                        $('button[name="'+fieldname+'"]').focus();
                                        $('button[type="submit"]').removeAttr('style');
                                        return false;
                                }
                               
                           }else{

                                if(field.is(":checkbox")  && field.is(':visible')){

     //                                console.log("checkbox");
     //                                console.log(field);
                                     var name= field.attr('name');
                                     var chkfields = $('input[name="'+name+'"]');
                                     var chkcount = chkfields.length;

                                     if(chkcount > 0){
     //                                    alert(chkcount);
                                         var flag2 = 0;
                                         var flag2count = 0;
                                         for(var j=0; j< chkcount; j++){
                                            var name = $(chkfields[j]).attr("name");
                                             var chkfield = $(chkfields[j]);
                                           //  var chkfield = $("input[name="+name+"]");
                                               if(!chkfield.is(':checked') && chkfield.is(':visible'))
                                                   flag2count++; 
                                         }

     //                                    console.log(chkfields[0]);
                                         if(flag2count == chkcount){
     //                                    console.log('chkfields[0]');
                                             var x =$(chkfields[0]);
     //                                    console.log(x);
                                             x.focus();
                                        $('button[type="submit"]').removeAttr('style');
                                             return false;
                                         }
                                     }else{

                                         if(!chkfields.is(':checked'))
                                             field.focus();
                                        $('button[type="submit"]').removeAttr('style');
                                             return false;
                                     }
                                 }
 if(field.is(":radio") && field.is(':visible')){
                                     var name= field.attr('name');
                                var chkfields = $('input[name="'+name+'"]');
                                     var chkcount = chkfields.length;
                                         var flag2count = 0;
                                    //  alert(chkcount);
                                     var x =$(chkfields[0]);
                                     for(var j=0; j< chkcount; j++){
                                        var name = $(chkfields[j]).attr("name");
                                             var chkfield = $(chkfields[j]);
                                            var chkfield = $("input[name="+name+"]");
                                               if(!chkfield.is(':checked') && chkfield.is(':visible'))
                                                   flag2count++; 
                                         }
 
                                         if(flag2count > 0){
                                                   
                                                // field.parent().parent().last().attr('style',' outline: 2px ridge rgba(56, 165, 224, .6);    border-radius: 0.4rem;');
                                                field.focus();
                                        $('button[type="submit"]').removeAttr('style');
                                     return false;
//   alert();
                                               }
                            }
                            
                                if( field.val() == ''  && field.is(':visible')){
                                    console.log(field);
                                     if ( field.is( ":hidden" ) || field.is( ":disabled" )){

                                             if(field.hasClass( "signature-btn" ) ) {
                                                 var name= field.attr('name');
                                                 $('button[name="'+name+'"]').attr('style','    outline: red 2px solid;');
                                                  flag = 1;
                                        $('button[type="submit"]').removeAttr('style');
                                        $('button[name="'+name+'"]').focus();
                                                 return false;
                                             }
                                         }else{ 
                                         flag = 1;
                                          field.focus();
                                        $('button[type="submit"]').removeAttr('style');
                                          return false;
                                         } 
                                }

                                
                                
                                if( field.val() == '' ){    
                                    console.log(field);
                                     if ( field.is( ":hidden" ) || field.is( ":disabled" )){
                                      
                                             if(field.hasClass( "signature-btn" ) ) {
                                                 var name= field.attr('name');
                                                 
                                                 if($('button[name="'+name+'"]:visible').length > 0){
                                                 $('button[name="'+name+'"]').attr('style','    outline: red 2px solid;');
                                                  flag = 1;
                                                  $('button[name="'+name+'"]').focus();
                                        $('button[type="submit"]').removeAttr('style');
                                                 return false;
                                                 }
                                             }
                                         } 
                                }
                            }
                        }
                    } 
                    if(flag == 0){
                        $(this).removeAttr('disabled');
                        $('form').submit();
                    }else{
                        
                        $('button[type="submit"]').removeAttr('style');
                    }
                }
             
function calculateLangth(){

    var val = $(this).val();
    var datasize = $(this).attr('data-size');
    
    
    if(datasize != undefined && val != undefined){
        if(val.length > datasize){
            
            var sub = val.substring(0, datasize);
            $(this).val(sub);
        
        }
    }

}
 
 
 
             
    window.addEventListener("message", validateFields, false);
 

    function validateFields(event){

//        var data  = $('.requiredfield');
        var data  = $(this).closest("form").find(".requiredfield");
        var flag = 0
        if(data != undefined && data.length > 0){
            for(var i=0; i< data.length; i++){
               var field = $(data[i]);
               
               if(field.is(":checkbox")){
                                
//                                console.log("checkbox");
//                                console.log(field);
                                var name= field.attr('name');
                                var chkfields = $('input[name="'+name+'"]');
                                var chkcount = chkfields.length;

                                if(chkcount > 1){
//                                    alert(chkcount);
                                    var flag2 = 0;
                                    var flag2count = 0;
                                    for(var j=0; j< chkcount; j++){
                                        var chkfield = $(chkfields[j]);
                                          if(!chkfield.is(':checked'))
                                              flag2count++; 
                                    }
                                    
//                                    console.log(chkfields[0]);
                                    if(flag2count == chkcount){
//                                    console.log('chkfields[0]');
                                        var x =$(chkfields[0]);
//                                    console.log(x);
                                        x.focus();
                                        return false;
                                    }
                                }else{
                                 
                                    if(!chkfields.is(':checked'))
                                        field.focus();
                                        return false;
                                }
                            }

               if( field.val() == '' ){
                               console.log(field);
                                if ( field.is( ":hidden" ) || field.is( ":disabled" )){
                                    
                                        if(field.hasClass( "signature-btn" ) ) {
                                            var name= field.attr('name');
                                            $('button[name="'+name+'"]').attr('style','    outline: red 2px solid;');
                                             flag = 1;
                                            return false;
                                        }
                                    }else{
                                 //    return false;
        //                         console.log(field);
                                    flag = 1;
                                     field.focus();
                                     return false;
                                    }
//                            if(field.is(':focus')){
//                                 field.focus();
//                                 return false;
//                             }else{
//                                  field.removeAttr('required');
//                            }
                           }
            }
        }

         var data  = $(this).closest("form").find('.validateId'); 
        if(data != undefined && data.length > 0){
//            for(var i= data.length; i>= 0; i--){
            for(var i=0; i< data.length; i++){
               var field = $(data[i]);

               if(field.val() == ''){
                 flag = 1;

                 field.focus();
                 
               }
            }
        }
        var data  = $(this).closest("form").find('.validateCellPhone'); 
        if(data != undefined && data.length > 0){
//            for(var i= data.length; i>= 0; i--){
            for(var i=0; i< data.length; i++){
               var field = $(data[i]);

               if(field.val() == ''){
                 flag = 1;

                 field.focus();
                 
               }
            }
        }
        var data  = $(this).closest("form").find('.validateEmail'); 
        if(data != undefined && data.length > 0){
//            for(var i= data.length; i>= 0; i--){
            for(var i=0; i< data.length; i++){
               var field = $(data[i]);

               if(field.val() == '' && field.hasClass('requiredfield')){
                 flag = 1;

                 field.focus();
                 
               }
            }
        }
        
        var msg ='';
        
        if(flag == 0)
            msg = 'Valid Data';
        else
            msg = 'Invalid Data';
        
        event.source.postMessage(msg, event.source);
    
    }
 
    function getOptions(){ 
        
        var options = $('.getOptions');
        
        if(options != undefined && options.length > 0){
          
           $.each(options , function(inx, option){
                var href = $(this).attr('href'); 
                var value = $(this).attr('value'); 
                var ref = $(this); 

                 var url = href+'/listoptions'

                 $.get(url, function(data){
 
                    if(data != undefined  ){ 
                        $.each(data , function(idx, val){

                            var opt = $('<option/>');
                                opt.attr('value',val.value);
                                opt.append(val.label);

                            if(value != undefined && value != '' && value == val.value){
                                opt.attr('selected','selected');
                            }
                            ref.append(opt);
                        });
                    }
                 });
              
            });
        }
    }
 
    function setBranchLink(){
        var bank_name = $(this).val();
      
        var branch_name = $(this).attr('branch_name');
        var branch_number = $(this).attr('branch_number');
 
        if(bank_name != undefined && bank_name != ''){
            
            var link = $('input[name="'+branch_name+'"]').attr('href2');
            var link2 = $('input[name="'+branch_number+'"]').attr('href2');
          
        
            if(link != ''){
                link = link+'?bankname='+bank_name;
                
                $('input[name="'+branch_name+'"]').val('');
                $('input[name="'+branch_name+'"]').attr('href',link);
            }
        
            if(link2 != ''){
                link2 = link2+'?bankname='+bank_name;
                
                $('input[name="'+branch_number+'"]').val('');
                $('input[name="'+branch_number+'"]').attr('href',link2);
            }   
            
            
        }
        
    }
  
//    function popup() {
        
            $('.popup-autocomplete').each(function(i, el) {
            el = $(el);
            var storage = window.localStorage;
            var domain = storage.getItem("domain");
            var url =  el.attr('href');
            console.log(url);
            var data_available;
            el.autocomplete({ 
                source: function(request, response){
                    var res = null;
                    var x = request.term;

                    if(this.element.hasClass('receiptNumber')){  
                        if(x.indexOf(',') > -1){
                            var y = x.split(',');
                            x = y.pop(); 
                            x = x.replace(/\s/g,'');
                            console.log(x);
                        }
                    } 
                    var control = this.element.attr('mapper');
                    var url = this.element.attr('href');
                    var catid = $('#hidden_category_id').val();
                    if(catid !== '' &&  url === '/products/listkey.json'){
                            url= url+"?category_id="+catid;
                                    console.log(url);
                    }
                    var custId = this.element.attr('custid');
                         console.log(url);
                    $.ajax({
                               url: url,
                               dataType: "json",
                               data: {
                                 searchterm: control,
                                 term:x,
                                 customer_id: custId
                               },
                               success: function( data ) {
                                   console.log('data received'+data);
                                   console.log( data);
                                   var newtemp = [];
                               
                                   if($('.receiptNumber').val() !== undefined){  
                                       var d = $('.receiptNumber').val();
                                       var existing_numbers = d.split(',');
                                       existing_numbers = existing_numbers.map(function (el1) {
                                                return el1.trim();
                                        });
                                        
                                        var temp = {value:"<table  style='margin-left:0;margin-right:0;width: 100%;margin-top: -1px;'><tr><th style='border:none;width:30%'>מספר קבלה</th><th style='border:none;width:30%'>סכום</th><th style='border:none;width:40%'>תאריך</th></tr></table>"};
                                        newtemp.push(temp);
                                        $.each(data, function(x,y){
                                            if(!existing_numbers.includes(y.receiptnumber)){
                                                y.value= "<table style='text-align:center;width: 100%;'><tr>\n\
                                                         <td style='border:none;width:30%;' class='receiptname'>"+y.receiptnumber+"<td style='border:none;width:30%'>"+y.total+
                                                        "</td><td style='border:none;width:40%;'>"+y.created_at+"</td></tr></table>";
                                                newtemp.push(y);
                                            }
                                        });
                                    }else{
                                        newtemp = data;
                                    }
                                        response(newtemp); 
                                }
                             });
                },

                select: function(event, ui){
                    data_available = $(this).val();
                    var hidden = $("#hidden_"+this.id);
                    hidden.attr('value',ui.item.id);
                    hidden.trigger('change');
                    
                   
                },
                close: function(e,ui) {
                   
                    if($(this).hasClass('receiptNumber')){
                        var data = '';
                        if(data_available !== undefined && data_available.indexOf(',') > -1){
                            var y = data_available.split(',');
                             y.pop(); 
                             data = y.join( ", " );
                             data +=", ";
                        }else{
                            if(data.length <2){
                                data = '';
                            }
                        }
                        
                        var autoval = $(this).val();
                        
                        var newstring = $(autoval);
                        var receiptNum =newstring.children().children().children("td.receiptname").text();
                        if(receiptNum !== undefined && !isNaN(parseInt(receiptNum))){
                            
                            $(this).val(parseInt(receiptNum));
                            
                            data += $(this).val();
                            var terms = split( data);
                                
                            terms.pop();
                                
                            terms.push(receiptNum );
                            terms.push( "" );

                            this.value = terms.join( ", " );
                            return false;          
                        }
                    }
                },
                
                open: function(e,ui) {
                        var acData = $(this).data('ui-autocomplete');
                        var acterm = $(this).val();
                        var temp  = $('<li>')
                        acData.menu.element.find("a").each(function() {
                                var me = $(this);
                                var keywords = acData.term.split(' ').join('|');
                             
                                me.html(me.text().replace(new RegExp("(\s" + keywords + "|" + keywords + ")", "i"), '<b>$1</b>')); //remove g if not required
                            });
                    }
            });
        });       
//        }
            
            
//            $('body').on('change','.popup-autocomplete', popup);
            $('body').on('change','.getBranch', setBranchLink);
    
    getOptions();
//    popup();
        $("html").off("click",".box-header",HeaderCollapsingButton); 
    $("html").on("click",".box-header", HeaderCollapsingButton);   
    
    
        $('body').on('click','.validateId', validateId);    
        $('body').on('click','.validateCellPhone', validateCellPhone);    
        $('body').on('click','.validateEmail', validateEmail);  
        $('body').on('change','.validateId', validateId);    
        $('body').on('change','.validateCellPhone', validateCellPhone);    
        $('body').on('change','.validateEmail', validateEmail);  
        $('body').on('focus','.validateId', validateId);    
        $('body').on('focus','.validateCellPhone', validateCellPhone);    
        $('body').on('focus','.validateEmail', validateEmail);  
//    $('body').on('click', 'button[type="submit"]' , disableSubmit );
    $('body').on('submit', '#myFormId' , disableSubmit );
    $('body').on('change', 'textarea' , calculateLangth );
    $('body').on('change', 'input' , calculateLangth ); 
//    $('body').on('change', '.getOptions' , getOptions ); 
    
    
    if(disablerequirednextfield == 0){
           function enablesubmit(e){
                    
                    var data  = $(this).closest("form").find(".requiredfield");
                    var flag = 0
                    
                    var tagname = $(this).attr('name');
//                    console.log('next');
//                    console.log($(this).closest(".box-body").next(".box-body").children('.requiredfield'));
//                    console.log(data);
//                    return false;
                    if(data != undefined && data.length > 0){
                        for(var i= 0; i< data.length; i++){
                           var field = $(data[i]);
                           var fieldname = field.attr('name'); 
                           
                           if(field)

                            if(field.is(":checkbox")){
                                
                                
                                var name= field.attr('name');
                                var chkfields = $('input[name="'+name+'"]');
                                var chkcount = chkfields.length;

                                if(chkcount > 1){
                                    
                                    var flag2count = 0;
                                    for(var j=0; j< chkcount; j++){
                                        var chkfield = $(chkfields[j]);
                                          if(!chkfield.is(':checked'))
                                              flag2count++; 
                                    }
                                    
                                    
                                    if(flag2count == chkcount){
                                        
                                        var x =$(chkfields[0]);
                                        
                                        x.focus();
                                        $('button[type="submit"]').removeAttr('style');
                                        return false;
                                    }
                                }else{
                                 
                                    if(!chkfields.is(':checked'))
                                        field.focus();
                                                                                $('button[type="submit"]').removeAttr('style');
                                        return false;
                                }
                            }
                            
                            if( field.val() == '' ){

                                if ( field.is( ":hidden" ) || field.is( ":disabled" )){

                                    if(field.hasClass( "signature-btn" ) ) {
                                        var name= field.attr('name');
                                        $('button[name="'+name+'"]').attr('style','    outline: red 2px solid;');
                                        flag = 1;
                                        $('button[type="submit"]').removeAttr('style');
                                        return false;
                                    }
                                 }else{
                                    flag = 1;
                                    field.focus();
                                    return false;
                                 }

                            } 
                        }
                    } 
                    var data  = $(this).closest("form").find('.validateId');
                    var flag = 0;
                    if(flag = 0 && data != undefined && data.length > 0){
                        
                        for(var i=0; i< data.length; i++){
                           var field = $(data[i]);
                           
                           if(field.val() == ''){
                             flag = 1;
                             
                             field.focus();
                           }
                        }
                    }
                    var data  = $(this).closest("form").find('.validateCellPhone');
                    var flag = 0;
                    if(flag = 0 && data != undefined && data.length > 0){
                        for(var i=0; i< data.length; i++){
                           var field = $(data[i]);
                           
                           if(field.val() == ''){
                             flag = 1;
                             
                             field.focus();
                           }
                        }
                    }
                    var data  = $(this).closest("form").find('.validateEmail');
                    var flag = 0;
                    if(flag = 0 && data != undefined && data.length > 0){
                        for(var i=0; i< data.length; i++){
                           var field = $(data[i]);
                           
                           if(field.val() == ''){
                             flag = 1;
                             
                             field.focus();
                           }
                        }
                    }
                    
                    if(flag == 0){
                        $('button[type="submit"]').removeAttr('disabled'); 
                        
                    }else{
                                        $('button[type="submit"]').removeAttr('style');
                        return false;
                    }
                }
            
    $('body').on('change', '.requiredfield' , enablesubmit );
        
    }
    
    
    
    $('input.file-upload-control-pdf').each(function(){ 
        var ref = $(this);
        var name =ref.attr('name');
        if($(this).attr("type") == "hidden"){
            
            var fieldval = $("input[name='"+name+"'][type='hidden']").val();

            var limit = parseInt(ref.attr('maxlimit'));
 
            if(Number.isNaN(limit) || limit == 0)
               $(this).attr('maxlimit','5');
            if(fieldval !== undefined){
                
                 var filelen = fieldval.split(',');

                $.each(filelen, function(i,v){

                    if(v !== ''){
                        
                        $.get('/dynamicforms/image/viewx/'+v,function(e){
                        var data = JSON.parse(e);
                       
                        if(data.car != undefined && data.car.name != ''){
                            
                            var ext = data.car.name.split('.').pop();
//                            var img_ext = ['PNG','JPEG','JPG','GIF','png','jpeg','jpg','gif'];
                            var img_ext = ['PDF','DOC','DOCX','XLS','TXT','ODT','PPT','XLSX','pdf','doc','docx','xls','txt','odt','ppt','xlsx'];
                            if(img_ext.indexOf(ext) != -1){
                            
                                var pdf_ext = ['PDF','pdf' ];

                                if(pdf_ext.indexOf(ext) != -1){

                                    var a= '<div  style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                            <iframe style="width:144px;" src="/Model_Products/'+data.car.name+'" target="_blank">\n\
                                                 </iframe>';

                                            if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                                a +=  '<a class="delete-img-pdf" name="'+name+'" data-id="'+data.car.id+'"><i class="icon-remove"></i></a>';
                                               
//                                                a +=  '<a href="/Model_Products/'+data.car.name+'" style="float:left;" download="'+data.car.name+'" >Download</a>';
                                            a += ' </div>';
                                            a += ' </div>';
                                }else{
                            
                            
                                    var a= '<div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                              <a href="/Model_Products/'+data.car.name+'" target="_blank">\n\
                                                 '+ext+'\n\
                                                 </a>';

                                                if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                                    a +=  '<a class="delete-img-pdf" name="'+name+'" data-id="'+data.car.id+'"><i class="icon-remove"></i></a>';
                                                a += ' </div>';
                                                a += ' </div>';
                                }
                            }else{
                                var a= '<div class="span1" style="float: left;margin-top:12px;width:135px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                      <a href="/Model_Products/'+data.car.name+'" target="_blank">\n\
                                         <img src="/Model_Products/'+data.car.name+'" style="width: 55px;  height: 60px;" />\n\
                                        </a>';
                                    if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                        a +=  '<a class="delete-img-pdf" name="'+name+'" data-id="'+data.car.id+'"><i class="icon-remove"></i></a>';
                                    a += ' </div>';
                                    a += ' </div>';
                            }
                            $('input[disable_file]').parent().children().children('.thumbnail').children('a.delete-img').hide();
                            $("input[name='"+name+"'][type='hidden']").parent().append(a);
                        }
                    });
                    }
                });
            }
        }
        
    });
     
      
    function progressBar(){
       
        var div_percent = $('<div/>');
            div_percent.addClass('percent');
            div_percent.text('0%');
        var div_bar = $('<div/>');
            div_bar.addClass('bar'); 
            div_bar.addClass('barData'); 
        var div_progress = $('<div/>');
            div_progress.addClass('span6');
            div_progress.addClass('progress');
            div_progress.addClass('progress-bar-mycom'); 
            div_progress.addClass('pull-left'); 
            
        var div_progress12 = $('<div/>');
            div_progress12.addClass('span12'); 
            div_progress12.addClass('progress-12'); 
            
            div_progress.append(div_bar);
            div_progress.append(div_percent);
            div_progress12.append(div_progress);
            
        return div_progress12;
   } 
    
   function fileuploadx_pdfopen(){ 
    var ref = $(this);
        var name =ref.attr('name');
      
        
        $('input[type="file"][name="'+name+'"]').click();
    } 
   function fileuploadx_pdf(){ 
        var ref = $(this);
        
        ref.parent().parent().children('.progress-12').remove();
        
        ref.attr('data-url',$('#uploadUrl').val());
        var name =ref.attr('name');
        var fieldval = $("input[name='"+name+"'][type='hidden']").val();
    
        if(fieldval === undefined){

            var ipt = '<input type="hidden" name="'+name+'"  />';
              ref.parent().append(ipt);
            fieldval = $("input[name='"+name+"'][type='hidden']").val();
        }
        var limit = parseInt(ref.attr('maxlimit'));
        
        if(Number.isNaN(limit) || limit == 0)
           $(this).attr('maxlimit','5');
       
        
        var filelen = fieldval.split(',');
         
        if(fieldval != '' &&  filelen.length >= limit){
            var msg = 'Only '+limit;
            if(limit >1){
               msg +=' files allowed'; 
            }else{
               msg +=' file allowed'; 
            }
            alert(msg);
            
            return false;
        }else{
        
            $('.progress-12').remove();
            var progress_bar =    progressBar();
            ref.parent().after(progress_bar);
             
            $(this).fileupload({
               dataType: 'json',
                maxFileSize: 1000,
                submit:function(e){
//                    alert('Please wait while uploading...');
                },
                progress: function (e, data) {
                     
                    var percentVal = data.progressInterval+'%';
                    var bar = $('.bar');
                    var percent = $('.percent');

                    bar.width(percentVal);
//                    bar.text('Uploading File'+percentVal);
                    bar.text('Uploading File');
                    percent.html(percentVal);
                },
                done: function (e, data) {
                     
                    var percentVal = data.progressInterval+'%';
                    var bar = $('.bar');
                    var percent = $('.percent');

                    bar.width(percentVal);
                    bar.text('Uploaded File');
                    percent.html(percentVal);
                    console.log(ref.parent().parent().children('.progress-12'));
                    $('.progress-12').remove();
                    
                    if($('#mycomform_id').val() != undefined && $('#mycomform_id').val() != '')
                        createDraftOrder();
                },
               success:function(response){   
                    console.log(response);
                    if(response == '102'){
                        alert('This file type cannot be uploaded');
                        $('.progress-12').remove();
                    }
                   if(response != ''){
                       
                       if(response.error != undefined){
                           alert(response.msg);
                           return false;
                       }
                       
                    fieldval = $("input[name='"+name+"'][type='hidden']").val();
                    if(fieldval === ''){ 
                       fieldval = response.id;
                    }else{ 
                        fieldval += ','+response.id;
                    }

                    $("input[name='"+name+"'][type='hidden']").val(fieldval);
                    $("input[name='"+name+"'][type='file']").removeAttr('required');

                    var ext =response.name;
                    
                    var extn = ext.split('.').pop();
                    
                    var img_ext = ['PDF','DOC','DOCX','XLS','TXT','ODT','PPT','XLSX','pdf','doc','docx','xls','txt','odt','ppt','xlsx'];
                   
                    if(extn != undefined && img_ext.indexOf(extn) != -1){
                        var pdf_ext = ['PDF','pdf' ];

                        if(pdf_ext.indexOf(extn) != -1){
                                        
                            var a= '<div  style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                    <iframe style="width:144px;" src="/Model_Products/'+response.name+'" target="_blank">\n\
                                         </iframe>';

                                    if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                        a +=  '<a class="delete-img-pdf" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                                   
//                                    a +=  '<a href="/Model_Products/'+name+'" style="float:left;" download="'+name+'" >Download</a>';
                                            
                                    a += ' </div>';
                                    a += ' </div>';
                        }else{
                            var a= '<div  style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                                      <a href="/Model_Products/'+response.name+'" target="_blank">\n\
                                         '+extn+'\n\
                                        </a>';

                                    if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                        a +=  '<a class="delete-img-pdf" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                                    a += ' </div>';
                                    a += ' </div>';
                        }

                    }else{
                        var a= '<div style="float: left;margin-top:12px;width:76px;margin-bottom: 12px;"> <div class="thumbnail" style="    width: 60px;display:table-cell;mat">\n\
                              <a href="/Model_Products/'+response.name+'" target="_blank">\n\
                                 <img src="/Model_Products/'+response.name+'" style="width: 55px;  height: 60px;" />\n\
                                </a>';

                            if( $("input[name='"+name+"'][type='file']").val() != undefined)
                                a +=  '<a class="delete-img" name="'+name+'" data-id="'+response.id+'"><i class="icon-remove"></i></a>';
                            a += ' </div>';
                            a += ' </div>';
                    }
                    $("input[name='"+name+"'][type='hidden']").parent().append(a);
                         //   scrollWin($("input[name='"+name+"'][type='hidden']").parent());

                    if(ref.hasClass('file-upload-defect')){
                        $("input[name='"+name+"'][type='hidden']").parent().parent().parent().parent().children().first().after(a);
                    }
                }
               }
           });
       }
    }

    function whatsapp_mobile_number(){

var mobile = $('input[name="whatsapp_mobile_number"]').val();  
var code = $('select[name="whatsapp_phonecode"]').val(); 
    code = code.substr(1,2);
    
var custname = $('#whatsapp-click.emailsms').attr('custname');

var text = 'שלום, נשלח לך קישור לצפייה וחתימה מ'+custname+':'
text += '%0A'+$('.urllink').val();
var href= $('.share').attr('attr-href')+"?phone=972"+code+mobile+'&';
        href +='&text='+text;
$('.share').attr('href',href);
}


$('body').on('change','.whatsapp_mobile_number', whatsapp_mobile_number);
$('body').on('change','.whatsapp_mobile_number_code', whatsapp_mobile_number);
$('body').on('keyup','.whatsapp_mobile_number', whatsapp_mobile_number);
$('body').on('keyup','.whatsapp_mobile_number_code', whatsapp_mobile_number);
        

    $('body').on('change','.form-file-upload',form_fileupload);
    $('body').on('click','input.file-upload-control-pdf',fileuploadx_pdf);
    $('body').on('change','input.file-upload-control-pdf',fileuploadx_pdf);
    $('body').on('click','button.file-upload-control-pdf',fileuploadx_pdfopen);
    $('body').on('change','button.file-upload-control-pdf',fileuploadx_pdfopen); 
 
    
    
    });
    
    
    
    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(1== 0){
    ?>
</script> 
    <?php
    
}

?>
