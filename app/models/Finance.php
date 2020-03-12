<?php

class Finance extends Eloquent {
    protected $table = 'finance_file';

    public function file(){
        return $this->belongsTo('Files', 'file_id');
    }
}