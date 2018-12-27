<?php

namespace PushNotification\Message;

interface GoogleMessageInterface
{
    /**
     * generate message notification block for fcm
     * @return mixed
     */
    public function notification();
}