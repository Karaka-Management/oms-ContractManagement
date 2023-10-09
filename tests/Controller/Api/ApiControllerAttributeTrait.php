<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\tests\Controller\Api;

use phpOMS\Localization\ISO3166TwoEnum;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Uri\HttpUri;

trait ApiControllerAttributeTrait
{
    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeTypeCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('title', 'EN:1');
        $request->setData('name', 'test_name');
        $request->setData('language', ISO639x1Enum::_EN);

        $this->attrModule->apiContractAttributeTypeCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeTypeL11nCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('title', 'DE:2');
        $request->setData('type', '1');
        $request->setData('language', ISO639x1Enum::_DE);

        $this->attrModule->apiContractAttributeTypeL11nCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeValueIntCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('default', '1');
        $request->setData('type', '1');
        $request->setData('value', '1');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiContractAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeValueStrCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('value', '1');
        $request->setData('type', '1');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiContractAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeValueFloatCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('value', '1.1');
        $request->setData('type', '1');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiContractAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeValueDatCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('value', '2020-08-02');
        $request->setData('type', '1');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiContractAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('ref', '1');
        $request->setData('value', '1');
        $request->setData('type', '1');

        $this->attrModule->apiContractAttributeCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeValueCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiContractAttributeValueCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeTypeCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiContractAttributeTypeCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeTypeL11nCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiContractAttributeTypeL11nCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractAttributeCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiContractAttributeCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
