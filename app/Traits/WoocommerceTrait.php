<?php

namespace App\Traits;

use App\Models\Integration;
use Automattic\WooCommerce\Client;

class WoocommerceTrait
{


    public function getConnection()
    {
        try {

            $platform = Integration::first();

            if ($platform != null && $platform->count() > 0) {

                //instancia de la api
                $woocommerce = new Client(
                    $platform->url,
                    $platform->key,
                    $platform->secret,
                    [
                        'version' => 'wc/v3',
                    ]
                );
                //retornamos conexión
                return $woocommerce;
            } else {

                throw ('No hay credenciales de integración a woocommerce');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
