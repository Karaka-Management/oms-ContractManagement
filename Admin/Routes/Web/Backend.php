<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use Modules\ContractManagement\Controller\BackendController;
use Modules\ContractManagement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/contract/list.*$' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::CONTRACT,
            ],
        ],
    ],
    '^.*/contract/single.*$' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContract',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::CONTRACT,
            ],
        ],
    ],
];
