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
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'laravel_api_with_sanctums',
                'username' => 'user_laravel_api_with_sanctum',
                'password' => 'acb',
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
    public function generateReport1(Request $request)
    {
        $jasper = new PHPJasper();

        try {
            // Compila o relatório JRXML
            $jasper->compile(storage_path('reports/my_report1.jrxml'))->execute();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
        }

        $input = storage_path('reports/my_report1.jasper');
        $output = storage_path('reports/my_report1');

        $params = [
            // Adicione parâmetros se necessário
        ];

        $options = [
            'format' => ['pdf'],
            'params' => $params,
            'db_connection' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'laravel_api_with_sanctums',
                'username' => 'user_laravel_api_with_sanctum',
                'password' => 'acb',
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
                    'Content-Disposition' => 'inline; filename="report1.pdf"',
                ]);
            }

            return response()->json(['message' => 'Relatório não encontrado'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
        }
    }
    public function generateReportSales(Request $request)
    {
        $jasper = new PHPJasper();

        try {
            // Compila o relatório JRXML
            $jasper->compile(storage_path('reports/my_report_sales.jrxml'))->execute();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
        }

        $input = storage_path('reports/my_report_sales.jasper');
        $output = storage_path('reports/my_report_sales');

        $params = [
            // Adicione parâmetros se necessário
        ];

        $options = [
            'format' => ['pdf'],
            'params' => $params,
            'db_connection' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'laravel_api_with_sanctums',
                'username' => 'user_laravel_api_with_sanctum',
                'password' => 'acb',
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
                    'Content-Disposition' => 'inline; filename="my_report_sales.pdf"',
                ]);
            }

            return response()->json(['message' => 'Relatório não encontrado'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
        }
    }
    public function generateReportSalesItens(Request $request, $id)
    {
        $jasper = new PHPJasper();

        try {
            // Compila o relatório JRXML
            $jasper->compile(storage_path('reports/my_report_Sales_itens.jrxml'))->execute();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
        }

        $input = storage_path('reports/my_report_Sales_itens.jasper');
        $output = storage_path('reports/my_report_Sales_itens');

        $params = [
            'id' => $id, // Adiciona o id aqui
        ];

        $options = [
            'format' => ['pdf'],
            'params' => $params,
            'db_connection' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'laravel_api_with_sanctums',
                'username' => 'user_laravel_api_with_sanctum',
                'password' => 'acb',
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
                    'Content-Disposition' => 'inline; filename="my_report_Sales_itens.pdf"',
                ]);
            }

            return response()->json(['message' => 'Relatório não encontrado'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
        }
    }
}
