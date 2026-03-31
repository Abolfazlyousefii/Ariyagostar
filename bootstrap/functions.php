<?php

function route($name, $parameters = [], $absolute = true)
{
    $locale = request()->segment(1);

    if ($locale && array_key_exists($locale, config('app.locales'))) {
        return app('url')->route($locale . '.' . $name, $parameters, $absolute);
    }

    return app('url')->route($name, $parameters, $absolute);
}
