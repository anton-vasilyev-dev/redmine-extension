<?php

namespace Application\Model;

class IssueModel extends \Application\Model\EntityModel
{
    protected $_subject;

    protected $_dueDate;

    protected $_doneRatio;

    protected $_priorityId;

    protected $_priority;

    protected $_status;

    protected $_tracker;

    public function setSubject($subject)
    {
        $this->_subject = $subject;
        return $this;
    }

    public function getSubject()
    {
        return $this->_subject;
    }

    public function setDueDate($dueDate)
    {
        $this->_dueDate = $dueDate;
        return $this;
    }

    public function getDueDate()
    {
        return $this->_dueDate;
    }

    public function setDoneRatio($doneRatio)
    {
        $this->_doneRatio = $doneRatio;
        return $this;
    }

    public function getDoneRatio()
    {
        return $this->_doneRatio;
    }

    public function setPriorityId($priorityId)
    {
        $this->_priorityId = $priorityId;
        return $this;
    }

    public function getPriorityId()
    {
        return $this->_priorityId;
    }

    public function setPriority($priority)
    {
        $this->_priority = $priority;
        return $this;
    }

    public function getPriority()
    {
        return $this->_priority;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setTracker($tracker)
    {
        $this->_tracker = $tracker;
        return $this;
    }

    public function getTracker()
    {
        return $this->_tracker;
    }
}