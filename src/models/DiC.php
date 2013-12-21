<?php

namespace App\Model;

use Zend\Di\Di;

class DiC
{
    private $_di;
    private $_im;

    public function __construct(Di $di)
    {
        $this->_di = $di;
        $this->_im = $di->instanceManager();
    }

    public function assemble()
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $_method) {
            if (strpos($_method->getName(), '_assemble') === 0) {
                $_method->setAccessible(true);
                $_method->invoke($this);
            }
        }
    }

    private function _assembleDbConnection()
    {
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $this->_im->setParameters('App\Model\Resource\DBCollection', ['connection' => $connection]);
        $this->_im->setParameters('App\Model\Resource\DBEntity', ['connection' => $connection]);
    }

    private function _assembleResources()
    {
        $this->_im->addTypePreference('App\Model\Resource\IResourceCollection', 'App\Model\Resource\DBCollection');
        $this->_im->addTypePreference('App\Model\Resource\IResourceEntity', 'App\Model\Resource\DBEntity');
        $this->_im->addAlias('ResourceCollection', 'App\Model\Resource\DBCollection');
        $this->_im->addAlias('ResourceEntity', 'App\Model\Resource\DBEntity');

        $this->_im->setShared('App\Model\Resource\DBEntity', false);
        $this->_im->setShared('App\Model\Resource\DBCollection', false);
    }

    private function _assemblePaginator()
    {
        $this->_im->setParameters('Zend\Paginator\Paginator', ['adapter' => 'App\Model\Resource\Paginator']);
        $this->_im->addAlias('Paginator', 'Zend\Paginator\Paginator');
    }

    private function _assembleProduct()
    {
        $this->_im->setParameters('App\Model\ProductCollection', ['table' => 'App\Model\Resource\Table\Product']);
        $this->_im->addAlias('ProductCollection', 'App\Model\ProductCollection');

        $this->_im->setParameters('App\Model\Product', ['table' => 'App\Model\Resource\Table\Product']);
        $this->_im->addAlias('Product', 'App\Model\Product');
    }

    private function _assembleReview()
    {
        $this->_im->setParameters('App\Model\ProductReviewCollection', ['table' => 'App\Model\Resource\Table\ProductReview']);
        $this->_im->addAlias('ProductReviewCollection', 'App\Model\ProductReviewCollection');

        $this->_im->setParameters('App\Model\ProductReview', ['table' => 'App\Model\Resource\Table\ProductReview']);
        $this->_im->addAlias('ProductReview', 'App\Model\ProductReview');

    }

    private function _assembleCustomer()
    {
        $this->_im->setParameters('App\Model\CustomerCollection', ['table' => 'App\Model\Resource\Table\Customer']);
        $this->_im->addAlias('CustomerCollection', 'App\Model\CustomerCollection');

        $this->_im->setParameters('App\Model\Customer', ['table' => 'App\Model\Resource\Table\Customer']);
        $this->_im->addAlias('Customer', 'App\Model\Customer');
    }

    private function _assembleView()
    {
        $this->_im->setParameters('App\Model\ModelView', [
            'layoutDir' => __DIR__ . '/../views/layout/',
            'templateDir' => __DIR__ . '/../views/',
            'layout' => 'base',
            'params' => [],
        ]);
        $this->_im->addAlias('View', 'App\Model\ModelView');
    }


    private function _assembleAddress()
    {
        $this->_im->setParameters('App\Model\Address', ['table' => 'App\Model\Resource\Table\Address']);
        $this->_im->addAlias('Address', 'App\Model\Address');
    }

    private function _assembleRegion()
    {
        $this->_im->setParameters('App\Model\Region', ['table' => 'App\Model\Resource\Table\Region']);
        $this->_im->addAlias('Region', 'App\Model\Region');

        $this->_im->setParameters('App\Model\RegionCollection', ['table' => 'App\Model\Resource\Table\Region']);
        $this->_im->addAlias('RegionCollection', 'App\Model\RegionCollection');
    }

    private function _assembleCity()
    {
        $this->_im->setParameters('App\Model\City', ['table' => 'App\Model\Resource\Table\City']);
        $this->_im->addAlias('City', 'App\Model\City');

        $this->_im->setParameters('App\Model\CityCollection', ['table' => 'App\Model\Resource\Table\City']);
        $this->_im->addAlias('CityCollection', 'App\Model\CityCollection');
    }

    private function _assembleSession()
    {
        $this->_im->addAlias('Session', 'App\Model\Session');
        $this->_im->setParameters('App\Model\ISessionUser', [
            'session' => $this->_di->get('Session')
        ]);
    }

    private function _assembleQuote()
    {
        $this->_im->setParameters('App\Model\QuoteItem', ['table' => 'App\Model\Resource\Table\QuoteItem']);
        $this->_im->addAlias('QuoteItem', 'App\Model\QuoteItem');

        $this->_im->setParameters('App\Model\QuoteItemCollection', [
            'table' => 'App\Model\Resource\Table\QuoteItem',
            'itemPrototype' => 'App\Model\QuoteItem'
        ]);

        $this->_im->setParameters('App\Model\Quote', [
            'table' => 'App\Model\Resource\Table\Quote',
            'items' => $this->_di->get('App\Model\QuoteItemCollection'),
            'address' => $this->_di->get('App\Model\Address')
        ]);
        $this->_im->addAlias('Quote', 'App\Model\Quote');
    }

    private function _assembleFactory()
    {
        $this->_im->setParameters('App\Model\Shipping\Factory', []);
        $this->_im->addAlias('Factory', 'App\Model\Shipping\Factory');
    }
}
 