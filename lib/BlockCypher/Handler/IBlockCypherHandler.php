<?php

namespace BlockCypher\Handler;

/**
 * Interface IBlockCypherHandler
 *
 * @package BlockCypher\Handler
 */
interface IBlockCypherHandler
{
    /**
     *
     * @param \BlockCypher\Core\BlockCypherHttpConfig $httpConfig
     * @param string $request
     * @param mixed $options
     * @return mixed
     */
    public function handle($httpConfig, $request, $options);
}
