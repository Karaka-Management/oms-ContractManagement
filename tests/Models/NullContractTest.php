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

use Modules\ContractManagement\Models\NullContract;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\ContractManagement\Models\NullContract::class)]
final class NullContractTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\ContractManagement\Models\Contract', new NullContract());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testId() : void
    {
        $null = new NullContract(2);
        self::assertEquals(2, $null->id);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testJsonSerialize() : void
    {
        $null = new NullContract(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
