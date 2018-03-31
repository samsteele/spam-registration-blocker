<?php

namespace SamSteele\SpamBlocker\Plugin;

class AccountManagementPlugin
{
    protected $_helper;
    protected $_creationTimer;
    protected $_messageManager;
    protected $_escaper;
    protected $_request;

    public function __construct(
        \SamSteele\SpamBlocker\Helper\Config $helper,
        \SamSteele\SpamBlocker\Api\CreationTimerInterface $creationTimer,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Escaper $_escaper,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->_helper = $helper;
        $this->_creationTimer = $creationTimer;
        $this->_messageManager = $messageManager;
        $this->_escaper = $_escaper;
        $this->_request = $request;
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

            // Block if account created too quickly
            if (!$this->_creationTimer->validateAccountCreationTime()) {
                $this->blockRegistration();
            }

            // Block if honeypot field is filled out
            if ($this->_request->getParam($this->_helper->getHoneyPotFieldName())) {
                $this->blockRegistration();
            }
        }

        // Continue with registration as normal
        return $proceed($customer, $password, $redirectUrl);
    }

    /**
     * @return null
     */
    protected function blockRegistration()
    {
        // Return to homepage with error message
        $this->_messageManager->addError($this->_escaper->escapeHtml($this->_helper->getBlockMessage()));
        header('Location: ' . '/');
        exit();
    }
}
