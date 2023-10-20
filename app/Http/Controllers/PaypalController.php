<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalController extends Controller
{

    public function crearPedido()
    {
        // Configurar las credenciales de PayPal
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'ASEcyjPIaXP_T-jykoJDt9wjE48D7HC7nWC1zcSXNw5Sa71Ww_Hfa7czzgXfqFnNN3yzIA0_9FEA8HmK', // Reemplaza con tu Client ID de PayPal
                'EIWWF1plQUl2syTkUGQNL1dqDdOGgXf6SSgnqU5WAK9asNaa1E3zdkjZIs8ZDfKNE7B_2Y7axm0Oeou_' // Reemplaza con tu Secret de PayPal
            )
        );

        $apiContext->setConfig(['mode' => 'sandbox']);

        // Crea un objeto Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Crea un objeto Item (reemplaza esto con los detalles de tu producto)
        $item = new Item();
        $item->setName('Suscripcion')
            ->setCurrency('USD') // Cambia la moneda según tus necesidades
            ->setQuantity(1)
            ->setPrice(1); // Cambia el precio según tus necesidades

        // Crea un objeto ItemList
        $itemList = new ItemList();
        $itemList->setItems([$item]);

        // Crea un objeto Amount
        $amount = new Amount();
        $amount->setCurrency('USD') // Cambia la moneda según tus necesidades
            ->setTotal(1); // Cambia el total según tus necesidades

        // Crea una transacción
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Suscripcion mensual al sistema');

        // Crea un objeto RedirectUrls
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('/confirmar-pago')) // Reemplaza con la URL de confirmación de pago en tu aplicación
            ->setCancelUrl(url('/cancelar-pago')); // Reemplaza con la URL de cancelación en tu aplicación

        // Crea un objeto Payment
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        // Crea el pago y obtén la URL de redirección a PayPal
        try {
            $payment->create($apiContext);

            //return redirect()->to($payment->getApprovalLink());
            return $payment->getApprovalLink();
        } catch (Exception $ex) {
            // Maneja cualquier error que pueda ocurrir
            return redirect('/')->with('error', 'Hubo un error al crear el pedido.');
        }
    }

}