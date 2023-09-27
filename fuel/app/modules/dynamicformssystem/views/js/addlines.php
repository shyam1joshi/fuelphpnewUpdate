<?php



if(isset($cloneData) && count($cloneData) > 0){
 
?>
<script>
    $(document).ready(function(){
                                          
      function addShoeLines(e){
                
            e.preventDefault();
            var cloneid = $(this).attr('clone-id');
            var clonelimit = $(this).attr('clone-limit');
            var clone = $('#'+cloneid).children().clone();
            
            var count = $('#'+cloneid).attr('count');
             
          
            console.log(clone);
            var elements = clone.find('.form-fields');
            var appendele = $(this).parent().parent().parent().children('.appendData');
            
            if (clonelimit > 0 && appendele.children('.section-col').length == clonelimit){
                
                $(this).attr('disabled','disabled');
                return false;
            }
                    
                    
            
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
                    var namecp =name;
   
   
                    var model = ele.attr('model'); 
                    var textid = ele.attr('text-id'); 
                    var paraid = ele.attr('para-id'); 
                    
                    var idattr = ele.attr('idattr'); 
                    var idmain = ele.attr('id'); 
                    var branch_name = ele.attr('branch_name'); 
                    var branch_number = ele.attr('branch_number'); 
                  
                    if(idmain != undefined){
                        var idmainx = idmain.replace('count',count);
                        clone.find('#'+eleid).attr('id',idmainx);  
                        eleid = idmainx;
                    }
                    if(branch_name != undefined){
                        var branch_namex = branch_name.replace('count',count);
                        clone.find('#'+eleid).attr('branch_name',branch_namex);  
                    }
                    
                    if(branch_number != undefined){
                        var branch_numberx = branch_number.replace('count',count);
                        clone.find('#'+eleid).attr('branch_number',branch_numberx);  
                    }
                    
                    if(idattr != undefined){
                        var eleclass = idattr.replace('count',count);
                        clone.find('#'+eleid).addClass(eleclass);  
                    }
                    var idreplace = ele.attr('idreplace'); 
                    
                    if(idreplace != undefined){
                        var elere = idreplace.replace('count',count);
                        clone.find('#'+eleid).attr('id',elere);  
                    }
               
               
                    if(textid != undefined){
                        var textid = textid.replace('count',count);
                        clone.find('#'+eleid).attr('text-id',textid);  
                    }
                    if(paraid != undefined){
                        var paraid = paraid.replace('count',count);
                        clone.find('#'+eleid).attr('para-id',paraid);  
                    }
               
//                    clone.find('#'+eleid).removeAttr('name');
                    
                    var namex = name; 
                    name = name.replace('count',count); 
                        
                    clone.find('#'+eleid+'[name="'+namex+'"]').attr('name',name); 
                    clone.find('#'+eleid).attr('count',count); 
                    
                    
                    if(clone.find('#'+eleid).hasClass('file-upload-control')){
                         
                        var hidnfile = 'input[type="hidden"][name="'+namecp+'"]';
                        var btnfile = 'button[name="'+namecp+'"]';
                        
                         clone.find(hidnfile).attr('name',name);
                         clone.find(btnfile).attr('name',name);
                         
                    }
                        
                    clone.find('#'+eleid).attr('id',model+'-'+eleid+'-'+count);
                }
             
                var divelements = clone.find('div[data-parent-name]');
             
                for(var i = 0; i <divelements.length; i++){
                    
                    var ele =  $(divelements[i]); 
                    var name = ele.attr('data-parent-name'); 
   
                    var name2 = name.replace('count',count);  
                    clone.find('div[data-parent-name="'+name+'"]').attr('data-parent-name',name2); 
                }
                
                appendele.append(clone);
                
                
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
                
                
        
        $('.updateflag').on("change", function () {                            
         
                var form = $(this).closest('form');
                var items = form.find('.'+this.id);
                var storage = window.localStorage;
                                
                var url =  '/'+$(this).attr('map-controller')+'/'+'viewx'+'/'+$(this).attr('value');
                
                if(!isNaN(parseInt($("#hidden_customer_id").val()))){
                    url +="?&customer_id="+ $("#hidden_customer_id").val();
                    //check for quantity
                   var qty=parseInt($(this).parent().parent().find('.change_total').val());
                    if(!isNaN(qty))
                    {
                       console.log("Quantity "+qty);
                       url +="&quantity="+qty;
                    }
                }
                
                $.getJSON(url,function(data){
                    console.log (items);
                    
                    $.each(items,function(){
                         
                        var name =$(this).attr('mapper');

                        if(name === 'categories')
                        {
                          var cat=data.car[name];
                          var catval=JSON.parse(cat);
                          $(this).val(catval); 
                          $(this).text(catval);
                        }
                        else
                         {   
                             $(this).val(data.car[name]);  
                            $(this).text(data.car[name]);
                         }
                        $(this).trigger('create');
                        console.log("Data set is   "+name+":"+data.car[name]);
                        
                        if($('input[name="amount"]').length !== undefined && $('input[name="amount"]').length === 1)
                            $('input[name="amount"]').focus();
                    });
                    
                    if($('.getPricelistsPrice').val() !== undefined)
                        getPricelistsPrice();
                    
                    $('.change_price').trigger('change');

                }); 
                               
                items.each(function(){
                    var controller = $('#hidden_'+$(this).attr('id'));
                    console.log("special-change event triggered, new value: ", controller.attr('map-controller'));
                    var storage = window.localStorage;

                    var url =  '/'+controller.attr('map-controller')+'/'+'viewx'+'/'+controller.attr('value');
                    console.log(url);
                });
                
                console.log("special-change event triggered, new value: ", items);
                                
                if($('#hidden_customer_id').val() != '' && $('#hidden_product_id').val() != '' && $('#formtype').val() == 'customerpricelists')
                {
                    var  domain = window.location.origin;

                    url =  domain+'/yogurtscustomerpricelists/customerpricelists/listkey.json';
                    $.ajax({
                            url: url,
                            dataType: "json",
                            data: {
                              searchterm1: 'customer_id',
                              searchterm2: 'product_id',
                              term1:$('#hidden_customer_id').val(),
                              term2:$('#hidden_product_id').val()
                            },
                            success: function( data ) {
                                console.log('customerpricelists data received');
                                $('#price').val(data);
                            }
                    });

                }

                if($('#hidden_customer_id').val() != '' && $('#hidden_product_id').val() != '')
                {
                    var url2 =  '/cheques/chequedetails/'+$('#hidden_customer_id').val();

                    $.getJSON(url2,function(data){

                        $('#tr_info_cheques input[lower-level=bank_account_number]').val(data.bank_account_number) ;

                        $('#tr_info_cheques input[lower-level=bank_branch_number]').val(data.bank_branch_number) ;
                        $('#tr_info_cheques input[lower-level=bank_number]').val(data.bank_number) ;

                    });
                }
                
                
                                
                /*
                 *  calculate discount
                 */
                $('.change_discount').on('change',function(){
                   
                        var  domain = window.location.origin;
                                    
//                        url =  domain+'/products/viewx/'+$('#hidden_product_id').val();;
//                        $.ajax({
//                            url: url,
//                            success: function( data ) 
                            {
                                console.log('discount data received');
//                                $('#price').val(data);

                                    var prev = parseFloat($('input[name="orderlines_new['+$(this).attr('count')+'][quantity]"]').val());
                                        console.log(prev);
                                        console.log(prev);
                                           prev = parseFloat($('input[name="orderlines_new['+$(this).attr('count')+'][price]"]').val())*parseFloat(prev);
                                 console.log(prev);
                                  var discountval = parseFloat($('input[name="orderlines_new['+$(this).attr('count')+'][discount_value]"]').val());
                                  
                                
                                 var discount = prev *(parseFloat($(this).val())/100);
                                 
                                  if(discount !== undefined && !isNaN(discount))
                                    prev = prev - discount;
                                  if(discountval !== undefined && !isNaN(discountval))
                                    prev = prev - discountval;
                                
                                    prev = prev.toFixed(2);
                                     $('input[name="orderlines_new['+$(this).attr('count')+'][total_amt]"]').val(prev);
                                     $('#amount_total').val(0);
                                     $('#form_amount_totalbeforetax').val(0);

                                     var final = 0;
                                     $('.add_to_total').each(function(){
                                         var val = parseFloat($(this).val());
                                         if(!isNaN(val)){
                                             var val = parseFloat($('#form_amount_totalbeforetax').val())+val;
                                             val = Math.round(val * 100)/100;
                                             $('#form_amount_totalbeforetax').val(val);   

                                              var taxadd =  parseFloat($('#form_amount_totalbeforetax').val()*tax);
                                              var val = parseFloat($('#form_amount_totalbeforetax').val()) + taxadd;
                                             val = Math.round(val * 100)/100; 
                                            // $('#amount_total').val(val);
                                              setAmountTotal(val);
                                         }
                                     });
                                }
//                        });
                    });
        });
        
            } 
        }
             

        function removeFault(){
             var flt= $(this).parent().parent().attr("faultno");
             var room = $(this).parent().parent().parent().parent().parent().attr("roomno");
             $(this).parent().parent().parent().remove();//.toggle();
             var input =   $("<input/>");
             input.attr("name","room["+room+"][fault]["+flt+"][removeme]");
             input.attr("value",1);
             
             var parentbtn = $(this).attr('parent-button');
             $('#'+parentbtn).removeAttr('disabled');
        //     validateLinesAdded();
        }  
<?php

foreach ($cloneData as $cldata){

?>
        $('body').on('click','#<?php if(key_exists('id', $cldata)){ echo $cldata['id']; }   ?>',addShoeLines  ); 
    
<?php   }  ?>
    
        $("html").on("click" ,".removeFaultButton",removeFault);
        
});
<?php  }  ?>

</script> 