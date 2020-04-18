<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests;

use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Crumb;
use UserFrosting\Tests\TestCase;

/**
 * CrumbTest
 *
 * Perform test for UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Crumb
 */
class CrumbTest extends TestCase
{
    public function testConstructor(): void
    {
        $crumb = new Crumb();
        $this->assertInstanceOf(Crumb::class, $crumb);

        $this->assertSame('', $crumb->getTitle());
        $this->assertSame([], $crumb->getTitlePlaceholder());
        $this->assertSame('', $crumb->getRouteName());
        $this->assertSame([], $crumb->getRouteData());
        $this->assertSame(false, $crumb->getActive());
    }

    /**
     * @dataProvider crumbProvider
     */
    public function testCrumbsConstructor($title, $route, $active): void
    {
        $crumb = new Crumb($title, $route, $active);
        $this->assertInstanceOf(Crumb::class, $crumb);

        $this->assertSame($title, $crumb->getTitle());
        $this->assertSame([], $crumb->getTitlePlaceholder());
        $this->assertSame($route, $crumb->getRouteName());
        $this->assertSame([], $crumb->getRouteData());
        $this->assertSame($active, $crumb->getActive());
    }

    /**
     * @dataProvider crumbProvider
     */
    public function testCrumbs($title, $route, $active): void
    {
        $crumb = new Crumb();
        $crumb->setTitle($title)
              ->setRoute($route)
              ->setActive($active);
        $this->assertInstanceOf(Crumb::class, $crumb);

        $this->assertSame($title, $crumb->getTitle());
        $this->assertSame([], $crumb->getTitlePlaceholder());
        $this->assertSame($route, $crumb->getRouteName());
        $this->assertSame([], $crumb->getRouteData());
        $this->assertSame($active, $crumb->getActive());
    }

    /**
     * @dataProvider crumbProvider
     */
    public function testCrumbsData($title, $route, $active, $placeholders, $data): void
    {
        $crumb = new Crumb();
        $crumb->setTitle($title, $placeholders)
              ->setRoute($route, $data)
              ->setActive($active);
        $this->assertInstanceOf(Crumb::class, $crumb);

        $this->assertSame($title, $crumb->getTitle());
        $this->assertSame($placeholders, $crumb->getTitlePlaceholder());
        $this->assertSame($route, $crumb->getRouteName());
        $this->assertSame($data, $crumb->getRouteData());
        $this->assertSame($active, $crumb->getActive());
    }

    /**
     * @dataProvider badCrumbProvider
     */
    public function testBadCrumbsConstructor($title, $route, $active): void
    {
        $this->expectException(\TypeError::class);
        new Crumb($title, $route, $active);
    }

    /**
     * @dataProvider badCrumbProviderData
     */
    public function testBadCrumbsData($title, $route, $active, $placeholders, $data): void
    {
        $crumb = new Crumb();

        $this->expectException(\TypeError::class);
        $crumb->setTitle($title, $placeholders)
              ->setRoute($route, $data)
              ->setActive($active);
    }

    /**
     * [$title, $route, $active, $placeholders, $data]
     */
    public function crumbProvider()
    {
        return [
            ['foo', 'bar', true, [], []],
            ['foo', 'bar', false, [], []],
            ['bar', 'foo', true, ['ME' => 'MOI'], ['arg' => 'blah']],
            ['', '', true, ['ME' => 'MOI'], ['arg' => 'blah']],
        ];
    }

    /**
     * [$title, $route, $active, $placeholders, $data]
     */
    public function badCrumbProvider()
    {
        return [
            [null, 'bar', true],
            ['foo', [], false],
            ['bar', 'foo', []],
        ];
    }

    /**
     * [$title, $route, $active, $placeholders, $data]
     */
    public function badCrumbProviderData()
    {
        return [
            [null, 'bar', true, [], []],
            ['foo', [], false, [], []],
            ['bar', 'foo', [], [], []],
            ['foo', 'bar', true, 'blah', []],
            ['foo', 'bar', true, [], null],
        ];
    }
}
