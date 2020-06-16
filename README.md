# Example Using Vue.js in Mezzio application

![ci build](https://github.com/samsonasik/mezzio-vue/workflows/ci%20build/badge.svg)

## Installation

*1.* Git clone

*2.* Run `composer install && composer development-enable`

*3.* Run PHP Development server

```php
composer serve
```

*4.* Open web browser http://localhost:8080

## Production

It has `webpack.config.js` in root directory that when we run `webpack` command. If you don't have a `webpack` installed yet in your system, you can install nodejs and install `webpack` and `webpack-cli`:

```bash
$ sudo npm install -g webpack
$ sudo npm install -g webpack-cli
```

we can get `public/js/dist/bundle.js` after run it:

```bash
$ webpack

Hash: 87078eb52a2e82bc4167
Version: webpack 4.43.0
Time: 166ms
Built at: 06/16/2020 1:56:19 PM
                   Asset      Size  Chunks             Chunk Names
public/js/dist/bundle.js  2.39 KiB       0  [emitted]  main
Entrypoint main = public/js/dist/bundle.js
[0] ./public/js/app.js + 3 modules 4.06 KiB {0} [built]
    | ./public/js/app.js 1.56 KiB [built]
    | ./public/js/create-page.js 876 bytes [built]
    | ./public/js/about.js 313 bytes [built]
    | ./public/js/portfolio.js 1.34 KiB [built]
```

After it generated, we can install the following commands to get `production` environment by default:

```bash
# ensure no left over file development config
$ rm config/development.config.php && rm config/autoload/development.local.php

# install with --no-dev
$ composer install --no-dev

# ensure no left over file cache before re-build cache
$ composer clear-config-cache
```

In `default.phtml`, we have a `isDevelopment()` view helper check to use `js/app.js` when on development, and use `/js/dist/bundle.js` on production when exists.

```php
// ...
    ->prependFile(
        $this->isDevelopment()
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