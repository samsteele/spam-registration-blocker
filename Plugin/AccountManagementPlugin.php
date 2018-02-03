<?php

namespace SamSteele\SpamBlocker\Plugin;

class AccountManagementPlugin
{
    protected $_creationTimer;

    public function __construct(
        \SamSteele\SpamBlocker\Api\CreationTimerInterface $creationTimer
    ) {
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

        // Compare account creation time against value set in config
        if ($this->_creationTimer->validateAccountCreationTime()) {
            // Continue with registration as normal
            return $proceed($customer, $password, $redirectUrl);
        } else {
            // TODO: Handle blocked registrations more elegantly
            // Block account registration
            die("BLOCKED AS SPAM");
        }
    }
}
