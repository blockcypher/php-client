<?php

namespace BlockCypher\Test\Common;

use BlockCypher\Common\BlockCypherModel;

class ArrayClass extends BlockCypherModel
{

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setTags($tags)
    {
        if (!is_array($tags)) {
            $tags = array($tags);
        }
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
}
