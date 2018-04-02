<?php

namespace SamSteele\SpamBlocker\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    protected $_scopeConfig;
    protected $_escaper;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_escaper = $escaper;
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
        return $this->_escaper->escapeHtml($this->_scopeConfig->getValue('spamblocker/general/block_message'));
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
        return $this->_escaper->escapeHtml($this->_scopeConfig->getValue('spamblocker/honeypot_field/honeypot_field_name'));
    }
}
