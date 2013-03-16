<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $_issuesMapper;

    protected function _getIssuesMapper()
    {
        if ($this->_issuesMapper == null) {
            $this->_issuesMapper = new \Application\Model\IssuesMapper();
            $this->_issuesMapper->setTable($this->getServiceLocator()->get('\Application\Model\IssuesTable'));
        }

        return $this->_issuesMapper;
    }

    public function indexAction()
    {
        $adapter = new \Zend\Paginator\Adapter\DbSelect(
            $this->_getIssuesMapper()->getTable()->getSql()
                ->select()
                ->columns(array('id', 'subject', 'done_ratio', 'due_date', 'priority_id'))
                ->join(array('ep' => 'enumerations'),
                             'ep.id = priority_id',
                       array())
                ->join(array('t' => 'trackers'),
                             't.id = tracker_id',
                       array('tracker' => 'name'))
                ->where('assigned_to_id = 10')
                ->where('status_id NOT IN (17, 5, 25, 32, 37, 42, 46)')
                ->order('ep.position DESC')
                ->order('due_date DESC')
                ->order('subject ASC'),
            $this->_getIssuesMapper()->getTable()->getAdapter()
        );
        $paginator = new \Zend\Paginator\Paginator($adapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage($this->params()->fromRoute('per-page', 25));

        return array(
            'paginator' => $paginator,
        );
    }
}
