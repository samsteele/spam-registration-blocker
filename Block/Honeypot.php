<?php

namespace SamSteele\SpamBlocker\Block;

class Honeypot extends \Magento\Framework\View\Element\Template
{ 
    protected $_helper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \SamSteele\SpamBlocker\Helper\Config $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_helper = $helper;
    }

    /**
     * @return boolean
     */
    public function useHoneyPot()
    {
        return $this->_helper->isHoneyPotEnabled($this->getRequest()->getFullActionName());
    }

    /**
     * @return string
     */
    public function getHoneyPotFieldName()
    {
        return $this->_helper->getHoneypotFieldName();
    }
}