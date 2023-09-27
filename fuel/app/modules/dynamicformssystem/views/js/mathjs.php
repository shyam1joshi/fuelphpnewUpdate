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
 
var prevadd = 0;
var prevsub = 0;
            
function calculateTotal(){

    var val = $(this).val();
    var showtotal = $(this).attr('show-data-total');
    var dataop = $(this).attr('data-operation');
    var mathval = $(this).attr('math-value');
    var mathvalori = $(this).attr('math-value');
    var count = $(this).attr('count');
    
    if(count != undefined && count != ''){
        var model = $(this).attr('model');
          mathval = model+'['+count+']['+mathval+']';
          showtotal = model+'['+count+']['+showtotal+']';
        
    }
//    alert(mathval);
    var mathvalue =  $('input[name="'+mathval+'"]').val();
 
    if(mathvalue == undefined)
        mathvalue = $('input[name="'+mathvalori+'"]').val();
    
    if( mathvalue != ''){
        mathvalue = parseFloat(mathvalue);
    }else{
         mathvalue = 0;
    }
    if(val != undefined && val != ''){
        val = parseFloat(val);
    }
    
    if(showtotal != undefined && showtotal != ''){
         
        var total =  $('input[name="'+showtotal+'"]').val();
         
        if( total == '')
            total = 0;
        else 
            total = parseFloat(total);
           
        switch(dataop){
            case 'add':   total = val+mathvalue; 
                                $('input[name="'+showtotal+'"]').val(total);
                                $('input[name="'+showtotal+'"]').trigger('change');
                                
//                                prevadd = parseFloat(val);
                                break;
            case 'subtract':    
                                var parent_math_value = $(this).attr('parent_math_value');
                                
                                if(parent_math_value != undefined && parent_math_value != ''){
                                    
                                    if(count != undefined && count != ''){
                                        var model = $(this).attr('model');
                                        parent_math_value = model+'['+count+']['+parent_math_value+']';
                                    }
                                    
                                    mathvalue = val;
                                    val = $('input[name="'+parent_math_value+'"]').val();
                                    
                                }
                                
                                total = val-mathvalue;
                                $('input[name="'+showtotal+'"]').val(total);
                                $('input[name="'+showtotal+'"]').trigger('change');
//                                prevsub = parseFloat(val);
                                break;
            case 'multiply':    
                                total = parseFloat(val)*parseFloat(mathvalue);
                                
                                if(total != '')
                                    total = total.toFixed(2);
                                
                                $('input[name="'+showtotal+'"]').val(total);
                                $('input[name="'+showtotal+'"]').trigger('change');
                                break;
            case 'divide':      
                                var parent_math_value = $(this).attr('parent_math_value');
                                
                                if(parent_math_value != undefined && parent_math_value != ''){
                                    
                                    if(count != undefined && count != ''){
                                        var model = $(this).attr('model');
                                        parent_math_value = model+'['+count+']['+parent_math_value+']';
                                    }
                                    
                                    mathvalue = val;
                                    val = $('input[name="'+parent_math_value+'"]').val();
                                    
                                }
                                
                                total = parseFloat(val)/parseFloat(mathvalue);
                                
                                 if(total != '')
                                    total = total.toFixed(2);
                                
                                $('input[name="'+showtotal+'"]').val(total);
                                $('input[name="'+showtotal+'"]').trigger('change');
                                break;
            case 'discount':    if(mathvalue == undefined || mathvalue == ''|| mathvalue == 'NaN'){
                                   mathvalue= 0;
                                }
//                                 alert(val);
//                                alert(mathvalue);
                                var parent_math_value = $(this).attr('parent_math_value');
                                
                                if(parent_math_value != undefined && parent_math_value != ''){
                                    
                                    if(count != undefined && count != ''){
                                        var model = $(this).attr('model');
                                        parent_math_value = model+'['+count+']['+parent_math_value+']';
                                    }
                                    
                                    mathvalue = val;
                                    
                                    val = $('input[name="'+parent_math_value+'"]').val();
                                    
                                }
                                
                               
                                mathvalue = parseFloat(val) * (parseFloat(mathvalue )/parseFloat(100));
                                
                                total = parseFloat(val) - parseFloat(mathvalue);
                               
                                 if(total != '')
                                    total = total.toFixed(2);
                                
                                $('input[name="'+showtotal+'"]').val(total);
                                $('input[name="'+showtotal+'"]').trigger('change');
                             
                                break;
            case 'tax':      
                                if(val > 0){
                                var parent_math_value = $(this).attr('parent_math_value');
                                
                                if(parent_math_value != undefined && parent_math_value != ''){
                                    
                                    if(count != undefined && count != ''){
                                        var model = $(this).attr('model');
                                        parent_math_value = model+'['+count+']['+parent_math_value+']';
                                    }
                                    
                                    mathvalue = val;
                                    val = $('input[name="'+parent_math_value+'"]').val();
                                    
                                }
                             
                                mathvalue = parseFloat(val) * (parseFloat(mathvalue )/parseFloat(100));
                                
                                total = parseFloat(val) + parseFloat(mathvalue);
                                
                                 if(total != '')
                                    total = total.toFixed(2);
                                
                                $('input[name="'+showtotal+'"]').val(total);
                                $('input[name="'+showtotal+'"]').trigger('change');
                            }
                                break;
            default :           
                                break;
            
        }
        
        
    }
}
            
function addTotal(){
    
    var val = $(this).val();
    var showtotal = $(this).attr('show-add-total');
    var dataop = $(this).attr('data-operation');
    var mathval = $(this).attr('add-value');
    var mathvalori = $(this).attr('add-value');
    var count = $(this).attr('count');
    
    if(count != undefined && count != ''){
        var model = $(this).attr('model');
          mathval = model+'['+count+']['+mathval+']';
          showtotal = model+'['+count+']['+showtotal+']';
        
    }
//    alert(mathval);
    var mathvalue =  $('input[name="'+mathval+'"]').val();
 
    if(mathvalue == undefined)
        mathvalue = $('input[name="'+mathvalori+'"]').val();
    
    if( mathvalue != ''){
        mathvalue = parseFloat(mathvalue);
    }else{
         mathvalue = 0;
    }
    if(val != undefined && val != ''){
        val = parseFloat(val);
    }
    
    if(showtotal != undefined && showtotal != ''){
         
        var total =  $('input[name="'+showtotal+'"]').val();
         
        if( total == '')
            total = 0;
        else 
            total = parseFloat(total);
            
            total = val+mathvalue; 
            
            $('input[name="'+showtotal+'"]').val(total);
            $('input[name="'+showtotal+'"]').trigger('change');
 
         
             
        
    }
}


function isFloat(n){
    return Number(n) === n && n % 1 !== 0;
}
            
function multiplyTotal(){
 
    
    var val = $(this).val();
    var showtotal = $(this).attr('show-multiply-total');
    var dataop = $(this).attr('data-operation');
    var mathval = $(this).attr('multiply-value');
    var mathvalori = $(this).attr('multiply-value');
    var count = $(this).attr('count');
    
    if(count != undefined && count != ''){
        var model = $(this).attr('model');
          mathval = model+'['+count+']['+mathval+']';
          showtotal = model+'['+count+']['+showtotal+']';
        
    }

        
    var mathvalue =  $('input[name="'+mathval+'"]').val();
   
    if(mathvalue == undefined)
        mathvalue = $('input[name="'+mathvalori+'"]').val();
    
    if( mathvalue != ''){
        mathvalue = parseFloat(mathvalue);
    }else{
         mathvalue = 0;
    }
    if(val != undefined && val != ''){
        val = parseFloat(val);
    }
    
    if(val == undefined || val == ''|| val == 'NaN'){
        val = 0;
        val = parseFloat(val);
    }
 
//     alert(showtotal);
    if(showtotal != undefined && showtotal != ''){
         
        var total =  $('input[name="'+showtotal+'"]').val();
         
        if( total == '')
            total = 0;
        else 
            total = parseFloat(total);
             
            
        total = parseFloat(val)*parseFloat(mathvalue);
                                
        if(total != '')
            total = total.toFixed(2);
  
        $('input[name="'+showtotal+'"]').val(total);
        $('input[name="'+showtotal+'"]').trigger('change');
         
             
        
    }
}
            
function subtractTotal(){
 
    
    var val = $(this).val();
    var showtotal = $(this).attr('show-subtract-total');
    var dataop = $(this).attr('data-operation');
    var mathval = $(this).attr('subtract-value');
    var mathvalori = $(this).attr('subtract-value');
    var count = $(this).attr('count');
    
    if(count != undefined && count != ''){
        var model = $(this).attr('model');
          mathval = model+'['+count+']['+mathval+']';
          showtotal = model+'['+count+']['+showtotal+']';
        
    }


    var mathvalue =  $('input[name="'+mathval+'"]').val();
 
    if(mathvalue == undefined)
        mathvalue = $('input[name="'+mathvalori+'"]').val();
    
    if( mathvalue != ''){
        mathvalue = parseFloat(mathvalue);
    }else{
         mathvalue = 0;
    }
    if(val != undefined && val != ''){
        val = parseFloat(val);
    }
    
    if(showtotal != undefined && showtotal != ''){
         
        var total =  $('input[name="'+showtotal+'"]').val();
         
        if( total == '')
            total = 0;
        else 
            total = parseFloat(total);
             
            
        var parent_math_value = $(this).attr('parent_math_value');
                                
        if(parent_math_value != undefined && parent_math_value != ''){

            if(count != undefined && count != ''){
                var model = $(this).attr('model');
                parent_math_value = model+'['+count+']['+parent_math_value+']';
            }

            mathvalue = val;
            val = $('input[name="'+parent_math_value+'"]').val();

        }

        total = val-mathvalue;
        $('input[name="'+showtotal+'"]').val(total);
        $('input[name="'+showtotal+'"]').trigger('change');
             
        
    }
}
            
function divideTotal(){
 
    var val = $(this).val();
    var showtotal = $(this).attr('show-divide-total');
    var dataop = $(this).attr('data-operation');
    var mathval = $(this).attr('divide-value');
    var mathvalori = $(this).attr('divide-value');
    var count = $(this).attr('count');
    
    if(count != undefined && count != ''){
        var model = $(this).attr('model');
          mathval = model+'['+count+']['+mathval+']';
          showtotal = model+'['+count+']['+showtotal+']';
        
    }


    var mathvalue =  $('input[name="'+mathval+'"]').val();
 
    if(mathvalue == undefined)
        mathvalue = $('input[name="'+mathvalori+'"]').val();
    
    if( mathvalue != ''){
        mathvalue = parseFloat(mathvalue);
    }else{
         mathvalue = 0;
    }
    if(val != undefined && val != ''){
        val = parseFloat(val);
    }
    
    if(showtotal != undefined && showtotal != '' && mathvalue != 0){
         
        var total =  $('input[name="'+showtotal+'"]').val();
         
        if( total == '')
            total = 0;
        else 
            total = parseFloat(total);
             
        var parent_math_value = $(this).attr('parent_math_value');
                                
        if(parent_math_value != undefined && parent_math_value != ''){

            if(count != undefined && count != ''){
                var model = $(this).attr('model');
                parent_math_value = model+'['+count+']['+parent_math_value+']';
            }

            mathvalue = val;
            val = $('input[name="'+parent_math_value+'"]').val();

        }

        total = parseFloat(val)/parseFloat(mathvalue);

         if(total != '')
            total = total.toFixed(2);
 
        $('input[name="'+showtotal+'"]').val(total);
        $('input[name="'+showtotal+'"]').trigger('change');
             
        
    }
}
            
function taxTotal(){
 
    
    var val = $(this).val();
    var showtotal = $(this).attr('show-tax-total');
    var dataop = $(this).attr('data-operation');
    var mathval = $(this).attr('tax-value');
    var mathvalori = $(this).attr('tax-value');
    var count = $(this).attr('count');
    
    if(count != undefined && count != ''){
        var model = $(this).attr('model');
          mathval = model+'['+count+']['+mathval+']';
          showtotal = model+'['+count+']['+showtotal+']';
        
    }
//    alert(mathval);
    var mathvalue =  $('input[name="'+mathval+'"]').val();
 
    if(mathvalue == undefined)
        mathvalue = $('input[name="'+mathvalori+'"]').val();
    
    if( mathvalue != ''){
        mathvalue = parseFloat(mathvalue);
    }else{
         mathvalue = 0;
    }
    if(val != undefined && val != ''){
        val = parseFloat(val);
    }
    
    if(showtotal != undefined && showtotal != ''){
         
        var total =  $('input[name="'+showtotal+'"]').val();
         
        if( total == '')
            total = 0;
        else 
            total = parseFloat(total);
             
            
        total = parseFloat(val)*parseFloat(mathvalue);
                                
        if(total != '')
            total = total.toFixed(2);

       if(val > 0){
            var parent_math_value = $(this).attr('parent_math_value');

            if(parent_math_value != undefined && parent_math_value != ''){

                if(count != undefined && count != ''){
                    var model = $(this).attr('model');
                    parent_math_value = model+'['+count+']['+parent_math_value+']';
                }

                mathvalue = val;
                val = $('input[name="'+parent_math_value+'"]').val();

            }

            mathvalue = parseFloat(val) * (parseFloat(mathvalue )/parseFloat(100));

            total = parseFloat(val) + parseFloat(mathvalue);

             if(total != '')
                total = total.toFixed(2);

            $('input[name="'+showtotal+'"]').val(total);
            $('input[name="'+showtotal+'"]').trigger('change');
        }
        
    }
}
            
function discountTotal(){
 
    
    var val = $(this).val();
    var showtotal = $(this).attr('show-discount-total');
    var dataop = $(this).attr('data-operation');
    var mathval = $(this).attr('discount-value');
    var mathvalori = $(this).attr('discount-value');
    var count = $(this).attr('count');
    
    if(count != undefined && count != ''){
        var model = $(this).attr('model');
          mathval = model+'['+count+']['+mathval+']';
          showtotal = model+'['+count+']['+showtotal+']';
        
    }
//    alert(mathval);
    var mathvalue =  $('input[name="'+mathval+'"]').val();
 
    if(mathvalue == undefined)
        mathvalue = $('input[name="'+mathvalori+'"]').val();
    
    if( mathvalue != ''){
        mathvalue = parseFloat(mathvalue);
    }else{
         mathvalue = 0;
    }
    if(val != undefined && val != ''){
        val = parseFloat(val);
    }
    
    if(showtotal != undefined && showtotal != ''){
         
        var total =  $('input[name="'+showtotal+'"]').val();
         
        if( total == '')
            total = 0;
        else 
            total = parseFloat(total);
             
            
        if(mathvalue == undefined || mathvalue == ''|| mathvalue == 'NaN'){
            mathvalue= 0;
         }
//                                 alert(val);
//                                alert(mathvalue);
         var parent_math_value = $(this).attr('parent_math_value');

         if(parent_math_value != undefined && parent_math_value != ''){

             if(count != undefined && count != ''){
                 var model = $(this).attr('model');
                 parent_math_value = model+'['+count+']['+parent_math_value+']';
             }

             mathvalue = val;

             val = $('input[name="'+parent_math_value+'"]').val();

         }


         mathvalue = parseFloat(val) * (parseFloat(mathvalue )/parseFloat(100));

         total = parseFloat(val) - parseFloat(mathvalue);

          if(total != '')
             total = total.toFixed(2);

         $('input[name="'+showtotal+'"]').val(total);
         $('input[name="'+showtotal+'"]').trigger('change');
        
    }
}


function show_final_total(){
    
    var attrshowtotal = $(this).attr('show-final-total');
    
    var data = $('.show_final_total[show-final-total="'+attrshowtotal+'"]');
    
    var total = parseFloat(0);
    
    $.each(data, function(i, v){
//        console.log(v);
//        console.log(i);
        var val = $(this).val();
        if(val != undefined && val != '')
            total += parseFloat(val);
        
        $('input[name="'+attrshowtotal+'"]').val(parseFloat(total));
        
        $('input[name="'+attrshowtotal+'"]').trigger('change');
    });
    
}
    
     
//    $('body').on('change', 'input.calculate' , calculateTotal );
    $('body').on('change', 'input.add' , addTotal );
    $('body').on('change', 'input.multiply' , multiplyTotal );
    $('body').on('change', 'input.subtract' , subtractTotal );
    $('body').on('change', 'input.divide' , divideTotal );
    $('body').on('change', 'input.discount' , discountTotal );
    $('body').on('change', 'input.tax' , taxTotal );
    $('body').on('change', 'input.show_final_total' , show_final_total );
    
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