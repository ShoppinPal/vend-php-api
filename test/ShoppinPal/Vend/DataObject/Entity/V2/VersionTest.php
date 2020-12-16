<?php
declare(strict_types=1);
namespace ShoppinPal\Vend\DataObject\Entity\V2;

use YapepBase\Exception\ParameterException;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    public function testHasNewerVersionWithNotSetValue(): void
    {
        $version = new Version(['outlets' => null]);

        $this->assertFalse($version->hasNewerVersion('outlets', null));
    }

    public function testHasNewerVersionWithValueOverride(): void
    {
        $version = new Version(['outlets' => 20]);

        $this->assertFalse($version->hasNewerVersion('outlets', null, 21));
        $this->assertTrue($version->hasNewerVersion('outlets', null, 20));
    }

    public function testHasNewerVersionWithInvalidEntity(): void
    {
        $this->expectException(ParameterException::class);

        $version = new Version(['outlets' => null]);

        $version->hasNewerVersion('invalid', null);
    }

    /**
     * @dataProvider hasNewerVersionDataProvider
     */
    public function testHasNewerVersionVersionChecks(
        string $entityType,
        int $currentVersion,
        ?int $lastRetrievedVersion,
        bool $expectedResult,
        string $description
    ): void
    {
        $version = new Version(
            [
                $entityType => $currentVersion
            ],
            Version::UNKNOWN_PROPERTY_THROW,
            true
        );

        $this->assertSame(
            $expectedResult,
            $version->hasNewerVersion($entityType, $lastRetrievedVersion),
            'Invalid result for test with ' . $description
        );
    }

    public function hasNewerVersionDataProvider(): array
    {
        return [
            // Old behaviour for no entity
            ['brands', 0, null, false, 'old behaviour for no entity for retailer'],
            // New behaviour for no entity
            ['outlets', 1, null, false, 'new behaviour for no entity for retailer'],
            ['outlets', 9, null, false, 'just below default ignored minimum version'],
            ['outlets', 10, null, true, 'at default ignored minimum version'],
            ['outlets', 5000, null, true, 'no synced entity with NULL'],
            ['outlets', 5000, 0, true, 'no synced entity with 0'],
            ['outlets', 5000, 4999, true, 'synced entity with lover version'],
            ['outlets', 5000, 5000, false, 'fully synchronised'],
        ];
    }
}
