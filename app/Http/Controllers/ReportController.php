<?php

namespace App\Http\Controllers;

use PHPJasper\PHPJasper;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        $jasper = new PHPJasper();

        try {
            // Compila o relatório JRXML
            $jasper->compile(storage_path('reports/my_report.jrxml'))->execute();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
        }

        $input = storage_path('reports/my_report.jasper');
        $output = storage_path('reports/my_report');

        $params = [
            // Adicione parâmetros se necessário
        ];

        $options = [
            'format' => ['pdf'],
            'params' => $params,
            'db_connection' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => env('DB_DATABASE'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'jdbc_driver' => 'com.mysql.cj.jdbc.Driver',
                'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST') . ':' . env('DB_PORT') . '/' . env('DB_DATABASE') . '?useSSL=false', // useSSL=false
            ],
        ];

        try {

            $jasper->process($input, $output, $options)->execute();

            $file = $output . '.pdf';

            if (file_exists($file)) {
                return response()->file($file, [
                    'Content-Type' => 'application/pdf; charset=UTF-8',
                    'Content-Disposition' => 'inline; filename="report.pdf"',
                ]);
            }

            return response()->json(['message' => 'Relatório não encontrado'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
        }
    }
}
