   public function action_listindex() {
   
        $this->validateAgent();
   
        $query = $this->query;
        $data['mode_select'] = $query->get_one();
        $filter = \Input::get('filter');
        $uri = "/{$this->base}/listindex/?";
        
        if(is_array($filter))
            foreach($filter as $where => $value)
                if(!empty($where) && !empty($value))
                {
                    $query->where($where,'like', "%$value%");
                    $uri .="&filter[$where]=$value";
                }   
                
        $created_from = \Input::get('created_from');
        if( !empty($created_from))  {
            $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', strtotime($created_from)))));
            $uri .="&created_from=$created_from";
        } 
        $created_to = \Input::get('created_to');
        if( !empty($created_to))  {
        
            $created_to = date('Y-m-d',strtotime("+1 day", strtotime(date('Y-m-d', strtotime($created_to)))));
            
            $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($created_to)));
            $uri .="&created_to=$created_to";
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
        $info = \Model_Systemconfig::query()->where("name","enablemodule")->get_one();
                $flagarray = array('enableIndividualEmail', 'setCentralEmail','enableCentralEmail');

                if(is_object($info)){
                    $info_val = json_decode($info->value, true);
                    foreach ($flagarray as $flag)                   
                        if(key_exists("$flag", $info_val)){
                                $data["$flag"] = $info_val["$flag"]; 
                                $$flag  = $info_val["$flag"]; 
                            }
                }  

//            $query->related('order');
//            $query->where('order.id','1');
    
        $agent = $this->getAgent();

        if(is_object($agent)){
            if( in_array($agent->allowonlyagentdata, array(1,'1')) ){ 
                $query->where('agent_id',$agent->id);
            }
        }
        

        if(isset($this->arrange_by_created) && !empty($this->arrange_by_created))
            $query->order_by('created_at',$this->arrange_by_created);

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
        $data['filepath'] = $this->filepath;
        $data['folder'] = $this->modulename;
        $data['enableExportCSV'] = $this->getSettingValue('enableExportCSV');
        $data['formIndexTitle'] = $this->getSettingValue('formIndexTitle');

        $this->template->logo = $this->logo;
        $this->template->backgroundimage = $this->backgroundimage;
        $this->template->color_scheme = $this->color_scheme;
        $this->template->logo_width = $this->logo_width;
        $this->template->logo_height = $this->logo_height;
        $this->template->logo_position = $this->logo_position;
        $this->template->logo_portrait_mode = $this->logo_portrait_mode;
        
        $this->template->menuList = $this->getMenuList();
        $this->template->loginmodule = $this->getModuleName();
        $this->template->removesalessoftbar = 0;
        $this->template->addAccessibilityMenu = $this->addAccessibilityMenu;
        
         $this->template->enableIndividualEmail = isset($enableIndividualEmail)?$enableIndividualEmail:'0';
             
        $this->template->content = \View::forge($this->filepath.'/index', $data);

    }    
    
    public function action_index() {
        die();
    }
    