<?php

namespace App\Traits;

trait GeneratesCode
{
    /**
     * Generates a code for the model if the code is null.
     *
     * @return void
     */
    protected static function bootGeneratesCode()
    {
        static::creating(function ($model) {
            if (is_null($model->code)) {
                $model->code = $model->generateCode();
            }
        });
    }

    /**
     * Generate a unique sequential code in the format 'XX-####'
     *
     * @return string
     */
    protected function generateCode()
    {
        $prefix = strtoupper(substr(class_basename($this), 0, 2));

        $lastCode = $this->where('code', 'like', "{$prefix}-%")
            ->orderBy('code', 'desc')
            ->value('code');

        if ($lastCode) {
            $lastNumber = (int) substr($lastCode, strlen($prefix) + 1);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $code = sprintf('%s-%04d', $prefix, $nextNumber);

        return $code;
    }
}
