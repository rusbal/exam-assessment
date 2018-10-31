<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Export extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function generateCsv()
    {
        $rows = DB::select("SELECT
                employees.id AS emp_id,
                employees.name AS emp_name,
                companies.id AS coy_id,
                companies.name AS coy_name,
                employees.created_at
            FROM employees
            LEFT JOIN company_employee ce ON ce.employee_id = employees.id
            LEFT JOIN companies ON ce.company_id = companies.id
            ");

        $csv = $this->toCsv($rows);
        $path = $this->nextFilename();
        Storage::disk('local')->put('public/'.$path, $csv);

        return url('storage/'.$path);
    }

    private function nextFilename()
    {
        return 'csv/export-'.time().'.csv';
    }

    private function toCsv($rows)
    {
        $out = [];
        $out[] = "\"Employee Name\",\"Employee ID\",\"Company Name\",\"Company ID\",\"Created\"";
        foreach ($rows as $row) {
            $date = explode(' ', $row->created_at)[0];
            $out[] = '"'.$row->emp_name.'",'.
                '"'.$row->emp_id.'",'.
                '"'.$row->coy_name.'",'.
                '"'.$row->coy_id.'",'.
                '"'.$date.'"';
        }
        return implode("\n", $out);
    }
}
