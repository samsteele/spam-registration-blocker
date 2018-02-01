<?php

namespace SamSteele\SpamBlocker\Plugin;

class CreatePlugin
{
    protected $_creationTimer;

    public function __construct(
        \SamSteele\SpamBlocker\Api\CreationTimerInterface $creationTimer
    ) {
        $this->_creationTimer = $creationTimer;
    }

    /**
     * @param \Magento\Customer\Controller\Account\Create $subject
     * @param mixed $result
     * @return mixed
     */
    public function afterExecute(\Magento\Customer\Controller\Account\Create $subject, $result)
    {
        $this->_creationTimer->setStartTime();

        return $result;
    }
}
