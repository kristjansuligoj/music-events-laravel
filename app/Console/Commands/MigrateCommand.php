<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset migrations, run migrations, and seed the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate:reset');
        $this->call('migrate');
        $this->call('db:seed');

        $this->info('Migrations reset, migrations ran, and database seeded.');
    }
}
