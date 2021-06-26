<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\ContractManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Controller;

use Modules\ContractManagement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Asset\AssetType;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;
use Modules\ContractManagement\Models\ContractMapper;

/**
 * Backend controller for the contracts module.
 *
 * @property \Web\WebApplication $app
 *
 * @package Modules\ContractManagement
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewContractList(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response));

        if ($request->getData('ptype') === 'p') {
            $view->setData('contracts',
                ContractMapper::with('language', $response->getLanguage())
                    ::getBeforePivot((int) ($request->getData('id') ?? 0), null, 25)
            );
        } elseif ($request->getData('ptype') === 'n') {
            $view->setData('contracts',
                ContractMapper::with('language', $response->getLanguage())
                    ::getAfterPivot((int) ($request->getData('id') ?? 0), null, 25)
            );
        } else {
            $view->setData('contracts',
                ContractMapper::with('language', $response->getLanguage())
                    ::getAfterPivot(0, null, 25)
            );
        }

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewContract(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response));

        $view->addData('contract', ContractMapper::get((int) $request->getData('id')));

        $editor = new \Modules\Editor\Theme\Backend\Components\Editor\BaseView($this->app->l11nManager, $request, $response);
        $view->addData('editor', $editor);

        return $view;
    }
}
