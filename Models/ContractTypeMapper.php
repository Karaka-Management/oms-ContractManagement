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

use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * Contract type mapper class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class ContractTypeMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
        'contractmgmt_type_id'       => ['name' => 'contractmgmt_type_id',     'type' => 'int',    'internal' => 'id'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    protected static array $hasMany = [
        'l11n' => [
            'mapper'            => ContractTypeL11nMapper::class,
            'table'             => 'contractmgmt_type_l11n',
            'self'              => 'contractmgmt_type_l11n_type',
            'column'            => 'title',
            'conditional'       => true,
            'external'          => null,
        ]
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'contractmgmt_type';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'contractmgmt_type_id';
}
