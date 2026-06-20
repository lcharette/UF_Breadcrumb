<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests\Unit;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Sprinkle\Breadcrumb\BreadcrumbManager;
use UserFrosting\Sprinkle\Breadcrumb\Tests\BreadcrumbTestCase;
use UserFrosting\Sprinkle\Breadcrumb\Twig\BreadcrumbExtension;

/**
 * Perform test for UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\BreadcrumbExtension
 */
class BreadcrumbExtensionTest extends BreadcrumbTestCase
{
    public function testConstructor(): void
    {
        $manager = Mockery::mock(BreadcrumbManager::class)
            ->shouldReceive('generate')->withArgs([])->andReturn([])
            ->getMock();

        $extension = new BreadcrumbExtension($manager);
        $this->assertInstanceOf(BreadcrumbExtension::class, $extension);

        $this->assertSame('userfrosting/breadcrumb', $extension->getName());
        $this->assertSame(['breadcrumbs' => []], $extension->getGlobals());
    }
}
