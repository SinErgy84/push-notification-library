<?php


namespace PushNotification\Message\Strategy;

use PushNotification\Message\BasicMessageAbstract;
use PushNotification\Message\GoogleMessageInterface;
use PushNotification\Message\Config\Provider;

/**
 * Class AndroidMessages
 * @package PushNotification\Message\Strategy
 */
class AndroidMessages extends BasicMessageAbstract implements GoogleMessageInterface
{

    public function __construct()
    {
        $this->setProvider(Provider::google());
    }

    /**
     * create full message
     * @param string $provider
     * @return mixed
     */
    public function make($provider = null)
    {
        $message = array(
            'registration_ids' => $this->targets(),
            'priority' => 'high',
            'notification' => $this->notification(),
            'data' => $this->data()
        );

        return $message;
    }

    /**
     * @return mixed
     */
    public function targets()
    {
        return $this->targets;
    }

    /**
     * generate message notification block for fcm
     * @return mixed
     */
    public function notification()
    {
        return array(
            'title' => $this->title,
            'body' => $this->body,
            "sound" => "default"
        );
    }

    /**
     * create message
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }

}