<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\ContractManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Models;

use Modules\Attribute\Models\AttributeValue;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Contract mapper class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of AttributeValue
 * @extends DataMapperFactory<T>
 */
final class ContractAttributeValueMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'contractmgmt_contract_attr_value_id'                => ['name' => 'contractmgmt_contract_attr_value_id',       'type' => 'int',      'internal' => 'id'],
        'contractmgmt_contract_attr_value_default'           => ['name' => 'contractmgmt_contract_attr_value_default',  'type' => 'bool',     'internal' => 'isDefault'],
        'contractmgmt_contract_attr_value_valueStr'          => ['name' => 'contractmgmt_contract_attr_value_valueStr', 'type' => 'string',   'internal' => 'valueStr'],
        'contractmgmt_contract_attr_value_valueInt'          => ['name' => 'contractmgmt_contract_attr_value_valueInt', 'type' => 'int',      'internal' => 'valueInt'],
        'contractmgmt_contract_attr_value_valueDec'          => ['name' => 'contractmgmt_contract_attr_value_valueDec', 'type' => 'float',    'internal' => 'valueDec'],
        'contractmgmt_contract_attr_value_valueDat'          => ['name' => 'contractmgmt_contract_attr_value_valueDat', 'type' => 'DateTime', 'internal' => 'valueDat'],
        'contractmgmt_contract_attr_value_unit'              => ['name' => 'contractmgmt_contract_attr_value_unit', 'type' => 'string', 'internal' => 'unit'],
        'contractmgmt_contract_attr_value_deptype'           => ['name' => 'contractmgmt_contract_attr_value_deptype', 'type' => 'int', 'internal' => 'dependingAttributeType'],
        'contractmgmt_contract_attr_value_depvalue'          => ['name' => 'contractmgmt_contract_attr_value_depvalue', 'type' => 'int', 'internal' => 'dependingAttributeValue'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'   => ContractAttributeValueL11nMapper::class,
            'table'    => 'contractmgmt_contract_attr_value_l11n',
            'self'     => 'contractmgmt_contract_attr_value_l11n_value',
            'external' => null,
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = AttributeValue::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'contractmgmt_contract_attr_value';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'contractmgmt_contract_attr_value_id';
}
