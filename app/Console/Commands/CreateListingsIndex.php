<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TeamTNT\TNTSearch\TNTSearch;

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
    protected $description = 'GEt LAravel Index';

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

        $tnt = new TNTSearch();
        $driver = config('database.default');

        $tnt->loadConfig(array_merge( config("database.connections.{$driver}"), [
            'storage'   => storage_path(),
            'stemmer'   => \TeamTNT\TNTSearch\Stemmer\NoStemmer::class//optional
        ] ));

        $edgeTokenizer = new \TeamTNT\TNTSearch\Support\EdgeNgramTokenizer;

        $indexer = $tnt->createIndex('listing.index');
        $indexer->query('SELECT id, description, type FROM listings;');
        $indexer->setTokenizer($edgeTokenizer);

        $indexer->run();
    }
}
