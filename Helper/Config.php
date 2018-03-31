<?php

namespace SamSteele\SpamBlocker\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{

    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return boolean
     */
    public function isSpamBlockerEnabled()
    {
        return $this->_scopeConfig->getValue('spamblocker/general/enable');
    }

    /**
     * @return string
     */
    public function getBlockMessage()
    {
        return $this->_scopeConfig->getValue('spamblocker/general/block_message');
    }

    /**
     * @return boolean
     */
    public function isRegistrationTimerEnabled()
    {
        return $this->_scopeConfig->getValue('spamblocker/registration_timer/enable_registration_timer');
    }

    /**
     * @return string
     */
    public function getMinRegistrationTime()
    {
        return $this->_scopeConfig->getValue('spamblocker/registration_timer/min_registration_time');
    }

    /**
     * @return string
     */
    public function isHoneyPotEnabled($action)
    {
        // Config keys match action names - eg, customer_account_create
        return $this->_scopeConfig->getValue('spamblocker/honeypot_field/' . $action);
    }

    /**
     * @return string
     */
    public function getHoneyPotFieldName()
    {
        return $this->_scopeConfig->getValue('spamblocker/honeypot_field/honeypot_field_name');
    }
}
