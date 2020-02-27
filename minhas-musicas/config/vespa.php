<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Custom Vespa Client Configuration
    |--------------------------------------------------------------------------
    |
    | This array will be passed to the Vespa client.
    |
    */

    'host' => env('VESPA_HOST', 'http://localhost:8080'),

    'model_columns' => [
        'status' => 'vespa_status',
        'date' => 'vespa_ultima_indexacao'
    ],

	'namespace' => [
        'letras' => [
            'document' => [
                [
                    'type' => '',
                    'class' => null,
                    'table' =>  '',
                ]
            ]
        ],
    ],

    'default' => [
        'client' => \Escavador\Vespa\Models\VespaRESTClient::class,
	        'vespa_rest_client' => [
            'max_concurrency' => 24
        ],
        #define os valores defautl para os queryProfile mapeado no Vespa. Ver arquivos de configurações no caminho abaixo:
        # resources/config/vendor/vespa/src/main/application/search/query-profiles/
        'query_profile' => [
            #Os valores devem estar iguais aos do arquivo api.xml
            "api" => [
                'max_offset' => 20000,
                'max_hits' => 100,
                'timeout' => 20000,
            ],
            #Os valores devem estar iguais aos do arquivo default.xml
            "default" => [
                'max_offset' => 1000,
                'max_hits' => 20,
                'timeout' => 1000,
            ]
        ],
        'limit' => 10000,
        'bulk' => 1000,
        'max_parallel_feed_requests' => 256,
        'set_language' => 'pt-BR',
        'log' => [
            'channel' => 'vespa'
        ],
        'timeout' => '500', //O timeout default  do Vespa é 500ms.
    ]
);
