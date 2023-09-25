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

use Modules\Admin\Models\NullAccount;
use Modules\ContractManagement\Models\Contract;
use Modules\ContractManagement\Models\ContractMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Media\Models\PathSettings;
use Modules\Organization\Models\NullUnit;
use phpOMS\Localization\NullBaseStringL11nType;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * Api controller for the contracts module.
 *
 * @package Modules\ContractManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
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
    public function apiContractCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $contract = $this->createContractFromRequest($request);
        $this->createModel($request->header->account, $contract, ContractMapper::class, 'contract', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $contract);
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
        if (($val['title'] = !$request->hasData('title'))
            || ($val['duration'] = !$request->hasData('duration'))
            || ($val['type'] = !$request->hasData('type'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Create media directory path
     *
     * @param Contract $contract Contract
     *
     * @return string
     *
     * @since 1.0.0
     */
    private function createContractDir(Contract $contract) : string
    {
        return '/Modules/ContractManagement/Contract/'
            . $contract->id;
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
        $contract->title       = $request->getDataString('title') ?? '';
        $contract->description = $request->getDataString('description') ?? '';
        $contract->type        = new NullBaseStringL11nType($request->getDataInt('type') ?? 0);
        $contract->start       = $request->getDataDateTime('start') ?? new \DateTime('now');
        $contract->account     = new NullAccount($request->getDataInt('account') ?? 0);
        $contract->renewal     = $request->getDataInt('renewal') ?? 0;
        $contract->autoRenewal = $request->getDataBool('autorenewal') ?? false;
        $contract->isTemplate  = $request->getDataBool('template') ?? false;
        $contract->unit        = new NullUnit($request->getDataInt('unit') ?? 0);
        $contract->end         = $request->getDataDateTime('end');

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
    public function apiContractDocumentCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        $uploadedFiles = $request->files;

        if (empty($uploadedFiles)) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $uploadedFiles);

            return;
        }

        /** @var \Modules\ContractManagement\Models\Contract */
        $contract = ContractMapper::get()
            ->where('id', $request->getDataInt('contract'))
            ->execute();

        $path = $this->createContractDir($contract);

        $uploaded = $this->app->moduleManager->get('Media')->uploadFiles(
            names: $request->getDataList('names'),
            fileNames: $request->getDataList('filenames'),
            files: $uploadedFiles,
            account: $request->header->account,
            basePath: __DIR__ . '/../../../Modules/Media/Files' . $path,
            virtualPath: $path,
            pathSettings: PathSettings::FILE_PATH,
            readContent: true
        );

        if ($request->hasData('type')) {
            foreach ($uploaded as $file) {
                $this->createModelRelation(
                    $request->header->account,
                    $file->id,
                    $request->getDataInt('type'),
                    MediaMapper::class,
                    'types',
                    '',
                    $request->getOrigin()
                );
            }
        }

        if (empty($uploaded)) {
            $this->createInvalidAddResponse($request, $response, []);

            return;
        }

        $this->createModelRelation(
            $request->header->account,
            (int) $request->getData('contract'),
            \reset($uploaded)->id,
            ContractMapper::class, 'files', '', $request->getOrigin()
        );

        $this->createStandardUpdateResponse($request, $response, $uploaded);
    }

    /**
     * Api method to update Contract
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
    public function apiContractUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\ContractManagement\Models\Contract $old */
        $old = ContractMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateContractFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, ContractMapper::class, 'contract', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Method to update Contract from request.
     *
     * @param RequestAbstract $request Request
     * @param Contract        $new     Model to modify
     *
     * @return Contract
     *
     * @todo: implement
     *
     * @since 1.0.0
     */
    public function updateContractFromRequest(RequestAbstract $request, Contract $new) : Contract
    {
        $new->title       = $request->getDataString('title') ?? $new->title;
        $new->description = $request->getDataString('description') ?? $new->description;
        $new->type        = $request->hasData('type') ? new NullBaseStringL11nType($request->getDataInt('type') ?? 0) : $new->type;
        $new->start       = $request->getDataDateTime('start') ?? $new->start;
        $new->account     = $request->hasData('account') ? new NullAccount($request->getDataInt('account') ?? 0) : $new->account;
        $new->renewal     = $request->getDataInt('renewal') ?? $new->renewal;
        $new->autoRenewal = $request->getDataBool('autorenewal') ?? $new->autoRenewal;
        $new->unit        = $request->hasData('unit') ? new NullUnit($request->getDataInt('unit') ?? 0) : $new->unit;
        $new->end         = $request->getDataDateTime('end') ?? $new->end;

        return $new;
    }

    /**
     * Validate Contract update request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @todo: implement
     *
     * @since 1.0.0
     */
    private function validateContractUpdate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to delete Contract
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
    public function apiContractDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateContractDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\ContractManagement\Models\Contract $contract */
        $contract = ContractMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $contract, ContractMapper::class, 'contract', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $contract);
    }

    /**
     * Validate Contract delete request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @todo: implement
     *
     * @since 1.0.0
     */
    private function validateContractDelete(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }
}
