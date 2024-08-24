<?php

namespace App\Http\Requests\Traits;

use Illuminate\Support\Str;

trait CamelCasing
{
    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (method_exists($this, $key)) {
            return parent::getAttribute($key);
        }
        return parent::getAttribute(Str::snake($key));
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    public function getIdAttribute($id)
    {
        return (string) $this->attributes['id'];
    }
}
