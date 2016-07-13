<?php

namespace Zxc\Keytask\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'keytask:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Keysql specifications.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->laravel->view->addNamespace('keytask', substr(__DIR__, 0, -8).'views');

        $key_task          = Config::get('keytask.keytask_table');
        $key_task_hour          = Config::get('keytask.keytaskhour_table');

        $this->line('');
        $this->info( "Tables: $key_task , $key_task_hour" );

        $message = "A migration that creates '$key_task','$key_task_hour' ".
        " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration($key_task,$key_task_hour)) {

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
     * @param $key_task
     * @param $key_task_hour
     * @return bool
     */
    protected function createMigration($key_task,$key_task_hour)
    {
        $migrationFile = base_path("/database/migrations")."/".date('Y_m_d_His')."_keytask_setup_tables.php";

        $data = compact('key_task','key_task_hour');

        $output = $this->laravel->view->make('keytask::generators.migration')->with($data)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
