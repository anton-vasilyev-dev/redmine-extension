<?php

namespace Application\Model;

class IssuesMapper extends \Application\Model\EntityMapper
{
    protected $_table = 'issues';

    protected $_modelName = '\Application\Model\IssueModel';

    public function calcSpentTimeByIssues($issuesIds, $userId)
    {
        $issues = array();
        foreach ($issuesIds as $id) {
            $issues[$id]['hours'] = 0;
        }

        $sql = $this->getTable()->getSql();

        $select = $this->getTable()->getSql()->select()
            ->join(array('ri' => 'issues'),
                   'ri.lft >= issues.lft AND ri.rgt <= issues.rgt AND ri.root_id = issues.id',
                   array())
            ->join(array('teri' => 'time_entries'),
                   'teri.issue_id = ri.id',
                   array())
            ->where(array('issues.id' => $issuesIds))
            ->where(array('ri.assigned_to_id' => (int)$userId))
            ->where(array('teri.user_id' => (int)$userId))
            ->columns(array('id', 'hours' => new \Zend\Db\Sql\Expression('SUM(teri.hours)')))
            ->group('issues.id');
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        foreach ($result as $row) {
            $issues[$row['id']]['hours'] = $row['hours'];
        }

        return $issues;
    }
}