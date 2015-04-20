<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherModel;

/**
 * Class Patch
 *
 * A JSON Patch object used for doing partial updates to resources.
 *
 * @package BlockCypher\Api
 *
 * @property string op
 * @property string path
 * @property mixed value
 * @property string from
 */
class Patch extends BlockCypherModel
{
    /**
     * Patch operation to perform.Value required for add & remove operation can be any JSON value.
     * Valid Values: ["add", "remove", "replace"]
     *
     * @param string $op
     *
     * @return $this
     */
    public function setOp($op)
    {
        $this->op = $op;
        return $this;
    }

    /**
     * Patch operation to perform.Value required for add & remove operation can be any JSON value.
     *
     * @return string
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * string containing a JSON-Pointer value that references a location within the target document (the target location) where the operation is performed.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * string containing a JSON-Pointer value that references a location within the target document (the target location) where the operation is performed.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * New value to apply based on the operation.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * New value to apply based on the operation.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * A string containing a JSON Pointer value that references the location in the target document to move the value from.
     *
     * @param string $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * A string containing a JSON Pointer value that references the location in the target document to move the value from.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

}
