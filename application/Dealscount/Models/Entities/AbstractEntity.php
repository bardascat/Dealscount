<?php

namespace Dealscount\Models\Entities;

abstract class AbstractEntity {

    public function postHydrate($post_params, $customMap = false) {
        $reflect = new \ReflectionObject($this);

        foreach ($post_params as $key => $value) {

            if (property_exists($this, $key)) {
                $prop = $reflect->getProperty($key);

                if (!$prop->isPrivate()) {

                    if (validateDate($value, 'd-m-Y') || validateDate($value, 'd-m-Y H:i:s')) {
                        $value = new \DateTime($value);
                    }

                    $this->$key = $value;
                }
            }
            if ($customMap)
                foreach ($customMap as $key => $prop) {
                    $this->$prop = $post_params[$key];
                }
        }
   
    }

    public function generateStdObject() {
        $class = new \stdClass;

        foreach ($this as $key => $value) {
            $class->$key = $value;
        }
        return $class;
    }

}

function validateDate($date, $format = 'Y-m-d H:i:s') {
    $d = \DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

?>
