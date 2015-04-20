<?php
namespace BlockCypher\Transport;

use BlockCypher\Core\BlockCypherHttpConfig;
use BlockCypher\Core\BlockCypherHttpConnection;
use BlockCypher\Core\BlockCypherLoggingManager;
use BlockCypher\Rest\ApiContext;

/**
 * Class BlockCypherRestCall
 *
 * @package BlockCypher\Transport
 */
class BlockCypherRestCall
{
    /**
     * BlockCypher Logger
     *
     * @var BlockCypherLoggingManager logger interface
     */
    private $logger;

    /**
     * API Context
     *
     * @var ApiContext
     */
    private $apiContext;


    /**
     * Default Constructor
     *
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
        $this->logger = BlockCypherLoggingManager::getInstance(__CLASS__);
    }

    /**
     * @param array $handlers Array of handlers
     * @param string $path Resource path relative to base service endpoint
     * @param string $method HTTP method - one of GET, POST, PUT, DELETE, PATCH etc
     * @param string $data Request payload
     * @param array $headers HTTP headers
     * @return mixed
     * @throws \BlockCypher\Exception\BlockCypherConnectionException
     */
    public function execute($handlers = array(), $path, $method, $data = '', $headers = array())
    {
        $config = $this->apiContext->getConfig();
        $httpConfig = new BlockCypherHttpConfig(null, $method, $config);
        $headers = $headers ? $headers : array();
        $httpConfig->setHeaders($headers +
            array(
                'Content-Type' => 'application/json'
            )
        );

        /** @var \BlockCypher\Handler\IBlockCypherHandler $handler */
        foreach ($handlers as $handler) {
            if (!is_object($handler)) {
                $fullHandler = "\\" . (string)$handler;
                $handler = new $fullHandler($this->apiContext);
            }
            $handler->handle($httpConfig, $data, array('path' => $path, 'apiContext' => $this->apiContext));
        }

        $connection = new BlockCypherHttpConnection($httpConfig, $config);
        $response = $connection->execute($data);

        return $response;
    }

}
