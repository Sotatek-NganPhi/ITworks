<?php

namespace App\Models;

use App\Consts;
use App\Manager;
use Eloquent as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class Company
 * @package App\Models
 * @version June 16, 2017, 6:41 am UTC
 */
class Company extends Model
{

    public $table = 'companies';

    public $fillable = [
        'name',
        'street_address',
        'contact_name',
        'phone_number',
        'short_description',
        'business_content',
        'email',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'email' => 'required|email',
        'name' => 'required|string',
        'street_address' => 'string',
        'contact_name' => 'string',
        'phone_number' => 'string',
        'short_description' => 'string',
        'business_content' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string',
        'street_address' => '',
        'contact_name' => '',
        'phone_number' => '',
        'short_description' => '',
        'email' => 'email',
    ];

    public function managers()
    {
        return $this->belongsToMany(Manager::class);
    }

    public function sycToManager(){
        if($this->id <= 0){
            Log:error('Id company invalid: ' . $this->id);
            return;
        }
        DB::beginTransaction();
        try{
            $manager = Manager::firstOrNew(['company_id' => $this->id]);
            $manager->username = $this->username;
            $manager->password = bcrypt($this->password);
            $manager->type = Consts::TYPE_COMPANY_ADMIN;
            $manager->name = $this->name;
            $manager->save();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

    public function deleteToManager(){
        DB::beginTransaction();
        try{
            Manager::where('company_id', $this->id)->delete();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }
}
