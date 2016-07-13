<?php

namespace Zxc\Keylib\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class MigrationCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'keylib:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Keylib specifications.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->laravel->view->addNamespace('keylib', substr(__DIR__, 0, -8).'views');

        $keylib_table          = config('keylib.keylib_table','zxc__key_lib');
        $keylib_dic_table       = config('keylib.keylib_dic_table','zxc__key_lib_dic');
        $keylib_sql_table       = config('keylib.keylib_sql_table','zxc__key_lib_sql');
        $keylib_realtime_table       = config('keylib.keylib_realtime_table','zxc__key_lib_realtime');
        $keylib_alert_table       = config('keylib.keylib_alert_table','zxc__key_lib_alert');

        $this->line('');
        $this->info( "Tables: $keylib_table, $keylib_dic_table, $keylib_sql_table, $keylib_realtime_table, $keylib_alert_table" );

        $message = "A migration that creates '$keylib_table' , '$keylib_dic_table' , '$keylib_sql_table' , '$keylib_realtime_table' , '$keylib_alert_table'".
        " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {
            $this->line('');
            $this->info("Creating migration...");
            if ($this->createMigration(compact('keylib_table','keylib_dic_table','keylib_sql_table','keylib_realtime_table','keylib_alert_table'))) {
                $this->info("Migration successfully created!");
            } else {
                $this->error(
                    "Couldn't create migration.\n Check the write permissions".
                    " within the database/migrations directory."
                );
            }

            $this->line('');

        }
    }

    /**
     * Create the migration.
     * @param $tables
     * @return bool
     */
    protected function createMigration($tables){
        $migrationFile = base_path("/database/migrations")."/".date('Y_m_d_His')."_keylib_setup_tables.php";

        $output = $this->laravel->view->make('keylib::generators.migration')->with($tables)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }

}
