<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Wallet;

/**
 * Class WalletTest
 *
 * @package BlockCypher\Test\Api
 */
class WalletTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return Wallet
     */
    public function testSerializationDeserialization()
    {
        $obj = new Wallet(self::getJson());
        $this->assertNotNull($obj);

        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getName());
        $this->assertNotNull($obj->getAddresses());

        $this->assertEquals(self::getJson(), $obj->toJSON());
        return $obj;
    }

    /**
     * Gets Json String of Object Wallet
     * @param array $addresses
     * @return string
     */
    public static function getJson($addresses=array())
    {
        /*
        {
          "token": "c0afcccdde5081d6429de37d16166ead",
          "name": "alice",
          "addresses": [
            "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
            "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
          ],
          "error": "",
          "errors": []  
        }
        */

        //return '{"token":"c0afcccdde5081d6429de37d16166ead","name":"alice","addresses":["18VAyux27CiWQnmYumZeTKNcaw6opvKRLq","1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"],"error":"","errors":[]}';

        if (empty($addresses)) {
            $addresses = array(
                "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
                "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
            );
        }

        return '{"token":"c0afcccdde5081d6429de37d16166ead","name":"alice","addresses":'.json_encode($addresses, true).',"error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param Wallet $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getName(), "alice");
        $this->assertEquals($obj->getAddresses(), array("18VAyux27CiWQnmYumZeTKNcaw6opvKRLq", "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"));
    }

    /**
     * @depends testSerializationDeserialization
     * @param Wallet $obj
     */
    public function testAddAddress($obj)
    {
        $obj->addAddress("1jr1rHMthQVMNSYswB9ExSvYn339fWMzn");

        $this->assertContains("1jr1rHMthQVMNSYswB9ExSvYn339fWMzn", $obj->getAddresses());
    }

    /**
     * @depends testSerializationDeserialization
     * @param Wallet $obj
     */
    public function testRemoveAddress($obj)
    {
        $addresses = self::addresses();
        $address = $addresses[0];
        $obj->removeAddress($address);

        $this->assertNotContains($address, $obj->getAddresses());
    }

    /**
     * @return string[]
     */
    public static function addresses()
    {
        $addresses = array(
            "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
            "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
        );
        return $addresses;
    }

    /**
     * @dataProvider mockProvider
     * @param Wallet $obj
     * @param $mockApiContext
     */
    public function testCreate($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                self::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->create(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Wallet $obj
     * @param $mockApiContext
     */
    public function testGenerateAddress($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletGenerateAddressResponseTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->generateAddress(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Wallet $obj
     * @param $mockApiContext
     */
    public function testAddAddresses($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $addressList = AddressListTest::getObject();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                self::getJson(array_merge(self::addresses(), $addressList->getAddresses()))
            ));

       /** @noinspection PhpParamsInspection */
        $result = $obj->addAddresses($addressList, array(), $mockApiContext, $mockBlockCypherRestCall);

        $this->assertNotNull($result);
        $this->assertArraySubset($addressList->getAddresses(), $result->getAddresses());
    }

    /**
     * @dataProvider mockProvider
     * @param Wallet $obj
     * @param $mockApiContext
     */
    public function testRemoveAddresses($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $addressList = AddressListTest::getObject();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                self::getJson(array_diff(self::addresses(), $addressList->getAddresses()))
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->addAddresses($addressList, array(), $mockApiContext, $mockBlockCypherRestCall);

        $this->assertNotNull($result);
        $this->assertNotContains($addressList->getAddresses(), $result->getAddresses());
    }

    /**
     * @dataProvider mockProvider
     * @param Wallet $obj
     * @param $mockApiContext
     */
    public function testGet($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("walletName", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Wallet $obj
     * @param $mockApiContext
     */
    public function testGetOnlyAddresses($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressListTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->getOnlyAddresses("walletName", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Wallet $obj
     * @param $mockApiContext
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForParams(
        $obj, /** @noinspection PhpDocSignatureInspection */
        $mockApiContext,
        $params
    )
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("walletName", $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Wallet $obj
     * @param $mockApiContext
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetMultipleParamsValidationForParams(
        $obj, /** @noinspection PhpDocSignatureInspection */
        $mockApiContext,
        $params
    )
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . WalletTest::getJson() . ']'
            ));

        $walletList = array(WalletTest::getObject()->getName());

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get($walletList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return Wallet
     */
    public static function getObject()
    {
        return new Wallet(self::getJson());
    }

    /**
     * @dataProvider mockProvider
     * @param Wallet $obj
     * @param $mockApiContext
     */
    public function testDelete($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                true
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->delete(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }
}
