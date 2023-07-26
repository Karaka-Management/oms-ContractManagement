<?php
/**
 * Jingga
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

use Modules\ContractManagement\Controller\Controller;
use Modules\ContractManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/contract/type.*$' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\ApiContractTypeController:apiContractTypeCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT_TYPE,
            ],
        ],
        [
            'dest'       => '\Modules\ContractManagement\Controller\ApiContractTypeController:apiContractTypeUpdate',
            'verb'       => RouteVerb::SET,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT_TYPE,
            ],
        ],
    ],

    '^.*/contract$' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\ApiController:apiContractCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
        [
            'dest'       => '\Modules\ContractManagement\Controller\ApiController:apiContractUpdate',
            'verb'       => RouteVerb::SET,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
    ],

    '^.*/contract/attribute.*$' => [
        [
            'dest'       => '\Modules\ContractManagement\Controller\ApiAttributeController:apiAttributeCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
        [
            'dest'       => '\Modules\ContractManagement\Controller\ApiAttributeController:apiAttributeUpdate',
            'verb'       => RouteVerb::SET,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::CONTRACT,
            ],
        ],
    ],
];
