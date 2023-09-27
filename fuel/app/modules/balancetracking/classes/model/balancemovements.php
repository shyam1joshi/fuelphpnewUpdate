<?php

namespace balancetracking;

class Model_Balancemovements extends \Model_Base
{
    protected static $_properties = array (
        'id' =>  array (
                        'label' => 'label.quotes.id',
                        'data_type' => 'int',
                      ),


        'document_type' =>  array (
                          'label' => 'label.customercards.document_type',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'ordername' =>  array (
                          'label' => 'label.customercards.ordername',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'customer_id' =>  array (
                          'label' => 'label.orders.customer_id',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'balance_before' =>  array (
                          'label' => 'label.quantities.balance_before',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'balance_difference' =>  array (
                          'label' => 'label.quantities.balance_difference',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'current_balance' =>  array (
                          'label' => 'label.customers.balance',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'transaction_type' =>  array (
                          'label' => 'label.quotes.transaction_type',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'agent_id' =>  array (
                          'label' => 'label.quotes.agent_id',
                          'data_type' => 'int',
                          'listview'=>true,
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),              
        'create_uid' =>  array (
                              'label' => 'label.quotes.create_uid',
                              'data_type' => 'int',
                              'form' => 
                              array (
                                'type' => false,
                              ),
                            ),
        'update_uid' => array (
                              'label' => 'label.quotes.update_uid',
                              'data_type' => 'int',
                              'form' => 
                              array (
                                'type' => false,
                              ),
                            ),

        'created_at' => array (
                          'listview' => true,
                          'label' => 'label.quotes.created_at',
                          'data_type' => 'date',
                          'form' => 
                          array (
                            'type' => 'text',
                          ),
                        ),
        'updated_at' => array (
                          'label' => 'label.quotes.updated_at',
                          'data_type' => 'date',
                          'form' => 
                          array (
                            'type' => false,
                          ),
                        ),
    );
    
    protected static $_has_one = array(
            'agent' => array(
                        'key_from' => 'agent_id',
                        'model_to' => '\\Model_Agents',
                        'key_to' => 'id',
                        'cascade_save' => true,
                        'cascade_delete' => false,
                    ),
            'customer' => array(
                        'key_from' => 'customer_id',
                        'model_to' => '\\Model_Customers',
                        'key_to' => 'id',
                        'cascade_save' => true,
                        'cascade_delete' => false,
                    ),
    );
    
    
    static function query($options = array()){
        
        $query = parent::query($options);
        
        return $query->order_by('id', 'desc');
    }
}