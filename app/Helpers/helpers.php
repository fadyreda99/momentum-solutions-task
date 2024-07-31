<?php

if (! function_exists('generate_order_code')) {
    /**
     * Generate a new order code based on the latest order ID.
     *
     * @return string
     */
    function generate_order_code()
    {
        $lastOrder = \App\Models\Order::latest('id')->first();
        $nextId = ($lastOrder ? $lastOrder->id + 1 : 1);
        return sprintf('ord-%05d', $nextId);
    }


}
