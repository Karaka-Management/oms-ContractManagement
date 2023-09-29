<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\ContractManagement\Models\Attribute
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Models\Attribute;

use Modules\Attribute\Models\AttributeValue;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Contract mapper class.
 *
 * @package Modules\ContractManagement\Models\Attribute
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
        'contractmgmt_attr_value_id'                => ['name' => 'contractmgmt_attr_value_id',       'type' => 'int',      'internal' => 'id'],
        'contractmgmt_attr_value_default'           => ['name' => 'contractmgmt_attr_value_default',  'type' => 'bool',     'internal' => 'isDefault'],
        'contractmgmt_attr_value_valueStr'          => ['name' => 'contractmgmt_attr_value_valueStr', 'type' => 'string',   'internal' => 'valueStr'],
        'contractmgmt_attr_value_valueInt'          => ['name' => 'contractmgmt_attr_value_valueInt', 'type' => 'int',      'internal' => 'valueInt'],
        'contractmgmt_attr_value_valueDec'          => ['name' => 'contractmgmt_attr_value_valueDec', 'type' => 'float',    'internal' => 'valueDec'],
        'contractmgmt_attr_value_valueDat'          => ['name' => 'contractmgmt_attr_value_valueDat', 'type' => 'DateTime', 'internal' => 'valueDat'],
        'contractmgmt_attr_value_unit'              => ['name' => 'contractmgmt_attr_value_unit', 'type' => 'string', 'internal' => 'unit'],
        'contractmgmt_attr_value_deptype'           => ['name' => 'contractmgmt_attr_value_deptype', 'type' => 'int', 'internal' => 'dependingAttributeType'],
        'contractmgmt_attr_value_depvalue'          => ['name' => 'contractmgmt_attr_value_depvalue', 'type' => 'int', 'internal' => 'dependingAttributeValue'],
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
            'table'    => 'contractmgmt_attr_value_l11n',
            'self'     => 'contractmgmt_attr_value_l11n_value',
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
    public const TABLE = 'contractmgmt_attr_value';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'contractmgmt_attr_value_id';
}
