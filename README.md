# Breadcrumb Sprinkle for [UserFrosting 4](https://www.userfrosting.com)

[![Donate][kofi-badge]][kofi]
[![Latest Version][releases-badge]][releases]
[![UserFrosting Version][uf-version]][uf]
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Travis][travis-badge]][travis]
[![Codecov][codecov-badge]][codecov]
[![StyleCI][styleci-badge]][styleci]

[kofi]: https://ko-fi.com/A7052ICP
[kofi-badge]: https://img.shields.io/badge/Donate-Buy%20Me%20a%20Coffee-blue.svg
[releases]: https://github.com/lcharette/UF_Breadcrumb/releases
[releases-badge]: https://img.shields.io/github/release/lcharette/UF_Breadcrumb.svg
[uf-version]: https://img.shields.io/badge/UserFrosting->=%204.3-brightgreen.svg
[uf]: https://github.com/userfrosting/UserFrosting
[travis]: https://travis-ci.org/lcharette/UF_Breadcrumb
[travis-badge]: https://travis-ci.org/lcharette/UF_Breadcrumb.svg?branch=master
[codecov]: https://codecov.io/gh/lcharette/UF_Breadcrumb
[codecov-badge]: https://codecov.io/gh/lcharette/UF_Breadcrumb/branch/master/graph/badge.svg
[styleci]: https://styleci.io/repos/70994902
[styleci-badge]: https://styleci.io/repos/70994902/shield?branch=master&style=flat

This Sprinkle provides an helper service and Twig template to manage simple page breadcrumb for [UserFrosting 4](https://www.userfrosting.com).

# Help and Contributing

If you need help using this sprinkle or found any bug, feels free to open an issue or submit a pull request. You can also find me on the [UserFrosting Chat](https://chat.userfrosting.com/) most of the time for direct support.

# Installation
Edit UserFrosting `app/sprinkles.json` file and add the following to the `require` list : `"lcharette/uf_breadcrumb": "^3.0.0"`. Also add `Breadcrumb` to the `base` list. For example:

```json
{
    "require": {
        "lcharette/uf_breadcrumb": "^3.0.0"
    },
    "base": [
        "core",
        "account",
        "admin",
        "Breadcrumb"
    ]
}
```

Run `composer update` then `php bakery bake` to install the sprinkle.

## Usage

### Adding crumbs
Breadcrumbs hierarchy needs to be manually defined in each controllers. To dynamically add breadcrumbs to the UI, simply use the `add` method of the `breadcrumb` service:

```php
// add($name, $uri = "")
$this->ci->breadcrumb->add('Item name', 'path/');
```

You can also chain multiple methods :

```php
$this->ci->breadcrumb->add("Projects", "projects/")
                     ->add("Project Foo", "projects/foo")
                     ->add("Settings");
```

The crumbs can also be created using the `Crumb` object :

```php
$crumb = new Crumb();
$crumb->setTitle('Item name')->setUri('path/');
$this->ci->breadcrumb->addCrumb($crumb);
```

The item name can also be switched for a translation key :
```php
$this->ci->breadcrumb->add(['TRANSLATION_KEY', ['placeholder' => 'Value']], 'path/');

// or

$crumb = new Crumb();
$crumb->setTitle('TRANSLATION_KEY', ['placeholder' => 'Value'])->setUri('path/');
```

Path is actually optional if you don't want to provide a link with your crumb. Alternatively, a route name / route pattern placeholders can also be used :

```php
$this->ci->breadcrumb->add('Item name', ['route_name', ['id' => '123']]);

// or

$crumb = new Crumb();
$crumb->setTitle('Item name')->setRoute('route_name', ['id' => '123']);
```

### Prepend crumbs
You can also use the `prepend` method to add a new item to the beginning of the list:

```php
//prepend($name, $uri = "")
$this->ci->breadcrumb->prepend("Item name", "path/");

// or

$this->ci->breadcrumb->prependCrumb($crumb);
```

Note that the site index is automatically added to the beginning of the list, whether you use `prepend` or not.

**If you don't add any custom breadcrumbs, it will fallback to the default UserFrosting behaviour.**

## Custom style

The default UserFrosting layouts and themes will pick up the breadcrumbs automatically. If your UserFrosting theme doesn't include breadcrumbs automatically, simply add this line to your twig files:

```html
{% include 'navigation/breadcrumb.html.twig' with {page_title: block('page_title')} %}
```

If you want to edit the style of the breadcrumbs, simply copy the `templates/navigation/breadcrumb.html.twig` file in your own sprinkle and edit according to your styling. No custom assets are included with this sprinkle.

# Licence
By [Louis Charette](https://github.com/lcharette). Copyright (c) 2020, free to use in personal and commercial software as per the MIT license.
