<?php
namespace Test\Model;
use \App\Model\Admin;

class AdminTest extends \PHPUnit_Framework_TestCase
{
    public function testSavesDataInResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['login' => 'Vasia']));

        $admin = new Admin(['login' => 'Vasia'], null, $resource);
        $admin->save();
    }

    public function testGetsIdFromResourceAfterSave()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['login' => 'Vasia']))
            ->will($this->returnValue(42));
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('admin_id'));

        $admin = new Admin(['login' => 'Vasia'], null,  $resource);
        $admin->save();
        $this->assertEquals(42, $admin->getId());
    }

    public function testReturnsIdWhichHasBeenInitialized()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('admin_id'));

        $admin = new Admin(['admin_id' => 1], null, $resource);
        $this->assertEquals(1, $admin->getId());

        $admin = new Admin(['admin_id' => 2], null, $resource);
        $this->assertEquals(2, $admin->getId());
    }
}
