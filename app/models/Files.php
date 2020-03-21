<?php

class Files extends Eloquent {
    protected $table = 'files';
    
     public function strata() {
        return $this->hasOne('Strata', 'file_id');
    }
}