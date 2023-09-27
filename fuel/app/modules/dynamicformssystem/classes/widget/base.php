<?php 

namespace dynamicformssystem;


class Widget_Base{
        var $fieldData = null;
        var $details = null;

        var  $widgets = array(
        'radio-group','checkbox-group','canvas',
        'editabletext', 'date','select','file','textarea' ,
        'hidden' ,"text", "default",'section');
        var $widgetObjects= array(); //serial number and place to look up widgets
                                     //Store groups saperately to process 
/*
Store widgets with subGrouping widget , create a widget object holding more widgets allowing a recursive processor
To handle subwidgets to make things easier to change later


*/      static $formControllerInstance  = null;
        var  $formController  = null;
        static  $instance = null;
 
        public function __construct($options=null,$field=null){
                if(is_array($options)){
                        foreach($options as $key=>$option)
                                $this->$key = $option;
                }
                $this->number = strtotime("now");

                $this->fieldData = $field;

        }

     


       

        public function buildLabel(){
                $field = $this->fieldData;
                $name = $this->getKeyValue($field,'name');  
                $line_name = $this->getKeyValue($field,'line_name');  
                $label_module = $name;
                if(!empty($line_name)) $label_module = $line_name;
                return "<?php \Lang::get('label.$label_module')?\Lang::get('label.$label_module'):'label.$label_module';  ;?>";
        }
        


        public function render() {

        }

        public function renderProperties(){
                $this->module = "max";
                return array(
                                        'form'=> array(
                                                'type'=> $this->type, 
                                                    ),
                                        'type'=> 'int',
                                        'null'=> true,
                                        'label'=> "label.{$this->module}.{$this->name}",
                                        'type'  =>  'varchar',
                                        'constraint' =>  '100',
                                        'input_validation' =>  '0',
                                        'limit' =>  '1',
                                        'label2'=>$this->label
                        );


        }
        public function setValues($formController){
                $this->formController=$formController;
        }

        public function fieldClassGeneration(){
                $className  = "";
                $className = $this->getKeyValue($this->fielddata,'className');  
                if(isRequired()) $className .= " required "; 

        }

        public function getPlaceHolder(){

                $placeholder = $this->getKeyValue($$this->fielddata,'placeholder');

                return $placeholder;
        }

        

        public function getValue(){
                $field = $this->fieldData;
                $name = $this->getKeyValue($field,'name');  
                $line_name = $this->getKeyValue($field,'line_name');  

                if(!empty($line_name) && $this->showEditData == 1){
                //                   $value = '<?php if(isset($order->{"$line_name)) echo $order->{"'.$line_name. '  ';
                        $value = '<?php if(isset($line->{"'.$line_name.'"})) echo $line->{"'.$line_name. '"} ?>';
                }else{
                if(!empty($name)){
                        $value = '<?php if(isset($order->{"'.$name.'"})) echo $order->{"'.$name. '"} ?>';
                }
                }

        }

        public function getCreateView(){

        }

        public function getEditview(){
               $value = $this->getValue();
        }
       

        public function getViewAndSign(){
                $value = $this->getValue();
        }

        public function getReadView(){
                $field = $this->fieldData;
                $name = $this->getKeyValue($field,'name');  
                $value = $this->getValue();
                $value = $this->formController->getViewElements($field, $value, $name);

        }

        public function getPDFLabeler(){
                $value = $this->getValue();
        }


        public static function  getKeyValue($field = array(), $key = '', $value= '') {
        
                $val = '';
                if(is_array($field)){
                    $val = key_exists($key,$field)?$field[$key]:$value;
                }
                return $val;
            }


        public function buildWidgetObject($widget){
                $widgetObject = null;

                if(key_exists("hr",$widget) && $widget['hr']==1) $widget['type'] = "hr";
                $type = ucwords($widget['type']);
               
                $widgetSelector = "Widget_$type"; 
                $localClass = "\dynamicformssystem\\$widgetSelector";
                if(class_exists($localClass)) return  new $localClass($widget);  //create widget 
            }
            public static function getWidget($field){
                if(!is_object(static::$instance))  static::$instance= new Widget_Base();
                $type = static::getKeyValue($field,'type'); 
                return static::$instance->buildWidgetObject($field);
            }


}