<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReadOnlyBase
{
    protected $countries = [];
    protected $timezones = [];

    public function all ( $element ){
        return $this->$element;
    }

    public function timezones() {
        return $this->timezones;
    }

}
