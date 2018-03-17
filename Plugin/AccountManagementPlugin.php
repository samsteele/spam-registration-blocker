<?php

namespace SamSteele\SpamBlocker\Plugin;

class AccountManagementPlugin
{
    protected $_helper;
    protected $_creationTimer;

    public function __construct(
        \SamSteele\SpamBlocker\Helper\Data $helper,
        \SamSteele\SpamBlocker\Api\CreationTimerInterface $creationTimer
    ) {
        $this->_helper = $helper;
        $this->_creationTimer = $creationTimer;
    }

    /**
     * @param \Magento\Customer\Model\AccountManagement $subject
     * @param callable $proceed
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param null $password
     * @param string $redirectUrl
     * @return mixed
     */
    public function aroundCreateAccount(
        \Magento\Customer\Model\AccountManagement $subject,
        callable $proceed,
        \Magento\Customer\Api\Data\CustomerInterface $customer,
        $password = null,
        $redirectUrl = ''
    ) {
        $this->_creationTimer->setEndTime();

        if ($this->_helper->isSpamBlockerEnabled()) {
            if (!$this->_creationTimer->validateAccountCreationTime()) {
                // TODO: Handle blocked registrations more elegantly
                // Block account registration
                die($this->_helper->getBlockMessage());
            }
        }

        // Continue with registration as normal
        return $proceed($customer, $password, $redirectUrl);
    }
}
