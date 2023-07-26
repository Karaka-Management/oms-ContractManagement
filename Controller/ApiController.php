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
            || ($val['start'] = !$request->hasData('start'))
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

        $this->createModelRelation(
            $request->header->account,
            (int) $request->getData('contract'),
            \reset($uploaded)->id,
            ContractMapper::class, 'files', '', $request->getOrigin()
        );

        $this->createStandardUpdateResponse($request, $response, $uploaded);
    }
}
