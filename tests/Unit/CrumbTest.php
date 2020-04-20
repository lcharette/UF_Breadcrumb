<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests\Unit;

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
        $this->assertSame('', $crumb->getRoute());
    }

    /**
     * @dataProvider crumbProvider
     */
    public function testCrumbsConstructor($title, $route): void
    {
        $crumb = new Crumb($title, $route);
        $this->assertInstanceOf(Crumb::class, $crumb);

        $this->assertSame($title, $crumb->getTitle());
        $this->assertSame([], $crumb->getTitlePlaceholder());
        $this->assertSame($route, $crumb->getRoute());
    }

    /**
     * @dataProvider crumbProvider
     */
    public function testCrumbs($title, $route): void
    {
        $crumb = new Crumb();
        $crumb->setTitle($title)
              ->setUri($route);
        $this->assertInstanceOf(Crumb::class, $crumb);

        $this->assertSame($title, $crumb->getTitle());
        $this->assertSame([], $crumb->getTitlePlaceholder());
        $this->assertSame($route, $crumb->getRoute());
    }

    /**
     * @dataProvider crumbProvider
     */
    public function testCrumbsData($title, $route, $placeholders, $data): void
    {
        $crumb = new Crumb();
        $crumb->setTitle($title, $placeholders)
              ->setRoute($route, $data);
        $this->assertInstanceOf(Crumb::class, $crumb);

        $this->assertSame($title, $crumb->getTitle());
        $this->assertSame($placeholders, $crumb->getTitlePlaceholder());
        $this->assertSame([$route, $data], $crumb->getRoute());
    }

    /**
     * @dataProvider badCrumbProvider
     */
    public function testBadCrumbsConstructor($title, $route): void
    {
        $this->expectException(\TypeError::class);
        new Crumb($title, $route);
    }

    /**
     * @dataProvider badCrumbProviderData
     */
    public function testBadCrumbsData($title, $route, $placeholders, $data): void
    {
        $crumb = new Crumb();

        $this->expectException(\TypeError::class);
        $crumb->setTitle($title, $placeholders)
              ->setRoute($route, $data);
    }

    /**
     * [$title, $route, $placeholders, $data]
     */
    public function crumbProvider()
    {
        return [
            ['foo', 'bar', [], []],
            ['foo', 'bar', [], []],
            ['bar', 'foo', ['ME' => 'MOI'], ['arg' => 'blah']],
            ['', '', ['ME' => 'MOI'], ['arg' => 'blah']],
        ];
    }

    /**
     * [$title, $route, $placeholders, $data]
     */
    public function badCrumbProvider()
    {
        return [
            [null, 'bar'],
            ['foo', []],
        ];
    }

    /**
     * [$title, $route, $placeholders, $data]
     */
    public function badCrumbProviderData()
    {
        return [
            [null, 'bar', [], []],
            ['foo', [], [], []],
            ['foo', 'bar', 'blah', []],
            ['foo', 'bar', [], null],
        ];
    }
}
