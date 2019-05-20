<?php

namespace App\Console\Commands\Kinoparser;

use App\Services\Kinoparser\Urls\Layouts\ListsOfPersonGetterFromFile;
use App\Services\Kinoparser\Urls\Layouts\PersonUrlsGetter;
use Illuminate\Console\Command;

class UrlsPerson extends Command
{

    /**
     * @var PersonUrlsGetter
     */
    private $urls;

    /**
     * @var ListsOfPersonGetterFromFile
     */
    private $lists;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kp:person-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Array urls of Person by person urls lists';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ListsOfPersonGetterFromFile $lists, PersonUrlsGetter $urls)
    {
        parent::__construct();
        $this->lists = $lists;
        $this->urls = $urls;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lists = $this->lists->getUrlsLists();
        $bar = $this->output->createProgressBar(count($lists));

        file_put_contents(PersonUrlsGetter::PESON_URLS, '');
        foreach ($lists as $list) {
            $this->urls->getPersonUrlsByList($list);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nDone!");
    }

}
