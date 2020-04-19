<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Breadcrumb;

/**
 * Representation of a breadcrumb element.
 */
class Crumb
{
    /**
     * @var string The title message key for translator
     */
    protected $title;

    /**
     * @var array Placeholder array for the title message into translator
     */
    protected $title_placeholder;

    /**
     * @var string|array<string,array> The route or uri.
     */
    protected $route;

    /**
     * @var bool Is this an active node.
     */
    protected $active;

    /**
     * Create a new Item object.
     *
     * @param string $title
     * @param string $uri
     * @param bool   $active
     */
    public function __construct(string $title = '', string $uri = '', bool $active = false)
    {
        $this->setTitle($title);
        $this->setUri($uri);
        $this->setActive($active);
    }

    /**
     * Set the title message key for translator.
     *
     * @param string $title       The title message key for translator
     * @param array  $placeholder
     *
     * @return self
     */
    public function setTitle(string $title, array $placeholder = [])
    {
        $this->title = $title;
        $this->title_placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the title message key for translator.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get placeholder array for the title message into translator.
     *
     * @return array
     */
    public function getTitlePlaceholder()
    {
        return $this->title_placeholder;
    }

    /**
     * Set the uri.
     *
     * @param string $name The uri
     * @param array  $data
     *
     * @return self
     */
    public function setRoute(string $name, array $data = [])
    {
        $this->route = [$name, $data];

        return $this;
    }

    public function setUri(string $uri)
    {
        $this->route = $uri;

        return $this;
    }

    /**
     * Get the uri.
     *
     * @return string|array<string,array>
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set is this an active node.
     *
     * @param bool $active Is this an active node
     *
     * @return self
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get is this an active node.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }
}
