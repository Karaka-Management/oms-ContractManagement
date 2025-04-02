<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\ContractManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Permission category enum.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class PermissionCategory extends Enum
{
    public const CONTRACT = 1;

    public const CONTRACT_TYPE = 2;

    public const NOTE = 3;

    public const ATTRIBUTE = 4;
}
