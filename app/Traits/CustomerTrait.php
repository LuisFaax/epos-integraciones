<?php


namespace App\Traits;

use App\Traits\WoocommerceTrait;

trait CustomerTrait
{

    use WoocommerceTrait;


    function createOrUpdateCustomer($customer, $isCreating = true)
    {

        $woocommerce = $this->getConnection();


        $billingDelivery = $customer->deliveries()->where('type', 'billing')->first();
        $shippingDelivery = $customer->deliveries()->where('type', 'shipping')->first();

        $data = [
            'email' => $customer->email,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'username' => trim($customer->first_name) . '.' . trim($customer->last_name),
            'billing' => [
                'first_name' => $billingDelivery->first_name ?? '',
                'last_name' => $billingDelivery->last_name ?? '',
                'company' =>  $billingDelivery->company ?? '',
                'address_1' => $billingDelivery->address1 ?? '',
                'address_2' => $billingDelivery->address2 ?? '',
                'city' => $billingDelivery->city ?? '',
                'state' => $billingDelivery->state ?? '',
                'postcode' => $billingDelivery->postcode ?? '',
                'country' => $billingDelivery->country ?? '',
                'email' => $billingDelivery->email ?? $customer->email,
                'phone' => $billingDelivery->phone ?? ''
            ],
            'shipping' => [
                'first_name' => $shippingDelivery->first_name ?? '',
                'last_name' => $shippingDelivery->last_name ?? '',
                'company' =>  $shippingDelivery->company ?? '',
                'address_1' => $shippingDelivery->address1 ?? '',
                'address_2' => $shippingDelivery->address2 ?? '',
                'city' => $shippingDelivery->city ?? '',
                'state' => $shippingDelivery->state ?? '',
                'postcode' => $shippingDelivery->postcode ?? '',
                'country' => $shippingDelivery->country ?? ''
            ]
        ];

        if ($isCreating) {
            $result = $woocommerce->post('customers', $data);
            $customer->platform_id = $result->id;
            $customer->save();
        } else {
            if ($customer->platform_id) {
                $woocommerce->put("customers/{$customer->platform_id}", $data);
            } else {
                $result = $woocommerce->post('customers', $data);
                $customer->platform_id = $result->id;
                $customer->save();
            }
        }

        return true;
    }
}
