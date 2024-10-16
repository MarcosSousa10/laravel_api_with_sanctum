<?php

namespace App\Http\Controllers;
use Exception;
use PHPJasper\PHPJasper;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
class ReportController extends Controller
{
public function generateReport(Request $request)
{
    $jasper = new PHPJasper();

    try {
        // Testa a conexão com o banco de dados
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()], 500);
    }

    try {
        // Compila o relatório JRXML
        $jasper->compile(storage_path('reports/my_report.jrxml'))->execute();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
    }

    $input = storage_path('reports/my_report.jasper');
    $output = storage_path('reports/my_report');
    
    // Defina seus parâmetros, se necessário
    $params = [
        // Exemplo de parâmetro: 'parametro' => 'valor'
    ];
    
    $jdbc_dir = base_path('vendor/geekcom/phpjasper-laravel/bin/jasperstarter/jdbc'); // Diretório JDBC

    // Configurações da conexão com o banco de dados
        $options = [
            'format' => ['pdf'],
            'params' => $params,
            'locale' => 'pt_BR',
            'db_connection' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'laravel_api_with_sanctums'),
                'username' => env('DB_USERNAME', 'user_laravel_api_with_sanctum'),
                'password' => env('DB_PASSWORD', 'acb'),
                'jdbc_driver' => 'com.mysql.cj.jdbc.Driver',
                'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST', '127.0.0.1') . ':' . env('DB_PORT', '3306') . '/' . env('DB_DATABASE', 'laravel_api_with_sanctums'),
            ],
        ];


    try {
        // Comando a ser executado como o usuário apache
   // $command = "/var/www/laravel_api_with_sanctum/vendor/geekcom/phpjasper-laravel/bin/jasperstarter/bin/jasperstarter process $input -o $output -f pdf --jdbc-dir $jdbc_dir";
            $report = $jasper->process($input, $output, $options)->execute();
//Log::info('Relatório processado com sucesso: ' . $report . '.pdf');
  //Log::info('Executando comando Jasper: ', [
    //            'input' => $input,
      //        'output' => $output,
        //        'options' => $options,
          //  ]);

        // Executa o comando e captura a saída
//        exec($command . ' 2>&1', $outputArray, $returnVar); // Captura erros também
//Log::info('Executando comando Jasper: ', [$command]);

        // Verifica se o comando foi bem-sucedido

  //      if ($returnVar !== 0) {
    //      throw new Exception('Erro ao executar o comando: ' . implode("\n", $outputArray));
    //}

        $file = $output . '.pdf';

        if (file_exists($file)) {
            return response()->file($file, [
                'Content-Type' => 'application/pdf; charset=UTF-8',
                'Content-Disposition' => 'inline; filename="report.pdf"',
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Arquivo PDF não encontrado.'], 404);
        }
    } catch (Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
    }
}

public function generateReportdd(Request $request)
{

    $jasper = new PHPJasper();

    try {
        $jasper->compile(storage_path('reports/my_report.jrxml'))->execute();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
    }

    $input = storage_path('reports/my_report.jasper');
    $output = storage_path('reports/my_report');

    $params = [
    ];

$options = [
    'format' => ['pdf'],
    'params' => $params,
    'db_connection' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'laravel_api_with_sanctums'),
        'username' => env('DB_USERNAME', 'user_laravel_api_with_sanctum'),
        'password' => env('DB_PASSWORD', 'acb'),
        'jdbc_driver' => 'com.mysql.cj.jdbc.Driver',
        'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST', '127.0.0.1') . ':' . env('DB_PORT', '3306') . '/' . env('DB_DATABASE', 'laravel_api_with_sanctums') . '?useSSL=true&requireSSL=true&verifyServerCertificate=true',
    ],
];


try {
    $result = $jasper->process($input, $output, $options);
    
    Log::info('Resultado do processamento do Jasper: ', ['resultado' => (array) $result]);

    $result->execute();
    $file = $output . '.pdf';

    if (file_exists($file)) {
        return response()->file($file, [
            'Content-Type' => 'application/pdf; charset=UTF-8',
            'Content-Disposition' => 'inline; filename="report.pdf"',
        ]);
    }

    return response()->json(['message' => 'Relatório não encontrado'], 500);
} catch (\Exception $e) {
    \Log::error('Erro ao gerar o relatório: ' . $e->getMessage());
    return response()->json(['error' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
}

}

  public function generateReport1(Request $request)
        {
            $jasper = new PHPJasper();
        
            try {
                // Testa a conexão com o banco de dados
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()], 500);
            }
        
            try {
                // Compila o relatório JRXML
                $jasper->compile(storage_path('reports/my_report1.jrxml'))->execute();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
            }
        
            $input = storage_path('reports/my_report1.jasper');
            $output = storage_path('reports/my_report1');
            
            // Defina seus parâmetros, se necessário
            $params = [
                // Exemplo de parâmetro: 'parametro' => 'valor'
            ];
            
            $jdbc_dir = base_path('vendor/geekcom/phpjasper-laravel/bin/jasperstarter/jdbc'); // Diretório JDBC
        
            // Configurações da conexão com o banco de dados
                $options = [
                    'format' => ['pdf'],
                    'params' => $params,
                    'locale' => 'pt_BR',
                    'db_connection' => [
                        'driver' => 'mysql',
                        'host' => env('DB_HOST', '127.0.0.1'),
                        'port' => env('DB_PORT', '3306'),
                        'database' => env('DB_DATABASE', 'laravel_api_with_sanctums'),
                        'username' => env('DB_USERNAME', 'user_laravel_api_with_sanctum'),
                        'password' => env('DB_PASSWORD', 'acb'),
                        'jdbc_driver' => 'com.mysql.cj.jdbc.Driver',
                        'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST', '127.0.0.1') . ':' . env('DB_PORT', '3306') . '/' . env('DB_DATABASE', 'laravel_api_with_sanctums'),
                    ],
                ];
        
        
            try {
                // Comando a ser executado como o usuário apache
           // $command = "/var/www/laravel_api_with_sanctum/vendor/geekcom/phpjasper-laravel/bin/jasperstarter/bin/jasperstarter process $input -o $output -f pdf --jdbc-dir $jdbc_dir";
                    $report = $jasper->process($input, $output, $options)->execute();
        
                $file = $output . '.pdf';
        
                if (file_exists($file)) {
                    return response()->file($file, [
                        'Content-Type' => 'application/pdf; charset=UTF-8',
                        'Content-Disposition' => 'inline; filename="report.pdf"',
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Arquivo PDF não encontrado.'], 404);
                }
            } catch (Exception $e) {
                // Captura e retorna qualquer erro que ocorrer
                return response()->json(['success' => false, 'message' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
            }
        }


public function generateReportSales(Request $request)
{
    $jasper = new PHPJasper();

    try {
        // Testa a conexão com o banco de dados
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()], 500);
    }

    try {
        // Compila o relatório JRXML
        $jasper->compile(storage_path('reports/my_report_sales.jrxml'))->execute();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
    }

    $input = storage_path('reports/my_report_sales.jasper');
    $output = storage_path('reports/my_report_sales');
    // Defina seus parâmetros, se necessário
    $params = [
        // Exemplo de parâmetro: 'parametro' => 'valor'
    ];

    $jdbc_dir = base_path('vendor/geekcom/phpjasper-laravel/bin/jasperstarter/jdbc'); // Diretório JDBC

    // Configurações da conexão com o banco de dados
        $options = [
            'format' => ['pdf'],
            'params' => $params,
            'locale' => 'pt_BR',
            'db_connection' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'laravel_api_with_sanctums'),
                'username' => env('DB_USERNAME', 'user_laravel_api_with_sanctum'),
                'password' => env('DB_PASSWORD', 'acb'),
                'jdbc_driver' => 'com.mysql.cj.jdbc.Driver',
                'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST', '127.0.0.1') . ':' . env('DB_PORT', '3306') . '/' . env('DB_DATABASE', 'laravel_api_with_sanctums'),
            ],
        ];


    try {
        // Comando a ser executado como o usuário apache
   // $command = "/var/www/laravel_api_with_sanctum/vendor/geekcom/phpjasper-laravel/bin/jasperstarter/bin/jasperstarter process $input -o $output -f pdf --jdbc-dir $j>           
 $report = $jasper->process($input, $output, $options)->execute();
//Log::info('Relatório processado com sucesso: ' . $report . '.pdf');
  //Log::info('Executando comando Jasper: ', [
    //            'input' => $input,
      //        'output' => $output,
        //        'options' => $options,
          //  ]);

        // Executa o comando e captura a saída
//        exec($command . ' 2>&1', $outputArray, $returnVar); // Captura erros também
//Log::info('Executando comando Jasper: ', [$command]);

        // Verifica se o comando foi bem-sucedido

  //      if ($returnVar !== 0) {
    //      throw new Exception('Erro ao executar o comando: ' . implode("\n", $outputArray));
    //}

        $file = $output . '.pdf';

        if (file_exists($file)) {
            return response()->file($file, [
                'Content-Type' => 'application/pdf; charset=UTF-8',
                'Content-Disposition' => 'inline; filename="report.pdf"',
            ]);
        } else {
          return response()->json(['success' => false, 'message' => 'Arquivo PDF não encontrado.'], 404);
        }
    } catch (Exception $e) {
        // Captura e retorna qualquer erro que ocorrer
        return response()->json(['success' => false, 'message' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
    }
}
    public function ddgenerateReportSales(Request $request)
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
                'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST', '127.0.0.1') . ':' . env('DB_PORT', '3306') . '/' . env('DB_DATABASE', 'laravel_api_with_sanctums') . '?useSSL=false&verifyServerCertificate=false',

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
                            // Testa a conexão com o banco de dados
                            DB::connection()->getPdo();
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()], 500);
                        }
                    
                        try {
                            // Compila o relatório JRXML
                            $jasper->compile(storage_path('reports/my_report_Sales_itens.jrxml'))->execute();
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Erro ao compilar o relatório: ' . $e->getMessage()], 500);
                        }
                    
                        $input = storage_path('reports/my_report_Sales_itens.jasper');
                        $output = storage_path('reports/my_report_Sales_itens');
                        // Defina seus parâmetros, se necessário
                        $params = [
                           'id'=> $id
                        ];
                    
                        $jdbc_dir = base_path('vendor/geekcom/phpjasper-laravel/bin/jasperstarter/jdbc'); // Diretório JDBC
                    
                        // Configurações da conexão com o banco de dados
                            $options = [
                                'format' => ['pdf'],
                                'params' => $params,
                                'locale' => 'pt_BR',
                                'db_connection' => [
                                    'driver' => 'mysql',
                                    'host' => env('DB_HOST', '127.0.0.1'),
                                    'port' => env('DB_PORT', '3306'),
                                    'database' => env('DB_DATABASE', 'laravel_api_with_sanctums'),
                                    'username' => env('DB_USERNAME', 'user_laravel_api_with_sanctum'),
                                    'password' => env('DB_PASSWORD', 'acb'),
                                    'jdbc_driver' => 'com.mysql.cj.jdbc.Driver',
                                    'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST', '127.0.0.1') . ':' . env('DB_PORT', '3306') . '/' . env('DB_DATABASE', 'laravel_api_with_sanctums'),
                                ],
                            ];
                    
                    
                        try {
                            // Comando a ser executado como o usuário apache
                       // $command = "/var/www/laravel_api_with_sanctum/vendor/geekcom/phpjasper-laravel/bin/jasperstarter/bin/jasperstarter process $input -o $output -f pdf --jdbc-dir $j>           
                     $report = $jasper->process($input, $output, $options)->execute();
                    //Log::info('Relatório processado com sucesso: ' . $report . '.pdf');
                      //Log::info('Executando comando Jasper: ', [
                        //            'input' => $input,
                          //        'output' => $output,
                            //        'options' => $options,
                              //  ]);
                    
                            // Executa o comando e captura a saída
                    //        exec($command . ' 2>&1', $outputArray, $returnVar); // Captura erros também
                    //Log::info('Executando comando Jasper: ', [$command]);
                    
                            // Verifica se o comando foi bem-sucedido
                    
                      //      if ($returnVar !== 0) {
                        //      throw new Exception('Erro ao executar o comando: ' . implode("\n", $outputArray));
                        //}
                    
                            $file = $output . '.pdf';
                    
                            if (file_exists($file)) {
                                return response()->file($file, [
                                    'Content-Type' => 'application/pdf; charset=UTF-8',
                                    'Content-Disposition' => 'inline; filename="report.pdf"',
                                ]);
                            } else {
                              return response()->json(['success' => false, 'message' => 'Arquivo PDF não encontrado.'], 404);
                            }
                        } catch (Exception $e) {
                            // Captura e retorna qualquer erro que ocorrer
                            return response()->json(['success' => false, 'message' => 'Erro ao gerar o relatório: ' . $e->getMessage()], 500);
                        }
                    }
}
