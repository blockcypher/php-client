<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\HDWallet;

/**
 * Class HDWalletTest
 *
 * @package BlockCypher\Test\Api
 */
class HDWalletTest extends ResourceModelTestCase
{
    // TODO: addSubchainIndex, removesSubchainIndex, isHd tests

    /**
     * Gets Object Instance with Json data filled in
     * @return HDWallet
     */
    public static function getObject()
    {
        return new HDWallet(self::getJson());
    }

    /**
     * Gets Json String of Object Wallet
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "name": "bob",
            "extended_public_key": "xpub661MyMwAqRbcFtXgS5sYJABqqG9YLmC4Q1Rdap9gSE8NqtwybGhePY2gZ29ESFjqJoCu1Rupje8YtGqsefD265TMg7usUDFdp6W1EGMcet8",
            "subchain_indexes": [
                1,
                3
            ],
            "token": "c0afcccdde5081d6429de37d16166ead",
            "hd": true,
            "error": "",
            "errors": []
        }
        */

        return '{"name":"bob","extended_public_key":"xpub661MyMwAqRbcFtXgS5sYJABqqG9YLmC4Q1Rdap9gSE8NqtwybGhePY2gZ29ESFjqJoCu1Rupje8YtGqsefD265TMg7usUDFdp6W1EGMcet8","subchain_indexes":[1,3],"token":"c0afcccdde5081d6429de37d16166ead","hd":true,"error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return HDWallet
     */
    public function testSerializationDeserialization()
    {
        $obj = new HDWallet(self::getJson());
        $this->assertNotNull($obj);

        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getName());
        //$this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getHd());
        $this->assertNotNull($obj->getExtendedPublicKey());
        $this->assertNotNull($obj->getSubchainIndexes());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param HDWallet $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getName(), "bob");
        //$this->assertEquals($obj->getAddresses(), array("18VAyux27CiWQnmYumZeTKNcaw6opvKRLq", "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"));
        $this->assertEquals($obj->getHd(), true);
        $this->assertEquals($obj->getExtendedPublicKey(), 'xpub661MyMwAqRbcFtXgS5sYJABqqG9YLmC4Q1Rdap9gSE8NqtwybGhePY2gZ29ESFjqJoCu1Rupje8YtGqsefD265TMg7usUDFdp6W1EGMcet8');
        $this->assertEquals($obj->getSubchainIndexes(), array(1, 3));
    }

    /**
     * @depends testSerializationDeserialization
     * @param HDWallet $obj
     */
    public function testAddAddress($obj)
    {
        $obj->addAddress("1jr1rHMthQVMNSYswB9ExSvYn339fWMzn");

        $this->assertContains("1jr1rHMthQVMNSYswB9ExSvYn339fWMzn", $obj->getAddresses());
    }

    /**
     * @depends testSerializationDeserialization
     * @param HDWallet $obj
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
     * @param HDWallet $obj
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
     * @param HDWallet $obj
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
                HDWalletGenerateAddressResponseTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->generateAddress(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param HDWallet $obj
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
     * @param HDWallet $obj
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
     * @param HDWallet $obj
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
     * @param HDWallet $obj
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
     * @dataProvider mockProvider
     * @param HDWallet $obj
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
