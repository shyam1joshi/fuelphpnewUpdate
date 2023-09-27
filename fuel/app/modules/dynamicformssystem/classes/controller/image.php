<?php

namespace dynamicformssystem;

class Controller_Image extends Controller_Base{
    public $title = "Image"; 
    public $base = "image";
    public $model = "\dynamicformssystem\Model_Image";
    
    
    public function get_deleteImage($id) {
        
        $status = 0;
        
        $model = $this->model;
        $object = $model::find($id);
        
        if(is_object($object)){
            
            $object->delete();
            
            $status = 1;
        }
        
        echo $status;
        
        die();
    }
        public function action_index()
	{
            $query = $this->query;
            $data['mode_select'] = $query->get_one();
            $filter = \Input::get('filter');
            $uri = "/{$this->base}/index/?";
            if(is_array($filter))
                foreach($filter as $where => $value)
                    if($value != 0 && !empty($value))
                    {
                        $query->where($where, $value);
                        $uri .="&filter[$where]=$value";
                    }   
    $per_page = \Input::get('per_page');
                    if(!empty($per_page) && intval($per_page)  != 0 )
                    {
                        $per_page = intval($per_page);
                    }
                    else $per_page = 20;
            $config = array(
               'pagination_url' => "$uri",
               'per_page'       => $per_page,
               'uri_segment'    => 'page',
            );
            
//            $query->related('order');
//            $query->where('order.id','1');
            // Create a pagination instance named 'mypagination'
            $pagination = \Pagination::forge('mypagination', $config);
            $data['paginate'] = $pagination;
            $pagination->total_items = $query->count() ;
            $data['cars']= $query->rows_limit($pagination->per_page)->rows_offset($pagination->offset);
            $data['page'] = 'mypagination';
            $data['filter'] = $filter;
            $data['cars'] = $query->get();
            
    
            $this->template->title = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['model'] = \Lang::get('base.'.$this->base)?\Lang::get('base.'.$this->base):$this->base;
            $data['base'] = $this->base;
            $this->template->content = \View::forge('cars/index', $data);

	}
        
}