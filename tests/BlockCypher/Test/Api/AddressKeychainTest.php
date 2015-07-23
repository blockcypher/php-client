<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\AddressKeyChain;

/**
 * Class AddressKeyChainTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressKeyChainTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return AddressKeyChain
     */
    public static function getObject()
    {
        return new AddressKeyChain(self::getJson());
    }

    /**
     * Gets Json String of Object AddressKeyChain
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "private": "bf442658d87e2fa590aca663b9f2bbff4fd19cac690941e6225b4eee3c6318d1",
            "public": "028043b74cddd7e25c8ad27794927f245cf7f8a9c2d08ffb9fb5e5776c03febaa1",
            "address": "2NBbY8fbHRLjWXHqRvs8P996N82eTYic1yX",
            "wif": "L3dWP9XFYznfeoDRabcUGDddcJrvauuMqx5bpSpoH7QgKiGe1PLq",
            "pubkeys": [
                "033e88a5503dc09243e58d9e7a53831c2b77cac014415ad8c29cabab5d933894c1",
                "02087f346641256d4ba19cc0473afaa8d3d1b903761b9220a915e1af65a12e613c",
                "03051fa1586ff8d509125d3e25308b4c66fcf656b377bf60bfdb296a4898d42efd"
            ],
            "script_type": "multisig-2-of-3",
            "error": "",
            "errors": []
        }
        */

        return '{"private":"bf442658d87e2fa590aca663b9f2bbff4fd19cac690941e6225b4eee3c6318d1","public":"028043b74cddd7e25c8ad27794927f245cf7f8a9c2d08ffb9fb5e5776c03febaa1","address":"2NBbY8fbHRLjWXHqRvs8P996N82eTYic1yX","wif":"L3dWP9XFYznfeoDRabcUGDddcJrvauuMqx5bpSpoH7QgKiGe1PLq","pubkeys":["033e88a5503dc09243e58d9e7a53831c2b77cac014415ad8c29cabab5d933894c1","02087f346641256d4ba19cc0473afaa8d3d1b903761b9220a915e1af65a12e613c","03051fa1586ff8d509125d3e25308b4c66fcf656b377bf60bfdb296a4898d42efd"],"script_type":"multisig-2-of-3","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return AddressKeyChain
     */
    public function testSerializationDeserialization()
    {
        $obj = new AddressKeyChain(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getPrivate());
        $this->assertNotNull($obj->getPublic());
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getWif());
        $this->assertNotNull($obj->getPubkeys());
        $this->assertNotNull($obj->getScriptType());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressKeyChain $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getPrivate(), "bf442658d87e2fa590aca663b9f2bbff4fd19cac690941e6225b4eee3c6318d1");
        $this->assertEquals($obj->getPublic(), "028043b74cddd7e25c8ad27794927f245cf7f8a9c2d08ffb9fb5e5776c03febaa1");
        $this->assertEquals($obj->getAddress(), "2NBbY8fbHRLjWXHqRvs8P996N82eTYic1yX");
        $this->assertEquals($obj->getWif(), "L3dWP9XFYznfeoDRabcUGDddcJrvauuMqx5bpSpoH7QgKiGe1PLq");
        $this->assertEquals($obj->getPubkeys(), array(
            "033e88a5503dc09243e58d9e7a53831c2b77cac014415ad8c29cabab5d933894c1",
            "02087f346641256d4ba19cc0473afaa8d3d1b903761b9220a915e1af65a12e613c",
            "03051fa1586ff8d509125d3e25308b4c66fcf656b377bf60bfdb296a4898d42efd"
        ));
        $this->assertEquals($obj->getScriptType(), "multisig-2-of-3");
    }
}
