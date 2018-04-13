<?php

namespace App\Models;

use App\Consts;
use App\Http\Requests\API\UpdateMasterdataAPIRequest;
use App\Manager;
use App\Models\Foundation\VersionedModel as VersionedModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ReferralAgency
 * @package App\Models
 * @version September 8, 2017, 4:34 am UTC
 */
class ReferralAgency extends VersionedModel
{

    public $table = 'referral_agencies';
    public static $tablename = 'referral_agencies';
    public static function getTableName() { return self::$tablename; }



    public $fillable = [
        'name',
        'code',
        'password',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|unique:managers,username',
        'password' => 'required',
        'name' => 'required',
    ];

    public function customUpdate(UpdateMasterdataAPIRequest $request)
    {
        if ($this->code !== $request->code) {
            $candidates = DB::table('user_references')->join('candidates', 'candidates.user_id', '=', 'user_references.user_id')
                ->where('referral_code', $this->code)->select('candidates.id')->count();
            if ($candidates > 0) {
                return [
                    'success' => false,
                    'message' => 'Agency code is in use',
                ];
            }
        }
        $this->update($request->all());
        return ['success' => true];
    }

    public function customDestroy()
    {
        $candidates = DB::table('user_references')->join('candidates', 'candidates.user_id', '=', 'user_references.user_id')
            ->where('referral_code', $this->code)->select('candidates.id')->count();
        if($candidates > 0) {
            return  [
                'success' => false,
                'message' => 'Agency is in use',
            ];
        }
        $this->delete();
        return ['success' => true];
    }

    public function sycToManager(){
        if($this->id <= 0){
            Log:error('Id agency invalid: ' . $this->id);
            return;
        }
        DB::beginTransaction();
        try{
            $manager = Manager::firstOrNew(['agency_id' => $this->id]);
            $manager->username = $this->code;
            $manager->password = bcrypt($this->password);
            $manager->type = Consts::TYPE_AGENCY_ADMIN;
            $manager->name = $this->name;
            $manager->save();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }
}
