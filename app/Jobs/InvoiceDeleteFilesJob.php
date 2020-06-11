<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InvoiceDeleteFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $FilePdf, $FileXml ) {
        Storage::disk('Files')->delete( $FilePdf );
        Storage::disk('Files')->delete( $FileXml ); 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
   
    }
}
