<?php

namespace Application\Model;

class SpentTimeMapper extends \Application\Model\EntityMapper
{
    protected $_table = 'time_entries';

    protected $_modelName = '\Application\Model\SpentTimeModel';

    public function todaySpentTimeByUser($userId)
    {
        $sql = $this->getTable()->getSql();

        $select = $this->getTable()->getSql()->select()
            ->where(array('spent_on' => date('Y-m-d')))
            ->where(array('user_id' => (int)$userId))
            ->columns(array('total_hours' => new \Zend\Db\Sql\Expression('SUM(hours)')));
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        if ($result->count() > 0) {
            $row = $result->current();
            return $row['total_hours'];
        }

        return 0;
    }
}