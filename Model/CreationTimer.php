<?php

namespace SamSteele\SpamBlocker\Model;

use SamSteele\SpamBlocker\Api\CreationTimerInterface;

class CreationTimer extends \Magento\Framework\Model\AbstractModel implements CreationTimerInterface
{

    protected $_startTime;
    protected $_endTime;
    protected $_creationTime;
    protected $_dateTime;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_dateTime = $dateTime;
    }

    /**
     * @return void
     */
    public function setStartTime()
    {
        // Set start time - called after account create form is hit
        $this->_startTime = $this->_dateTime->timestamp();
    }

    /**
     * @return void
     */
    public function setEndTime()
    {
        // Set end time - called before account creation is carried out
        $this->_endTime = $this->_dateTime->timestamp();
    }

    /**
     * @return integer
     */
    public function getAccountCreationTime()
    {
        // Calculate time between hitting account creation form and submitting it
        $this->_creationTime = $this->_endTime - $this->_startTime;

        return $this->_creationTime;
    }

    /**
     * @return boolean
     */
    public function validateAccountCreationTime()
    {
        // TODO: Dummy threshold value - get from store config

        echo "start = " . $this->_startTime;
        echo "end = " . $this->_endTime;
        die();

        if ($this->getAccountCreationTime() < 20) {
            return true;
        } else {
            return false;
        }
    }

}
