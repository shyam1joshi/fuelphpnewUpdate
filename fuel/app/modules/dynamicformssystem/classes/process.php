<?php 

namespace dynamicformssystem;

class Process{

    public $formlimit = 30;
    public $deleteRecordLimit = 100;
    public $forms = '';
    public $formObject = '';
    public $formModulename = '';
    public $moduleModel = '';
    public $objectsQuery = '';
    public $objectsCount = '';
    public $objectsData = '';
    public $countlimit = ''; 
    public $deleteBeforeDate = '';


    /**
     * 2
     */
    public function getForms(){
        
        $namespace = __NAMESPACE__;

        $model = '\\'.$namespace."\Model_Forms";

        $todayDate = date('d-m-Y');

        $this->forms = $model::clearQuery()->where('enablePermanantDelete','1')
                        ->where_open()
                        ->or_where('lastDeleteDate','<', $todayDate )
                        ->or_where('lastDeleteDate',null )
                        ->or_where('lastDeleteDate','' )
                        ->where_close()
                        ->limit($this->formlimit)->get();
                     
    }

    public function calculateDeleteBeforeDate(){

        $numberOfDaysAfterMarkedDeleted = is_object($this->formObject) && !empty($this->formObject->numberOfDaysAfterMarkedDeleted)?$this->formObject->numberOfDaysAfterMarkedDeleted:7;

        $this->deleteBeforeDate =date('Y-m-d H:i:s', strtotime(  "-$numberOfDaysAfterMarkedDeleted days" , strtotime(date('Y-m-d' )))); 
        
    }

    /**
     * 3
     */
    public function processFormsDelete(){

        if(count( $this->forms) > 0){
 
            foreach( $this->forms as $form){


                $this->formObject = $form;
                
                $this->calculateDeleteBeforeDate();
                
                $this->processFormIndividual();
            }
        }
       
    }

    
    /**
     * 5
     */
    public function setModuleModel(){

        
        $filename = \Inflector::classify($this->formModulename); 
        $this->moduleModel = "\\$this->formModulename\Model_{$filename}";
     
    }

    /**
     * 7
     */
    public function setObjectsQuery(){

        \Module::load($this->formModulename);
     
        $model = $this->moduleModel;

        $this->objectsQuery =  $model::clearQuery()->where('deleted','1')->where('deleted_date','<', $this->deleteBeforeDate);
         
    }

    /**
     * 8
     */
    public function getbjectsCount(){
 

        $this->objectsCount =   $this->objectsQuery->count();
    
        $this->setCountLimit();

     
    }

    
    /**
     * 11
     */
    public function processObjectRelationData($object){
                
        $hasManyRelations = $object->GetHasMany();

        if (is_array($hasManyRelations)) {
            foreach ($hasManyRelations as $key => $relation) {
               
                $model = $relation['model_to'];

                $objectLineDel = new $model;
                $toDelete = $objectLineDel::query()->where('key_to', $object->id)->get();

                if (!empty($toDelete) && is_array($toDelete) && count($toDelete) > 0) {
                    foreach ($toDelete as $toDeleteItem) {
                        $toDeleteItem->delete();
                    }
                } 
            }
        }
    }

    /**
     * 10
     */
    public function processObjectsData(){
 

        if(count( $this->objectsData ) > 0){

            foreach( $this->objectsData  as $object){
               
                if(is_object($object)){


                    $this->processObjectRelationData($object);
                        

                    $object->delete();
                }
            }
        }
    }

    
    /**
     * 6
     */
    public function getObjectsData(){

        $this->setObjectsQuery(); 
        $this->getbjectsCount();

        for($i =0; $i< $this->countlimit; $i++){

            $this->objectsData =   $this->objectsQuery->limit($this->deleteRecordLimit)->get();
         
            $this->processObjectsData(); 
 
        }
        
       
    }

    /**
     * 9
     */
    public function setCountLimit(){ 
        
        $this->countlimit =  $this->objectsCount/$this->deleteRecordLimit;
       
        $this->countlimit  = ceil( $this->countlimit );

      
    }

    /**
     * 4
     */
    public function processFormIndividual(){

        
        if(is_object( $this->formObject)){

            $this->formModulename = $this->formObject->name;
            
            $this->setModuleModel();
           
            $this->getObjectsData();

            $this->updateFormObject();

        }
       
    }


    /**
     * 12
     */
    public function updateFormObject(){

        
        if(is_object( $this->formObject)){

            $this->formObject->lastDeleteDate = date('d-m-Y');
            $this->formObject->lastDeleteDateTime = date('d-m-Y H:i:s'); //for logs

            $this->formObject->save();

            
            \Log::warning("Called for delete data permanently for  module $this->formModulename  ; Number of records deleted : $this->objectsCount ");
        }
       
    }


    /**
     * 1
     */
    public function processDeletePermanently(){

        $this->getForms();

        $this->processFormsDelete();

    }
       
                     


}