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

use Modules\Admin\Models\NullAccount;
use Modules\ContractManagement\Models\ContractType;
use Modules\ContractManagement\Models\ContractTypeMapper;
use Modules\ContractManagement\Models\ContractTypeL11n;
use Modules\ContractManagement\Models\ContractTypeL11nMapper;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;
use phpOMS\Utils\Parser\Markdown\Markdown;
use phpOMS\Message\Http\HttpRequest;
use Modules\Media\Models\PathSettings;
use Modules\ContractManagement\Models\Contract;
use Modules\ContractManagement\Models\NullContractType;
use Modules\ContractManagement\Models\ContractMapper;
use phpOMS\Localization\ISO639x1Enum;

/**
 * Api controller for the contracts module.
 *
 * @package Modules\ContractManagement
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Api method to create a contract
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
    public function apiContractCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateContractCreate($request))) {
            $response->set('contract_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $contract = $this->createContractFromRequest($request);
        $this->createModel($request->header->account, $contract, ContractMapper::class, 'contract', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Contract', 'Contract successfully created', $contract);
    }

    /**
     * Validate contract create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateContractCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = empty($request->getData('title')))
            || ($val['start'] = empty($request->getData('start')))
            || ($val['duration'] = empty($request->getData('duration')))
            || ($val['type'] = empty($request->getData('type')))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create item l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Contract
     *
     * @since 1.0.0
     */
    private function createContractFromRequest(RequestAbstract $request) : Contract
    {
        $contract              = new Contract();
        $contract->title       = (string) ($request->getData('title') ?? '');
        $contract->description = (string) ($request->getData('description') ?? '');
        $contract->type        = new NullContractType((int) ($request->getData('type') ?? 0));
        $contract->start       = new \DateTime($request->getData('start') ?? 'now');
        $contract->account     = new NullAccount((int) ($request->getData('account') ?? 0));

        if (!empty($request->getData('end'))) {
            $contract->end = new \DateTime($request->getData('end'));
        }

        return $contract;
    }

    /**
     * Api method to create a contract document
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
    public function apiContractDocumentCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        $uploadedFiles = $request->getFiles() ?? [];

        if (empty($uploadedFiles)) {
            $this->fillJsonResponse($request, $response, NotificationLevel::ERROR, 'Contract', 'Invalid contract image', $uploadedFiles);
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $uploaded = $this->app->moduleManager->get('Media')->uploadFiles(
            [$request->getData('name') ?? ''],
            $uploadedFiles,
            $request->header->account,
            __DIR__ . '/../../../Modules/Media/Files/Modules/ContractManagement/Contracts/' . ($request->getData('contract_title') ?? '0'),
            '/Modules/ContractManagement/Contracts/' . ($request->getData('contract_title') ?? '0'),
            $request->getData('type', 'int'),
            '',
            '',
            PathSettings::FILE_PATH
        );

        $this->createModelRelation(
            $request->header->account,
            (int) $request->getData('contract'),
            \reset($uploaded)->getId(),
            ContractMapper::class, 'files', '', $request->getOrigin()
        );

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Image', 'Image successfully updated', $uploaded);
    }

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
    public function apiContractTypeCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeCreate($request))) {
            $response->set('contract_type_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $contractType = $this->createContractTypeFromRequest($request);
        $this->createModel($request->header->account, $contractType, ContractTypeMapper::class, 'contract_type', $request->getOrigin());

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Contract type', 'Contract type successfully created', $contractType);
    }

    /**
     * Method to create item attribute from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return ContractType
     *
     * @since 1.0.0
     */
    private function createContractTypeFromRequest(RequestAbstract $request) : ContractType
    {
        $contractType = new ContractType();
        $contractType->setL11n($request->getData('title'), $request->getData('language') ?? ISO639x1Enum::_EN);

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
        if (($val['title'] = empty($request->getData('title')))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create item l11n type
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
    public function apiContractTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateContractTypeL11nCreate($request))) {
            $response->set('contract_type_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $itemL11nType = $this->createContractTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $itemL11nType, ContractTypeL11nMapper::class, 'contract_type', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Contract type', 'Contract localization type successfully created', $itemL11nType);
    }

    /**
     * Method to create item l11n type from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return ContractTypeL11n
     *
     * @since 1.0.0
     */
    private function createContractTypeL11nFromRequest(RequestAbstract $request) : ContractTypeL11n
    {
        $typeL11n = new ContractTypeL11n(
            (int) ($request->getData('type') ?? 0),
            (string) ($request->getData('title') ?? ''),
            $request->getData('language') ?? $request->getLanguage()
        );

        return $typeL11n;
    }

    /**
     * Validate item l11n type create request
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
        if (($val['title'] = empty($request->getData('title')))
            || ($val['type'] = empty($request->getData('type')))
        ) {
            return $val;
        }

        return [];
    }
}
