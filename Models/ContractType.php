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
 * Contract Type class.
 *
 * @package Modules\ContractManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class ContractType implements \JsonSerializable, ArrayableInterface
{
    /**
     * Id
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Name/string identifier by which it can be found/categorized
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = ''; // @todo: currently not filled, should be used as identifier or if not required removed (at the moment it seems like it is useless?!)

    /**
     * Localization
     *
     * @var ContractTypeL11n
     */
    protected string |

 ContractTypeL11n $l11n;

    /**
     * Constructor.
     *
     * @param string $name Name/identifier of the attribute type
     *
     * @since 1.0.0
     */
    public function __construct(string $name = '')
    {
        if (!empty($name)) {
            $this->setL11n($name);
        }
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
     * Set l11n
     *
     * @param string|ContractTypeL11n $l11n Tag article l11n
     * @param string                       $lang Language
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setL11n($l11n, string $lang = ISO639x1Enum::_EN) : void
    {
        if ($l11n instanceof ContractTypeL11n) {
            $this->l11n = $l11n;
        } elseif (\is_string($l11n)) {
            $this->l11n        = new ContractTypeL11n();
            $this->l11n->title = $l11n;
            $this->l11n->setLanguage($lang);
        } elseif ($this->l11n instanceof ContractTypeL11n && \is_string($l11n)) {
            $this->l11n->title = $l11n;
        }
    }

    /**
     * @return string
     *
     * @since 1.0.0
     */
    public function getL11n() : string
    {
        return $this->l11n instanceof ContractTypeL11n ? $this->l11n->title : $this->l11n;
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
