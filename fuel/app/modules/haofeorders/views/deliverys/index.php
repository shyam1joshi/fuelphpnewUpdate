<h2> <?php echo \Lang::get('message.list')?\Lang::get('message.list'):"רשימת"; ?><span class='muted'> <?php echo "$model"?> </span></h2>
<style>
    span.active > a{
        font-weight: 900;
        font-size: 21px;
        
    }
    @media only screen and (max-width: 815px) and (min-width: 620px){
        table.table {
            width: 100% !important;
            font-size: 14px;
            max-width: none;
        } 
        .table th:nth-child(2), .table td:nth-child(2){
            display: table-cell;
        }
    }

</style>
<br>
<form action="#" id="ordersfilter">
<div style="display: inline-block;padding: 0px 40px 14px 30px;">
    <label for="extra4"> <?php echo \Lang::get('label.customers.name')?\Lang::get('label.customers.name'):"שם"; ?></label>
    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
    <input type="text" class="popup-autocomplete hidden_customer_id  ui-autocomplete-input" id="customer_id" map-controller="customers" mapper="name" href="/customers/listkey.json" style="width:200px" name="customer_name" value="<?php echo \Input::get('customer_name');?>" autocomplete="off">
    <label for="extra4"> <?php echo \Lang::get('label.customers.customer_key')?\Lang::get('label.customers.customer_key'):"מספר לקוח"; ?></label>
        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
        <input type="text" class="popup-autocomplete hidden_customer_id ui-autocomplete-input" id="customer_id" map-controller="customers" mapper="customer_key" href="/customers/listkey.json" style="width:200px" name="customer_key" value="<?php echo \Input::get('customer_key');?>" autocomplete="off">
        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
        <input   class="popup-autocomplete updateflag ui-autocomplete-input hidden" map-controller="customers" mapper="customer_key" href="/customers/listkey.json" style="width:200px" id="hidden_customer_id" type="hidden" name="filter[customer_id]" value="<?php echo \Input::get('filter.customer_id');?>" autocomplete="off">
    </div>
        
<div style="display: inline-block;padding: 0px 40px 14px 30px;">
        <label for="extra4"> <?php echo \Lang::get('message.agentname')?\Lang::get('message.agentname'):"שם סוכן"; ?></label>
    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text" class="popup-autocomplete hidden_agent_id  ui-autocomplete-input" id="agent_id" map-controller="agents" mapper="name" href="/agents/listkey.json" style="width:200px" name="agent_name" value="<?php echo \Input::get('agent_name');?>" autocomplete="off">
    
        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible "></span><input  class="popup-autocomplete updateflag ui-autocomplete-input" map-controller="agents" id="hidden_agent_id" type="hidden" name="filter[agent_id]" value="<?php echo \Input::get('filter.agent_id');?>" autocomplete="off">
<label for="name" ><?php echo \Lang::get('label.deliverys.name')?\Lang::get('label.deliverys.name'):'label.deliverys.name'; ?></label>    
        <input class="text" name="name" type="text" value="<?php echo \Input::get('name');?>" >
</div>
        <div style="display: inline-block;padding: 0px 40px 14px 30px;">
    <label for="fromdate">
        <?php echo \Lang::get('message.fromdate')?\Lang::get('message.fromdate'):"מתאריך"; ?></label>    
        <input class="date" name="fromdate" type="text" value="<?php echo \Input::get('fromdate');?>">
        <label for="todate" ><?php echo \Lang::get('message.todate')?\Lang::get('message.todate'):"עד תאריך"; ?></label>    
        <input class="date" name="todate" type="text" value="<?php echo \Input::get('todate');?>" >
</div>
        <div style="display: inline-block;padding: 0px 40px 14px 30px;">
        <label for="extra4"> <?php echo \Lang::get('message.all')?\Lang::get('message.all'):"כל הרשומות"; ?></label>   
        <input class="text" name="all" type="checkbox" value="1" <?php if(\Input::get('all') == 1) echo 'checked';?>>
</div>
   <input type="submit" value="<?php echo \Lang::get('message.submit')?\Lang::get('message.submit'):"הכנס"; ?>">
   <input type="button" value="<?php echo \Lang::get('message.reset')?\Lang::get('message.reset'):"אתחל"; ?>" onclick="x()" >
 <script>
     function x(){$('#ordersfilter').children('div').children(':input').val('');
         $('#ordersfilter').submit();}
     
     </script>
</form>

<?php $order_total=null;$count=0; $totalbeforetax=0;  $total_quantities=0; 

$agent_id = is_object($agent)?$agent->id:"";
$allowupdate = is_object($agent)?$agent->allowupdate:"";



?>   
 

<!--<a class="btn" href="/deliverys/generateProductsReport"><?php echo \Lang::get('message.viewundeliveredproducts')?\Lang::get('message.viewundeliveredproducts'):'View Undelivered Products'; ?></a>-->
<?php   if(  in_array($warehouse, array('',0))){ ?>
<!--<p>
	<?php // echo Html::anchor("$base/create",\Lang::get('message.create')?\Lang::get('message.create'):'הוסף', array('class' => 'btn btn-success', 'style'=>'display:initial !important;')); ?>

</p>-->
<?php } ?>
<?php if ($cars): ?>
<a class="btn" onclick="print()"><?php echo \Lang::get('message.print')?\Lang::get('message.print'):'Print'; ?></a>

<?php if( isset($page)  &&  !empty($page) && is_object(Pagination::instance($page))) echo Pagination::instance('mypagination')->render();?>
<?php 
$car = key($cars);

$listview = $cars[$car]->GetListViewRelations(); 




?>
<style>
    .table th{
        width:<?php if(isset($listview)&& count($listview)>0) echo 90/(count($listview)+1); else echo "200"; ?>%;
    }    
    
/*    @media only screen and (max-width: 815px) and (min-width: 200px){
    .span12 a.btn {
        display: inline-block !important;
    }
}*/
</style>


<table class="table table-striped">
	<thead>
		<tr>
                    <?php foreach($listview as $column => $properties ){
                        
                        
                        ?>
                    <th style="display:table-cell;"><?php echo $listview[$column]['label'];?></th>
                    <?php }
                        
                    ?>
<!--                    <th><?php  
//                    echo \Lang::get('label.deliverys.comment')?\Lang::get('label.deliverys.comment'):'Comment';
                    
                    ?></th>-->
                    <th style="display:table-cell;">לחץ לצפיה</th>
		</tr>
	</thead>
	<tbody>        
<?php foreach ($cars as $car): ?>		<tr>

        
                    <?php 
                    
                    foreach($listview as $column => $properties) {
                        
                        if(key_exists('relation', $properties)){
                            $rel_mod = $properties['relation'];
                            if(is_object($car->$rel_mod)){
                                $related = $car->$rel_mod;
                                $car->$column = $related->name;
                                if(array_key_exists('image', $properties)){
                                      $car->$column= "<a target='_new' href='/{$car->$rel_mod->model_to}/{$car->$column}' ><img src=/{$car->$rel_mod->model_to}/{$car->$column} class='img-polaroid' style='width: 25%;height: 9%;'></a>";
                                }
                                
                            }
                            
                            
                            
                        }
                        
                        
                        
                        
                        ?>
			<td style="display:table-cell;"><?php echo $car->$column; ?></td>
                         <?php  if($column == 'amount_total')
                                    $order_total += $car->$column; 
                                if($column == 'amount_totalbeforetax')
                                    $totalbeforetax += $car->$column; 
                                if($column == 'total_quantities')
                                    $total_quantities+= floatval ($car->$column); 
                            ?>
                    <?php }
//                    echo "<td>";
//                    if(!empty($car->comment))
//                        {
//                            
//                            echo substr($car->comment, 0, 10);
//                            
//                        }
//                    
                    ?>
                    </td>
                    
                    <td style="display:table-cell;">
			     &nbsp;&nbsp;<?php if( $car->confirm != 1 && $warehouse == 1){
                                     
                                     
                                    if(empty($car->delivery_id)){ 
                                    if(empty($car->agent_update_id) || 
                                      (!empty($car->agent_update_id) && 
                                            $car->agent_update_id == $agent_id  )){  ?>
                                    <?php echo Html::anchor("$base/edit/".$car->id, '<i class="icon-wrench" title="Edit"></i>', array('class'=>'btn btn-danger', 'style' => 'padding: 10px 28px;display: inline-block !important;')); ?> <br/><br/>&nbsp;&nbsp;
                                  
                              
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        
                        <?php echo Html::anchor("$base/view/".$car->id, '<i class="icon-eye-open" title="View"></i>', array('class'=>'btn btn-primary', 'style' => 'padding: 6px 24px;display: inline-block !important;')); ?><br/><br/> &nbsp;&nbsp;
                            <?php // if($car->confirm != 1  && $warehouse == 0){ ?>
<!--                                |
				<?php // echo Html::anchor("$base/edit/".$car->id, '<i class="icon-wrench" title="Edit"></i>', array('class'=>'btn btn-danger', 'style' => 'display: inline-block !important;')); ?>&nbsp;&nbsp; |-->
<!--				<?php // echo Html::anchor("$base/confirm/".$car->id, 'שלח תעודה', array('class'=>'btn btn-danger', 'style' => 'display: inline-block !important;')); ?>&nbsp;&nbsp; |-->
				<?php // echo Html::anchor("$base/delete/".$car->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')",'class'=>'btn  ', 'style' => 'display: inline-block !important;')); ?>
                            <?php // }else{ ?>
                                 <?php if( $car->confirm != 1 && $warehouse == 1){
                                     
                                     
                                    if(empty($car->delivery_id)){ 
                                    if(empty($car->agent_update_id) || 
                                      (!empty($car->agent_update_id) && 
                                            $car->agent_update_id == $agent_id  )){  ?>
                                    <?php // echo Html::anchor("$base/edit/".$car->id, '<i class="icon-wrench" title="Edit"></i>', array('class'=>'btn btn-danger', 'style' => 'padding: 10px 28px;display: inline-block !important;')); ?>
                                    <?php echo Html::anchor("$base/confirm/".$car->id, 'הפוך לתעודת משלוח', array('onclick' => "return confirm('?האם אתה בטוח')", 'class'=>'btn btn-danger', 'style' => '    display: inline-block !important;
        padding: 0px 1px;
    width: 63px;
    font-size: 11px;')); ?> &nbsp;<br/><br/>
				   <?php if( $allowupdate == 1 && $warehouse == 1){
                                     ?>
                       &nbsp;&nbsp;&nbsp;<?php echo Html::anchor("$base/delete/".$car->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')",'class'=>'btn btn-danger ', 'style' => 'padding: 6px 24px;display: inline-block !important;')); ?>
                            &nbsp;<br/><br/>
				
                            <?php } ?>
                            <?php } ?>
                              
                            <?php } ?>
                            <?php  ?>
                            <?php } ?>
                            <?php if(isset($enablesyncbackdelivery) && $enablesyncbackdelivery==1 && isset($car->suppliedstatus) && $car->suppliedstatus != 1 ){ ?>
                                |<?php echo Html::anchor("$base/setSuppliedstatus/".$car->id, '<i class="icon-refresh" title="Set Supplied Status"></i>', array('onclick' => "return confirm('Are you sure?')")); ?>

                                 <?php } ?>
			</td>
		</tr>
                <?php $count++; ?>
<?php endforeach; ?>	
                
        </tbody>
</table>

<?php else: ?>
<p><?php echo "No $model"?></p>

<?php endif; ?>

<hr  style="border-top:2px solid;"/>
<div>
<div class="span12" style="padding:18px 0px;background: #EBEAEA;" >
    <div id='async-order-total' class="span9" style="">
        <!--<div class='span12 loading' id='loading' style='text-align: center;'> .....<?php // echo \Lang::get('label.message.data_loading')?\Lang::get('label.message.data_loading'):'Data is loading. Please Wait'?>  </div>-->
          <?php if(isset($listview)){ foreach($listview as $column => $properties):  ?>
               <?php if($column == 'name' ){  ?>
                            <div class="span4" id="async-count" style="padding-right:8px;" ><table><tr><td style=""><span><?php echo $count; ?></span></td></tr></table></div>                    
                        <?php }
                            if($column == 'amount_total' ){  ?>
                           <div class="span2" id="async-total" style="  padding-right: 7%;" ><table><tr><td style=""><span><?php echo $order_total; ?></span></td></tr></table></div>
                        <?php }
                        if($column == 'amount_totalbeforetax' ){ ?>
                       <div class="span2" id="async-totalbeforetax" style="    padding-right: 3%;" ><table><tr><td style=""><span><?php echo $totalbeforetax; ?></span></td></tr></table></div>
                        <?php }
                            if($column == 'total_quantities' ){  ?></td> 
                        <div class="span3" id="async-total_quantities" style=" margin-right: 2%;" ><table><tr><td style=""><span><?php echo $total_quantities; ?></span></td></tr></table></div>

          <?php } endforeach; } ?>
    </div>
    <div class="" style="padding: 4px;float:left;">
        <select id='order-total' onchange='x1()' >
            <option value='default'><?php echo \Lang::get('label.select.default')?\Lang::get('label.select.default'):'Default'?></option>
            <option value='all-filtered'><?php echo \Lang::get('label.select.allfiltered')?\Lang::get('label.select.allfiltered'):'All Filtered'?></option>
            <option value='0'><?php echo \Lang::get('label.select.all')?\Lang::get('label.select.all'):'All'?></option>
            <option value="today"><?php echo \Lang::get('label.select.today')?\Lang::get('label.select.today'):'Today'?></option>
            <option value="this-week"><?php echo \Lang::get('label.select.this_week')?\Lang::get('label.select.this_week'):'This Week'?></option>
            <option value="this-month"><?php echo \Lang::get('label.select.this_month')?\Lang::get('label.select.this_month'):'This Month'?></option>
            <option value='clear-orders'><?php echo \Lang::get('label.select.clear')?\Lang::get('label.select.clear'):'Clear'?></option>
        </select>
    </div>
</div>
</div>
<script>
function x1(){    
    
    var div_val=$('#async-order-total #loading').text();
    
        if(div_val === '' || div_val === null)
        {
            $('#async-order-total').append("<div class='span12 loading' id='loading' style='text-align: center;'> .....<?php echo \Lang::get('label.message.data_loading')?\Lang::get('label.message.data_loading'):'Data is loading. Please Wait'?>  </div>");
        }
         
     $('#async-total').remove();
     $('#async-totalbeforetax').remove();
     $('#async-count').remove();
     $('#async-total_quantities').remove();
    var ord_total=$("#order-total").val();
    
     if(ord_total === 'default')
    {
        var val=(<?php echo $order_total; ?>).toFixed(3) ;
        var valbeforetax=(<?php echo $totalbeforetax; ?>).toFixed(3) ;
        
        var temp1='<div class="span4" id="async-count" style="padding-right:8px;" ><table><tr><td style=""><span><?php echo $count; ?></span></td></tr></table></div>';
        var temptotalquan='<div class="span3" id="async-total_quantities" style="  padding-right: 2%;" ><table><tr><td style=""><span><?php echo $total_quantities; ?></span></td></tr></table></div>';
        var temp='<div class="span2" id="async-total" style="padding-right: 7%;" ><table><tr><td style=""><span>'+val+'</span></td></tr></table></div>';
        var tempbeforetax='<div class="span2" id="async-totalbeforetax" style="  padding-right: 3%;  width: 12.5%;" ><table><tr><td style=""><span>'+valbeforetax+'</span></td></tr></table></div>';

        $('#async-order-total #loading').remove();
        $('#async-order-total').append(temp1);
        $('#async-order-total').append(temp);
        $('#async-order-total').append(tempbeforetax);
        $('#async-order-total').append(temptotalquan);
    }
    else
    {
        if(ord_total !== 'clear-orders')
        {
            if(ord_total === 'all-filtered' )  //for filtered total
            {
                var from=$("input[name='fromdate']").val();
                var to=$("input[name='todate']").val();
                var cust_id=$("#hidden_customer_id").val();
                var agent_id=$("#hidden_agent_id").val();

                if(from === '' && to === '' && cust_id === '' && agent_id === '' )
                {
                    ord_total='0';
                }
                else
                {
                    if( from !== '')
                        ord_total =ord_total+"&from="+from;
                    if( to !== '')
                        ord_total =ord_total+"&to="+to;               
                    if( cust_id !== '')
                        ord_total =ord_total+"&customer_id="+cust_id;
                    if( agent_id !== '')
                        ord_total =ord_total+"&agent_id="+agent_id;
                }
            }


            $.ajax({
                url:"<?php echo Uri::base()."/".$base; ?>/calculateTotal?data="+ord_total,
                success:function(e){
                        var res=JSON.parse(e);
                        var val=(res.total).toFixed(3) ;
                        var valbeforetax=(res.totalbeforetax).toFixed(3) ;

                        var temp='<div class="span2" id="async-total" style="padding-right:7%;" ><table><tr><td style=""><span>'+val+'</span></td></tr></table></div>';
                        var tempbeforetax='<div class="span2" id="async-totalbeforetax" style="padding-right:3%;   width: 12.5%;" ><table><tr><td style=""><span>'+valbeforetax+'</span></td></tr></table></div>';
                        var temp1='<div class="span4" id="async-count" style="padding-right:8px;" ><table><tr><td style=""><span>'+res.count+'</span></td></tr></table></div>';
                        var temptotalquan='<div class="span3" id="async-total_quantities" style="  padding-right: 2%;" ><table><tr><td style=""><span>'+res.quantity+'</span></td></tr></table></div>';

                        $('#async-order-total #loading').remove();
                        $('#async-order-total').append(temp1);
                        $('#async-order-total').append(temp);
                        $('#async-order-total').append(tempbeforetax);
                        $('#async-order-total').append(temptotalquan);

                }
            });
        }
    }
}  
</script>


 <style>
         
        
        @media print{
          
             a,a.btn,#ordersfilter,.navbar,table.table tbody tr td:last-child,footer,#order-total{
                   display: none;
             }
           
             #async-total,#async-total_quantities{
                 padding-right: 22px !important;
             }
             #async-totalbeforetax{
                 padding-right: 15px !important;
                 
             }
              table td{
                  font-size: 14px;
              }
              table td, table th{
                    padding: 1px !important;
             }
                 tr   {  page-break-before: always; }
            @page {
                    margin-bottom: 1.0cm;   
                    margin-top: 1.0cm;                
                   margin-left: -0.5cm; 
                   margin-right: 0.0cm; 
                  }
            hr {
                    margin-left: 60px !important;
                  }      
            table { page-break-inside:auto;
                    padding: 40px !important;}
       
         }
         </style>    