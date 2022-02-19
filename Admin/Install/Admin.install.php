<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\ContractManagement\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
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
