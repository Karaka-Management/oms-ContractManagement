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

use Modules\ContractManagement\Models\NullContract;

/**
 * @internal
 */
final class NullContractTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\ContractManagement\Models\NullContract
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\ContractManagement\Models\Contract', new NullContract());
    }

    /**
     * @covers Modules\ContractManagement\Models\NullContract
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullContract(2);
        self::assertEquals(2, $null->getId());
    }
}
