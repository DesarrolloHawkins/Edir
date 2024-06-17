<?php

if (!function_exists('enviarMensajeWhatsapp')) {
    function enviarMensajeWhatsapp($template, $nombre, $telefono, $idioma = 'es') {
        $token = env('TOKEN_WHATSAPP', 'valorPorDefecto');

        switch ($template) {
            case 'actualizacion_aviso':
                $mensajePersonalizado = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => $telefono,
                    "type" => "template",
                    "template" => [
                        "name" => $template,
                        "language" => ["code" => $idioma],
                    ],
                ];
                break;
                case 'nueva_incidencia':
                    $mensajePersonalizado = [
                        "messaging_product" => "whatsapp",
                        "recipient_type" => "individual",
                        "to" => $telefono,
                        "type" => "template",
                        "template" => [
                            "name" => $template,
                            "language" => ["code" => $idioma],
                        ],
                        "components" => [
                            [
                                "type" => "body",
                                "parameters" => [
                                    ["type" => "text", "text" => $nombre],
                                ],
                            ],
                        ],
                    ];
                break;
                case 'nuevo_aviso':
                    $mensajePersonalizado = [
                        "messaging_product" => "whatsapp",
                        "recipient_type" => "individual",
                        "to" => $telefono,
                        "type" => "template",
                        "template" => [
                            "name" => $template,
                            "language" => ["code" => $idioma],
                        ],
                    ];
                break;
                case 'nuevos_anuncios':
                    dd($nombre);
                    switch($nombre['tipo']){
                        case 1:
                            $texto ='anuncio';
                            break;
                        case 2:
                            $texto ='anuncio con enlace';
                            break;
                        case 3:
                            $texto ='anuncio con imagen';
                            break;
                        case 4:
                            $texto ='anuncio con archivo';
                            break;
                        default:
                        break;
                    }
                    $mensajePersonalizado = [
                        "messaging_product" => "whatsapp",
                        "recipient_type" => "individual",
                        "to" => $telefono,
                        "type" => "template",
                        "template" => [
                            "name" => $template,
                            "language" => ["code" => $idioma],
                        ],
                        "components" => [
                            [
                                "type" => "body",
                                "parameters" => [
                                    ["type" => "text", "text" => $texto ],
                                    ["type" => "text", "text" => $nombre['seccion'] ],
                                ],
                            ],
                        ],
                    ];
                break;
            default:
                # code...
                break;
        }

        $urlMensajes = 'https://graph.facebook.com/v19.0/312803688580839/messages';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlMensajes,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($mensajePersonalizado),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $json_response = json_decode($response, true);
    }
}
