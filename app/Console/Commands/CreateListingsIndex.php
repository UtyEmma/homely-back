<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TNTSearch;

class CreateListingsIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:listings';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an Index for Listings Search';
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
     * @return int
     */
    public function handle(){
        // $tnt = new TNTSearch();
        $indexer = TNTSearch::createIndex('listings.index');
        $indexer->query('SELECT id, unique_id, title, description, type, landmark FROM listings;');
        $indexer->run();
    }
}
