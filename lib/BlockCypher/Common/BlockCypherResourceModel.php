<?php

namespace BlockCypher\Common;

use BlockCypher\Rest\ApiContext;
use BlockCypher\Rest\IResource;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class BlockCypherResourceModel
 * An Executable BlockCypherModel Class
 *
 * @property \BlockCypher\Api\Links[] links
 * @package BlockCypher\Common
 */
class BlockCypherResourceModel extends BlockCypherModel implements IResource
{
    /**
     * Execute SDK Call to BlockCypher services
     *
     * @param string $url
     * @param string $method
     * @param string $payLoad
     * @param array $headers
     * @param ApiContext $apiContext
     * @param BlockCypherRestCall $restCall
     * @param array $handlers
     * @return string json response of the object
     */
    protected static function executeCall(
        $url,
        $method,
        $payLoad,
        $headers = array(),
        $apiContext = null,
        $restCall = null,
        $handlers = array('BlockCypher\Handler\TokenRestHandler')
    )
    {
        //Initialize the context and rest call object if not provided explicitly
        $apiContext = $apiContext ? $apiContext : new ApiContext(self::$credential);
        $restCall = $restCall ? $restCall : new BlockCypherRestCall($apiContext);

        //Make the execution call
        $json = $restCall->execute($handlers, $url, $method, $payLoad, $headers);
        return $json;
    }

    public function getLink($rel)
    {
        foreach ($this->links as $link) {
            if ($link->getRel() == $rel) {
                return $link->getHref();
            }
        }
        return null;
    }

    /**
     * Append Links to the list.
     *
     * @param \BlockCypher\Api\Links $links
     * @return $this
     */
    public function addLink($links)
    {
        if (!$this->getLinks()) {
            return $this->setLinks(array($links));
        } else {
            return $this->setLinks(
                array_merge($this->getLinks(), array($links))
            );
        }
    }

    /**
     * Gets Links
     *
     * @return \BlockCypher\Api\Links[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Sets Links
     *
     * @param \BlockCypher\Api\Links[] $links
     *
     * @return $this
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     * Remove Links from the list.
     *
     * @param \BlockCypher\Api\Links $links
     * @return $this
     */
    public function removeLink($links)
    {
        return $this->setLinks(
            array_diff($this->getLinks(), array($links))
        );
    }
}