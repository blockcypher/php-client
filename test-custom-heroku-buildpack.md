Testing this Heroku builpack:

https://github.com/josecelano/heroku-buildpack-php

with GMP PHP extension enabled.

Using this custom buildpack:

```shell
heroku buildpacks:set https://github.com/josecelano/heroku-buildpack-php.git -a php-client-sample
```