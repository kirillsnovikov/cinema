<?php

namespace App\Console\Commands\Kinoparser;

use App\Services\Kinoparser\Curl\BaseCurl;
use App\Services\Kinoparser\Options\ReferersSetterFromHotlog;
use Illuminate\Console\Command;

class Referers extends Command
{

    /**
     * @var ReferersSetterFromHotlog
     */
    private $referers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kp:referers-hl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get referers from Hotlog pages and write in config file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ReferersSetterFromHotlog $referers)
    {
        parent::__construct();
        $this->referers = $referers;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i = 1; $i <= 40; $i++) {
            $lists[] = 'http://top1000-ru.hotlog.ru/?page=' . $i . '&cat_id=90000';
            $lists[] = 'http://top1000-ru.hotlog.ru/?page=' . $i . '&cat_id=50000';
            $lists[] = 'http://top1000-ru.hotlog.ru/?page=' . $i . '&cat_id=180000';
        }
        $bar = $this->output->createProgressBar(count($lists));

        file_put_contents(BaseCurl::REFERERS_FILE, '');

        foreach ($lists as $list) {
            $this->referers->setRefferersIntoFile($list);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nDone!");
    }

}
