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

use Modules\ContractManagement\Models\Contract;
use Modules\ContractManagement\Models\ContractType;
use Modules\Media\Models\Media;

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
     * @covers Modules\ContractManagement\Models\Contract
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->contract->getId());
        self::assertEquals([], $this->contract->getFiles());
    }

    /**
     * @covers Modules\ContractManagement\Models\Contract
     * @group module
     */
    public function testMediaInputOutput() : void
    {
        $this->contract->addFile(new Media());
        self::assertCount(1, $this->contract->getFiles());
    }

    /**
     * @covers Modules\ContractManagement\Models\Contract
     * @group module
     */
    public function testSerialize() : void
    {
        $this->contract->title = 'Title';
        $this->contract->description = 'Description';
        $this->contract->duration   = 123;
        $this->contract->warning   = 2;

        $serialized = $this->contract->jsonSerialize();
        unset($serialized['createdAt']);

        self::assertEquals(
            [
                'id'       => 0,
                'title'    => 'Title',
                'description'    => 'Description',
                'start'    => null,
                'end'    => null,
                'duration'    => 123,
                'warning'    => 2,
                'responsible'    => null,
                'costs'    => null,
                'type'    => new ContractType(),
            ],
            $serialized
        );
    }
}
