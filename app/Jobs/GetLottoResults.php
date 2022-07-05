<?php

namespace App\Jobs;

use App\DB\Repositories\LottoResultRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class GetLottoResults implements ShouldQueue
{
    protected $repository;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->repository = app(LottoResultRepository::class);
        $rows = file('http://www.mbnet.com.pl/dl_plus.txt');
        DB::transaction(function () use ($rows) {
            $lastDateResult = $this->repository->newQuery()->orderByDesc('date')->limit(1)->first();
            if (!empty($lastDateResult->date ?? '')) {
                $lastDate = Carbon::parse($lastDateResult->date)->format('d.m.Y');
            }

            foreach (array_reverse($rows) as $row) {
                preg_match('/[0-9]{2}\.[0-9]{2}\.[0-9]{4}/s', $row, $match);
                preg_match('/\s([0-9,]{11,17})/s', $row, $match2);
                $numbers = explode(',', trim($match2[1] ?? ''));
                $findedDate = $match[0] ?? '';
                if (!empty($findedDate) && (strtotime($findedDate) > strtotime($lastDate ?? 0)) && count($numbers) == 6) {
                    foreach ($numbers as $number) {
                        $this->repository->insert(['date' => Carbon::parse($findedDate)->format('Y-m-d'), 'number' => $number]);
                        echo sprintf('Dodano wynik %s z dnia %s', $number, $findedDate);
                        echo '<br>';
                    }
                } else {
                    echo sprintf('Nie dodano %s', $row);
                    echo '<br>';
                    break;
                }
            }
        });
    }
}
