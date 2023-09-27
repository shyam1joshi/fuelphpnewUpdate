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

                
var autosaveflag = 0;

function createDraftOrderx(){

    if(autosaveflag== 1) return false;

    autosaveflag = 1;
    var dateObj = new Date();
    
    var date  = dateObj.toLocaleDateString();
    var time  = dateObj.toLocaleTimeString();
//    var datetime  = date+' '+time;
    
    var day  = dateObj.getDate();
    var month  = dateObj.getMonth();
    var month2  = month+1;
    var year  = dateObj.getFullYear();
    
    var dateformed = day+'/'+month2+'/'+year;
    var datetime  = dateformed+' '+time;
    var timex  = dateformed+' '+time;
     
    console.log(datetime);
    var queryString = $('#myFormId').serialize();
    var queryUrl = $('#myFormId').attr('js-url');
     
    queryString += '&created_at='+datetime;
 
    $.post(queryUrl,queryString, function(e){
        console.log(' ******************saved************************* ');
        console.log(e);
         var fieldval = $("input[name='draft_id'][type='hidden']").val();
        if(fieldval === undefined){
            var ipt = '<input type="hidden" name="draft_id"  />';
             $('#myFormId').append(ipt);
        }
         var fieldval = $("input[name='draft_id'][type='hidden']").val();
        if(fieldval === ''){

             $("input[name='draft_id'][type='hidden']").val(e);
        }

         autosaveflag = 0; 

        setTimeout(function(){
            $('.container .save-notification').remove(); 
        },3000);
    });
}
                
        function deleteRecord(){
            var count = $(this).attr('del-count');
            var count2 = $(this).attr('del-count2'); 
            
                $('[name="ipyeydjotyline['+count+'][items]['+count2+'][selectitem]"]').remove();
                $('input[name="ipyeydjotyline['+count+'][items]['+count2+'][quantity]"]').remove();
                $(this).parent().parent().parent().parent().parent().parent().parent().parent().find(".additem").removeAttr("disabled");
                $(this).parent().parent().parent().parent().parent().parent().parent().parent().find(".additem").trigger("click");
        
            createDraftOrderx();
        }
               
    
     $('body').on('change','.input-modify-elmor', createDraftOrderx);
     $('body').on('click','.deleteRecord', deleteRecord);
       
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

$('body').on('click','#deleteData', validateUser);
$('body').on('click','#confirmDataSubmit', validateConfirmUser);
    
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
 