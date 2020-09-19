# Example Using Vue.js in Mezzio application

![ci build](https://github.com/samsonasik/mezzio-vue/workflows/ci%20build/badge.svg)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fsamsonasik%2Fmezzio-vue%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/samsonasik/mezzio-vue/master)
[![Code Coverage](https://codecov.io/gh/samsonasik/mezzio-vue/branch/master/graph/badge.svg)](https://codecov.io/gh/samsonasik/mezzio-vue)
[![Downloads](https://poser.pugx.org/samsonasik/mezzio-vue/downloads)](https://packagist.org/packages/samsonasik/mezzio-vue)

> Version ~0.0.3 is for Vue 2 usage in Mezzio application

Introduction
------------

A Mezzio 3 Skeleton Application with Vue.js integration.

Features
--------

- SPA application with Vue Router with cached pages after visited.
- Using server side template from Mezzio, compiled with `Vue.compile()` in Vue.js component's `render()`.
- Using Vuex for state management library, combo with sessionStorage on portfolio page.

## Setup

*1.* Run composer create-project command:

```bash
composer create-project samsonasik/mezzio-vue
composer development-enable
```

*2.* Run PHP Development server

```php
cd mezzio-vue
composer serve
```

*3.* Open web browser http://localhost:8080

## Production

For deploy to production purpose, it has `webpack.config.js` in root directory that when we run `webpack` command, we can get `public/js/dist/bundle.js` after run it. If you don't have a `webpack` installed yet in your system, you can install nodejs and install `webpack` and `webpack-cli`:

```bash
sudo npm install -g webpack
sudo npm install -g webpack-cli
```

So, we can run:

```bash
webpack

Hash: 6ed53cca3add09d67d7f
Version: webpack 4.43.0
Time: 462ms
Built at: 06/22/2020 5:14:09 PM
                   Asset     Size  Chunks             Chunk Names
public/js/dist/bundle.js  2.9 KiB       0  [emitted]  main
Entrypoint main = public/js/dist/bundle.js
[0] ./public/js/app.js + 5 modules 5.08 KiB {0} [built]
    | ./public/js/app.js 1.61 KiB [built]
    | ./public/js/create-page.js 918 bytes [built]
    | ./public/js/about.js 388 bytes [built]
    | ./public/js/portfolio.js 1.68 KiB [built]
    | ./public/js/store.js 183 bytes [built]
    | ./public/js/portfolio-store-module.js 353 bytes [built]
```

After it generated, we can run the following commands to get `production` environment by default:

```bash
# ensure no left over file development config
rm config/development.config.php && rm config/autoload/development.local.php

# install with --no-dev
composer install --no-dev

# ensure no left over file cache before re-build cache
composer clear-config-cache
```

In `default.phtml`, we have a `isDevelopment()` view helper check to use `js/app.js` when on development, and use `/js/dist/bundle.js` on production when exists.

```php
// src/App/templates/layout/default.phtml
$isDevelopment = $this->isDevelopment();

// ...
    ->prependFile(
        $isDevelopment
            ? '/js/app.js'
            : (
                // when after run webpack, allow to use bundled js
                // fallback to use /js/app.js when not
                file_exists('./public/js/dist/bundle.js')
                    ? '/js/dist/bundle.js'
                    : '/js/app.js'
            ),
        'module'
    )
// ...
```

that will automatically take care of that.