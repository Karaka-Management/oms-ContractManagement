<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\ContractManagement\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\ContractManagement\Controller\ApiController;
use Modules\ContractManagement\Models\SettingsEnum;

return [
    [
        'type'    => 'setting',
        'name'    => SettingsEnum::CONTRACT_RENEWAL_WARNING,
        'content' => '7776000',
        'module'  => ApiController::NAME,
    ]
];
