 <?php 
 
           
        $flag = 0;
        $count = 0; 
        $temp = array(); 
        $form = '';
        $script = <<<SCRIPT
                <script>
   function x(){ 
        $('#ordersfilter').children('div').children('input[type="text"]').val("");
        $('#ordersfilter').children('div').children('input[type="number"]').val("");
        $('#ordersfilter').children('div').children('input[type="date"]').val("");
        $('#ordersfilter').children('div').children('input[type="tel"]').val("");
        $('#ordersfilter').submit();
    }
</script> 
SCRIPT;
        
        
        if(isset($arr) && is_array($arr)){ 
            
        foreach($arr as $property=>$val){ 
            
            if(isset($val['filter']) && $val['filter'] == '1' && $count < $filiterLimit){
                $flag = 1;
                $labelval = \Lang::get($val['label'])?\Lang::get($val['label']):$val['label'];
                
                $label  = html_tag('label',array(), $labelval); 
                
                 $attributes['class'] = 'form_control';
                    $attributes['style'] = 'width: 200px; height: 25px'; 
                    
                if($property == 'created_at'){
                    $attributes['type'] = 'date';
                    $property = 'created_from';
                    
                    $attributes['value'] =  \Input::get($property);
                    
                
                    $attributes['name'] = $property;
                    $attributes['id'] = $property;
                    
                      $field  = html_tag('input',$attributes);
                      $labelval = 'מתאריך';
                    $label  = html_tag('label',array(), $labelval); 
                    $label .= '<br/>';
                    $label .= $field;

                    $div  = html_tag('div',array('class'=>" form-control", 'style' =>'display:inline-block'
                        ), $label); 

                    $div .=   "&nbsp;&nbsp;";
                    $temp[$property] = $div;
                    $count++;
                    $property = 'created_to';
                    $attributes['name'] = $property;
                    $attributes['id'] = $property;
                     $attributes['value'] =  \Input::get($property);
                    $field  = html_tag('input',$attributes);
                    $labelval = 'עד תאריך';
                    $label  = html_tag('label',array(), $labelval); 
                    $label .= '<br/>';
                    $label .= $field;
                     $div  = html_tag('div',array('class'=>" form-control", 'style' =>'display:inline-block'
                      ), $label); 

                    
                    $div .=   "&nbsp;&nbsp;";
                    $temp[$property] = $div;
                    $count++;
                    
                }else{
                    $attributes['type'] = 'text';
                    $attributes['value'] =  \Input::get('filter.'.$property);
                
                
                    $attributes['name'] = 'filter['.$property.']';
                    $attributes['id'] = $property;

    //                if($property == 'created_at'){
    //                    $attributes['type'] = 'date';
    //                    $property = 'created_from';
    //                }else
    //                    $attributes['type'] = 'text';

                   


                    $field  = html_tag('input',$attributes);

                    $label .= '<br/>';
                    $label .= $field;

                    $div  = html_tag('div',array('class'=>" form-control", 'style' =>'display:inline-block'
                        ), $label); 

                    $div .=   "&nbsp;&nbsp;";
                    $temp[$property] = $div;
                    $count++;
                }
            }
        }
        
        if($flag == 1){
            $filters = implode('<br/>', $temp);

            $filters .=   "&nbsp;&nbsp;&nbsp;&nbsp;";

            $labelval = \Lang::get('base.submit')?\Lang::get('base.submit'):'submit';

            $attr['name'] = 'submitx';
            $attr['id'] = 'submitx';
            $attr['type'] = 'submit';
            $attr['class'] = 'btn  btn-print span2'; 
            $attr['style'] = '
        padding: 0px 15px;
        margin-top: -10px;
    '; 
            $attr['value'] = $labelval; 

            $btn = html_tag('input', $attr);

            $labelval = \Lang::get('label.base.reset')?\Lang::get('label.base.reset'):'reset';

            $attr['name'] = 'reset';
            $attr['id'] = 'resetx';
            $attr['onclick'] = 'x()';
            $attr['type'] = 'button';
            $attr['class'] = 'btn  btn-print span2'; 
            $attr['style'] = '
        padding: 0px 15px;
        margin-top: -10px;
        width: 66px;
    '; 
            $attr['value'] = $labelval; 

            $btn .=   "&nbsp;";
            $btn .= html_tag('input', $attr);

            $div  = html_tag('div',array('class'=>" form-control",
                           'style' =>'display:inline-block;    margin-top: 32px;'
                       ), $btn); 

            $filters .=   $div;
            $filters .=   "&nbsp;&nbsp;&nbsp;&nbsp;";
            $filters .=   $script;

            $formattr['id'] = 'ordersfilter';
            $formattr['class'] = 'span12';
            $formattr['style'] = 'display:inline-flex';
            $formattr['action'] = '#';
            $form  = html_tag('form',$formattr,$filters);
        }
             
    } 
 echo $form;  