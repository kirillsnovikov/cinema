<?php

namespace App\Console\Commands\Kinoparser;

use App\Services\Kinoparser\Options\CountriesGetterFromFile;
use App\Services\Kinoparser\Urls\Layouts\ListsOfPersonGetter;
use Illuminate\Console\Command;

class UrlsPersonLists extends Command
{

    /**
     * @var ListsOfPersonGetter
     */
    private $list;

    /**
     * @var CountriesGetterFromFile
     */
    private $countries;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kp:person-lists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Array of Urls with persons lists';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CountriesGetterFromFile $countries, ListsOfPersonGetter $list)
    {
        parent::__construct();
        $this->countries = $countries;
        $this->list = $list;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countries = $this->countries->getCountries();
        $bar = $this->output->createProgressBar(count($countries));

        file_put_contents(ListsOfPersonGetter::PERSON_URLS_LISTS, '');
        foreach ($countries as $country) {

            $this->list->getUrlsListsByCountry($country);

            if ($this->getOutput()->isVerbose()) {
                $this->info("\n  " . $country);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nDone!");
    }

}
