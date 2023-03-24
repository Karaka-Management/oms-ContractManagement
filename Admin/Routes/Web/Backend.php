<?php
/**
 * Karaka
 *
 * PHP Version 8.1
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
    '^.*/contract/list.*$' => [
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
    '^.*/contract/single.*$' => [
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
];
