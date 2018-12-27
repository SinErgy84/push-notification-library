<?php


namespace PushNotification\Message\Strategy;

use PushNotification\Message\AppleMessageInterface;
use PushNotification\Message\BasicMessageAbstract;
use PushNotification\Message\Config\Provider;

/**
 * Class IOSMessages
 * @package PushNotification\Message\Strategy
 */
class IOSMessages extends BasicMessageAbstract implements AppleMessageInterface
{

    use Provider;

    /** string , send badge as default 1 */
    const DEFAULT_BADGE = 1;

    /** string default sound at push  */
    const DEFAULT_SOUND = 'bingbong.aiff';

    /** @var */
    private $id;

    /** @var string */
    private $token;

    /** @var int */
    private $expire = 100;

    /** @var string */
    private $loc_key;

    /** @var array */
    private $loc_args;

    public function __construct()
    {
        $this->setProvider(Provider::apple());
    }


    /**
     * create full message
     * @param string $provider
     * @return mixed
     */
    public function make($provider = null)
    {
        $message = array(
            'aps' => $this->aps(),
            'data' => $this->data(),
        );

        $payload = json_encode($message, JSON_UNESCAPED_UNICODE);
        $length = strlen($payload);

        return pack('CNNnH*', 1, $this->id, $this->expire, 32, $this->token)
            . pack('n', $length)
            . $payload;
    }

    /**
     * generate aps message block for apns
     * @return mixed
     */
    public function aps()
    {
        $alert_content = array(
            'title' => $this->title,
            'body'  => $this->body,
        );

        if (NULL !== $this->loc_key)
        {
            $alert_content['loc-key'] = $this->loc_key;
        }

        if (TRUE === is_array($this->loc_args) && FALSE === empty($this->loc_args))
        {
            $alert_content['loc-args'] = $this->loc_args;
        }

        return array(
            'alert'             => $alert_content,
            'content-available' => 1,
            'badge'             => $this->getBadge(),
            'sound'             => $this->getSound(),
        );

    }

    /**
     * @return int
     */
    private function getBadge()
    {
        return self::DEFAULT_BADGE;
    }

    private function getSound()
    {
        return self::DEFAULT_SOUND;
    }

    /**
     * create message
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function targets()
    {
        return $this->targets;
    }

    /**
     * set the unique id for message
     *
     * @param $id
     *
     * @return IOSMessages
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * set the token for message
     *
     * @param string $token
     *
     * @return IOSMessages
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $loc_key
     *
     * @return IOSMessages
     */
    public function setLocKey($loc_key)
    {
        $this->loc_key = $loc_key;

        return $this;
    }

    /**
     * @param array $loc_args
     *
     * @return IOSMessages
     */
    public function setLocArgs(array $loc_args)
    {
        $this->loc_args = $loc_args;

        return $this;
    }
}