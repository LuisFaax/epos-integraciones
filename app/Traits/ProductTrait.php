<?php


namespace App\Traits;

use App\Traits\WoocommerceTrait;

trait ProductTrait
{

    use WoocommerceTrait;


    function createProduct($product)
    {

        $woocommerce = $this->getConnection();

        $categories = $product->categories()->get()->map(function ($category) {
            return ['id' => $category->id];
        })->toArray();


        $data = [
            'sku' => $product->sku,
            'name' => $product->name,
            'description' => $product->description,
            'type' => $product->type, //'simple',
            'status' => $product->status, //'publish',
            'visibility' => $product->visibility, //'visible',
            'price' => $product->price, //precio base
            'regular_price' => $product->price, // precio al que normalmente se muestra el producto
            'sale_price' => $product->price2, // precio al que se vendio, con descuento 
            'stock_status' => $product->stock_status, //'in stock',
            'manage_stock' => $product->manage_stock,
            'stock_quantity' => $product->stock_qty,
            'low_stock' => $product->low_stock,
            'categories' => $categories,
        ];

        $result = $woocommerce->post('products', $data);

        $product->platform_id = $result->id;
        $product->save();

        return true;
    }

    function updateProduct($product)
    {
        $woocommerce = $this->getConnection();

        $categories = $product->categories()->get()->map(function ($category) {
            return ['id' => $category->id];
        })->toArray();


        $data = [
            'sku' => $product->sku,
            'name' => $product->name,
            'description' => $product->description,
            'type' => $product->type,
            'status' => $product->status,
            'visibility' => $product->visibility,
            'price' => $product->price,
            'regular_price' => $product->price,
            'sale_price' => $product->price2,
            'stock_status' => $product->stock_status,
            'manage_stock' => $product->manage_stock,
            'stock_quantity' => $product->stock_qty,
            'low_stock' => $product->low_stock,
            'categories' => $categories,
        ];

        $result = $woocommerce->put("products/{$product->platform_id}", $data);

        $product->platform_id = $result->id;
        $product->save();

        return true;
    }

    function deleteProduct($id, $force = false)
    {
        $woocommerce = $this->getConnection();

        $orders = $woocommerce->get('orders', ['per_page' => 1, 'product' => $id]);

        if (!empty($orders)) {
            return false;
        } else {

            $woocommerce->delete("products/{$id}", ['force' => $force]);

            return true;
        }
    }


    function findOrCreateProductByName($product)
    {
        $woocommerce = $this->getConnection();


        $params = ['search' => $product->name];


        $result = $woocommerce->get('products', $params);

        if (!empty($result)) {
            $product->platform_id = $result[0]->id;
            $product->save();
        } else {
            $this->createProduct($product);
        }
    }
}
