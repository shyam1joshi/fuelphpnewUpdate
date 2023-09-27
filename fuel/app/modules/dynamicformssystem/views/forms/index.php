<h2> <?php //echo \Lang::get('message.list')?\Lang::get('message.list'):"רשימת"; ?><span class='muted'> <?php //echo "$model"?> </span></h2>
<style>
    span.active > a{
        font-weight: 900;
        font-size: 21px;
        
    }
    
</style>
<br>
<form class="span12" action="#" id="ordersfilter">
    <div class=" form-control" style="    display: inline-block">
        <label for="extra4">Form Name</label>
        
        <input type="text"  style="width: 200px; height: 25px" name="form_name" value="<?php echo \Input::get('form_name');?>" autocomplete="off">
    </div>
    <div class="  form-control" style="    display: inline-block">
          <br/>
        <input type="submit" value="<?php echo \Lang::get('message.submit')?\Lang::get('message.submit'):"הכנס"; ?>"  class="btn btn-primary btn-print span2" style="padding: 0px 15px;    margin-top: -10px;width: 45% !important;" />
        <input type="button" value="<?php echo \Lang::get('message.reset')?\Lang::get('message.reset'):"אתחל"; ?>" class="btn btn-primary btn-print span2" onclick="x()"  style="padding: 0px 15px;    margin-top: -10px;    width: 66px;" />
        
    </div>
    
    <script>
    function x(){ 
        $('#ordersfilter').children('div').children('input').val('');
        $('#ordersfilter').submit();
    }
</script>
</form>
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
<p>
	<?php echo Html::anchor("$base/create",\Lang::get('message.create')?\Lang::get('message.create'):'הוסף', array('class' => 'btn btn-success')); ?>

</p>
<!--<a href="/<?php // echo $base; ?>/importcsv" > <?php echo \Lang::get('message.importcsv')?\Lang::get('message.importcsv'):"Import CSV"; ?> </a>-->

<?php if ($cars): ?>
<a class="btn" onclick="print()"><?php echo \Lang::get('message.print')?\Lang::get('message.print'):'Print'; ?></a>
 
<?php 
$car = key($cars); 

$listview = $cars[$car]->GetListViewRelations(); 




?>


<style>
    .table th{
        width:<?php if(isset($listview)&& count($listview)>0) echo 90/(count($listview)+3); else echo "200"; ?>%;
    }    
</style>


<table class="table table-striped">
	<thead>
		<tr>
                    <?php foreach($listview as $column => $properties ){
                        
                        
                        ?>
                    <th><?php echo $listview[$column]['label'];?></th>
                    <?php }?>
                    <th>Link</th>
                    <th>Labelers</th>
                    <th>Setting</th>
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
                                if( isset($related->name))
                                    $car->$column = $related->name;
                                else { 
                                    if(is_object($related) && property_exists($related, "alternates") 
                                            && is_array($related::$alternates)&& 
                                            key_exists("name", $related::$alternates))
                                    {
                                        $fetch = $related::$alternates["name"];
                                        $data['car'][$column] = $related->$fetch;   
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
                        <td><a href="/<?php
                        if(!empty($car->name)){
                        $flag=0; 
                        $n = strlen($car->name); 
                        
                            if ($car->name[$n -1] == 's') 
                                $flag=1; 
                        
                        if($flag== 1)
                        echo $car->name.'/'.$car->name; 
                        else
                        echo $car->name.'/'.$car->name.'s'; 
                        }
                        
                        ?>">URL</a></td>
                        <td><a href="/<?php
                         if(!empty($car->name)){
                        $flag=0; 
                        $n = strlen($car->name); 
                        
                            if ($car->name[$n -1] == 's') 
                                $flag=1; 
                        
                        if($flag== 1)
                        echo $car->name.'/'.$car->name; 
                        else
                        echo $car->name.'/'.$car->name.'s'; 
                        }
                        
                        
                        
                        
                        ?>/labelers">labelers</a></td>
                        <td><a href="/dynamicformssystem/forms/setSettings/<?php echo $car->name; ?>">Update</a></td>
			<td>
				<?php echo Html::anchor("$base/showForm/".$car->id, '<i class="icon-eye-open" title="View"></i>'); ?> 
			
                                <?php // if($car->flow <2 ){ ?> |
                                <?php echo Html::anchor("$base/edit/".$car->id, '<i class="icon-wrench" title="Edit"></i>'); ?> 
				<?php // echo Html::anchor("$base/delete/".$car->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')")); ?>
                                <br/>
                                    <?php echo Html::anchor("$base/duplicate/".$car->id, 'Duplicate', array('class' => 'btn btn-danger','onclick'=> "return confirm('Are you sure?')",'target' =>'_blank')); ?> 
				
                    <?php // } ?>
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<?php if( isset($page)  &&  !empty($page) && is_object(Pagination::instance($page))) echo Pagination::instance('mypagination')->render();?>
<?php else: ?>
<p><?php echo "No $model"?></p>

<?php endif; ?>

<?php 
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/create";
echo "$actual_link"; 
?>
 <style>
         
        
        @media print{
          
             a,a.btn,#ordersfilter,.navbar,table.table tbody tr td:last-child,footer,#order-total{
                   display: none;
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