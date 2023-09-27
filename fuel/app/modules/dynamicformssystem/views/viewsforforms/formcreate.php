<?php 
$draft_id  ="";
if(in_array($viewType, array('edit','viewandsign')))
$draft_id = '<input name="draft_id" type="hidden" value="<?php if(isset(\$order) && is_object(\$order)) echo \$order->id; ?>" />';

$cloneViews = "";
if(count($cloneData) > 0) 
    foreach ($cloneData as $cldata){
        $cloneViews .= <<<CREATE
    <div id="{$cldata['clone-id']}"  style="display:none;" count="<?php if(isset(\$count_{$cldata['clone-id']}) && \$count_{$cldata['clone-id']} > 0) echo \$count_{$cldata['clone-id']}; else echo 1; ?>"> 
    {$cldata['clone-view']}
    
    </div>
                
CREATE;
}
    
    


$view  =  <<<CREATE
<form method='post' action="<?php // echo \$base;/create ?>" id="myFormId"
js-url="/{$filename}/{$controller}/<?php if(isset(\$jsurl) && !empty(\$jsurl)) echo \$jsurl; else echo 'jsonOrdercomplete'; ?>" 
enctype='multipart/form-data' role="form" class="box-body">        
{$renderedElements}

<!-- <div id="emailWrap" style="display:none;">
   <label>Enter the Email</label>
   <input type="text" name="email" id="enterEmail"  value="{$email}"/>
</div> -->
{$draft_id}
</form>

{$cloneViews}
<input id="uploadUrl" type="hidden" value="/{$filename}/{$controller}/createImagex" />
CREATE;
       





echo $view;