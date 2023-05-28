<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\tests\Models;

use Modules\ContractManagement\Models\ContractType;
use phpOMS\Localization\BaseStringL11n;

/**
 * @internal
 */
final class ContractTypeTest extends \PHPUnit\Framework\TestCase
{
    private ContractType $type;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->type = new ContractType();
    }

    /**
     * @covers Modules\ContractManagement\Models\ContractType
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->type->id);
        self::assertEquals('', $this->type->getL11n());
    }

    /**
     * @covers Modules\ContractManagement\Models\ContractType
     * @group module
     */
    public function testL11nInputOutput() : void
    {
        $this->type->setL11n('Test');
        self::assertEquals('Test', $this->type->getL11n());

        $this->type->setL11n(new BaseStringL11n('NewTest'));
        self::assertEquals('NewTest', $this->type->getL11n());
    }

    /**
     * @covers Modules\ContractManagement\Models\ContractType
     * @group module
     */
    public function testSerialize() : void
    {
        self::assertEquals(
            [
                'id'       => 0,
                'l11n'     => new BaseStringL11n(),
            ],
            $this->type->jsonSerialize()
        );
    }
}
