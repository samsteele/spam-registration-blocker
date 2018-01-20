<?php

namespace SamSteele\SpamBlocker\Api;

interface CreationTimerInterface
{
    /**
     * @return null
     */
    public function setStartTime();

    /**
     * @return null
     */
    public function setEndTime();

    /**
     * @return integer
     */
    public function getAccountCreationTime();

    /**
     * @return boolean
     */
    public function validateAccountCreationTime();
}
