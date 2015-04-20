<?php

// Do not add namespace

use BlockCypher\Common\BlockCypherUserAgent;

class UserAgentTest extends \PHPUnit_Framework_TestCase
{

    public function testGetValue()
    {
        $ua = BlockCypherUserAgent::getValue("name", "version");
        list($id, $version, $features) = sscanf($ua, "BlockCypherSDK/%s %s (%s)");

        // Check that we pass the user agent in the expected format
        $this->assertNotNull($id);
        $this->assertNotNull($version);
        $this->assertNotNull($features);

        $this->assertEquals("name", $id);
        $this->assertEquals("version", $version);

        // Check that we pass in these minimal features
        $this->assertThat($features, $this->stringContains("OS="));
        $this->assertThat($features, $this->stringContains("Bit="));
        $this->assertThat($features, $this->stringContains("Lang="));
        $this->assertThat($features, $this->stringContains("V="));
        $this->assertGreaterThan(5, count(explode(';', $features)));
    }
}
