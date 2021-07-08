<?php

namespace App\Traits;

/**
 * Trait DynamicSetterTrait.
 */
trait DynamicSetterTrait
{
    /**
     * dynamic setter.
     *
     * @param array $data
     * @param bool $checkEmpty
     * @return $this
     */
    public function dynamicSet(array $data = [], bool $checkEmpty = false): self
    {
        foreach ($data as $key => $value) {
            if ($checkEmpty && (is_null($value) || empty($value) || '' == $value)) {
                continue;
            } else {
                $key = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
                $method = 'set'.$key;
                if (method_exists($this, $method)) {
//                    call_user_func_array([$this, $method], [$value]);
                    $this->$method($value);
                }
            }
        }

        return $this;
    }
}
