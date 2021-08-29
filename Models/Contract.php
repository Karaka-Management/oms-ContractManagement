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

use Modules\Media\Models\Media;
use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;
use phpOMS\Localization\Money;

/**
 * Account class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
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
    protected int $id = 0;

    /**
     * Files.
     *
     * @var Media[]
     * @since 1.0.0
     */
    private array $files = [];

    public string $title = '';

    public string $description = '';

    public \DateTime $start;

    public ?\DateTime $end = null;

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

    public ContractType $type;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->account = new NullAccount();
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
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
