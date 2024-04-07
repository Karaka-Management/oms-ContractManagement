<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\ContractManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Controller;

use Modules\ContractManagement\Models\Attribute\ContractAttributeTypeMapper;
use Modules\ContractManagement\Models\ContractMapper;
use Modules\ContractManagement\Models\ContractTypeMapper;
use Modules\Organization\Models\UnitMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\DataStorage\Database\Query\OrderType;
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
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewContractList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response);

        $mapper = ContractMapper::getAll()
            ->with('account')
            ->limit(25);

        if ($request->getData('ptype') === 'p') {
            $view->data['contracts'] = $mapper->where('id', $request->getDataInt('offset') ?? 0, '<')->execute();
        } elseif ($request->getData('ptype') === 'n') {
            $view->data['contracts'] = $mapper->where('id', $request->getDataInt('offset') ?? 0, '>')->execute();
        } else {
            $view->data['contracts'] = $mapper->where('id', 0, '>')->execute();
        }

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewContractTypeList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-type-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response);

        $mapper = ContractTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $response->header->l11n->language)
            ->limit(25);

        if ($request->getData('ptype') === 'p') {
            $view->data['types'] = $mapper->where('id', $request->getDataInt('offset') ?? 0, '<')->execute();
        } elseif ($request->getData('ptype') === 'n') {
            $view->data['types'] = $mapper->where('id', $request->getDataInt('offset') ?? 0, '>')->execute();
        } else {
            $view->data['types'] = $mapper->where('id', 0, '>')->execute();
        }

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewContractType(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-type');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response);

        $type = ContractTypeMapper::get()
            ->with('l11n')
            ->where('l11n/language', $response->header->l11n->language)
            ->where('id', (int) $request->getData('id'))
            ->execute();

        $view->data['type'] = $type;

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewContract(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/ContractManagement/Theme/Backend/contract-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007901001, $request, $response);

        $view->data['contract'] = ContractMapper::get()
            ->with('account')
            ->with('attributes')
            ->with('attributes/type')
            ->with('attributes/value')
            ->with('attributes/type/l11n')
            ->with('attributes/value/l11n')
            ->with('files')
            ->with('notes')
            ->where('id', (int) $request->getData('id'))
            ->where('attributes/type/l11n/language', $response->header->l11n->language)
            ->where('attributes/value/l11n/language', [$response->header->l11n->language, null])
            ->sort('files/id', OrderType::DESC)
            ->execute();

        $view->data['children'] = ContractMapper::getAll()
            ->with('account')
            ->where('parent', (int) $request->getData('id'))
            ->sort('createdAt', OrderType::DESC)
            ->executeGetArray();

        $view->data['contractTypes'] = ContractTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $response->header->l11n->language)
            ->executeGetArray();

        $view->data['units'] = UnitMapper::getAll()
            ->executeGetArray();

        $view->data['attributeTypes'] = ContractAttributeTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $response->header->l11n->language)
            ->executeGetArray();

        $view->data['editor']       = new \Modules\Editor\Theme\Backend\Components\Editor\BaseView($this->app->l11nManager, $request, $response);
        $view->data['media-upload'] = new \Modules\Media\Theme\Backend\Components\Upload\BaseView($this->app->l11nManager, $request, $response);
        $view->data['note']         = new \Modules\Editor\Theme\Backend\Components\Note\BaseView($this->app->l11nManager, $request, $response);

        $view->data['attributeView']                               = new \Modules\Attribute\Theme\Backend\Components\AttributeView($this->app->l11nManager, $request, $response);
        $view->data['attributeView']->data['default_localization'] = $this->app->l11nServer;

        return $view;
    }
}
