<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    public function created(Company $company)
    {
        $company->sycToManager();
    }

    public function updated(Company $company)
    {
        $company->sycToManager();
    }

    public function saved(Company $company)
    {
        $company->sycToManager();
    }

    public function deleting(Company $company)
    {
        $company->deleteToManager();
    }
}