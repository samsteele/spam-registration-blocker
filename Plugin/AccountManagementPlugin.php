<?php

namespace SamSteele\SpamBlocker\Plugin;

class AccountManagementPlugin
{
    protected $_helper;
    protected $_creationTimer;
    protected $_messageManager;
    protected $_escaper;

    public function __construct(
        \SamSteele\SpamBlocker\Helper\Config $helper,
        \SamSteele\SpamBlocker\Api\CreationTimerInterface $creationTimer,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Escaper $_escaper
    ) {
        $this->_helper = $helper;
        $this->_creationTimer = $creationTimer;
        $this->_messageManager = $messageManager;
        $this->_escaper = $_escaper;
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

                $this->_messageManager->addError($this->_escaper->escapeHtml($this->_helper->getBlockMessage()));
                header('Location: ' . '/');
                exit();
            }
        }

        // Continue with registration as normal
        return $proceed($customer, $password, $redirectUrl);
    }
}
