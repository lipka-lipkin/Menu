<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Csv\StoreCsvRequest;
use App\Jobs\SendUnloadedCsv;

class CsvController extends Controller
{
    public function store(StoreCsvRequest $request)
    {
        SendUnloadedCsv::dispatch($request->user(), $request->from, $request->to);
        return ['status' => 'ok'];
    }
}
