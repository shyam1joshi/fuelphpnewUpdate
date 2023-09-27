<?php


namespace haofeorders;

class Controller_Products extends \Controller_Products 
{
    public $select_id = "בחר מוצר";
    
    
        public function get_listx()
	{
        
           
            $name = \Auth::get_user_id();
            
            $agent_now = \Model_Agents::query()->where("connect_uid","=",$name[1])->get_one();
            
            
            if(is_object($agent_now)){
                
                $loc=\Model_Agentwarehouses::query()->where("agent_id","=",$agent_now->id)->get_one();
                if(is_object($loc))
                    $location_now = \Model_Locations::query()->where('id','=',$loc->location_id)->get_one();
                else 
                    $location_now = null;
            }
            else
                $location_now = null;
            
            
            
            /*
            print_r($data['cars']);
              die();
            
            */
            
            
            
            $query = $this->query;
        
            $data['mode_select'] = $query->get_one();
            $props = array();
            
            if(is_object($data['mode_select']))
            $props = $data['mode_select']->properties();
            $filter = \Input::get('filter');
            $prodcategory = \Input::get('prodcategory');
            $prodname = \Input::get('prodname');
            $text_filter = \Input::get('text_filter');
            $uri = "/{$this->base}/index/?";
            if(is_array($filter))
                foreach($filter as $where => $value)
                    if($value != 0 && !empty($value))
                    {
                        $query->where($where, $value);
                        $uri .="&filter[$where]=$value";
                    }   
                    
             if(is_array($text_filter))
                foreach($text_filter as $where => $value)
                    if(isset($value) && !empty($value) && array_key_exists( $where,$props))
                    {
                        
                        $query->where($where,'like', "%$value%");
                        $uri .="&text_filter[$where]=$value";
                        
                    }

                    $per_page = \Input::get('per_page');
                    if(!empty($per_page) && intval($per_page)  != 0 )
                    {
                        $per_page = intval($per_page);
                    }
                    else $per_page = 5;
            $config = array(
               'pagination_url' => "$uri",
               'per_page'       => $per_page,
               'uri_segment'    => 'page',
            );
            
            if(isset($prodcategory) && !empty($prodcategory)){
                
                $query->related('productcategories');
                
                $query->where('productcategories.category_id',$prodcategory);
                
            }
            if(isset($prodname) && !empty($prodname)){
                 
                $query->where('item_name','like',"%$prodname%");
                
            }
            
//            $query->where('disable', 0);
            
            $model = $this->model;
            $order_by =\Input::get('order_by');
            if(isset($order_by) && is_numeric($order_by) && $order_by > 1)
                $query->order_by('id','ASC');
            else 
                $query->order_by('id','DESC');
            
            $pagination = \Pagination::forge('mypagination', $config);
            $data['paginate'] = $pagination;
            $data['alternate']= property_exists($model, 'alternates')? $model::$alternates: null;
            $data['model'] = \Lang::get("menu.".strtolower($this->base) )?\Lang::get("menu.".strtolower($this->base)):$this->base;
            $pagination->total_items = $query->count();
            $data['cars']= $query->rows_limit($pagination->per_page)->rows_offset($pagination->offset);
            
            
            $data['cars'] = $query->get_array();    
            
            
            $stk=  \Model_Systemconfig::query();
            
            $stk->where("name","enablemodule");
            $info = $stk->get_one();
            
            /*
             * Added a if else clause by Shyam joshi <shyam@shyamjoshi.in>
             */
            if(is_object($info))
            $info_jd = json_decode($info->value,true);
        else {
            $info_jd = array();
            $info_jd['stockmgmt']= 0;
        }
//             print_r($info);die();
            
            if($info_jd['stockmgmt']== 0){
            
                foreach($data['cars'] as $key=>$info){
                    if(!is_object($location_now)) continue;
                    $quan  = \Model_Quantities::query()->where('location_id','=',$location_now->id);
                    if(is_object($quan))
                        $infox = $quan->where('product_id','=',$info['id'])->get_one();
                   if(is_object($infox)){
                       $data['cars'][$key]['positivequan']=$infox->amount;
                   }  
                   else $data['cars'][$key]['positivequan'] =0;
                }
            }   
            
            
           $rel_get = \Input::get('relation_get','1');    //default is set to 1 by namrata. to retrieve image name
            if(!empty($rel_get) && intval($rel_get)  == 1  )
           foreach($data['mode_select']->GetHasOne() as $relation => $keys){
               foreach($data['cars'] as $key => $items)
               {
                      $model_to = $keys['model_to'];
                      $query_to = $model_to::query();
                      $query_to->where($keys['key_to'],$data['cars'][$key][$keys['key_from']]);
                      $dataarray = $query_to->get_array();
                      if(is_array($dataarray) && array_key_exists(0,$dataarray) &&
                                    is_array($dataarray[0]) && !empty($dataarray[0]))
                        $data['cars'][$key][$keys['key_from']] = $dataarray[0]['name'];
                      //print_r($dataarray);
               }
            }
            $data['page']= $pagination->current_page;
            $data['total_items']=$pagination->total_items;
            $data['pages']=\Pagination::instance('mypagination')->total_pages;
            $echos = json_encode($data);
            
            echo  $echos;
          
            die();
	}
        
        
}