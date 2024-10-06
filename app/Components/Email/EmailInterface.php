<?php

namespace App\Components\Email;

interface EmailInterface
{
    /**
     * Send email
     *
     * @param array $args
     */
    public function send($args);
}
