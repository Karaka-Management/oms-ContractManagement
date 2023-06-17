<?php
/**
 * Jingga
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

use Modules\ContractManagement\Models\NullContractType;

/**
 * @internal
 */
final class NullContractTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\ContractManagement\Models\NullContractType
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\ContractManagement\Models\ContractType', new NullContractType());
    }

    /**
     * @covers Modules\ContractManagement\Models\NullContractType
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullContractType(2);
        self::assertEquals(2, $null->id);
    }
}
