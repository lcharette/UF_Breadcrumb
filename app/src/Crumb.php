<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb;

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
     * @var mixed[] Placeholder array for the title message into translator
     */
    protected $title_placeholder;

    /**
     * @var string|array<string,array> The route or uri.
     */
    protected $route;

    /**
     * Create a new Item object.
     *
     * @param string $title
     * @param string $uri
     */
    public function __construct(string $title = '', string $uri = '')
    {
        $this->setTitle($title);
        $this->setUri($uri);
    }

    /**
     * Set the title message key for translator.
     *
     * @param string  $title       The title message key for translator
     * @param mixed[] $placeholder
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get placeholder array for the title message into translator.
     *
     * @return mixed[]
     */
    public function getTitlePlaceholder(): array
    {
        return $this->title_placeholder;
    }

    /**
     * Set the uri from a route.
     *
     * @param string  $name The uri
     * @param mixed[] $data
     *
     * @return self
     */
    public function setRoute(string $name, array $data = [])
    {
        $this->route = [$name, $data];

        return $this;
    }

    /**
     * Set the raw uri.
     *
     * @param string $uri
     *
     * @return self
     */
    public function setUri(string $uri)
    {
        $this->route = $uri;

        return $this;
    }

    /**
     * Get the uri.
     *
     * @return string|array<mixed>
     */
    public function getRoute()
    {
        return $this->route;
    }
}
