<?php

namespace App\Libraries\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Deletable
{
    /**
     * Check able delete record if it exists in relates model
     *
     * @return void
     */
    public function scopeDeletable()
    {
        foreach ($this->getRelates() as $relate) {
            if ($this->$relate()->count()) {
                return collect(['message' => false]);
            }
        }
        return collect([$this->delete(), 'message' => true]);
    }

    /**
     * Get relates model
     *
     * @return mixed
     */
    protected function getRelates()
    {
        return array_get($this->relates, 'relates', []);
    }
}
