<?php

namespace Application\Paginator\Adapter;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\ResultSet\ResultSet;

class DbSelect extends \Zend\Paginator\Adapter\DbSelect
{
    /**
     * Returns the total number of rows in the result set.
     *
     * @return integer
     */
    public function count()
    {
        if ($this->rowCount !== null) {
            return $this->rowCount;
        }

        $select = clone $this->select;
        $select->reset(Select::COLUMNS);
        $select->reset(Select::LIMIT);
        $select->reset(Select::OFFSET);
        $select->reset(Select::ORDER);
        $select->reset(Select::GROUP);

        // get join information, clear, and repopulate without columns
        $joins = $select->getRawState(Select::JOINS);
        $select->reset(Select::JOINS);
        foreach ($joins as $join) {
            $select->join($join['name'], $join['on'], array(), $join['type']);
        }

        $select->columns(array('c' => new Expression('COUNT(DISTINCT ' . $select->getRawState(Select::TABLE) . '.id)')));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
        $row       = $result->current();

        $this->rowCount = $row['c'];

        return $this->rowCount;
    }
}