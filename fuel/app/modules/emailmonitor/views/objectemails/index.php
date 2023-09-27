<h2> <?php echo \Lang::get('message.list')?\Lang::get('message.list'):"רשימת"; ?><span class='muted'> <?php echo "$model"?> </span></h2>
<style>
    span.active > a{
        font-weight: 900;
        font-size: 21px;
        
    }
    
</style>
<br>
<?php
if(isset($mode_select) && is_object($mode_select)){
$listview = $mode_select->GetListViewRelations();
$relation = array();

              foreach($listview as $column => $properties) {
                        if(key_exists('relation', $properties)){
                            $relation[$column] = $listview[$column];
                        }
              }
if(is_array($relation) && isset($relation) && count($relation)>0){
echo \Form::open(array('class'=>'form-inline','method' => 'get'));
echo "<div class='row-fluid inline'>";
foreach($relation as $name=>$select){
    if(array_key_exists('image', $select))
        continue;
    else{
          echo "<div style='display: inline-block;padding: 0px 40px 14px 30px;'>";
        echo Fuel\Core\Form::label($select['label'],"filter[$name]");
        $select['form']['id'] = "form_$name";
        echo Form::input("filter[$name]", \Input::post($name)?\Input::post($name):'',array(),$select['form']);
           echo "</div>";
    }
    
    
}
echo Fuel\Core\Form::button(\Lang::get('message.submit')?\Lang::get('message.submit'):'message.submit');
echo Fuel\Core\Form::close();
echo '</div>';
}
}
?>


<?php if ($cars): ?>
<a class="btn" onclick="printX()"><?php echo \Lang::get('message.print')?\Lang::get('message.print'):'Print'; ?></a>
 <script>
     function printX(){
         $('#ordersfilter').hide();
         $('#async-order-total').hide();
         $('#order-total').hide();
         $('.navbar').hide();
         $('hr').hide();
         $('a').hide();
         $('tbody tr td:last-child').hide();
         print();
         $('#ordersfilter').show();
         $('#async-order-total').show();
         $('.navbar').show();
         $('#order-total').show();
         $('a').show();
         $('hr').show();
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


<table class="table table-striped">
	<thead>
		<tr>
                    <?php foreach($listview as $column => $properties ){
                        
                        
                        ?>
                    <th><?php echo $listview[$column]['label'];?></th>
                    <?php }?>
                    <th></th>
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
			<td><?php echo $car->$column; ?></td>
                    <?php } ?>
			<td>
				<?php echo Html::anchor("$base/send/".$car->id, '<i class="icon-envelope" title="Send"></i>'); ?> 
				<?php // echo Html::anchor("$base/view/".$car->id, '<i class="icon-eye-open" title="View"></i>'); ?> 
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<?php if( isset($page)  &&  !empty($page) && is_object(Pagination::instance($page))) echo Pagination::instance('mypagination')->render();?>
<?php else: ?>
<p><?php echo "No $model"?></p>

<?php endif; ?>
<!--<p>
	<?php echo Html::anchor("$base/create",\Lang::get('message.create')?\Lang::get('message.create'):'הוסף', array('class' => 'btn btn-success')); ?>

</p>-->
