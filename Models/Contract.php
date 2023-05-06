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

use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;
use Modules\Media\Models\Media;
use Modules\Organization\Models\Unit;
use phpOMS\Localization\Money;

/**
 * Account class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Contract
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public ?int $parent = null;

    public bool $isTemplate = false;

    /**
     * Files.
     *
     * @var Media[]
     * @since 1.0.0
     */
    private array $files = [];

    public string $title = '';

    public string $description = '';

    public ?\DateTime $start = null;

    public ?\DateTime $end = null;

    /**
     * Months until end of contract
     *
     * The renewal sometimes can be done up until the end of the contract and sometimes x-months prior to the contract end.
     */
    public int $renewal = 0;

    public bool $autoRenewal = false;

    public int $duration = 0;

    public int $warning = 0;

    public ?int $responsible = null;

    public Account $account;

    /**
     * Created at.
     *
     * @var \DateTimeImmutable
     * @since 1.0.0
     */
    public \DateTimeImmutable $createdAt;

    public ?Money $costs = null;

    public ?ContractType $type = null;

    public ?Unit $unit = null;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->account   = new NullAccount();
    }

    /**
     * Get id
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get files
     *
     * @return Media[]
     *
     * @since 1.0.0
     */
    public function getFiles() : array
    {
        return $this->files;
    }

    /**
     * Add media to item
     *
     * @param Media $media Media
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addFile(Media $media) : void
    {
        $this->files[] = $media;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'start'       => $this->start,
            'end'         => $this->end,
            'duration'    => $this->duration,
            'warning'     => $this->warning,
            'responsible' => $this->responsible,
            'createdAt'   => $this->createdAt,
            'costs'       => $this->costs,
            'type'        => $this->type,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }
}
