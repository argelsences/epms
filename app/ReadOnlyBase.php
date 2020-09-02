<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReadOnlyBase
{
    protected $countries = [];

    public function all ( $element ){
        return $this->$element;
    }

}
