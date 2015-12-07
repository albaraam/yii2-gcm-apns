<?php
/**
 * Created by Albaraa Mishlawi.
 * User: Albaraa
 * Date: 12/7/2015
 * Time: 2:31 PM
 */

namespace albaraam\yii2_gcm_apns;


use albaraam\gcmapns\Client;
use albaraam\gcmapns\Message;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * @property mixed _client
 */
class GcmApns extends Component
{
    const ENVIRONMENT_SANDBOX = 1;
    const ENVIRONMENT_PRODUCTION = 2;

    private $_client;

    // Android Configs
    // ================

    public $google_api_key;

    // IOS Configs
    // ============

    public $pem_file;

    public $environment;

    public $passphrase;

    public $provider_certificate_passphrase;

    public $root_certification_authority;

    public $write_interval;

    public $connect_timeout;

    public $connect_retry_times;

    public $connect_retry_interval;

    public $socket_select_timeout;

    public $logger;


    public function init()
    {
        foreach (['google_api_key', 'pem_file', 'environment'] as $attribute) {
            if ($this->$attribute === null) {
                throw new InvalidConfigException(strtr('"{class}::{attribute}" cannot be empty.', [
                    '{class}' => static::className(),
                    '{attribute}' => '$' . $attribute
                ]));
            }
        }

        parent::init();
    }


    /**
     * @param $title
     * @param $body
     * @return Message
     */
    public function messageBuilder($title, $body){
        return new Message($title, $body);
    }

    /**
     * @param Message $message
     * @return array
     */
    public function send(Message $message){
        return $this->getClient()->send($message);
    }

    /**
     * @param Message $message
     * @return \albaraam\gcm\GCMResponse
     */
    public function sendAndroid(Message $message){
        return $this->getClient()->sendAndroid($message);
    }

    /**
     * @param Message $message
     * @return array
     */
    public function sendIOS(Message $message){
        return $this->getClient()->sendIOS($message);
    }

    public function getClient(){
        if($this->_client == null){
            $this->_client = new Client($this->google_api_key, $this->pem_file, $this->environment);
            if(!empty($this->passphrase)){
                $this->_client->setIosPassphrase($this->passphrase);
            }
            if(!empty($this->provider_certificate_passphrase)){
                $this->_client->setIosProviderCertificatePassphrase($this->provider_certificate_passphrase);
            }
            if(!empty($this->root_certification_authority)){
                $this->_client->setIosRootCertificationAuthority($this->root_certification_authority);
            }
            if(!empty($this->write_interval)){
                $this->_client->setIosWriteInterval($this->write_interval);
            }
            if(!empty($this->connect_timeout)){
                $this->_client->setIosConnectTimeout($this->connect_timeout);
            }
            if(!empty($this->connect_retry_times)){
                $this->_client->setIosConnectRetryTimes($this->connect_retry_times);
            }
            if(!empty($this->connect_retry_interval)){
                $this->_client->setIosConnectRetryInterval($this->connect_retry_interval);
            }
            if(!empty($this->socket_select_timeout)){
                $this->_client->setIosSocketSelectTimeout($this->socket_select_timeout);
            }
            if(!empty($this->logger)){
                $this->_client->setIosLogger($this->logger);
            }
        }
        return $this->_client;
    }

}