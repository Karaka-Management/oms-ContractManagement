<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\ContractManagement\tests\Models;

use Modules\ContractManagement\Models\ContractType;
use Modules\ContractManagement\Models\ContractTypeL11n;
use phpOMS\Localization\ISO639x1Enum;

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
        self::assertEquals(0, $this->type->getId());
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

        $this->type->setL11n(new ContractTypeL11n(0, 'NewTest'));
        self::assertEquals('NewTest', $this->type->getL11n());
    }

    /**
     * @covers Modules\ContractManagement\Models\ContractType
     * @group module
     */
    public function testSerialize() : void
    {
        $this->type->type = 1;

        self::assertEquals(
            [
                'id'       => 0,
                'l11n'    => new ContractTypeL11n(),
            ],
            $this->type->jsonSerialize()
        );
    }
}
