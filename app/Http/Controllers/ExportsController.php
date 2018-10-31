<?php

namespace App\Http\Controllers;

use App\Export;
use App\Mail\CsvExported;
use Illuminate\Support\Facades\Mail;

class ExportsController extends Controller
{
    public function store(Export $export)
    {
        $csvUri = $export->generateCsv();

        Mail::to(auth()->user())->send(new CsvExported($csvUri));

        return response()->json([ 'csv_uri' => $csvUri ], 201);
    }
}
