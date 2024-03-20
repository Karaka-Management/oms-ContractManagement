<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\ContractManagement\Controller\BackendController;
use Modules\ContractManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/contract/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
    ],
    '^.*/contract/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContract',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
    ],
    '^.*/contract/type/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractTypeList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT_TYPE,
            ],
        ],
    ],
    '^.*/contract/type/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractType',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT_TYPE,
            ],
        ],
    ],
];
