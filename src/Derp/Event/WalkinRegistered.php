<?php

namespace Derp\Event;

use SimpleBus\Message\Message;

class WalkinRegistered implements Message
{
    private $indication;

    /**
     * Constructor
     *
     * @param string $indication
     */
    public function __construct($indication)
    {
        $this->indication = $indication;
    }

    /**
     * @return mixed
     */
    public function indication()
    {
        return $this->indication;
    }
}
