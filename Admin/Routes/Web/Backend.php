<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\ContractManagement\Controller\BackendController;
use Modules\ContractManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/contract/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
    ],
    '^/contract/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContract',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
    ],
    '^/contract/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
    ],
    '^/contract/type/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractTypeList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT_TYPE,
            ],
        ],
    ],
    '^/contract/type/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractType',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT_TYPE,
            ],
        ],
    ],
    '^/contract/type/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractTypeCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::CONTRACT_TYPE,
            ],
        ],
    ],
    '^/contract/attribute/type/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractManagementAttributeTypeList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/contract/attribute/type/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractManagementAttributeType',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/contract/attribute/type/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractManagementAttributeTypeCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/contract/attribute/value/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractManagementAttributeValue',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/contract/attribute/value/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\BackendController:viewContractManagementAttributeValueCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
];
