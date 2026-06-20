<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests;

use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb;
use UserFrosting\Testing\TestCase;

/**
 * Test case with Admin as main sprinkle
 */
class BreadcrumbTestCase extends TestCase
{
    protected string $mainSprinkle = Breadcrumb::class;
}