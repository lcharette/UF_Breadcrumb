<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests\Unit;

use Mockery as m;
use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Manager;
use UserFrosting\Sprinkle\Breadcrumb\Twig\BreadcrumbExtension;
use UserFrosting\Tests\TestCase;

/**
 * Perform test for UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\BreadcrumbExtension
 */
class BreadcrumbExtensionTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testConstructor(): void
    {
        $manager = m::mock(Manager::class);
        $manager->shouldReceive('generate')->withArgs([])->andReturn([]);

        $extension = new BreadcrumbExtension($manager);
        $this->assertInstanceOf(BreadcrumbExtension::class, $extension);

        $this->assertSame('userfrosting/breadcrumb', $extension->getName());
        $this->assertSame(['breadcrumbs' => []], $extension->getGlobals());
    }
}
