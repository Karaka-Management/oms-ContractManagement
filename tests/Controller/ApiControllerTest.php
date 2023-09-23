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

namespace Modules\ContractManagement\tests\Controller;

use Model\CoreSettings;
use Modules\Admin\Models\AccountPermission;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\TestUtils;

/**
 * @testdox Modules\ContractManagement\tests\Controller\ApiControllerTest: ContractManagement api controller
 *
 * @internal
 */
final class ApiControllerTest extends \PHPUnit\Framework\TestCase
{
    protected ApplicationAbstract $app;

    /**
     * @var \Modules\ContractManagement\Controller\ApiController
     */
    protected ModuleAbstract $module;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $this->app->dbPool          = $GLOBALS['dbpool'];
        $this->app->unitId          = 1;
        $this->app->accountManager  = new AccountManager($GLOBALS['session']);
        $this->app->appSettings     = new CoreSettings();
        $this->app->moduleManager   = new ModuleManager($this->app, __DIR__ . '/../../../../Modules/');
        $this->app->dispatcher      = new Dispatcher($this->app);
        $this->app->eventManager    = new EventManager($this->app->dispatcher);
        $this->app->eventManager->importFromFile(__DIR__ . '/../../../../Web/Api/Hooks.php');
        $this->app->sessionManager = new HttpSession(36000);
        $this->app->l11nManager    = new L11nManager();

        $account = new Account();
        TestUtils::setMember($account, 'id', 1);

        $permission = new AccountPermission();
        $permission->unit = 1;
        $permission->app  = 2;
        $permission->setPermission(
            PermissionType::READ
            | PermissionType::CREATE
            | PermissionType::MODIFY
            | PermissionType::DELETE
            | PermissionType::PERMISSION
        );

        $account->addPermission($permission);

        $this->app->accountManager->add($account);
        $this->app->router = new WebRouter();

        $this->module = $this->app->moduleManager->get('ContractManagement');

        TestUtils::setMember($this->module, 'app', $this->app);
    }

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

        $this->module->apiContractTypeCreate($request, $response);
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

        $this->module->apiContractTypeCreate($request, $response);
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

        $this->module->apiContractTypeL11nCreate($request, $response);
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

        $this->module->apiContractTypeL11nCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('title', 'Title');
        $request->setData('start', '2010-10-09');
        $request->setData('end', '2011-10-09');
        $request->setData('duration', '2');
        $request->setData('type', '1');

        $this->module->apiContractCreate($request, $response);
        self::assertGreaterThan(0, $response->get('')['response']->id);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiContractCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractDocCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

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
        self::assertCount(1, $response->get('')['response']);
    }

    /**
     * @covers Modules\ContractManagement\Controller\ApiController
     * @group module
     */
    public function testApiContractDocCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiContractCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
