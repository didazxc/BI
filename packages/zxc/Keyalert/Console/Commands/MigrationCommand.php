<?php

namespace Zxc\Keyalert\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Storage;

class MigrationCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'keyalert:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Keyalert specifications.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        Storage::makeDirectory('keyalert');
        
        $this->laravel->view->addNamespace('keylib', substr(__DIR__, 0, -8).'views');

        $keyalert_table          = config('keyalert.keyalert_table','zxc__key_alert');
        $keyalert_scripts_table       = config('keyalert.keyalert_scripts_table','zxc__key_alert_scripts');

        $this->line('');
        $this->info( "Tables: $keyalert_table, $keyalert_scripts_table" );

        $message = "A migration that creates '$keyalert_table' , '$keyalert_scripts_table'".
        " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {
            $this->line('');
            $this->info("Creating migration...");
            if ($this->createMigration(compact('keyalert_table','keyalert_scripts_table'))) {
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
        $migrationFile = base_path("/database/migrations")."/".date('Y_m_d_His')."_keyalert_setup_tables.php";

        $output = $this->laravel->view->make('keyalert::generators.migration')->with($tables)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }

}
