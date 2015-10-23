<?php


class BannerTest extends PHPUnit_Framework_TestCase
{
    private $object = null;

    public function setUp()
    {
        $this->object = new AppBundle\Entity\Banner();
    }

    public function tearDown()
    {
        $this->object = null;
    }

    public function testConstructor()
    {
        $property = $this->getPrivateProperty('contentunits');

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $property->getValue($this->object));
        $this->assertCount(0, $property->getValue($this->object));
    }

    public function testGetId()
    {
        $id = 1;

        $property = $this->getPrivateProperty('id');

        $property->setValue($this->object, $id);

        $this->assertEquals($id, $this->object->getId());
    }

    public function testSetName()
    {
        $name = 'test name';

        $property = $this->getPrivateProperty('name');

        $this->object->setName($name);

        $this->assertEquals($name, $property->getValue($this->object));
    }

    public function testGetName()
    {
        $name = 'test name';

        $property = $this->getPrivateProperty('name');

        $property->setValue($this->object, $name);

        $this->assertEquals($name, $this->object->getName());
    }

    public function testAddContentunit()
    {
        $contentunit = $this->getMock('AppBundle\Entity\Contentunit');

        $property = $this->getPrivateProperty('contentunits');

        $this->object->addContentunit($contentunit);

        $this->assertCount(1, $property->getValue($this->object));
        $this->assertSame($contentunit, $property->getValue($this->object)[0]);
    }

    protected function getPrivateProperty($propertyName)
    {
        $reflector = new ReflectionClass(get_class($this->object));
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }
}