<?php
class Application_Model_Resource_Tour extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Tour_Interface 
{
    protected $_name = 'tour';
    protected $_primary = 'id';
    protected $_rowClass = 'Application_Model_Resource_Tour_Item';

    public function getTourById($id)
    {
        return $this->find($id)->current();
    }

    public function getTours($paged=null, $order=null)
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
            $count->from('tour', new Zend_Db_Expr('COUNT(*) AS `zend_paginator_row_count`'));
            $adapter->setRowCount($count);

            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(5)
                        ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
}