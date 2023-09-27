<h2> <?php echo \Lang::get('message.list')?\Lang::get('message.list'):"רשימת"; ?><span class='muted'> <?php echo "$model"?> </span></h2>
<style>
    span.active > a{
        font-weight: 900;
        font-size: 21px;
        
    }
     @media only screen and (max-width: 815px) and (min-width: 620px){
        #listcus-tbl.table th:nth-child(2), #listcus-tbl.table td:nth-child(2){ 
            display: table-cell !important;
        }
        
    }
    
    @media only screen and (max-width: 720px) and (min-width: 360px){
        
        #listcus-tbl.table th, #listcus-tbl.table td {
            width: 23% !important;
        }
        
        table#listcus-tbl.table th:nth-child(2), table#listcus-tbl.table td:nth-child(2) {
            width: 20% !important;
        }
        
        table#listcus-tbl.table th:nth-child(1), table#listcus-tbl.table td:nth-child(1), table#list-tbl.table th:nth-child(2), table#list-tbl.table td:nth-child(2) {
            width: 14% !important;
        }
        
        #listcus-tbl.table th.last-col, #listcus-tbl.table td.last-col{
            display: table-cell !important;
        }
    }
    
</style>
<br>
<?php


echo \Form::open(array('class'=>'form-inline','id'=>'form-filter-id','name'=>'form-filter', 'method' => 'get'));
echo "<div style='display: inline-block;padding: 0px 40px 14px 30px;'>";
echo Fuel\Core\Form::label(\Lang::get('label.customers.customer_key'),"");
echo "<br/>";
echo Form::input("filter_like[customer_key]", \Input::get("filter_like.customer_key"),array('type' =>'number'));
echo "<br/>";
////   echo "</div>";
//   
//echo "<div style='display: inline-block;padding: 0px 40px 14px 30px;'>";
echo Fuel\Core\Form::label(\Lang::get('label.customers.customer_name'),"");
echo "<br/>";
echo Form::input("filter_like[name]", \Input::get("filter_like.name"));
   echo "</div>";?>
<?php
  if(isset($enablebkcityfilter) && $enablebkcityfilter == 1){  
      echo "<div style='display: inline-block;padding: 0px 40px 14px 30px;'>";
//$citylist = \Model_Customers::get_city();
echo Fuel\Core\Form::label(\Lang::get('label.customers.city'),"");
echo "<br/>";
//if(!is_array($citylist))
//    $citylist = array();
//echo Form::select('filter_like[city]',\Input::get("filter_like.city"), $citylist); 
?>
<input type="text" class="popup-autocomplete hidden_customer_id  ui-autocomplete-input" id="customer_id" map-controller="customers" mapper="city" href="/customers/listcity.json" style="width:200px" name="filter_like[city]" value="<?php echo \Input::get('filter_like.city');?>" autocomplete="off">
        

<?php 
   echo "</div>";
  }
?>

<?php if(isset($agentFilteronCustomers) && $agentFilteronCustomers == 1){ ?>
   <div style="display: inline-block;padding: 0px 40px 14px 30px;">
 <label for="extra4"> <?php echo \Lang::get('message.agentname')?\Lang::get('message.agentname'):"שם סוכן"; ?></label>
    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><br/><input type="text" class="popup-autocomplete hidden_agent_id  ui-autocomplete-input" id="agent_id" map-controller="agents" mapper="name" href="/agents/listkey.json" style="width:200px" name="agent_name" value="<?php echo \Input::get('agent_name');?>" autocomplete="off">
    
        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible "></span><input  class="popup-autocomplete updateflag ui-autocomplete-input" map-controller="agents" id="hidden_agent_id" type="hidden" name="filter[agent_id]" value="<?php echo \Input::get('filter.agent_id');?>" autocomplete="off">

</div>

<?php } ?>
<?php if(isset($enablebalancefilter) && $enablebalancefilter == 1){ ?>
<div style="display: inline-block;padding: 0px 40px 14px 30px;" class="cus-bal-filter">
    <label style="  padding: 0px 12px;"><?php echo \Lang::get('message.balance')?\Lang::get('message.balance'):'Balance'; ?></label>
     <br/>  <input type="checkbox" value="1" name="balance" id="balance" <?php if(\Input::get("balance") == 1) echo 'checked'; ?>/>
</div>
<?php } ?>
<div class="form-submit" style="  display: inline;" >
<?php
//   echo Fuel\Core\Form::button(\Lang::get('message.submit'));
echo Fuel\Core\Form::button(\Lang::get('message.submit')?\Lang::get('message.submit'):'message.submit',\Lang::get('message.submit'));
    
  ?>

      <input type="button" value="<?php echo \Lang::get('message.reset')?\Lang::get('message.reset'):"אתחל"; ?>" onclick="x()" >
</div>     <?php
echo Fuel\Core\Form::close();
echo '</div>';

?>
<script>
function x(){
        $('#form-filter-id').children('div').children(':input').val('');
        $('#form-filter-id').submit();
    };
</script>

<a class="a-importcsv" href="/customers/importcsv" > <?php echo \Lang::get('message.importcsv')?\Lang::get('message.importcsv'):"Import CSV"; ?> </a>
<?php // if(isset($allowupdate) && $allowupdate == 1){ ?>                            
<p  class="create-btn">
	<?php echo Html::anchor("$base/create",\Lang::get('message.create')?\Lang::get('message.create'):'הוסף', array('class' => 'btn btn-success')); ?>
</p>
<?php // } ?>
<?php if ($cars): ?>
<a class="btn" onclick="printX()"><?php echo \Lang::get('message.print')?\Lang::get('message.print'):'Print'; ?></a>
 <script>
     function printX(){
         $('#form-filter-id').hide();
         $('.navbar').hide();
         $('a').hide();
         $('tbody tr td:last-child').hide();
         print();
         $('#form-filter-id').show();
         $('.navbar').show();
         $('#order-total').show();
         $('a').show();
         $('tbody tr td:last-child').show();
     }
     
     </script>
<?php 
$car = key($cars);

$listview = $cars[$car]->GetListViewRelations(); 




?>


<style>
    .table th{
        width:<?php if(isset($listview)&& count($listview)>0) echo 90/count($listview); else echo "200"; ?>%;
    }    
</style>


<table class="table table-striped"  id="listcus-tbl">
	<thead>
		<tr>
                    <?php foreach($listview as $column => $properties ){
                        
                        
                        ?>
                    <th><?php echo $listview[$column]['label'];?></th>
                    <?php }?>
                    <th class="last-col"></th> 
		</tr>
	</thead>
	<tbody>
            
<?php foreach ($cars as $car): ?>		<tr>

        
                    <?php 
                    
                    foreach($listview as $column => $properties) {
                       // if($column == 'modelversion') {print_r($properties);die();}
                        if(key_exists('relation', $properties)){
                            $rel_mod = $properties['relation'];
                            if(is_object($car->$rel_mod)){
                                $related = $car->$rel_mod;
                                
                                if(property_exists($related,"name"))
                                $car->$column = $related->name;
                                else{
                                    if(property_exists($related, "alternates") && is_array($related::$alternates)&& key_exists("name", $related::$alternates))
                                    {
                                        $fetch = $related::$alternates["name"];
                                        $car->column = $related->$fetch;   
                                    }
                                }
                                if(array_key_exists('image', $properties)){
                                      $car->$column= "<a target='_new' href='/{$car->$rel_mod->model_to}/{$car->$column}' ><img src=/{$car->$rel_mod->model_to}/{$car->$column} class='img-polaroid' style='width: 25%;height: 9%;'></a>";
                                }
                                
                            }
                            
                            
                            
                        }
                        
                        ?>
			<td><?php 
                                if($column == 'name'){
                                      if(isset($allowupdate) && $allowupdate == 1){  
                                            echo "<span style='display:none' class='hidecol'><a href='/customers/edit/".$car->id."' >"
                                            .$car->$column."</a></span>";  
                                      }else
                                            echo "<span style='display:none' class='hidecol'>".$car->$column."</span>";  
                                    echo '<span class="showcol">'.$car->$column.'</sapn>';  
                                    
                                }else echo $car->$column; ?>
                        </td>
                    <?php } ?>
                            
                           <td  class="last-col">
				<?php echo Html::anchor("$base/view/".$car->id, '<i class="icon-eye-open" title="View"></i>'); ?> 
                          
			 <?php if(isset($allowupdate) && $allowupdate == 1){ ?>  |
				<?php echo Html::anchor("$base/edit/".$car->id, '<i class="icon-wrench" title="Edit"></i>'); ?> |
                                <?php if(isset($enablereminder) && $enablereminder == 1 ){ ?>
                            <?php echo Html::anchor("/reminders/create/?customer_id=".$car->id, '<i class="icon-inbox" title="reminder"></i>'); ?>|
                                <?php } ?>      
                              <?php echo Html::anchor("$base/delete/".$car->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')")); ?>
                         
                      <?php } ?> 
			 <?php if(isset($car->usercreated) ){ ?>  |
				 <?php if(  $car->usercreated == 1 ){ ?>
                            <?php echo Html::anchor("/haofeorders/customers/updateUser/".$car->id, '<i class="icon-user" title="user"></i>', array('class' => 'btn btn-danger')); ?>
                                <?php }else{ ?>      
                              <?php echo Html::anchor("/haofeorders/customers/createUser/".$car->id, '<i class="icon-user" title="user"></i>', array('class' => 'btn btn-info')); ?>
                         
                      <?php } ?> 
                      <?php } ?> 
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<?php if( isset($page)  &&  !empty($page) && is_object(Pagination::instance($page))) echo Pagination::instance('mypagination')->render();?>
<?php else: ?>
<p><?php echo "No $model"?></p>

<?php endif; ?>

			