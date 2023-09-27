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
 
 $('body').on('click','.editText',getTinymce); 

  
    
    function getTinymce(){
        var ele = $(this).attr('text-id');
                        var paraid = $(this).attr('para-id');
 
                    if($(this).hasClass('openEdit')){
                         $(this).removeClass('openEdit');
                         tinymce.get(ele).remove();
//                        $('#'+paraid).removeClass('hideText');
//                        $('#'+paraid).addClass('showText');
                            $('#'+ele).parent().children('div.hideText').addClass('showText');
 
                            if( $('#'+ele).parent().children('button.saveLatestData').val() != undefined){
                                $('#'+ele).parent().children('button.saveLatestData').toggle('hideText'); 
                            }
                            $('#'+ele).parent().children('div.showText').removeClass('hideText');
                                       
                         return true;
                    }
                       
                        $(this).addClass('openEdit');
//                        $('#'+paraid).addClass('hideText');
//                        $('#'+paraid).removeClass('showText');
                         
                        $('#'+ele).parent().children('div.showText').addClass('hideText');
                        $('#'+ele).parent().children('div.hideText').removeClass('showText');
                        
                        if( $('#'+ele).parent().children('button.saveLatestData').val() != undefined){
                            $('#'+ele).parent().children('button.saveLatestData').toggle('hideText'); 
                        }
                            
 
                            tinymce.init({ 
                                selector: 'textarea#'+ele, 
                                paste_as_text: true,  
                                plugins: "paste   image link",
                                directionality : "rtl",
                                paste_enable_default_filters: false,
                                setup: function (editor) {
                                    editor.on('change', function () {
                                        editor.save(); 
                                       var data =  editor.getContent(); 
                                        var para1 = $('#'+editor.id).attr('para-id');
                                        $('#'+editor.id).val(data);
                                        $('#'+editor.id).html(data); 
                                        
                                        $('#'+editor.id).parent().children('div.hideText').html(data);
//                                        $('#'+para1).html(data); 
                                        
                                    });
                            }
                            });
                            
                  } 
 
            
            
            
    
    });
    
         
function validateUser(e){

e.preventDefault();

var username = prompt('Please Enter Username');
var password = '' ; // prompt('Please Enter Password');
var path = $('#urlpath').val();

var url = path+'/validateUserLoggedIn';

if(username != ''   ){

    var data  = {'username': username, 'password':password};
    $.post(url,data, function(e){

        if(e == '1'){
          location.href = path+'/deleteAllData';                
          return false;
        }else{
         
            alert(' Delete Not allowed for this user ');
            return false;
        }

    });
}

}

function validateConfirmUser(e){

e.preventDefault();

var username = $('input[name="username"]').val();

if(username == ''){
  alert('Please Enter Username');
  $('input[name="username"]').focus();

  return false;
}

var password = $('input[name="password"]').val();

if(password == ''){
  alert('Please Enter Password');
  $('input[name="password"]').focus();

  return false;
}

var confirmcheck = $('input[name="confirm"]:checked').length;

if(  confirmcheck == 0 ){
alert('Please mark the confirm');
$('input[name="confirm"]').attr('style',' outline :1px solid red;');

return false;
}else{
$('input[name="confirm"]').remove('style');

}

var path = $('#urlpath').val();


var url = path+'/validateUserLoggedIn';

if(confirm('Are you sure ?') == true ){

var data  = {'username': username, 'password':password};
 
      url = path+'/deleteAllData';   

      $.post(url,data, function(e){
       
        if(e == 1){
          alert('All the data is deleted ');
           location.href = path+'/setfieldstobereset';  
         }else{
     
                alert(' Delete Not allowed for this user ');
                return false;
            }
      });

     

}


var url = path+'/validateUserLoggedIn';

if(username != ''   ){

}

}

function saveLatestData(e){

    e.preventDefault();

    $(this).parent().parent().find('.editText').trigger('click');
    var textname =  $(this).attr('text-id');
    var textdata = $('textarea[name="'+textname+'"]').text();

    var path = $(this).closest('form').attr('path');

    var data = {
        'field' : textname,
        'data' : textdata
    }

    $.post(path+'/saveLatestEditabletextData',data, function(e){

    });

}

$('body').on('click','#deleteData', validateUser);
$('body').on('click','#confirmDataSubmit', validateConfirmUser);
$('body').on('click','.saveLatestData', saveLatestData);
    
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