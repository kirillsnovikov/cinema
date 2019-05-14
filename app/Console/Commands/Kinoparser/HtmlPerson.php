<?php

namespace App\Console\Commands\Kinoparser;

use App\Services\Kinoparser\Person\PersonHtmlGetter;
use App\Services\Kinoparser\Urls\Layouts\PersonUrlsGetterFromFile;
use Illuminate\Console\Command;

class HtmlPerson extends Command
{

    /**
     * @var PersonUrlsGetterFromFile
     */
    private $urls;

    /**
     * @var PersonHtmlGetter
     */
    private $html;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kp:person-html';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put Person html page in file. Format \'kp_id.html\' (123458.html)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PersonHtmlGetter $html, PersonUrlsGetterFromFile $urls)
    {
        parent::__construct();
        $this->html = $html;
        $this->urls = $urls;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $urls = $this->urls->getUrls();
        $bar = $this->output->createProgressBar(count($urls));
//        dd($urls);
        foreach ($urls as $url) {
            $this->html->putHtmlInFile($url);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nDone!");
    }

}
