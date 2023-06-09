<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\ContractManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Controller;

use Modules\ContractManagement\Models\ContractMapper;
use Modules\ContractManagement\Models\ContractTypeMapper;
use Modules\Organization\Models\UnitMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Backend controller for the contracts module.
 *
 * @property \Web\WebApplication $app
 *
 * @package Modules\ContractManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
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
    public function viewContractList(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response);

        $mapper = ContractMapper::getAll()
            ->with('account')
            ->limit(25);

        if ($request->getData('ptype') === 'p') {
            $view->data['contracts'] = $mapper->where('id', $request->getDataInt('id') ?? 0, '<')->execute();
        } elseif ($request->getData('ptype') === 'n') {
            $view->data['contracts'] = $mapper->where('id', $request->getDataInt('id') ?? 0, '>')->execute();
        } else {
            $view->data['contracts'] = $mapper->where('id', 0, '>')->execute();
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
    public function viewContract(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-single');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response);

        $contract = ContractMapper::get()
            ->with('account')
            ->with('files')
            ->where('id', (int) $request->getData('id'))
            ->sort('files/id', 'DESC')
            ->execute();
        $view->data['contract'] = $contract;

        $contractTypes = ContractTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $response->header->l11n->language)
            ->execute();
        $view->data['contractTypes'] = $contractTypes;

        $units = UnitMapper::getAll()
            ->execute();
        $view->data['units'] = $units;

        $view->data['editor'] = new \Modules\Editor\Theme\Backend\Components\Editor\BaseView($this->app->l11nManager, $request, $response);
        $view->data['media-upload'] = new \Modules\Media\Theme\Backend\Components\Upload\BaseView($this->app->l11nManager, $request, $response);

        return $view;
    }
}
