<?php

namespace Emporium\Svc\Alert\Http\Controller;

function marshalEntity() {
    return function($obj) {
        $data = [];
        foreach ($obj as $key => $val) {
            if ($val instanceof \DateTime) {
                $val = $val->format('r');
            }
            if (is_object($val) && property_exists($val, 'id')) {
                $val = ['id' => $val->id];
            }

            $data[$key] = $val;
        }
        return $data;
    };
}
