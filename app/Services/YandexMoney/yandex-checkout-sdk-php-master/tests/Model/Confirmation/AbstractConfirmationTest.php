<?php

namespace Tests\YandexCheckout\Model\Confirmation;

use PHPUnit\Framework\TestCase;
use YandexCheckout\Helpers\Random;
use YandexCheckout\Model\Confirmation\AbstractConfirmation;

abstract class AbstractConfirmationTest extends TestCase
{
    /**
     * @return AbstractConfirmation
     */
    abstract protected function getTestInstance();

    /**
     * @return string
     */
    abstract protected function getExpectedType();

    /**
     *
     */
    public function testGetType()
    {
        $instance = $this->getTestInstance();
        self::assertEquals($this->getExpectedType(), $instance->getType());
    }

    /**
     * @dataProvider invalidTypeDataProvider
     * @expectedException \InvalidArgumentException
     * @param $value
     */
    public function testInvalidType($value)
    {
        new TestConfirmation($value);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function invalidTypeDataProvider()
    {
        return array(
            array(''),
            array(null),
            array(Random::str(40)),
            array(0),
            array(array()),
            array(new \stdClass()),
        );
    }
}

class TestConfirmation extends AbstractConfirmation
{
    public function __construct($type)
    {
        $this->_setType($type);
    }
}
