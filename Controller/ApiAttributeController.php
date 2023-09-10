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

use Modules\Attribute\Models\Attribute;
use Modules\Attribute\Models\AttributeType;
use Modules\Attribute\Models\AttributeValue;
use Modules\ContractManagement\Models\Attribute\ContractAttributeMapper;
use Modules\ContractManagement\Models\Attribute\ContractAttributeTypeL11nMapper;
use Modules\ContractManagement\Models\Attribute\ContractAttributeTypeMapper;
use Modules\ContractManagement\Models\Attribute\ContractAttributeValueL11nMapper;
use Modules\ContractManagement\Models\Attribute\ContractAttributeValueMapper;
use phpOMS\Localization\BaseStringL11n;
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
final class ApiAttributeController extends Controller
{
    use \Modules\Attribute\Controller\ApiAttributeTraitController;

    /**
     * Api method to create item attribute
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
    public function apiContractAttributeCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attribute = $this->createAttributeFromRequest($request);
        $this->createModel($request->header->account, $attribute, ContractAttributeMapper::class, 'attribute', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attribute);
    }

    /**
     * Api method to create contract attribute l11n
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
    public function apiContractAttributeTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeTypeL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrL11n = $this->createAttributeTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $attrL11n, ContractAttributeTypeL11nMapper::class, 'attr_type_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrL11n);
    }

    /**
     * Api method to create contract attribute type
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
    public function apiContractAttributeTypeCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeTypeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrType = $this->createAttributeTypeFromRequest($request);
        $this->createModel($request->header->account, $attrType, ContractAttributeTypeMapper::class, 'attr_type', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrType);
    }

    /**
     * Api method to create contract attribute value
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
    public function apiContractAttributeValueCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeValueCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\Attribute\Models\AttributeType $type */
        $type = ContractAttributeTypeMapper::get()
            ->where('id', $request->getDataInt('type') ?? 0)
            ->execute();

        $attrValue = $this->createAttributeValueFromRequest($request, $type);
        $this->createModel($request->header->account, $attrValue, ContractAttributeValueMapper::class, 'attr_value', $request->getOrigin());

        if ($attrValue->isDefault) {
            $this->createModelRelation(
                $request->header->account,
                (int) $request->getData('type'),
                $attrValue->id,
                ContractAttributeTypeMapper::class, 'defaults', '', $request->getOrigin()
            );
        }

        $this->createStandardCreateResponse($request, $response, $attrValue);
    }

    /**
     * Api method to create contract attribute l11n
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
    public function apiContractAttributeValueL11nCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeValueL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrL11n = $this->createAttributeValueL11nFromRequest($request);
        $this->createModel($request->header->account, $attrL11n, ContractAttributeValueL11nMapper::class, 'attr_value_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrL11n);
    }

    /**
     * Api method to update ContractAttribute
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
    public function apiContractAttributeUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var Attribute $old */
        $old = ContractAttributeMapper::get()
            ->with('type')
            ->with('type/defaults')
            ->with('value')
            ->where('id', (int) $request->getData('id'))
            ->execute();

        $new = $this->updateAttributeFromRequest($request, clone $old);

        if ($new->id === 0) {
            // Set response header to invalid request because of invalid data
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $new);

            return;
        }

        $this->updateModel($request->header->account, $old, $new, ContractAttributeMapper::class, 'contract_attribute', $request->getOrigin());

        if ($new->value->getValue() !== $old->value->getValue()) {
            $this->updateModel($request->header->account, $old->value, $new->value, ContractAttributeValueMapper::class, 'attribute_value', $request->getOrigin());
        }

        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete ContractAttribute
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
    public function apiContractAttributeDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        $contractAttribute = ContractAttributeMapper::get()
            ->with('type')
            ->where('id', (int) $request->getData('id'))
            ->execute();

        if ($contractAttribute->type->isRequired) {
            $this->createInvalidDeleteResponse($request, $response, []);

            return;
        }

        $this->deleteModel($request->header->account, $contractAttribute, ContractAttributeMapper::class, 'contract_attribute', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contractAttribute);
    }

    /**
     * Api method to update ContractAttributeTypeL11n
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
    public function apiContractAttributeTypeL11nUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeTypeL11nUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $old */
        $old = ContractAttributeTypeL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateAttributeTypeL11nFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, ContractAttributeTypeL11nMapper::class, 'contract_attribute_type_l11n', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete ContractAttributeTypeL11n
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
    public function apiContractAttributeTypeL11nDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeTypeL11nDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $contractAttributeTypeL11n */
        $contractAttributeTypeL11n = ContractAttributeTypeL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $contractAttributeTypeL11n, ContractAttributeTypeL11nMapper::class, 'contract_attribute_type_l11n', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contractAttributeTypeL11n);
    }

    /**
     * Api method to update ContractAttributeType
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
    public function apiContractAttributeTypeUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeTypeUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var AttributeType $old */
        $old = ContractAttributeTypeMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateAttributeTypeFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, ContractAttributeTypeMapper::class, 'contract_attribute_type', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete ContractAttributeType
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @todo: implement
     *
     * @since 1.0.0
     */
    public function apiContractAttributeTypeDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeTypeDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var AttributeType $contractAttributeType */
        $contractAttributeType = ContractAttributeTypeMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $contractAttributeType, ContractAttributeTypeMapper::class, 'contract_attribute_type', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contractAttributeType);
    }

    /**
     * Api method to update ContractAttributeValue
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
    public function apiContractAttributeValueUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeValueUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var AttributeValue $old */
        $old = ContractAttributeValueMapper::get()->where('id', (int) $request->getData('id'))->execute();

        /** @var \Modules\Attribute\Models\Attribute $attr */
        $attr = ContractAttributeMapper::get()
            ->with('type')
            ->where('id', $request->getDataInt('attribute') ?? 0)
            ->execute();

        $new = $this->updateAttributeValueFromRequest($request, clone $old, $attr);

        $this->updateModel($request->header->account, $old, $new, ContractAttributeValueMapper::class, 'contract_attribute_value', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete ContractAttributeValue
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
    public function apiContractAttributeValueDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        return;
        // @todo: I don't think values can be deleted? Only Attributes
        // However, It should be possible to remove UNUSED default values
        // either here or other function?
        if (!empty($val = $this->validateAttributeValueDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var AttributeValue $contractAttributeValue */
        $contractAttributeValue = ContractAttributeValueMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $contractAttributeValue, ContractAttributeValueMapper::class, 'contract_attribute_value', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contractAttributeValue);
    }

    /**
     * Api method to update ContractAttributeValueL11n
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
    public function apiContractAttributeValueL11nUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeValueL11nUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $old */
        $old = ContractAttributeValueL11nMapper::get()->where('id', (int) $request->getData('id'));
        $new = $this->updateAttributeValueL11nFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, ContractAttributeValueL11nMapper::class, 'contract_attribute_value_l11n', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete ContractAttributeValueL11n
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
    public function apiContractAttributeValueL11nDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateAttributeValueL11nDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $contractAttributeValueL11n */
        $contractAttributeValueL11n = ContractAttributeValueL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $contractAttributeValueL11n, ContractAttributeValueL11nMapper::class, 'contract_attribute_value_l11n', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contractAttributeValueL11n);
    }
}
