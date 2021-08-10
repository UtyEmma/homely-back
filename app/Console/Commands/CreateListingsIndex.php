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
    protected $signature = 'create:search-suggestions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an Index for Fuzzy Search suggestions';

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
    public function handle()
    {
        $tnt = new TNTSearch;
        $driver = config('database.default');

        $tnt->loadConfig(array_merge(config("database.connections.{$driver}"), [
            'storage' => storage_path(),
            'stemmer' => \TeamTNT\TNTSearch\Stemmer\NoStemmer::class
        ]));

        $edgeTokenizer = new \TeamTNT\TNTSearch\Support\EdgeNgramTokenizer;

        $indexer = $tnt->createIndex('listings.index');
        $indexer->query('SELECT id, title, description, type, landmark FROM listings');
        $indexer->setTokenizer($edgeTokenizer);
        $indexer->run();

        $productTokenizer = new \TeamTNT\TNTSearch\Support\ProductTokenizer;
        $indexer->setTokenizer($productTokenizer);
    }
}
