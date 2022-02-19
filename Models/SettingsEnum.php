<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\ContractManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Module settings enum.
 *
 * @package  Modules\ContractManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
abstract class SettingsEnum extends Enum
{
    public const CONTRACT_RENEWAL_WARNING = '1007900001';
}
