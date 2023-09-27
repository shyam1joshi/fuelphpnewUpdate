<?php
if(1== 0) {
   
    ?>
 <script>
<?php 
}

?>
 
$(document).ready(function(){
  var mysigPod = {};
    $("#sinatureCanvasBox").css("opacity",1);
    $("#sinatureCanvasBox").css("display","none");
     
     
    function showPopUpModal(e){ 
   
       //  var valid =   $('form').validate;
     
    //if(valid == false) return;
        e.preventDefault();
        var fieldid = $(this).attr('id');
        var submitid = $(this).attr('submitid');
     
        $("#sinatureCanvasBox").attr('field-id', fieldid);
        $("#sinatureCanvasBox").attr('submit-id', submitid);
        
        $("#sinatureCanvasBox").modal('show'); 
        var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'


        });
        
       mysigPod["sigPad"] = signaturePad;   

        resizeCanvas();
  
  }  
  

function resizeCanvas() { 
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    var canvas = document.getElementById('signature-pad');
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    mysigPod["sigPad"].clear(); // otherwise isEmpty() might return incorrect value
}

    $(".take_sign").click(function(){
        $("#sinatureCanvasBox").modal('show'); 
            var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)'


            });
       mysigPod["sigPad"] = signaturePad;     

    });
  
    $('body').on('click', '#sigpad-export', function(){
        if(!mysigPod["sigPad"].isEmpty()){
            var imgData  =$("#signature-pad")[0].toDataURL('image/png');//$("#signature-pad")[0].toDataURL('image/png');
            var exportfieldid =  $("#sinatureCanvasBox").attr('field-id');
            var submitid =  $("#sinatureCanvasBox").attr('submit-id');
             $("#sinatureCanvasBox").attr('field-id', '');
             $("input[name='"+exportfieldid+"']").parent().children('.signpreview').remove();
            $("input[name='"+exportfieldid+"']").val(imgData);
            $("button[name='"+exportfieldid+"']").removeAttr('style');
            console.log( $("#"+exportfieldid).val());
            var div = $('<div/>')
            var img = $('<img/>')
                img.attr('src',imgData);
                div.addClass('signpreview');
                div.append(img);
                $("input[name='"+exportfieldid+"']").parent().prepend(div);    
            $("div#"+exportfieldid).removeClass('signature-btn');    

            
            $('button[type="submit"]').removeAttr('disabled');
            
            var modify =  $('.input-modify-elmor').val();
            
            if(modify != undefined){ 
                $('input[type="text"].input-modify-elmor').trigger('change');
                $('input[type="text"].input-modify-elmor').trigger('click');
                $('input[type="number"].input-modify-elmor').trigger('click');
//                $('input[type="checkbox"].input-modify-elmor').trigger('click');
                $('input[type="tel"].input-modify-elmor').trigger('click');
//                $('input[type="radio"].input-modify-elmor').trigger('click');
                $('textarea.input-modify-elmor').trigger('click');
//                $('select.input-modify-elmor').trigger('click');
            }
            
            var requiredfield =  $('.requiredfield').val();
            if(requiredfield != undefined){ 
                $('input[type="text"].requiredfield').trigger('change');
            }
            
            $("#sinatureCanvasBox").modal('hide'); 
            if(submitid == 'submit')
                signDone();
            else{
                return false;
            }
        }
         
    });
    
    
    $('body').on('click', '#sigpad-reset', function(){
        mysigPod["sigPad"].clear();
        
        return false;
    });
  

  function signDone(){
  
    $("form.box-body").submit();
  }   
     
    $('body').on('click','.signature-btn', showPopUpModal); 
    $('body').on('click','.signature-btn-popup', showPopUpModal);

    
$("#whatsapp_mobile_number_id").on("change", function(e){
    // access the clipboard using the api 

    var mobile = $(this).val();  
    mobile =   mobile.replaceAll("+", "");
            mobile =   mobile.replaceAll("-", "");
            mobile =   mobile.replaceAll(" ", "");

       
            mobile =   mobile.replaceAll(/[^0-9\s]/gi, '')
            $(this).val(''); 
            $(this).val(mobile);
    
} ); 
    
});




<?php
if(1== 0) {
   
    ?>
 </script>
<?php 
}

?>