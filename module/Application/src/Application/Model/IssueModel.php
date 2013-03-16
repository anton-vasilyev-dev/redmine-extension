<?php

namespace Application\Model;

class IssueModel extends \Application\Model\EntityModel
{
    protected $_subject;

    protected $_dueDate;

    protected $_doneRatio;

    protected $_startDate;

    protected $_timeSpent;

    protected $_timeEstimate;


    protected $_trackerId;

    protected $_tracker;


    protected $_projectId;

    protected $_projectTree;

    protected $_projectIdentifier;

    protected $_projectVcsAlias;


    protected $_fixedVersionId;

    protected $_version;


    protected $_priorityId;

    protected $_priority;

    protected $_priorityPosition;


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

    public function setStartDate($startDate)
    {
        $this->_startDate = $startDate;
        return $this;
    }

    public function getStartDate()
    {
        return $this->_startDate;
    }

    public function setPriorityPosition($priorityPosition)
    {
        $this->_priorityPosition = $priorityPosition;
        return $this;
    }

    public function getPriorityPosition()
    {
        return $this->_priorityPosition;
    }

    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    public function getVersion()
    {
        return $this->_version;
    }

    public function setFixedVersionId($versionId)
    {
        $this->_fixedVersionId = $versionId;
        return $this;
    }

    public function getFixedVersionId()
    {
        return $this->_fixedVersionId;
    }

    public function setProjectId($projectId)
    {
        $this->_projectId = $projectId;
        return $this;
    }

    public function getProjectId()
    {
        return $this->_projectId;
    }

    public function setTrackerId($trackerId)
    {
        $this->_trackerId = $trackerId;
        return $this;
    }

    public function getTrackerId()
    {
        return $this->_trackerId;
    }

    public function setProjectTree($projectTree)
    {
        $this->_projectTree = $projectTree;
        return $this;
    }

    public function getProjectTree()
    {
        return $this->_projectTree;
    }

    public function setTimeEstimate($timeEstimate)
    {
        $this->_timeEstimate = $timeEstimate;
        return $this;
    }

    public function getTimeEstimate()
    {
        return $this->_timeEstimate;
    }

    public function setTimeSpent($timeSpent)
    {
        $this->_timeSpent = $timeSpent;
        return $this;
    }

    public function getTimeSpent()
    {
        return $this->_timeSpent;
    }

    public function setProjectIdentifier($projectIdentifier)
    {
        $this->_projectIdentifier = $projectIdentifier;
        return $this;
    }

    public function getProjectIdentifier()
    {
        return $this->_projectIdentifier;
    }

    public function setProjectVcsAlias($projectVcsAlias)
    {
        $this->_projectVcsAlias = $projectVcsAlias;
        return $this;
    }

    public function getProjectVcsAlias()
    {
        return $this->_projectVcsAlias;
    }
}