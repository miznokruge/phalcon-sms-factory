<?php
namespace SMSFactory\Providers;

use SMSFactory\Aware\ClientProviders\CurlTrait;
use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Exceptions\BaseException;

/**
 * Class SmsUkraine. SmsUkraine Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see http://smsukraine.com.ua/techdocs/
 */
class SmsUkraine implements ProviderInterface
{

    /**
     * Using Curl client (you can make a change to Stream)
     */
    use CurlTrait;

    /**
     * Recipient of message
     *
     * @var null|int
     */
    private $recipient = null;

    /**
     * Provider config object
     *
     * @var \SMSFactory\Config\SmsUkraine $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\SmsUkraine $config
     */
    public function __construct(\SMSFactory\Config\SmsUkraine $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return SmsUkraine
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get server response info
     *
     * @param \Phalcon\Http\Client\Response $response
     * @return \Phalcon\Http\Client\Response|string
     * @throws BaseException
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {
        // this is not json response, parse as string
        if (stripos($response->body, 'errors') !== false) {

            // have an error
            preg_match_all('/errors:([\w].*)/iu', $response->body, $matches);

            $matches = array_filter($matches);

            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), implode('.', $matches[0]));
        }

        return ($this->debug === true) ? [$response->header, $response] : $response->body;

    }

    /**
     * Final send function
     *
     * @param string $message
     * @return \Phalcon\Http\Client\Response|string
     */
    final public function send($message)
    {

        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getMessageUri(), array_merge(
                $this->config->getProviderConfig(), [
                    'command' => 'send',
                    'to' => $this->recipient,
                    'message' => $message,
                ])
        );

        return $this->getResponse($response);
    }

    /**
     * Final check balance function
     *
     * @return \Phalcon\Http\Client\Response|string
     * @throws BaseException
     */
    final public function balance()
    {

        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getBalanceUri(), array_merge(
                $this->config->getProviderConfig(), [
                    'command' => 'balance'
                ])
        );

        return $this->getResponse($response);
    }
}
