<?php

namespace Zxc\Keysql\Console\Commands;

use Illuminate\Console\Command;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'keysql:migration';

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
        $this->laravel->view->addNamespace('keysql', substr(__DIR__, 0, -8).'views');

        $key_sql          = config('keysql.keysql_table','zxc__key_sql');
        $key_sql_nav       = config('keysql.keysqlnav_table','zxc__key_sql_nav');
        $key_sql_access_log       = config('keysql.accesslog_table','zxc__key_sql_access_log');

        $this->line('');
        $this->info( "Tables: $key_sql, $key_sql_nav, $key_sql_access_log" );

        $message = "A migration that creates '$key_sql' , '$key_sql_nav', '$key_sql_access_log'".
        " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration($key_sql, $key_sql_nav,$key_sql_access_log)) {

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
     * @param $key_sql
     * @param $key_sql_nav
     * @return bool
     */
    protected function createMigration($key_sql, $key_sql_nav,$key_sql_access_log)
    {
        $migrationFile = base_path("/database/migrations")."/".date('Y_m_d_His')."_keysql_setup_tables.php";

        $data = compact('key_sql', 'key_sql_nav','key_sql_access_log');

        $output = $this->laravel->view->make('keysql::generators.migration')->with($data)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
