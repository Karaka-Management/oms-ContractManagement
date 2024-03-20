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

use Modules\ContractManagement\Models\Contract;

/**
 * @internal
 */
final class ContractTest extends \PHPUnit\Framework\TestCase
{
    private Contract $contract;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->contract = new Contract();
    }

    /**
     * @covers \Modules\ContractManagement\Models\Contract
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->contract->id);
        self::assertEquals([], $this->contract->files);
    }

    /**
     * @covers \Modules\ContractManagement\Models\Contract
     * @group module
     */
    public function testSerialize() : void
    {
        $this->contract->title       = 'Title';
        $this->contract->description = 'Description';
        $this->contract->duration    = 123;
        $this->contract->warning     = 2;

        $serialized = $this->contract->jsonSerialize();
        unset($serialized['createdAt']);

        self::assertEquals(
            [
                'id'          => 0,
                'title'       => 'Title',
                'description' => 'Description',
                'start'       => null,
                'end'         => null,
                'duration'    => 123,
                'warning'     => 2,
                'responsible' => null,
                'costs'       => null,
                'type'        => null,
            ],
            $serialized
        );
    }
}
