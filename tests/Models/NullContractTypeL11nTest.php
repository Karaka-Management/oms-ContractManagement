<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\tests\Models;

use Modules\ContractManagement\Models\NullContractTypeL11n;

/**
 * @internal
 */
final class NullContractTypeL11nTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\ContractManagement\Models\NullContractTypeL11n
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\ContractManagement\Models\ContractTypeL11n', new NullContractTypeL11n());
    }

    /**
     * @covers Modules\ContractManagement\Models\NullContractTypeL11n
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullContractTypeL11n(2);
        self::assertEquals(2, $null->getId());
    }
}
