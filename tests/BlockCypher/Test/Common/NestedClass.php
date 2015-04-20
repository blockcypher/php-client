<?php

namespace BlockCypher\Test\Common;

use BlockCypher\Common\BlockCypherModel;

class NestedClass extends BlockCypherModel
{

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param \BlockCypher\Test\Common\ArrayClass $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     *
     * @return \BlockCypher\Test\Common\ArrayClass
     */
    public function getInfo()
    {
        return $this->info;
    }
}
