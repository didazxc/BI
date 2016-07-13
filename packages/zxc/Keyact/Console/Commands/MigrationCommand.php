<?php

namespace Zxc\Keyact\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'keyact:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Keyact specifications.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->laravel->view->addNamespace('keyact', substr(__DIR__, 0, -8).'views');

        $key_act          = Config::get('keyact.keyact_table');

		$data = compact('key_act');
		
        $this->line('');
        $this->info( "Tables: $key_act" );

        $message = "A migration that creates '$key_act' ".
        " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

		
		
		
        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration($data)) {

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
     * @param $data
     * @return bool
     */
    protected function createMigration($data)
    {
        $migrationFile = base_path("/database/migrations")."/".date('Y_m_d_His')."_keyact_setup_tables.php";
	
        $output = $this->laravel->view->make('keyact::generators.migration')->with($data)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
