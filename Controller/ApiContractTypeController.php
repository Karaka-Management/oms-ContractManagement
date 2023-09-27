<?php

/**
 * Jingga
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

use Modules\ContractManagement\Models\ContractTypeL11nMapper;
use Modules\ContractManagement\Models\ContractTypeMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\BaseStringL11nType;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * ContractManagement class.
 *
 * @package Modules\ContractManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiContractTypeController extends Controller
{
    /**
     * Api method to create item attribute type
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiContractTypeCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $contractType = $this->createContractTypeFromRequest($request);
        $this->createModel($request->header->account, $contractType, ContractTypeMapper::class, 'contract_type', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $contractType);
    }

    /**
     * Method to create item attribute from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11nType
     *
     * @since 1.0.0
     */
    private function createContractTypeFromRequest(RequestAbstract $request) : BaseStringL11nType
    {
        $contractType = new BaseStringL11nType();
        $contractType->setL11n($request->getDataString('title') ?? '', $request->getDataString('language') ?? ISO639x1Enum::_EN);
        $contractType->title = $request->getDataString('name') ?? '';

        return $contractType;
    }

    /**
     * Validate item attribute create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateContractTypeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create item attribute l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiContractTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $contractTypeL11n = $this->createContractTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $contractTypeL11n, ContractTypeL11nMapper::class, 'contract_type_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $contractTypeL11n);
    }

    /**
     * Method to create item attribute l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createContractTypeL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $contractTypeL11n      = new BaseStringL11n();
        $contractTypeL11n->ref = $request->getDataInt('type') ?? 0;
        $contractTypeL11n->setLanguage(
            $request->getDataString('language') ?? $request->header->l11n->language
        );
        $contractTypeL11n->content = $request->getDataString('title') ?? '';

        return $contractTypeL11n;
    }

    /**
     * Validate item attribute l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateContractTypeL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['type'] = !$request->hasData('type'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update ContractType
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiContractTypeUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11nType $old */
        $old = ContractTypeMapper::get()->where('id', (int) $request->getData('id'));
        $new = $this->updateContractTypeFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, ContractTypeMapper::class, 'contract_type', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Method to update ContractType from request.
     *
     * @param RequestAbstract    $request Request
     * @param BaseStringL11nType $new     Model to modify
     *
     * @return BaseStringL11nType
     *
     * @todo: implement
     *
     * @since 1.0.0
     */
    public function updateContractTypeFromRequest(RequestAbstract $request, BaseStringL11nType $new) : BaseStringL11nType
    {
        $new->title = $request->getDataString('name') ?? $new->title;

        return $new;
    }

    /**
     * Validate ContractType update request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @todo: implement
     *
     * @since 1.0.0
     */
    private function validateContractTypeUpdate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to delete ContractType
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiContractTypeDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11nType $contractType */
        $contractType = ContractTypeMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $contractType, ContractTypeMapper::class, 'contract_type', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contractType);
    }

    /**
     * Validate ContractType delete request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateContractTypeDelete(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update ContractTypeL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiContractTypeL11nUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeL11nUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $old */
        $old = ContractTypeL11nMapper::get()->where('id', (int) $request->getData('id'));
        $new = $this->updateContractTypeL11nFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, ContractTypeL11nMapper::class, 'contract_type_l11n', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Method to update ContractTypeL11n from request.
     *
     * @param RequestAbstract $request Request
     * @param BaseStringL11n  $new     Model to modify
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    public function updateContractTypeL11nFromRequest(RequestAbstract $request, BaseStringL11n $new) : BaseStringL11n
    {
        $new->setLanguage(
            $request->getDataString('language') ?? $new->language
        );
        $new->content = $request->getDataString('title') ?? $new->content;

        return $new;
    }

    /**
     * Validate ContractTypeL11n update request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateContractTypeL11nUpdate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to delete ContractTypeL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiContractTypeL11nDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeL11nDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $contractTypeL11n */
        $contractTypeL11n = ContractTypeL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $contractTypeL11n, ContractTypeL11nMapper::class, 'contract_type_l11n', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contractTypeL11n);
    }

    /**
     * Validate ContractTypeL11n delete request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateContractTypeL11nDelete(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }
}
