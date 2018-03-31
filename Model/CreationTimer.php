<?php

namespace SamSteele\SpamBlocker\Model;

use SamSteele\SpamBlocker\Api\CreationTimerInterface;

class CreationTimer extends \Magento\Framework\Model\AbstractModel implements CreationTimerInterface
{
    protected $_helper;
    protected $_dateTime;
    protected $_customerSession;

    public function __construct(
        \SamSteele\SpamBlocker\Helper\Config $helper,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_helper = $helper;
        $this->_dateTime = $dateTime;
        $this->_customerSession = $customerSession;
    }

    /**
     * @return void
     */
    public function setStartTime()
    {
        // Called after account create form is hit
        $this->_customerSession->setRegistrationStartTime($this->_dateTime->timestamp());
    }

    /**
     * @return void
     */
    public function setEndTime()
    {
        // Called before account creation is executed
        $this->_customerSession->setRegistrationEndTime($this->_dateTime->timestamp());
    }

    /**
     * @return integer
     */
    public function getAccountCreationTime()
    {
        $registrationStartTime = $this->_customerSession->getRegistrationStartTime();
        $registrationEndTime = $this->_customerSession->getRegistrationEndTime();

        return $registrationEndTime - $registrationStartTime;
    }

    /**
     * @return boolean
     */
    public function validateAccountCreationTime()
    {
        if ($this->_helper->isRegistrationTimerEnabled()) {

            $minRegistrationTime = $this->_helper->getMinRegistrationTime();
            return $this->getAccountCreationTime() > $minRegistrationTime;

        }

        return true;
    }
}
