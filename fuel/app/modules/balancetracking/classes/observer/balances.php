<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Created At 
 * @version    1.6
 * @author     Parikrama Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Parikrama-Tech
 * @link       http://parikrama-tech.in
 */
namespace balancetracking;

/**
 * CreatedAt observer. Makes sure the created timestamp column in a Model record
 * gets a value when a new record is inserted in the database.
 */
class Observer_Balances extends \Orm\Observer
{
	/**
	 * @var  string   
         * 2 - creditorders
         * 3 - customerbalances /customer
         * 4 - priceoffers
         * 5 - deliverys
         * 6 - orders
         * 7 - receiptinvoices
         * 8 - payments
         * 9 - quotes
	 */
	public static $transaction_type = '';
        
        /**
	 * @var  string   
	 */
	protected $_transaction_type;
        
	protected static $new;


	/**
	 * Set the properties for this observer instance, based on the parent model's
	 * configuration or the defined defaults.
	 *
	 * @param  string  Model class this observer is called on
	 */
	public function __construct($class)
	{
            $temp  = isset($class::$_transaction_type)?$class::$_transaction_type:static::$transaction_type;
            
	}
        
        public function getType($temp) {
            
            $type = '';
            
            switch ($temp){
                case 2 : $type = 'creditorders';break;
                
                case 3 : $type = 'customer';break;
                
                case 4 : $type = 'priceoffers';break;
                
                case 5 : $type = 'deliverys';break;
                
                case 6 : $type = 'orders';break;
                
                case 7 : $type = 'receiptinvoices';break;
                
                case 8 : $type = 'payments'; break;
                
                case 9 : $type = 'quotes'; break;
                
                default : $type = 'customer'; break; 
            }
            
            return $type;
        }
        
	public function before_save($obj) { 
            
           static::$new = $obj->get_isNew();
           
            if(static::$new == false  && is_object($obj) && $obj->is_changed('balance')){
                $original =  $obj->get_original();
                
                if(!empty($original)){
                    $this->saveBalance($obj,$original); 
                }
            }
	}
	
	public function after_save($obj) { 
            
            $is_new = static::$new;
            
            if($is_new && is_object($obj)){
                
                $this->saveBalance($obj); 
            }
	}
        
        public function saveBalance($obj,$original = null) {
            
            \Module::load('balancetracking');
            
            if(isset($obj->transaction_type)){
                $temp = $obj->transaction_type;
            }else {
                $temp = 3;
            }
            
            $type = $this->getType($temp);                
                        
            \balancetracking\Controller_Balancemovements::addBalance($original, $obj,$type); 
           
        }
        
        
}
