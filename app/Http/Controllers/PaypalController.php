<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

/**
 * Class PaypalController
 * @package App\Http\Controllers
 */
class PaypalController extends Controller
{
    /**
     * @var ApiContext
     */
    private $_api_context;

    /**
     * PaypalController constructor.
     */
    public function __construct()
    {
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * @return mixed
     */
    public function Payment(Request $request)
    {
        $sessionId = $request['id'];
        Session::put('cartid', $sessionId);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item = new Item();
        $item->setName($request['product_id'])
            ->setCurrency('EUR')
            ->setQuantity($request['quantity'])
            ->setPrice($request['price']);
        $items[] = $item;
        $itemlist = new ItemList();
        $itemlist->setItems($items);
        $amount = new Amount();
        $amount->setCurrency('EUR')->setTotal($request['quantity'] * $request['price']);
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemlist)->setDescription('THis is Demo Transaction');
        $redirect_url = new RedirectUrls();
        $redirect_url->setReturnUrl(URL::route('payment.status'))->setCancelurl(URL::route('payment.status'));
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_url)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EQL;
            } else {
                return redirect()->to(route('products.index'))->with('message', 'Some Error !');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }
        return redirect()->to('products')->with('error', 'Unknown Error occured');
    }

    /**
     * @return mixed
     */
    public function getPaymentStatus()
    {
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return redirect()->to('products.index')->with('error', 'Payment failed');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            session()->flash('message','Hey, You have a message to read');
            return redirect()->to(route('products.index'));
        }
        return redirect()->to(route('products.index'))->with('error', 'Payment failed');
    }
}

