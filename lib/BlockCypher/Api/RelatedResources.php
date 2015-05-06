<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class RelatedResources
 *
 * A dummy class to test multiple nesting levels.
 * See: \BlockCypher\Test\Common\ModelTest::testEmptyArrayConversion
 * It should be deleted when real class is added with this nesting required level.
 *
 * @package BlockCypher\Api
 *
 * @property string dummy_property
 */
class RelatedResources extends BlockCypherBaseModel
{
    /**
     * @return string
     */
    public function getDummyProperty()
    {
        return $this->dummy_property;
    }

    /**
     * @param string $dummy_property
     * @return $this
     */
    public function setDummyProperty($dummy_property)
    {
        $this->dummy_property = $dummy_property;
        return $this;
    }
}
