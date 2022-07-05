<?php

namespace App\Http\Controllers\Api;

use App\DB\Models\LottoResult;
use App\DB\Repositories\LottoResultRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LottoController extends ApiController
{
    public function __construct(protected LottoResultRepository $repository)
    {

    }

    public function data($date)
    {
        try {
            $date = Carbon::parse($date)->format('Y-m-d');
            $lottoResults = $this->repository->newQuery()->where('date', $date)->get()->pluck('number')->toArray();
            return $this->responseSuccess([$date => $lottoResults]);
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    public function number($number)
    {
        if($number > 1 && $number <=49){
            $lottoResults = $this->repository->newQuery()->where('number', $number)->get()->pluck('date')->toArray();
            return $this->responseSuccess(['count' => count($lottoResults), 'results' => $lottoResults]);
        }else{
            return $this->responseFailed('Nieprawidlowy format/numer.');

        }
    }

}
