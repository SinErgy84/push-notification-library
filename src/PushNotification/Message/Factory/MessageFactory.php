<?php

namespace PushNotification\Message\Factory;

use PushNotification\Exceptions\MessageException;
use PushNotification\Exceptions\PushException;
use PushNotification\Message\Config\MessageConfig;
use PushNotification\Message\Strategy\AndroidMessages;
use PushNotification\Message\Strategy\IOSMessages;

class MessageFactory implements FactoryInterface
{

    /** @var   MessageFactory */
    private static $instance = null;

    /** @var  string  type of message we are going to create */
    private $message;

    /** @var  array data */
    private $data;

    /**
     * MessageFactory constructor.
     */
    private function __construct()
    {

    }

    /**
     * singleton the creation
     * @return MessageFactory
     */
    public static function getInstance()
    {
        if (NULL === self::$instance) {
            self::$instance = new MessageFactory();
        }

        return self::$instance;
    }

    /**
     * @param array $message type of message we are going to create like AndroidMessage
     * @return MessageFactory
     */
    public function setParam($message)
    {
        $this->message = ucfirst($message['type']);

        $this->data = $message;

        $this->validate();

        return $this;
    }

    /**
     * validate the data
     * @return mixed
     * @Exception MessageException
     */
    public function validate()
    {
        if (!isset($this->data['action']) || empty($this->data['action'])
            || !isset($this->data['title']) || empty($this->data['title'])
            || !isset($this->data['body']) || empty($this->data['body'])
            || !isset($this->data['data']) || empty($this->data['data'])
        ) {
            throw new MessageException('invalid data. please check message data');
        }

        return true;
    }

    /**
     * create the strategy
     * @return mixed
     */
    public function create()
    {
        if (!class_exists(MessageConfig::MESSAGE_NAMESPACE . $this->message)) {
            throw new PushException('class does not exist :' . MessageConfig::MESSAGE_NAMESPACE . $this->message);
        }

        $this->message = MessageConfig::MESSAGE_NAMESPACE . $this->message;
        $object = new $this->message();

        $object->setAction($this->data['action'])
            ->setTargets($this->data['targets'])
            ->setTitle($this->data['title'])
            ->setBody($this->data['body'])
            ->setData($this->data['data']);

        if(TRUE === isset($this->data[AndroidMessages::MESSAGE_TYPE]))
        {
            $object->setMessageType($this->data[AndroidMessages::MESSAGE_TYPE]);
        }

        if ($object instanceof IOSMessages)
        {
            if (TRUE === isset($this->data['loc-key']) && '' !== $this->data['loc-key'])
            {
                $object->setLocKey($this->data['loc-key']);
            }

            if (TRUE === isset($this->data['loc-args']) && TRUE === is_array($this->data['loc-args']) && FALSE === empty($this->data['loc-args']))
            {
                $object->setLocArgs($this->data['loc-args']);
            }
        }

        return $object;
    }

}