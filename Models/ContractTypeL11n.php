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

use phpOMS\Contract\ArrayableInterface;
use phpOMS\Localization\ISO639x1Enum;

/**
 * Contract type l11n class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class ContractTypeL11n implements \JsonSerializable, ArrayableInterface
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Model ID.
     *
     * @var int|ContractType
     * @since 1.0.0
     */
    protected int | ContractType $type = 0;

    /**
     * Language.
     *
     * @var string
     * @since 1.0.0
     */
    protected string $language = ISO639x1Enum::_EN;

    /**
     * Title.
     *
     * @var string
     * @since 1.0.0
     */
    public string $title = '';

    /**
     * Constructor.
     *
     * @param int|ContractType $type     Attribute type
     * @param string           $title    Localized title
     * @param string           $language Language
     *
     * @since 1.0.0
     */
    public function __construct(int | ContractType $type = 0, string $title = '', string $language = ISO639x1Enum::_EN)
    {
        $this->type     = $type;
        $this->title    = $title;
        $this->language = $language;
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
     * Get attribute type
     *
     * @return int|ContractType
     *
     * @since 1.0.0
     */
    public function getType() : int | ContractType
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param int $type Type id
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setType(int $type) : void
    {
        $this->type = $type;
    }

    /**
     * Set language
     *
     * @param string $language Language
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setLanguage(string $language) : void
    {
        $this->language = $language;
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