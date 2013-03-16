<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IssueController extends AbstractActionController
{
    /**
     * @var \Application\Model\IssuesMapper
     */
    protected $_issuesMapper;

    /**
     * @var \Application\Model\SpentTimeMapper
     */
    protected $_spentTimeMapper;

    protected function _getIssuesMapper()
    {
        if ($this->_issuesMapper == null) {
            $this->_issuesMapper = new \Application\Model\IssuesMapper();
            $this->_issuesMapper->setTable($this->getServiceLocator()->get('\Application\Model\IssuesTable'));
        }

        return $this->_issuesMapper;
    }

    protected function _getSpentTimeMapper()
    {
        if ($this->_spentTimeMapper == null) {
            $this->_spentTimeMapper = new \Application\Model\SpentTimeMapper();
            $this->_spentTimeMapper->setTable($this->getServiceLocator()->get('\Application\Model\SpentTimeTable'));
        }

        return $this->_spentTimeMapper;
    }

    public function listAction()
    {
        $userId = 10;

        $sql    = $this->_getIssuesMapper()->getTable()->getSql();
        $select = $sql->select()
            ->columns(array('id', 'subject', 'done_ratio', 'due_date', 'priority_id', 'start_date', 'fixed_version_id', 'time_estimate' => 'estimated_hours'))
            ->join(array('ep' => 'enumerations'),
                   'ep.id = issues.priority_id',
                   array('priority_position' => 'position'))
            ->join(array('t' => 'trackers'),
                   't.id = issues.tracker_id',
                   array('tracker' => 'name'))
            ->join(array('v' => 'versions'),
                   'v.id = issues.fixed_version_id',
                   array('version' => 'name'))
            ->join(array('p' => 'projects'),
                   'p.id = issues.project_id',
                   array('project_identifier' => 'identifier'))
            ->join(array('pt' => 'projects'),
                   'pt.lft <= p.lft AND pt.rgt >= p.rgt',
                   array('project_tree' => new \Zend\Db\Sql\Expression('GROUP_CONCAT(pt.name ORDER BY pt.lft ASC SEPARATOR " » ")')))
            ->join(array('cv' => 'custom_values'),
                   new \Zend\Db\Sql\Expression('cv.customized_type = "Project" AND cv.customized_id = p.id AND cv.custom_field_id = 37'),
                   array('project_vcs_alias' => 'value'),
                   \Zend\Db\Sql\Select::JOIN_LEFT)
            ->where('issues.assigned_to_id = ' . (int)$userId)
            ->where('issues.status_id NOT IN (17, 5, 25, 32, 37, 42, 46)')
            ->order('ep.position DESC')
            ->order('issues.due_date DESC')
            ->order('issues.subject ASC')
            ->group('issues.id');
        //\Zend\Debug\Debug::dump($sql->getSqlStringForSqlObject($select));

        $adapter = new \Application\Paginator\Adapter\DbSelect($select, $this->_getIssuesMapper()->getTable()->getSql());
        $paginator = new \Zend\Paginator\Paginator($adapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage($this->params()->fromRoute('per-page', 25));

        $issuesIds = array(0);
        $issues = $paginator->getCurrentItems()->toArray();
        foreach ($issues as $issue) {
            $issuesIds[] = $issue['id'];
        }

        $todaySpentTime = $this->_getSpentTimeMapper()->todaySpentTimeByUser($userId);
        $issuesSpentTime = $this->_getIssuesMapper()->calcSpentTimeByIssues($issuesIds, $userId);

        return array(
            'paginator'       => $paginator,
            'issues'          => $issues,
            'todaySpentTime'  => $todaySpentTime,
            'issuesSpentTime' => $issuesSpentTime,
        );
    }
}
