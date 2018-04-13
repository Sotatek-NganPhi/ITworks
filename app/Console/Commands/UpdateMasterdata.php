<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class UpdateMasterdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:update {lang?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update masterdata from json file to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $BATCH_SIZE = 500;
        try {
            DB::beginTransaction();
            $language = $this->argument('lang');
            $filename = empty($language) ? 'latest.json' : 'latest_'.$language.'.json';
            $path = storage_path('masterdata/'.$filename);
            $jsonData = json_decode(file_get_contents($path), true);
            foreach ($jsonData as $table => $values) {
                if(Schema::hasTable($table)) {
                    printf("Update table: %s\n", $table);
                    DB::table($table)->truncate();

                    $chunks = array_chunk($values, $BATCH_SIZE);
                    for ($chunkIndex = 0; $chunkIndex < count($chunks); $chunkIndex++) {
                        $chunk = $chunks[$chunkIndex];
                        DB::table($table)->insert($chunk);
                    }
                }
            }

            DB::commit();
            Cache::flush();
        } catch (Exception $e) {
            DB::rollback();
            printf ($e);
        }
    }
}
