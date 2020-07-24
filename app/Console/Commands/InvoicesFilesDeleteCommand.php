<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Storage;
class InvoicesFilesDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'InvoicesFilesDelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borrar archivos innecesarios.';

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
/*           $files = Storage::disk('Files')->files();
          foreach ($files as $File ) {
              Storage::disk('Files')->delete( $File);
          } */
    }
}
