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
              
}
?> 
<p>
	<?php echo Html::anchor("$base/create",\Lang::get('message.create')?\Lang::get('message.create'):'הוסף', array('class' => 'btn btn-success')); ?>

</p>
<?php if ($cars): ?>
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
                                $car->$column = $related->name.'-'.$related->email?$related->email:"";
                                if(array_key_exists('image', $properties)){
                                      $car->$column= "<a target='_new' href='/{$car->$rel_mod->model_to}/{$car->$column}' ><img src=/{$car->$rel_mod->model_to}/{$car->$column} class='img-polaroid' style='width: 25%;height: 9%;'></a>";
                                }
                                
                            }
                            
                            
                            
                        }
                        
                        ?>
			<td><?php echo $car->$column; ?></td>
                    <?php } ?>
			<td>
				<?php echo Html::anchor("$base/view/".$car->id, '<i class="icon-eye-open" title="View"></i>'); ?> |
				<?php echo Html::anchor("$base/edit/".$car->id, '<i class="icon-wrench" title="Edit"></i>'); ?> |
				<?php echo Html::anchor("$base/delete/".$car->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<?php if( isset($page)  &&  !empty($page) && is_object(Pagination::instance($page))) echo Pagination::instance('mypagination')->render();?>
<?php else: ?>
<p><?php echo "No $model"?></p>

<?php endif; ?>
