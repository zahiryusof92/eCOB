<?php

class Files extends Eloquent {
    protected $table = 'files';
    
     public function strata() {
        return $this->hasOne('Strata', 'file_id');
    }
    
    public function company() {
        return $this->belongsTo('Company', 'company_id');
    }
}