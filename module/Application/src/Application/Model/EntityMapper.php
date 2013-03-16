<?php

namespace Application\Model;

use Exception;

class EntityMapper
{
    /**
     * @var \Zend\Db\TableGateway\TableGateway
     */
    protected $_table;

    protected $_modelName;

    public function setTable(\Zend\Db\TableGateway\TableGateway $table)
    {
        if (is_string($table)) {
            $table = new $table();
        }
        if (!$table instanceof \Zend\Db\TableGateway\TableGateway) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_table = $table;
        return $this;
    }

    /**
     * @return \Zend\Db\TableGateway\TableGateway
     */
    public function getTable()
    {
        return $this->_table;
    }

    public function save(EntityModel $model)
    {
        $data = $model->getArrayCopy();

        if (null == ($id = $model->getId())) {
            unset($data['id']);
            $this->getTable()->insert($data);
            return $this->getTable()->getLastInsertValue();
        } else {
            $this->getTable()->update($data, array('id = ?' => $id));
            return $id;
        }
    }

    public function find($id)
    {
        $result = $this->getTable()->select(array('id' => $id));
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        /**
         * @var EntityModel
         */
        $model = new $this->_modelName();
        $model->exchangeArray($row->getArrayCopy());

        return $model;
    }

    /**
     * @return EntityModel
     */
    public function create()
    {
        return new $this->_modelName();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new $this->_modelName();
            $entry->exchangeArray($row->toArray());
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id)
    {
        $this->getTable()->delete(array(
            'id' => $id
        ));
    }
}