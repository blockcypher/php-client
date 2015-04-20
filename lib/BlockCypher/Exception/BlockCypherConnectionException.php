<?php

namespace BlockCypher\Exception;

/**
 * Class BlockCypherConnectionException
 *
 * @package BlockCypher\Exception
 */
class BlockCypherConnectionException extends \Exception
{
    /**
     * The url that was being connected to when the exception occurred
     *
     * @var string
     */
    private $url;

    /**
     * Any response data that was returned by the server
     *
     * @var string
     */
    private $data;

    /**
     * Default Constructor
     *
     * @param string $url
     * @param string $message
     * @param int $code
     */
    public function __construct($url, $message, $code = 0)
    {
        parent::__construct($message, $code);
        $this->url = $url;
    }

    /**
     * Gets Data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets Data
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Gets Url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
