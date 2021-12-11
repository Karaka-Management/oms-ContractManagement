<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\ContractManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Contract type l11n mapper class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class ContractTypeL11nMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'contractmgmt_type_l11n_id'        => ['name' => 'contractmgmt_type_l11n_id',       'type' => 'int',    'internal' => 'id'],
        'contractmgmt_type_l11n_title'     => ['name' => 'contractmgmt_type_l11n_title',    'type' => 'string', 'internal' => 'title', 'autocomplete' => true],
        'contractmgmt_type_l11n_type'      => ['name' => 'contractmgmt_type_l11n_type',      'type' => 'int',    'internal' => 'type'],
        'contractmgmt_type_l11n_lang'      => ['name' => 'contractmgmt_type_l11n_lang', 'type' => 'string', 'internal' => 'language'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'contractmgmt_type_l11n';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='contractmgmt_type_l11n_id';
}
