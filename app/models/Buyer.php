<?php

class Buyer extends Eloquent {

    protected $table = 'buyer';

    public function race() {
        return $this->belongsTo('Race', 'race_id');
    }

}
