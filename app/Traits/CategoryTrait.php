<?php

namespace App\Traits;

use App\Traits\WoocommerceTrait;
use Illuminate\Support\Facades\Log;


trait CategoryTrait
{

    use WoocommerceTrait;

    public function getCategories()
    {

        $woocommerce = $this->getConnection();

        return $woocommerce->get('products/categories');
    }

    public function createCategory($name)
    {
        try {
            $woocommerce = $this->getConnection();

            $data = ['name' => $name];

            $result = $woocommerce->post('products/categories', $data);

            Log::info(json_encode($result));

            return $result->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateCategory($category)
    {
        try {
            $woocommerce = $this->getConnection();

            $data = [
                'name' => $category->name
            ];

            $result = $woocommerce->put("products/categories/{$category->platform_id}", $data);

            return $result->id;
            //

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function findOrCreateCategoryByName($category)
    {
        try {
            $woocommerce = $this->getConnection();

            $params = [
                'search' => $category->name
            ];

            $result = $woocommerce->get('products/categories', $params);

            Log::info(json_encode($result));

            if (!empty($result)) {
                $category->platform_id = $result[0]->id;
                $category->save();
            } else {
                $result = $this->createCategory($category->name);
                $category->platform_id = $result;
                $category->save();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
