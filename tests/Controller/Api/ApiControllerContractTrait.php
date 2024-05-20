<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\tests\Controller\Api;

use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Utils\TestUtils;

trait ApiControllerContractTrait
{
    /**
     * @covers \Modules\ContractManagement\Controller\ApiController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiContractCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('title', 'Title');
        $request->setData('start', '2010-10-09');
        $request->setData('end', '2011-10-09');
        $request->setData('duration', '2');
        $request->setData('type', '1');

        $this->module->apiContractCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\ContractManagement\Controller\ApiController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiContractCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiContractCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers \Modules\ContractManagement\Controller\ApiController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiContractDocCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        if (!\is_file(__DIR__ . '/test_tmp.pdf')) {
            \copy(__DIR__ . '/test.pdf', __DIR__ . '/test_tmp.pdf');
        }

        $request->header->account = 1;
        $request->setData('contract', 1);
        $request->setData('contract_title', 'Test title');

        TestUtils::setMember($request, 'files', [
            'file1' => [
                'name'     => 'test.pdf',
                'type'     => 'pdf',
                'tmp_name' => __DIR__ . '/test_tmp.pdf',
                'error'    => \UPLOAD_ERR_OK,
                'size'     => \filesize(__DIR__ . '/test_tmp.pdf'),
            ],
        ]);

        $this->module->apiContractDocumentCreate($request, $response);
        self::assertCount(1, $response->getDataArray('')['response']);
    }

    /**
     * @covers \Modules\ContractManagement\Controller\ApiController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiContractDocCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiContractCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
