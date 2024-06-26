<?php
/**
 * Jingga
 *
 * PHP Version 8.2
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
use Modules\Organization\Models\Unit;
use phpOMS\Localization\BaseStringL11nType;
use phpOMS\Localization\Money;

/**
 * Contract class.
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

    public string $title = '';

    public string $description = '';

    // The original start of the contract ignoring renewals
    public ?\DateTime $originalStart = null;

    // Start of the contract considering renewals
    public ?\DateTime $start = null;

    // End of the contract considering renewals
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

    // Contract with
    public Account $account;

    /**
     * Created at.
     *
     * @var \DateTimeImmutable
     * @since 1.0.0
     */
    public \DateTimeImmutable $createdAt;

    public ?Money $costs = null;

    public ?BaseStringL11nType $type = null;

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

    use \Modules\Media\Models\MediaListTrait;
    use \Modules\Editor\Models\EditorDocListTrait;
    use \Modules\Attribute\Models\AttributeHolderTrait;
}
