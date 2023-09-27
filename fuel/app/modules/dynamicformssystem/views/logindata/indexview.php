
<?php
 

$filepathdata  = '';
if(isset($filepath))  $filepathdata = $filepath;
  
$enableExportCSV = isset($enableExportCSV)?$enableExportCSV:0;
        
        
        ?>
<?php 

$data = <<<A
        <link rel="stylesheet" href="/{$filepathdata}/indexcss" >
        <?php if(isset(\$formIndexTitle)){ ?>
            <h2> <?php echo \$formIndexTitle ?> </h2>
            <?php } ?>
<style>
    span.active > a{
        font-weight: 900;
        font-size: 21px;
        
    }
    
</style>
<br>
<?php
if(isset(\$mode_select) && is_object(\$mode_select)){
 
   \$filter = \$mode_select->GetFilters();
       
    echo \$filter;    
        }
?>
          
<p>
	<?php echo Html::anchor("\$base/create?clear=1",\Lang::get('message.create')?\Lang::get('message.create'):'הוסף', array('class' => 'btn btn-success')); ?>

</p>
A;
         
$data .= <<<A
            
<?php
if(isset(\$enableExportCSV) &&  \$enableExportCSV == '1' ){ ?>
<p>
	<?php echo Html::anchor("\$base/exportCSVData",\Lang::get('message.exportcsv')?\Lang::get('message.exportcsv'):'Export CSV', array('class' => 'btn btn-primary')); ?>

</p>   
<?php         }
?> 
        
A;
     

$data .= <<<A
                
 
<?php if (\$cars): ?>
 
<?php 
\$car = key(\$cars); 

\$listview = \$cars[\$car]->GetListViewRelations(); 




?>


<style>
    .table th{
        width:<?php if(isset(\$listview)&& count(\$listview)>0) echo 90/count(\$listview); else echo "200"; ?>%;
    }    
</style>


<table class="table table-striped mycomTable">
	<thead>
		<tr>
                    <?php foreach(\$listview as \$column => \$properties ){
                        
                        
                        ?>
                    <th><?php echo \$listview[\$column]['label'];?></th>
                    <?php }?>
                    <th></th>
		</tr>
	</thead>
	<tbody>
            
<?php foreach (\$cars as \$car): ?>		<tr>

        
                    <?php 
                    
                    foreach(\$listview as \$column => \$properties) {
                       // if(\$column == 'modelversion') {print_r(\$properties);die();}
                       if(key_exists('relation', \$properties)){
                            \$rel_mod = \$properties['relation'];
                            if(is_object(\$car->\$rel_mod)){
                                \$related = \$car->\$rel_mod;
                                if( isset(\$related->name))
                                    \$car->\$column = \$related->name;
                                else { 
                                    if(is_object(\$related) && property_exists(\$related, "alternates") 
                                            && is_array(\$related::\$alternates)&& 
                                            key_exists("name", \$related::\$alternates))
                                    {
                                        \$fetch = \$related::\$alternates["name"];
                                       \$data['car'][\$column] = \$related->\$fetch;   
                                    }
                                }
                                 
                                if(array_key_exists('image', \$properties)){
                                      \$car->\$column= "<a target='_new' href='/{\$car->\$rel_mod->model_to}/{\$car->\$column}' ><img src=/{\$car->\$rel_mod->model_to}/{\$car->\$column} class='img-polaroid' style='width: 25%;height: 9%;'></a>";
                                }
                                
                            }
                            
                            
                            
                        }
                        
                        ?>
			<td><?php 
                        
                      /*                      
                       \$type =  \$car->GetPropertiesType(\$column);
                       
                       if(\$type == 'date' && !empty(\$car->\$column))
                           echo date('d.m.Y', strtotime(\$car->\$column));
                       else{ 
                            if(!empty(\$car->\$column) && (\$column =='created_at' || \$type == 'datetime'))
                                echo date('d.m.Y H:i:s', strtotime(\$car->\$column));
                            else echo 

                                  \$car->\$column; 
                       }
        
        */
        echo  \$car->\$column; 
        
                        ?></td>
                    <?php } ?>
			<td><?php echo Html::anchor("\$base/view/".\$car->id, '<i class="icon-eye-open" title="View"></i>',array("class" => 'btn btn-info span3', 'style'=>'    margin: 0px 5px;')); ?><?php  if(\$car->flow <2 ){ ?>  

A;
                                        
if(isset($showeditbtnonindex) && $showeditbtnonindex ==1){
$data .= <<<A
        <?php   echo Html::anchor("\$base/edit/".\$car->id, '<i class="icon-wrench" title="Edit"></i>',array("class" => 'btn btn-info span3', 'style'=>'    margin: 0px 5px;')); ?>  

A;
}

       

                                        
if(isset($showdeletebtnonindex) && $showdeletebtnonindex ==1){
$data .= <<<A
        <?php echo Html::anchor("\$base/delete/".\$car->id, '<i class="icon-trash" title="Delete"></i>', array("class" => 'btn btn-info span3', 'style'=>'    margin: 0px 5px;','onclick' => "return confirm('Are you sure?')")); ?>

A;
          
}

$data .= <<<A
        <?php } ?>
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<?php if( isset(\$page)  &&  !empty(\$page) && is_object(Pagination::instance(\$page))) echo Pagination::instance('mypagination')->render();?>
<?php else: ?>
<p><?php echo "No \$model"?></p>

<?php endif; ?>

<?php 
\$actual_link = "https://\$_SERVER[HTTP_HOST]\$_SERVER[REQUEST_URI]/create";
echo "\$actual_link"; 
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
A;
                                      
                                      
                                      
                                      
echo $data;                                  
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      