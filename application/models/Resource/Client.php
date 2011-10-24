<?php
class Application_Model_Resource_Client extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Client_Interface 
{
    protected $_name = 'client';
    protected $_primary = 'publicKey';
    protected $_rowClass = 'Application_Model_Resource_Client_Item';

    public function getClientByPublicKey($publicKey)
    {
        return $this->find($publicKey)->current();
    }

    public function getClients($paged=false, $order=null)
    {
		$select = $this->select();

        if (true === is_array($order)) {
            $select->order($order);
        }

        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$count = clone $select;
			$count->reset(Zend_Db_Select::COLUMNS);
			$count->reset(Zend_Db_Select::FROM);
			$count->from('client', new Zend_Db_Expr('COUNT(*) AS `zend_paginator_row_count`'));
			$adapter->setRowCount($count);

			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(5)->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }
}