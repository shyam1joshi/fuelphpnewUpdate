<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(1==0){ ?>
   <script>

    <?php
}
?>

$(document).ready(function(){
 
function getSections(){
    
    var x=  $(this).parent().parent().find('.fld-section');
    
    var name =   $(this).parent().parent().parent().find('.fld-name[type="hidden"]').val();
    var data=  $('.build-wrap').data('formBuilder').actions.getData();
    var ref = x.attr('id');
    
    var selected = '';
    var selectedy = '';
   
    var formdata = $('#formData').val();
    
    var formjson = JSON.parse(formdata);
    for(var j= 0;j<formjson.length;j++ ){
        var nameval = formjson[j].name;
        
        if(name == nameval)
             selectedy = formjson[j].section;
        
    }
    var selectedx = x.val();
    
//    if(selectedx != '--select--' && selectedy != selectedx){
//       selected = selectedx;
//    }else{
//       selected = selectedy;
//    }
if( selectedx == '--select--' &&  selectedy == selectedx ){
       selected = selectedy; 
       
    }else{
       selected = selectedx;
    }
    
   $('#'+ref).children().remove();
   $('#'+ref).append('<option> --select-- </option>');
    $.each(data,function(i,v){
        
            if(v['type'] == 'section' && name != v['name']) {
                   //console.log(v['type']); y.push(v);}

                   var markselected = '';
                   
                   if(selected == v['name']){
                       
                       markselected = 'selected';
                   }
                   
                     var vallabel = v['label'];
                 
                 if(vallabel != undefined){
                    
                 //   vallabel =  vallabel.replace(/&lt;[^&gt;]+&gt;/g, '');
                    vallabel =  vallabel.replace(/<[^>]+>/g, '');
                    vallabel = vallabel.substring(0, 42);
                    
                  //  console.log(vallabel);
                }
                   
                    var opt = '<option value="'+v['name']+'" '+markselected+' >'+vallabel+'</option>';
                    
                    
                    $('#'+ref).append(opt);
            }
        });
    
}

function getPDFSameLines(){
     
    var x=  $(this).parent().parent().find('.fld-PDFSameLine');
    var name=  $(this).parent().parent().parent().find('.fld-name[type="hidden"]').val();
    
    var data=  $('.build-wrap').data('formBuilder').actions.getData();
    var ref = x.attr('id'); 
    var selected = '';
    var selectedy = '';
  
    var formdata = $('#formData').val();
    
    var formjson = JSON.parse(formdata);
    for(var j= 0;j<formjson.length;j++ ){
        var nameval = formjson[j].name;
        
        if(name == nameval)
             selectedy = formjson[j].PDFSameLine;
        
    }
    var selectedx = x.val();
    
//    if(selectedx != '--select--' && selectedy != selectedx){
//       selected = selectedx;
//    }else{
//       selected = selectedy;
//    }
if( selectedx == '--select--' &&  selectedy == selectedx ){
       selected = selectedy; 
       
    }else{
       selected = selectedx;
    }
    
   $('#'+ref).children().remove();
   $('#'+ref).append('<option> --select-- </option>');
    $.each(data,function(i,v){
         
            if(v['PDFSameLine'] != undefined && v['name'] != name ) {
                   //console.log(v['type']); y.push(v);}

                   var markselected = '';
                   
                   if(selected == v['name']){
                       
                       markselected = 'selected';
                   }
                   
                     var vallabel = v['label'];
                 
                 if(vallabel != undefined){
                    
                 //   vallabel =  vallabel.replace(/&lt;[^&gt;]+&gt;/g, '');
                    vallabel =  vallabel.replace(/<[^>]+>/g, '');
                    vallabel = vallabel.substring(0, 42);
                    
                  //  console.log(vallabel);
                }
                   
                    var opt = '<option value="'+v['name']+'" '+markselected+' >'+vallabel+'</option>';
                    
                    
                    $('#'+ref).append(opt);
            }
        });
    
}

        function deleteImage(){
            
            $(this).parent().parent().parent().children('.form-file-upload').show();
            var varname = $(this).parent().parent().parent().children('.form-file-upload').attr('name');
            
            $('input[name="'+varname+'"][type="hidden"]').val('');
            $(this).parent().parent().remove();

        }

var PDFOption = 0;

function getPDFXYOption(){
  
    if(PDFOption == '3'){    
       PDFOption = "3";
       $('.XPosition-wrap').addClass('hide-xy');
       $('.YPosition-wrap').addClass('hide-xy');
       $('.fld-PDF').children('option[value="3"]').attr('selected','selected');
//       $('.YPosition-wrap').attr('style','display:block !important');
    }else{
   var x=  $(this).val();
        if(x == '3'){    
            PDFOption = "3";
            $('.XPosition-wrap').addClass('hide-xy');
            $('.YPosition-wrap').addClass('hide-xy');
            $('.fld-PDF').children('option[value="3"]').attr('selected','selected');
     //       $('.YPosition-wrap').attr('style','display:block !important');
        }else{

            PDFOption = "0";
            $('.XPosition-wrap').removeClass('hide-xy');
            $('.YPosition-wrap').removeClass('hide-xy');
     //       $('.YPosition-wrap').removeAttr('display');
        }
    }
}


function getElements(){ 
    var x=  $(this).parent().parent().find('.fld-elements');
//     var x=  $(this).parent().parent().find('.fld-PDFSameLine');
    var name =   $(this).parent().parent().parent().find('.fld-name[type="hidden"]').val();
   
    var data=  $('.build-wrap').data('formBuilder').actions.getData();
    var ref = x.attr('id');
    var selected = '';
    var selectedy = '';
   
    var formdata = $('#formData').val();
    
    var formjson = JSON.parse(formdata);
    for(var j= 0;j<formjson.length;j++ ){
        var nameval = formjson[j].name;
        
        if(name == nameval)
             selectedy = formjson[j].element;
        
    }
    
    var selectedx = x.val();
    
//    if(selectedx != '--select--' && selectedy != selectedx){
//       selected = selectedx;
//    }else{
//       selected = selectedy;
//    }

if( selectedx == '--select--' &&  selectedy == selectedx ){
       selected = selectedy; 
       
    }else{
       selected = selectedx;
    }

   $('#'+ref).children().remove();
   $('#'+ref).append('<option> --select-- </option>');
//   console.log(data);
    $.each(data,function(i,v){
        
            if(v['type'] != 'canvas' && v['type'] != 'button' && v['type'] != 'file' &&
                     v['type'] != 'hr' && v['type'] != 'paragraph' && 
                     v['type'] != 'header' && v['type'] != 'section' && name != v['name'] ) {
                   //console.log(v['type']); y.push(v);}

                   var markselected = '';
                   
                   if(selected == v['name']){
                       
                       markselected = 'selected';
                   }
                   
                     var vallabel = v['label'];
                 
                 if(vallabel != undefined){
                    
                 //   vallabel =  vallabel.replace(/&lt;[^&gt;]+&gt;/g, '');
                    vallabel =  vallabel.replace(/<[^>]+>/g, '');
                    vallabel = vallabel.substring(0, 42);
                    
                  //  console.log(vallabel);
                }
                   
                    var opt = '<option value="'+v['name']+'" '+markselected+' >'+vallabel+'</option>';
                    
                    
                    $('#'+ref).append(opt);
            }
        });
        
    
}


function getShowElements(){ 
    var x=  $(this).parent().parent().find('.fld-ShowOnClick');
//     var x=  $(this).parent().parent().find('.fld-PDFSameLine');
    var name =   $(this).parent().parent().parent().find('.fld-name[type="hidden"]').val();
   
    var data=  $('.build-wrap').data('formBuilder').actions.getData();
    var ref = x.attr('id');
    var selected = '';
    var selectedy = '';
 
    var formdata = $('#formData').val();
    
    var formjson = JSON.parse(formdata);
    for(var j= 0;j<formjson.length;j++ ){
        var nameval = formjson[j].name;
        
        if(name == nameval)
             selectedy = formjson[j].ShowOnClick;
        
    }
    
    var selectedx = x.val();
    
//    if(selectedx != '--select--' && selectedy != selectedx){
//       selected = selectedx;
//    }else{
//       selected = selectedy;
//    }
if( selectedx == '--select--' &&  selectedy == selectedx ){
       selected = selectedy; 
       
    }else{
       selected = selectedx;
    }
    
   $('#'+ref).children().remove();
   $('#'+ref).append('<option> --select-- </option>');
//   console.log(data);
    $.each(data,function(i,v){
       
             if(v['type'] != 'canvas' && v['type'] != 'button' && v['type'] != 'file' &&
                     v['type'] != 'hr' && v['type'] != 'paragraph' && 
                     v['type'] != 'header' && v['type'] != 'section' && name != v['name'] ) {
                
                   //console.log(v['type']); y.push(v);}

                   var markselected = '';
                   
                   if(selected == v['name']){
                       
                       markselected = 'selected';
                      
                       data[i]['hr'] =1;
                   }else{
                       data[i]['hr'] =0;
                   }
                   
                     var vallabel = v['label'];
                 
                 if(vallabel != undefined){
                    
                 //   vallabel =  vallabel.replace(/&lt;[^&gt;]+&gt;/g, '');
                    vallabel =  vallabel.replace(/<[^>]+>/g, '');
                    vallabel = vallabel.substring(0, 42);
                    
                  //  console.log(vallabel);
                }
                   
                    var opt = '<option value="'+v['name']+'" '+markselected+' >'+vallabel+'</option>';
                    
                    
                    $('#'+ref).append(opt);
            }
        });
         
}


function getInputOption(){
    
    
//    console.log(formjson);
    
     var x=  $(this).parent().parent().find('.fld-math_value');
    var name =   $(this).parent().parent().parent().find('.fld-name[type="hidden"]').val();
   
    var data=  $('.build-wrap').data('formBuilder').actions.getData();
    var ref = x.attr('id');
     
    var selected = '';
    var selectedy = '';
    
    
    var formdata = $('#formData').val();
    
    var formjson = JSON.parse(formdata);
    for(var j= 0;j<formjson.length;j++ ){
        var nameval = formjson[j].name;
        
        if(name == nameval)
             selectedy = formjson[j].math_value;
        
    }
    var selectedx = x.val();
    
//    if(selectedx != '--select--' && selectedy != selectedx){
//       selected = selectedx;
//    }else{
//       selected = selectedy;
//    }
    if( selectedx == '--select--' &&  selectedy == selectedx ){
       selected = selectedy; 
       
    }else{
       selected = selectedx;
    }
//    selected = selectedy;
    
   $('#'+ref).children().remove();
 
   $('#'+ref).append('<option> --select-- </option>');
 
    $.each(data,function(i,v){
       
            if((v['type'] == 'text' || v['type'] == 'hidden' )  && name != v['name'] ) {
                   //console.log(v['type']); y.push(v);}

                   var markselected = '';
                   
                   if(selected == v['name']){
                       
                       markselected = 'selected';
                       
                   } 
                    var opt = '<option value="'+v['name']+'" '+markselected+' >'+v['label']+'</option>';
                    
                    
                    $('#'+ref).append(opt);
            }
        });
}

function getTooltipTextOption(){
 
    if($(this).val() == 'yes'){
        
       $(this).parent().parent().parent().find('.tooltip_text-wrap').addClass('show');
    }else{
       $(this).parent().parent().parent().find('.tooltip_text-wrap').removeClass('show');
    }
}

   
function getSectionLimit(){
 
    if($(this).val() == '2'){
        
       $(this).parent().parent().parent().find('.limit-wrap').addClass('show');
    }else{
       $(this).parent().parent().parent().find('.limit-wrap').removeClass('show');
    }
}

function getEmailOption(){
 
    if($(this).val() == 'email'){
        
       $(this).parent().parent().parent().find('.send_mail-wrap').addClass('show');
    }else{
       $(this).parent().parent().parent().find('.send_mail-wrap').removeClass('show');
    }
}
var show_total_flag = 0;
function getElementsx(){ 
    var x=  $(this).parent().parent().find('.fld-show_total');
//     var x=  $(this).parent().parent().find('.fld-PDFSameLine');
    var name =   $(this).parent().parent().parent().find('.fld-name[type="hidden"]').val();
   
    var data=  $('.build-wrap').data('formBuilder').actions.getData();
    var ref = x.attr('id');
    var selected = '';
    var selectedy = '';
    var formdata = $('#formData').val();
    
    var formjson = JSON.parse(formdata);
    for(var j= 0;j<formjson.length;j++ ){
        var nameval = formjson[j].name;
        
        if(name == nameval)
             selectedy = formjson[j].show_total;
        
    }
    var selectedx = x.val();
//    selectedx != '--select--' && 
//    if(  selectedy != selectedx  && show_total_flag == 0){
    if( selectedx == '--select--' &&  selectedy == selectedx ){
       selected = selectedy; 
       
    }else{
       selected = selectedx;
    }
    
   $('#'+ref).children().remove();
 
    
   $('#'+ref).append('<option> --select-- </option>');
//   console.log(data);
    $.each(data,function(i,v){
       
             if((v['type'] == 'hidden'  || v['type'] == 'text')  && v['name'] != name ) {
                   //console.log(v['type']); y.push(v);}

                   var markselected = '';
                   
                   if(selected == v['name']){
                       
                       markselected = 'selected';
                      
                       data[i]['hr'] =1;
                   }else{
                       data[i]['hr'] =0;
                   }
                    var opt = '<option value="'+v['name']+'" '+markselected+' >'+v['label']+'</option>';
                    
                    
                    $('#'+ref).append(opt);
            }
        });
        
//    $('.build-wrap').data('formBuilder').actions.setData(data);
}

function getElementsxx(){ 
    var x=  $(this).parent().parent().find('.fld-show_final_total');
//     var x=  $(this).parent().parent().find('.fld-PDFSameLine');
    var name =   $(this).parent().parent().parent().find('.fld-name[type="hidden"]').val();
   
    var data=  $('.build-wrap').data('formBuilder').actions.getData();
    var ref = x.attr('id');
    var selected = '';
    var selectedy = '';
 
    var formdata = $('#formData').val();
    
    var formjson = JSON.parse(formdata);
    for(var j= 0;j<formjson.length;j++ ){
        var nameval = formjson[j].name;
        
        if(name == nameval)
             selectedy = formjson[j].show_final_total;
        
    }
    var selectedx = x.val();
//    selectedx != '--select--' &&
//    if( selectedy != selectedx){
//       selected = selectedx;
//    }else{
//       selected = selectedy;
//    }
if( selectedx == '--select--' &&  selectedy == selectedx ){
       selected = selectedy; 
       
    }else{
       selected = selectedx;
    }
   
        $('#'+ref).children().remove();
    
   $('#'+ref).append('<option> --select-- </option>');
//   console.log(data);
    $.each(data,function(i,v){
       
             if((v['type'] == 'hidden'  || v['type'] == 'text')  && v['name'] != name ) {
                   //console.log(v['type']); y.push(v);}

                   var markselected = '';
                   
                   if(selected == v['name']){
                       
                       markselected = 'selected';
                      
                       data[i]['hr'] =1;
                   }else{
                       data[i]['hr'] =0;
                   }
                    var opt = '<option value="'+v['name']+'" '+markselected+' >'+v['label']+'</option>';
                    
                    
                    $('#'+ref).append(opt);
            }
        });
        
//    $('.build-wrap').data('formBuilder').actions.setData(data);
}

function getCalculateOption(){
    
//    if($(this).val() > 0){
//        
//        
//        $(this).parent().parent().parent().find('.show_total-wrap').addClass('show');
//        
//        if($(this).val() == '1' || $(this).val() == '2'|| $(this).val() == '3'|| $(this).val() == '4'
//           || $(this).val() == '5'|| $(this).val() == '6'     
//                    ){
//
//           $(this).parent().parent().parent().find('.math_value-wrap').addClass('show');
//        }else{
//           $(this).parent().parent().parent().find('.math_value-wrap').removeClass('show');
//        }
//    }else{
//       $(this).parent().parent().parent().find('.show_total-wrap').removeClass('show');
//    }
}

    $('body').on('mouseover','.fld-section',getSections);
    $('body').on('mouseover','.fld-element',getElements);
    $('body').on('change','.form-file-upload',form_fileupload);
    $('body').on('click','.form-file-upload',form_fileupload);
    $('body').on('mouseover','.fld-PDFSameLine',getPDFSameLines);
    $('body').on('mouseover','.fld-ShowOnClick',getShowElements);
$('body').on('change','.fld-ShowOnClick',getShowElements);
$('body').on('click','.fld-ShowOnClick',getShowElements); 
$('body').on('change','.fld-sectionType',getSectionLimit);
    
$('body').on('change','.fld-PDF',getPDFXYOption);
 $('body').on('click','.delete-img', deleteImage);    
$('body').on('change','.fld-tooltip',getTooltipTextOption);
$('body').on('change','.fld-calculate',getCalculateOption);
$('body').on('mouseover','.fld-math_value',getInputOption);
$('body').on('change','.fld-subtype',getEmailOption);
$('body').on('mouseover','.fld-show_total',getElementsx);
$('body').on('mouseover','.fld-show_final_total',getElementsxx);
    });
    
    
    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(1==0){ ?>
   </script>

    <?php
}
?>