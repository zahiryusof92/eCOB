<?php

class Tenant extends Eloquent {

    protected $table = 'tenant';

    public function race() {
        return $this->belongsTo('Race', 'race_id');
    }

}
