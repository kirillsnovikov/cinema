<?php

namespace App\Console\Commands\Kinoparser;

use App\Services\Kinoparser\Person\PersonHtmlGetter;
use App\Services\Kinoparser\Urls\Layouts\PersonUrlsGetterFromFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
        $urls = $this->getRemainUrls();
//        dd($urls);
        $bar = $this->output->createProgressBar(count($urls));

        foreach ($urls as $url) {
            $this->html->putHtmlInFile($url);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nDone!");
    }

    private function getRemainUrls()
    {
        $this->info("\nSort Urls in process!");
        $disk = Storage::disk('person');
        $files = $disk->allFiles();

        foreach ($files as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $url = 'https://www.kinopoisk.ru/name/' . $name;
            $handled_urls[] = $url;
        }
        $all_urls = $this->urls->getUrls();
        $remain_urls = array_diff($all_urls, $handled_urls);
        natsort($remain_urls);
        $this->info("\nSort Urls is Done!");

        return $remain_urls;
    }

}
