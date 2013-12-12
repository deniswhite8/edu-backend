<?php
namespace Test\Model;

use App\Model\ModelView;

class ModelViewTest extends \PHPUnit_Framework_TestCase
{
    public function testRendersProviderTemplate()
    {
        $view = new ModelView(
            $layoutDir = __DIR__ . '/ModelViewTest/fixtures/layout/',
            $templateDir = __DIR__ . 'ModelViewTest/fixture/template/',
            $layout = 'layout',
            $template = 'template',
            $param = ['foo' => 'bar']
        );

        ob_start();
        $view->render();
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('<p>foo is baar</p>', $contents);
    }
}