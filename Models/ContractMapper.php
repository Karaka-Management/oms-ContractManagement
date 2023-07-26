<?php

/**
 * Jingga
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

use Modules\Admin\Models\AccountMapper;
use Modules\ContractManagement\Models\Attribute\ContractAttributeMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Editor\Models\EditorDocMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Contract mapper class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Contract
 * @extends DataMapperFactory<T>
 */
final class ContractMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'contractmgmt_contract_id'                        => ['name' => 'contractmgmt_contract_id',          'type' => 'int',               'internal' => 'id'],
        'contractmgmt_contract_parent'                    => ['name' => 'contractmgmt_contract_parent',          'type' => 'int',               'internal' => 'parent'],
        'contractmgmt_contract_template'                  => ['name' => 'contractmgmt_contract_template',          'type' => 'int',               'internal' => 'isTemplate'],
        'contractmgmt_contract_title'                     => ['name' => 'contractmgmt_contract_title',       'type' => 'string',            'internal' => 'title', 'autocomplete' => true],
        'contractmgmt_contract_description'               => ['name' => 'contractmgmt_contract_description', 'type' => 'string',            'internal' => 'description'],
        'contractmgmt_contract_account'                   => ['name' => 'contractmgmt_contract_account',     'type' => 'int',               'internal' => 'account'],
        'contractmgmt_contract_costs'                     => ['name' => 'contractmgmt_contract_costs',       'type' => 'Serializable',      'internal' => 'costs'],
        'contractmgmt_contract_renewal'                   => ['name' => 'contractmgmt_contract_renewal',     'type' => 'int',               'internal' => 'renewal'],
        'contractmgmt_contract_autorenewal'               => ['name' => 'contractmgmt_contract_autorenewal', 'type' => 'bool',              'internal' => 'autoRenewal'],
        'contractmgmt_contract_duration'                  => ['name' => 'contractmgmt_contract_duration',    'type' => 'int',               'internal' => 'duration'],
        'contractmgmt_contract_warning'                   => ['name' => 'contractmgmt_contract_warning',     'type' => 'int',               'internal' => 'warning'],
        'contractmgmt_contract_startoriginal'             => ['name' => 'contractmgmt_contract_startoriginal',       'type' => 'DateTime',          'internal' => 'originalStart'],
        'contractmgmt_contract_start'                     => ['name' => 'contractmgmt_contract_start',       'type' => 'DateTime',          'internal' => 'start'],
        'contractmgmt_contract_end'                       => ['name' => 'contractmgmt_contract_end',         'type' => 'DateTime',          'internal' => 'end'],
        'contractmgmt_contract_responsible'               => ['name' => 'contractmgmt_contract_responsible', 'type' => 'int',               'internal' => 'responsible'],
        'contractmgmt_contract_unit'                      => ['name' => 'contractmgmt_contract_unit',        'type' => 'int',               'internal' => 'unit'],
        'contractmgmt_contract_type'                      => ['name' => 'contractmgmt_contract_type',        'type' => 'int',               'internal' => 'type'],
        'contractmgmt_contract_created_at'                => ['name' => 'contractmgmt_contract_created_at',  'type' => 'DateTimeImmutable', 'internal' => 'createdAt'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'contractmgmt_contract';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'contractmgmt_contract_id';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    public const CREATED_AT = 'contractmgmt_contract_created_at';

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'type' => [
            'mapper'   => ContractTypeMapper::class,
            'external' => 'contractmgmt_contract_type',
        ],
        'account' => [
            'mapper'   => AccountMapper::class,
            'external' => 'contractmgmt_contract_account',
        ],
        'unit' => [
            'mapper'   => UnitMapper::class,
            'external' => 'contractmgmt_contract_unit',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'files' => [
            'mapper'   => MediaMapper::class,            /* mapper of the related object */
            'table'    => 'contractmgmt_contract_media',         /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'contractmgmt_contract_media_media',
            'self'     => 'contractmgmt_contract_media_contract',
        ],
        'notes' => [
            'mapper'   => EditorDocMapper::class,       /* mapper of the related object */
            'table'    => 'contractmgmt_contract_note',         /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'contractmgmt_contract_note_doc',
            'self'     => 'contractmgmt_contract_note_contract',
        ],
        'attributes' => [
            'mapper'   => ContractAttributeMapper::class,
            'table'    => 'contractmgmt_contract_attr',
            'self'     => 'contractmgmt_contract_attr_contract',
            'external' => null,
        ],
    ];
}
