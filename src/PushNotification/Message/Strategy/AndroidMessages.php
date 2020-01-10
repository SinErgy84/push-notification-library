<?php


namespace PushNotification\Message\Strategy;

use PushNotification\Message\BasicMessageAbstract;
use PushNotification\Message\Config\Provider;
use PushNotification\Message\GoogleMessageInterface;

/**
 * Class AndroidMessages
 *
 * @package PushNotification\Message\Strategy
 */
class AndroidMessages extends BasicMessageAbstract implements GoogleMessageInterface
{
    public const MESSAGE_TYPE              = 'message_type';
    public const MESSAGE_TYPE_DATA         = 'message_type_data';
    public const MESSAGE_TYPE_NOTIFICATION = 'message_type_notification';


    public function __construct()
    {
        $this->setProvider(Provider::google());
    }

    /**
     * create full message
     *
     * @param string $provider
     *
     * @return mixed
     */
    public function make($provider = null)
    {
        $notification = $this->notification();

        $message      = array(
            'registration_ids' => $this->targets(),
            'priority'         => 'high',
            'data'             => $this->data()
        );

        if (self::MESSAGE_TYPE_DATA === $this->getMessageType())
        {
            $message['data'] = array_merge($message['data'], $notification);
        }
        else
        {
            $message['notification'] = $notification;
        }


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
     *
     * @return mixed
     */
    public function notification()
    {
        return array(
            'title' => $this->title,
            'body'  => $this->body,
            "sound" => "default"
        );
    }

    /**
     * create message
     *
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }

}