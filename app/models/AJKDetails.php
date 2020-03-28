<?php

class AJKDetails extends Eloquent {
    protected $table = 'ajk_details';
    
    public function files() {
        return $this->belongsTo('Files', 'file_id');
    }
}