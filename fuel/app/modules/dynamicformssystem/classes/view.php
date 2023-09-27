<?php

namespace dynamicformssystem;
class view{
    public function __construct(
        $name,
        $model,
        $module,
        $array
    ) {

        $this->name = $name;
        $this->model = $model;
        $this->module = $module;
        $this->settings =  $array;
        $this->controllerName = \Inflector::classify($this->name);
    }

    function getPreTags($string) {
        $pattern = "/{(.*)}/";
        preg_match_all($pattern, $string, $matches);
        return $matches[1];
    }

    function readTemplateFile(){
      $path             = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'views'.DS.'viewsforforms'.DS.'head.php';
      $head             = file_get_contents($path);
      $placeholders_arr = $this->getPreTags($head);

      $path_tmp = '';
      $placeholders_content = array();
      foreach($placeholders_arr as $placeholder){
        $path_tmp = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'views'.DS.'viewsforforms'.DS.substr($placeholder, 1).'.php';
        $placeholders_tags[] = '{'.$placeholder.'}';
        $placeholders_content[] = file_get_contents($path_tmp);
      }

      $head = str_replace($placeholders_tags, $placeholders_content, $head);


      $body   = '';
      $footer = '';

      $template = $head.$body.$footer;

      return $template;
    }


    function buildIndex(){


    }

    function buildEdit(){


    }

    function buildViewAndSign(){



    }

    function buildView(){

    }

    public function buildFiles(){

    }

    public function viewPath(){
        return $this->module->getModulePath().DS.$this->module->name.DS."views".DS;
    }

    public function viewPathFile(){
        return $this->viewPath()."template.php";
    }
    ///
    public function flushFiles(){
      $stringTemplate = $this->readTemplateFile();
      $file  =  $this->viewPathFile();
      if(file_exists($file)) \File::delete($file);
      \File::create($this->viewPath(),"template.php",$stringTemplate);
    }

    public function populateSettings(){

    }

}