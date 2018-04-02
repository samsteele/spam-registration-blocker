<?php

namespace SamSteele\SpamBlocker\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Spam extends Base
{
    protected $fileName = '/var/log/spamblocker.log';
    protected $loggerType = Logger::INFO;
}