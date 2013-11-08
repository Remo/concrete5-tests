<?php

/**
 * Test class for FileHelper.
 * Generated by PHPUnit on 2013-11-08 at 17:20:23.
 */
class FileHelperTest extends PHPUnit_Framework_TestCase {

    /**
     * @var FileHelper
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
		  $this->object = Loader::helper('file');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    public function testSanitize() {
        $this->assertEquals("Mixed_with_English_and", $this->object->sanitize("Mixed with English and 日本人"));
        $this->assertEquals("Mixed_with_English_and_.doc", $this->object->sanitize("Mixed with English and 日本人.doc"));
        $this->assertEquals("Mixed_with_English_and_.", $this->object->sanitize("Mixed with English and 日本人.日本人"));
        $this->assertEquals("903910d73b335d7ef5c78fec3ca36891", $this->object->sanitize("日本人"));
        $this->assertEquals("a4a76883426db812ed7e71efbb9fcea0.doc", $this->object->sanitize("日本人.doc"));
        $this->assertEquals("f491ec23fce87df961290adb8fc8f153", $this->object->sanitize("日本人.日本人"));     
    }


}

?>
