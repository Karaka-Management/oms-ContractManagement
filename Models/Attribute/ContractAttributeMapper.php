<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\ContractManagement\Models\Attribute
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Models\Attribute;

use Modules\Attribute\Models\Attribute;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Fleet mapper class.
 *
 * @package Modules\ContractManagement\Models\Attribute
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Attribute
 * @extends DataMapperFactory<T>
 */
final class ContractAttributeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'contractmgmt_contract_attr_id'       => ['name' => 'contractmgmt_contract_attr_id',    'type' => 'int', 'internal' => 'id'],
        'contractmgmt_contract_attr_contract' => ['name' => 'contractmgmt_contract_attr_contract',  'type' => 'int', 'internal' => 'ref'],
        'contractmgmt_contract_attr_type'     => ['name' => 'contractmgmt_contract_attr_type',  'type' => 'int', 'internal' => 'type'],
        'contractmgmt_contract_attr_value'    => ['name' => 'contractmgmt_contract_attr_value', 'type' => 'int', 'internal' => 'value'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'type' => [
            'mapper'   => ContractAttributeTypeMapper::class,
            'external' => 'contractmgmt_contract_attr_type',
        ],
        'value' => [
            'mapper'   => ContractAttributeValueMapper::class,
            'external' => 'contractmgmt_contract_attr_value',
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = Attribute::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'contractmgmt_contract_attr';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'contractmgmt_contract_attr_id';
}
