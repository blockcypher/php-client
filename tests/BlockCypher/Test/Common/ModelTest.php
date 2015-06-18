<?php

namespace BlockCypher\Test\Common;

use BlockCypher\Api\TX;
use BlockCypher\Common\BlockCypherModel;
use BlockCypher\Core\BlockCypherConfigManager;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleClassConversion()
    {
        $o = new SimpleClass();
        $o->setName("test");
        $o->setDescription("description");

        $this->assertEquals("test", $o->getName());
        $this->assertEquals("description", $o->getDescription());

        $json = $o->toJSON();
        $this->assertEquals('{"name":"test","description":"description"}', $json);

        $newO = new SimpleClass();
        $newO->fromJson($json);
        $this->assertEquals($o, $newO);
    }

    public function testConstructorJSON()
    {
        $obj = new SimpleClass('{"name":"test","description":"description"}');
        $this->assertEquals($obj->getName(), "test");
        $this->assertEquals($obj->getDescription(), "description");
    }

    public function testConstructorArray()
    {
        $arr = array('name' => 'test', 'description' => 'description');
        $obj = new SimpleClass($arr);
        $this->assertEquals($obj->getName(), "test");
        $this->assertEquals($obj->getDescription(), "description");
    }

    public function testConstructorNull()
    {
        $obj = new SimpleClass(null);
        $this->assertNotEquals($obj->getName(), "test");
        $this->assertNotEquals($obj->getDescription(), "description");
        $this->assertNull($obj->getName());
        $this->assertNull($obj->getDescription());
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Invalid JSON String
     */
    public function testConstructorInvalidInput()
    {
        new SimpleClass("Something that is not even correct");
    }

    public function testSimpleClassObjectConversion()
    {
        $json = '{"name":"test","description":"description"}';

        $obj = new SimpleClass();
        $obj->fromJson($json);

        $this->assertEquals("test", $obj->getName());
        $this->assertEquals("description", $obj->getDescription());

    }

    public function testSimpleClassObjectInvalidConversion()
    {
        try {
            $json = '{"name":"test","description":"description","invalid":"value"}';

            $obj = new SimpleClass();
            $obj->fromJson($json);

            $this->assertEquals("test", $obj->getName());
            $this->assertEquals("description", $obj->getDescription());
        } catch (\PHPUnit_Framework_Error_Notice $ex) {
            // No need to do anything
        }
    }

    public function testInvalidMagicMethod()
    {
        $obj = new SimpleClass();
        try {
            $obj->invalid = "value2";
            $this->assertEquals($obj->invalid, "value2");
            if (BlockCypherConfigManager::getInstance()->get('validation.level') == 'strict') {
                $this->fail("It should have thrown a Notice Error");
            }
        } catch (\PHPUnit_Framework_Error_Notice $ex) {

        }
    }

    /**
     * Test Case to determine if the unknown object is returned, it would not add that object to the model.
     */
    public function testUnknownObjectConversion()
    {
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'disabled'));
        $json = '{"name":"test","unknown":{ "id" : "123", "object": "456"},"description":"description"}';

        $obj = new SimpleClass();
        $obj->fromJson($json);

        $this->assertEquals("test", $obj->getName());
        $this->assertEquals("description", $obj->getDescription());
        $resultJson = $obj->toJSON();
        $this->assertContains("unknown", $resultJson);
        $this->assertContains("id", $resultJson);
        $this->assertContains("object", $resultJson);
        $this->assertContains("123", $resultJson);
        $this->assertContains("456", $resultJson);
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'strict'));
    }

    /**
     * Test Case to determine if the unknown object is returned, it would not add that object to the model.
     */
    public function testUnknownArrayConversion()
    {
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'disabled'));
        $json = '{"name":"test","unknown":[{"object": { "id" : "123", "object": "456"}}, {"more": { "id" : "123", "object": "456"}}],"description":"description"}';

        $obj = new SimpleClass();
        $obj->fromJson($json);

        $this->assertEquals("test", $obj->getName());
        $this->assertEquals("description", $obj->getDescription());
        $resultJson = $obj->toJSON();
        $this->assertContains("unknown", $resultJson);
        $this->assertContains("id", $resultJson);
        $this->assertContains("object", $resultJson);
        $this->assertContains("123", $resultJson);
        $this->assertContains("456", $resultJson);
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'strict'));
    }

    public function testEmptyArrayConversion()
    {
        /** @noinspection SpellCheckingInspection */
        $json = '{"block_hash":"0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328","inputs":[{"related_resources":[]}]}';
        $transaction = new TX($json);
        $result = $transaction->toJSON();
        $this->assertContains('"related_resources":[]', $result);
        $this->assertNotNull($result);
    }

    public function testMultipleEmptyArrayConversion()
    {
        /** @noinspection SpellCheckingInspection */
        $json = '{"block_hash":"0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328","inputs":[{"related_resources":[{},{}]}]}';
        $transaction = new TX($json);
        $result = $transaction->toJSON();
        $this->assertContains('"related_resources":[{},{}]', $result);
        $this->assertNotNull($result);
    }

    public function testSetterMagicMethod()
    {
        $obj = new BlockCypherModel();
        $obj->something = "other";
        $obj->else = array();
        $obj->there = null;
        $obj->obj = '{}';
        $obj->objs = array('{}');
        $this->assertEquals("other", $obj->something);
        $this->assertTrue(is_array($obj->else));
        $this->assertNull($obj->there);
        $this->assertEquals('{}', $obj->obj);
        $this->assertTrue(is_array($obj->objs));
        $this->assertEquals('{}', $obj->objs[0]);
    }

    public function testInvalidMagicMethodWithDisabledValidation()
    {
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'disabled'));
        $obj = new SimpleClass();
        try {
            $obj->invalid = "value2";
            $this->assertEquals($obj->invalid, "value2");
        } catch (\PHPUnit_Framework_Error_Notice $ex) {
            $this->fail("It should not have thrown a Notice Error as it is disabled.");
        }
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'strict'));
    }

    public function testInvalidMagicMethodWithValidationLevel()
    {
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'log'));
        $obj = new SimpleClass();
        $obj->invalid2 = "value2";
        $this->assertEquals($obj->invalid2, "value2");
        BlockCypherConfigManager::getInstance()->addConfigs(array('validation.level' => 'strict'));
    }

    public function testArrayClassConversion()
    {
        $o = new ArrayClass();
        $o->setName("test");
        $o->setDescription("description");
        $o->setTags(array('payment', 'info', 'test'));

        $this->assertEquals("test", $o->getName());
        $this->assertEquals("description", $o->getDescription());
        $this->assertEquals(array('payment', 'info', 'test'), $o->getTags());

        $json = $o->toJSON();
        $this->assertEquals('{"name":"test","description":"description","tags":["payment","info","test"]}', $json);

        $newO = new ArrayClass();
        $newO->fromJson($json);
        $this->assertEquals($o, $newO);
    }

    public function testNestedClassConversion()
    {
        $n = new ArrayClass();
        $n->setName("test");
        $n->setDescription("description");
        $o = new NestedClass();
        $o->setId('123');
        $o->setInfo($n);

        $this->assertEquals("123", $o->getId());
        $this->assertEquals("test", $o->getInfo()->getName());

        $json = $o->toJSON();
        $this->assertEquals('{"id":"123","info":{"name":"test","description":"description"}}', $json);

        $newO = new NestedClass();
        $newO->fromJson($json);
        $this->assertEquals($o, $newO);
    }
}
