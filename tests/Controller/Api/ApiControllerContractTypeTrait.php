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

use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Uri\HttpUri;

trait ApiControllerContractTypeTrait
{
    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractTypeCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('title', 'Test');
        $request->setData('language', ISO639x1Enum::_EN);

        $this->typeModule->apiContractTypeCreate($request, $response);
        self::assertGreaterThan(0, $response->get('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractTypeCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->typeModule->apiContractTypeCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractTypeL11nCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('title', 'Test');
        $request->setData('type', '1');
        $request->setData('language', ISO639x1Enum::_DE);

        $this->typeModule->apiContractTypeL11nCreate($request, $response);
        self::assertGreaterThan(0, $response->get('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractTypeL11nCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->typeModule->apiContractTypeL11nCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}