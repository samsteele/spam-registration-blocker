<?php

namespace SamSteele\SpamBlocker\Model;

use SamSteele\SpamBlocker\Api\CreationTimerInterface;

class CreationTimer extends \Magento\Framework\Model\AbstractModel implements CreationTimerInterface
{

    protected $_startTime;
    protected $_endTime;
    protected $_creationTime;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

    }

    /**
     * @return void
     */
    public function setStartTime()
    {
        // TODO: Dummy value - get time from Magento
        // Set start time - called after account create form is hit
        $this->_startTime = 20;
    }

    /**
     * @return void
     */
    public function setEndTime()
    {
        // TODO: Dummy value - get time from Magento
        // Set end time - called before account creation is carried out
        $this->_endTime = 30;
    }

    /**
     * @return integer
     */
    public function getAccountCreationTime()
    {
        // TODO: Dummy setters - move to appropriate plugins
        $this->setStartTime();
        $this->setEndTime();

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
        if ($this->getAccountCreationTime() < 20) {
            return true;
        } else {
            return false;
        }
    }

}
