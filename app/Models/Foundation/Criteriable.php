<?php

namespace App\Models\Foundation;

use App\Events\CriteriaDeleteEvent;

trait Criteriable
{
    public function delete()
    {
        if (parent::delete()) {
            event(new CriteriaDeleteEvent($this->id, $this->table));
            return true;
        }
        return false;
    }
}
