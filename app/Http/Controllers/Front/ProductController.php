<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Admin\CouponDesign;
use App\Models\Admin\Modifier;
use App\Models\Admin\Offering;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Plivo\RestClient;
use Plivo\Resources\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailToAllSubscribers;

class ProductController extends Controller
{
    public function index()
    {
        // return redirect('https://booksy.com/en-us/637898_absolute-barbershop-vip-salons_barber-shop_134655_los-angeles');

        $sliders = DB::table('sliders')->where('page','shop')->get();
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $shop = DB::table('page_shop_items')->where('id', 1)->first();
        // $products = DB::table('products')->orderBy('product_order', 'asc')->where('product_status', 'Show')->get();
        $products = Product::with(['variant', 'modifiers'])->orderBy('product_order', 'asc')->where('product_status', 'Show')->get();
        $categories = ProductCategory::all();
        $is_shop=true;
        $services = Offering::all();
        $appointed_slots = $this->appointed_slots();

        return view('pages.shop', compact('shop','g_setting','products', 'categories', 'sliders','is_shop', 'services', 'appointed_slots'));
    }


    public function detail($slug)
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $product_detail = DB::table('products')->where('product_slug', $slug)->first();
        if(!$product_detail) {
            return abort(404);
        }
        return view('pages.product_detail', compact('g_setting','product_detail'));
    }

    public function add_to_cart(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_count = $request->input('product_count');
        $variant = $request->input('variant');
        $modifiers = $request->get('products_modifiers', []);

        // Handle variant
        if ($variant) {
            $product_id = $product_id . '--' . $variant;
        }

        // Check if items available in stock or not
        $product = Product::findOrFail($product_id);
        if(!$this->check_if_stock_available($product, $product_count)) {
            return redirect()->back()->with('error', 'Sorry! There are only '.$product->product_stock.' item(s) in stock');
        }

        // Add products according to count
        for ($i = 0; $i < $product_count; $i++) {
            session()->push('cart_product_id', $product_id);
            session()->push('cart_product_qty', 1);
            session()->push('cart_modifier_id' , $modifiers);
        }

        return redirect()->back()->with('success', 'Item(s) are added to the cart successfully!');
    }

    private function check_if_stock_available(Product $product, $count)
    {
        // Check if cart is empty
        if (!(Session::has('cart_product_id') && Session::has('cart_product_id'))) {
            return true;
        }

        // Calculate total quantity of given product either with variant or not
        $product_qtys = Session::get('cart_product_qty');
        $cart_product_total_qty = 0;

        foreach (Session::get('cart_product_id') as $index => $value) {
            // Handle variant if exists
            $product_arr = explode("--", $value);
            $session_product_id = isset($product_arr[0]) ? $product_arr[0] : $value;

            if ($product->id == $session_product_id) {
                $cart_product_total_qty += $product_qtys[$index];
            }
        }

        return $product->product_stock >= $cart_product_total_qty + $count;
    }

    public function cart()
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $modifiers = Modifier::all();
        $selected_modifiers = $modifiers->whereIn('id', session()->get('modifiers_added', []))->all();
        return view('pages.cart', compact('g_setting', 'modifiers', 'selected_modifiers'));
    }

    public function cart_item_delete($id, $index)
    {
        // Remove product ID
        $cart_product_id = session()->get('cart_product_id');
        if (array_key_exists($index, $cart_product_id)) {
            unset($cart_product_id[$index]);
            $cart_product_id = array_values($cart_product_id);

            // Handle general modifiers for empty cart
            if (count($cart_product_id) < 1) {
                Session::forget(['modifiers_added', 'modifiers_qtys', 'cart_product_id']);
            } else {
                Session::put('cart_product_id', $cart_product_id);
            }
        }
        // Remove product qty
        $cart_product_qty = session()->get('cart_product_qty');
        if (array_key_exists($index, $cart_product_qty)) {
            unset($cart_product_qty[$index]);
            $cart_product_qty = array_values($cart_product_qty);

            if (count($cart_product_qty) < 1) {
                Session::forget('cart_product_qty');
            } else {
                Session::put('cart_product_qty', $cart_product_qty);
            }
        }
        // Remove modifier ID array
        $cart_modifier_id = session()->get('cart_modifier_id');
        if (array_key_exists($index, $cart_modifier_id)) {
            unset($cart_modifier_id[$index]);
            $cart_modifier_id = array_values($cart_modifier_id);

            if (count($cart_modifier_id) < 1) {
                Session::forget('cart_modifier_id');
            } else {
                Session::put('cart_modifier_id', $cart_product_qty);
            }
        }

        Session::save();

        return redirect()->back()->with('success', 'Item is deleted from the cart successfully!');
    }

    public function update_cart(Request $request)
    {
        $error_flag = false;
        $data = $request->validate([
            'product_id' => 'required|array',
            'product_qty' => 'required|array',
            'products_modifiers' => 'sometimes|array',
            'products_modifiers.*' => 'required|array',
        ]);

        $cart_product_qty = session()->get('cart_product_qty');
        $cart_modifier_id = session()->get('cart_modifier_id');

        foreach(session()->get('cart_product_id') as $key => $value) {
            $product_arr = explode("--", $value);
            $session_product_id = isset($product_arr[0]) ? $product_arr[0] : $value;
            $product = Product::findOrFail($session_product_id);

            // Handle quantity w.r.t stock availibility
            $total_qty = $this->get_cart_product_qty_difference($session_product_id, $data['product_qty']);
            if($total_qty > $product->product_stock) {
                $error_flag = true;
            } else {
                $cart_product_qty[$key] = $data['product_qty'][$key];
                Session::put('cart_product_qty', $cart_product_qty);
            }

            // Handle empty modifiers
            if (isset($data['products_modifiers'][$key])) {
                $cart_modifier_id[$key] = $data['products_modifiers'][$key];
            } else {
                $cart_modifier_id[$key] = array();
            }
        }

        Session::put('cart_modifier_id', $cart_modifier_id);

        if($error_flag) {
            return redirect()->back()->with('error', 'Those quantity will not be updated that are more than stock.');
        }

        return redirect()->back()->with('success', 'Cart is updated successfully!');
    }

    private function get_cart_product_qty_difference($product_id, $new_qty)
    {
        $cart_product_qty = Session::get('cart_product_qty');
        $difference = 0;
        $total = 0;

        foreach (Session::get('cart_product_id') as $key => $value) {
            $product_arr = explode("--", $value);
            $session_product_id = isset($product_arr[0]) ? $product_arr[0] : $value;

            if ($product_id == $session_product_id) {
                $total += $cart_product_qty[$key];
                $difference += $new_qty[$key] - $cart_product_qty[$key];
            }
        }

        return $difference + $total;
    }

    public function checkout()
    {
        if(!session()->get('cart_product_id'))
        {
            return redirect()->to('/');
        }
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $shipping_data = DB::table('shippings')->orderBy('shipping_order', 'asc')->get();

        if(!session()->get('shipping_id'))
        {
            session()->put('shipping_id', 0);
            session()->put('shipping_cost', '0');
        }

        if(!session()->get('coupon_id'))
        {
            session()->put('coupon_id', 0);
            session()->put('coupon_code', '');
            session()->put('coupon_amount', '0');
        }

        return view('pages.checkout', compact('g_setting', 'shipping_data'));
    }

    public function shipping_update(Request $request)
    {
        $shipping_id = $request->input('shipping_id');
        $shipping_detail = DB::table('shippings')->where('id', $shipping_id)->first();

        session()->put('shipping_id', $shipping_id);
        session()->put('shipping_cost', $shipping_detail->shipping_cost);

        return redirect()->back()->with('success', 'Shipping method is selected successfully!');
    }

    public function coupon_update(Request $request)
    {
        $coupon_code = $request->input('coupon_code');
        $today = date('Y-m-d');

        $coupon_detail = DB::table('coupons')->where('coupon_code', $coupon_code)->first();
		if(!$coupon_detail) {
            return redirect()->back()->with('error', 'Wrong coupon code!');
        }

        $coupon_id = $coupon_detail->id;
        $coupon_discount = $coupon_detail->coupon_discount;
        $coupon_type = $coupon_detail->coupon_type;

        if($coupon_detail->coupon_existing_use == $coupon_detail->coupon_maximum_use) {
            return redirect()->back()->with('error', 'Coupon code is maximum time used!');
        }

        if($today < $coupon_detail->coupon_start_date) {
            return redirect()->back()->with('error', 'Date of this coupon code is not come yet!');
        }

        if($today > $coupon_detail->coupon_end_date) {
            return redirect()->back()->with('error', 'Date of this coupon code is expired!');
        }

        if($coupon_type== 'Percentage') {
            $arr['coupon_amount'] = (session()->get('subtotal') * $coupon_discount)/100;
        } else {
            $arr['coupon_amount'] = $coupon_discount;
        }

        session()->put('coupon_code', $coupon_code);
        session()->put('coupon_amount', $arr['coupon_amount']);
        session()->put('coupon_id', $coupon_id);

        if(!session()->get('shipping_cost')) {
            $temp1 = 0;
        } else {
            $temp1 = session()->get('shipping_cost');
        }

        $final_price = (session()->get('subtotal')+$temp1)-session()->get('coupon_amount');
	    $arr['final_price'] = $final_price;

        return redirect()->back()->with('success', 'Coupon is selected successfully!');
    }

    public function avail_offering(Request $request)
    {
        $data = $this->validate_offering($request);

        if (!preg_match('/^\+1|^1/', $data['client_phone'])) {
            $data['client_phone'] = '+1' . $data['client_phone'];
        }

        Session::put('offering', $data);
        return redirect()->route('front.checkout_offering')->with('success', 'Please Make Payment to Book Service.');
    }

    public function checkout_offering()
    {
        if (!Session::has('offering')) {
            return redirect()->route('front.shop')->with('error', 'No service is added yet');
        }

        $session_offering = Session::get('offering');
        $offering = Offering::findOrFail($session_offering['offering_id']);
        $enabled_modes = DB::table('service_payment_modes')
            ->where('service_type', $session_offering['rate_type'])
            ->where('enabled', 1)
            ->get();

        $final_price = $session_offering['rate_type'] == 'regular'
            ? $offering->regular_rate
            : $offering->appointed_rate;

        $slots = $this->appointed_slots();

        return view('pages.service_checkout', compact('offering', 'final_price', 'session_offering', 'enabled_modes', 'slots'));
    }

    public function update_offering(Request $request)
    {

        $data = $this->validate_offering($request);
        $data["appointment_date"] =  $data["rate_type"] == "appointed" ? $data["appointment_date"] : null;
        $data["appointment_time"] =  $data["rate_type"] == "appointed" ? $data["appointment_time"] : null;

        Session::put('offering', $data);


        $session_offering = $request->session()->get('offering', []);

        // Save the tip amount to the session if it's from the tip form
        if ($request->input('tip_amount')>=0) {
            $session_offering['tip_amount'] = $request->input('tip_amount', 0);
            $request->session()->put('offering', $session_offering);
        }


        // Save back to session
        $request->session()->put('offering', $session_offering);




        return redirect()->back()->with('success', 'Service is updated successfully');
    }

    public function payment_offering_cash()
    {
        if (!Session::has('offering')) {
            return redirect()->route('front.shop')->with('error', 'No service is added yet');
        }

        $data = $this->setup_order("cash");

        if ($data["is_appointed"] && is_null($data["appointment_time"])) {
            return back()->with('error', 'For appointment, You must select an available time slot');
        }

        $data["created_at"] = now();

        DB::table('service_orders')->insert($data);

        $this->send_email_to_admin($data);
        $this->send_sms_to_customer($data);
        $this->send_sms_to_admin($data);

        Session::put("payment_mode", "cash");
        Session::put("order_no", $data["order_no"]);
        return redirect()->route('front.thank_offering')->with('success', 'Service order is placed successfully through cash!');
    }

    private function send_sms_to_customer($data)
    {
        if (!preg_match('/^\+1|^1/', $data['client_phone'])) {
            $data['client_phone'] = '+1' . $data['client_phone'];
        }


        try {
            $text = null;
            if ($data['is_appointed']) {
                $converted_time = Carbon::createFromFormat('H:i', $data['appointment_time'])->format('h:i A');
                $text = "Thanks for your payment of $" . $data['net_amount'] . " and your appointment is for " . $data['appointment_date'] . " at " . $converted_time;
            } else {
                $text = "Thanks for your payment of $" . $data['net_amount'] . " and your appointment is of type Walking.";
            }

            $to = $data['client_phone'];

            $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
            $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
            $sent = $response->statusCode === 202;

        } catch (\Exception $exp) {
            \Log::error('SMS sending to customer failed: ' . $exp->getMessage());
        }
    }

    private function send_sms_to_admin($data)
    {
        try {
            $text = null;
            if ($data['is_appointed']) {
                $converted_time = Carbon::createFromFormat('H:i', $data['appointment_time'])->format('h:i A');
                $text = $data['client_fname'] . " made an appointment for " . $data['appointment_date'] . " at " . $converted_time . " and the payment was $" . $data['net_amount'] . ", Please CHECK DASHBOARD on YOUR PC.";
            } else {
                $text = $data['client_fname'] . " made an appointment of type Walking and the payment was $" . $data['net_amount'] . ", Please CHECK DASHBOARD on YOUR PC.";
            }

            $to = env('ADMIN_PHONE_NO');

            $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
            $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
            $sent = $response->statusCode === 202;

        } catch (\Exception $exp) {
            \Log::error('SMS sending to admin failed: ' . $exp->getMessage());
        }
    }

    private function send_email_to_admin($data){

            try {
                $message = null;
                if ($data['is_appointed']) {
                    $converted_time = Carbon::createFromFormat('H:i', $data['appointment_time'])->format('h:i A');
                    $message = $data['client_fname'] . " made an appointment for " . $data['appointment_date'] . " at " . $converted_time . " and the payment was $" . $data['net_amount'] . ", Please CHECK DASHBOARD on YOUR PC.";
                } else {
                    $message = $data['client_fname'] . " made an appointment of type Walking and the payment was $" . $data['net_amount'] . ", Please CHECK DASHBOARD on YOUR PC.";
                }
                $subject="(🎉 New Servive Order) ".$data['client_fname'] . " made an appointment ";

                $to = env('ADMIN_EMAIL');

                Mail::to($to)->send(new MailToAllSubscribers($subject,$message));


            } catch (\Exception $exp) {
                \Log::error('SMS sending to admin failed: ' . $exp->getMessage());
            }
    }


    public function payment_offering_paypal()
    {
        if (!Session::has('offering')) {
            return redirect()->route('front.shop')->with('error', 'No service is added yet');
        }

        $data = $this->setup_order("paypal");
        if ($data["is_appointed"] && is_null($data["appointment_time"])) {
            return back()->with('error', 'For appointment, You must select an available time slot');
        }

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'), // ClientID
                env('PAYPAL_SECRET_KEY') // ClientSecret
            )
        );

        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();
        $details->setShipping(0)->setTax(0)->setSubtotal($data["net_amount"]);
        $amount->setCurrency('USD');
        $amount->setTotal($data["net_amount"]);
        $amount->setDetails($details);
        $transaction->setAmount($amount);
        $execution->addTransaction($transaction);
        $result = $payment->execute($execution, $apiContext);

        if($result->state == 'approved') {
            $paid_amount = $result->transactions[0]->amount->total;
            $fee_amount  = $result->transactions[0]->related_resources[0]->sale->transaction_fee->value;
            $net_amount  = $paid_amount-$fee_amount;

            $data["paid_amount"] = $paid_amount;
            $data["net_amount"] = $net_amount;
            $data["fee_amount"] = $fee_amount;
            $data["created_at"]=now();
            DB::table('service_orders')->insert($data);

            $this->send_email_to_admin($data);
            $this->send_sms_to_customer($data);
            $this->send_sms_to_admin($data);


            Session::put("payment_mode", "paypal");
            Session::put("order_no", $data["order_no"]);
            return redirect()->route('front.thank_offering')->with('success', 'Service order is placed successfully through paypal!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong while proceeding paypal payment');
        }
    }

    public function payment_offering_stripe()
    {
        if (!Session::has('offering')) {
            return redirect()->route('front.shop')->with('error', 'No service is added yet');
        }

        $data = $this->setup_order("card");
        if ($data["is_appointed"] && is_null($data["appointment_time"])) {
            return back()->with('error', 'For appointment, You must select an available time slot');
        }

        \Stripe\Stripe::setApiKey(env('ADMIN_STRIPE_SECRET_KEY'));

        if(isset($_POST['stripeToken']))
        {
            \Stripe\Stripe::setVerifySslCerts(false);
			$token = $_POST['stripeToken'];
            $amount = $data["net_amount"]+ ($data['tip_amount'] ?? 0) - ($data['coupon_discount'] ?? 0);
            if ($amount <= 0) {
                return redirect()->back()->with('error', 'Amount should be greater than 0');
            }
            $response = \Stripe\Charge::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'description' => 'Stripe Payment',
                'source' => $token,
                'metadata' => ['order_id' => uniqid()],
            ]);

            $bal = \Stripe\BalanceTransaction::retrieve($response->balance_transaction);
            $balJson = $bal->jsonSerialize();

            $paid_amount = $balJson['amount']/100;
            $fee_amount  = $balJson['fee']/100;
            $net_amount  = $balJson['net']/100;

            $data["paid_amount"] = $paid_amount;
            // $data["net_amount"] = $net_amount;
            $data["fee_amount"] = $fee_amount;
            $data["created_at"] = now();

            DB::table('service_orders')->insert($data);

            $this->send_email_to_admin($data);
            $this->send_sms_to_customer($data);
            $this->send_sms_to_admin($data);

            Session::put("payment_mode", "card");
            Session::put("order_no", $data["order_no"]);
            return redirect()->route('front.thank_offering')->with('success', 'Service order is placed successfully through stripe!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong while proceeding stripe payment');
        }
    }

    private function validate_offering(Request $request)
    {
        $data = $request->validate([
            'offering_id' => 'required',
            'client_fname' => 'required|max:50',
            'client_lname' => 'required|max:50',
            'client_email' => 'required|email',
            'client_phone' => 'required|max:50',
            'rate_type' => 'required|in:regular,appointed',
            'appointment_time' => 'nullable'
        ]);

        $data['appointment_date'] = today()->format('Y-m-d');
        return $data;
    }

    private function setup_order($type)
    {
        $data = Session::get('offering');
        $offering = Offering::findOrFail($data['offering_id']);

        $data["is_appointed"] = $data["rate_type"] == "appointed";
        $data["offering_name"] = $offering->name;
        $data["net_amount"] = $data["rate_type"] == "appointed" ? $offering->appointed_rate : $offering->regular_rate;

        if ($type == "cash") {
            $data["payment_type"] = "cash";
            $data["paid_amount"] = $data["net_amount"];
            $data["fee_amount"] = 0;
        } else {
            $data["payment_type"] = $type;
        }

        $data["appointment_date"] =  $data["rate_type"] == "appointed" ? $data["appointment_date"] : null;
        $data["appointment_time"] =  $data["rate_type"] == "appointed" ? $data["appointment_time"] : null;

        // Auto Incremented ID
        $id_to_incremenet=DB::table('service_orders')
        ->orderBy('id', 'desc')
        ->first();
        if($id_to_incremenet==null){
            $data["order_no"]='ORDER-1';
        }
        // if(sizeof())
        else{
            $data["order_no"]='ORDER-'.(intval($id_to_incremenet->id)+1);
        }

        // $statement = DB::select("SHOW TABLE STATUS LIKE 'service_orders'");
        // $data["order_no"] = 'ORDER-' . $statement[0]->Auto_increment;



        unset($data["rate_type"]);
        return $data;
    }

    private function appointed_slots()
    {
        return DB::table('service_orders')
            ->select('appointment_time')
            ->where('appointment_date', today())
            ->get()
            ->pluck('appointment_time')
            ->toArray();
    }

    public function thank_offering()
    {
        if (!Session::has('offering')) {
            return redirect()->route('front.shop')->with('error', 'No service is added yet');
        }

        $session_offering = Session::get("offering");
        $order_no = Session::get("order_no");
        return view('pages.thanks', compact('session_offering', 'order_no'));
    }

    public function finish_offering()
    {
        $mode = "payment mode";
        if (Session::has('offering') && Session::has("payment_mode") && Session::has("order_no")) {

            $mode = Session::get("payment_mode");
            Session::forget(["offering", "payment_mode", "order_no"]);
        }

        return redirect()
            ->route('front.shop')
            ->with('success', 'Service order is placed successfully through ' . $mode .'!');
    }

    public function availUpdate(Request $request)
    {
        $session_offering = $request->session()->get('offering', []);

        // Save the tip amount to the session if it's from the tip form
        if ($request->isMethod('post') && $request->has('tip_amount') && $request->input('tip_amount')>=0) {
            $session_offering['tip_amount'] = $request->input('tip_amount', 0);
            $request->session()->put('offering', $session_offering);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function availCoupon(Request $request)
    {
        $session_offering = $request->session()->get('offering', []);
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);
        $coupon = CouponDesign::where('code', $request->input('coupon_code'))->first();
        if (!$coupon) {
            return redirect()->back()->withErrors(['coupon_code' => 'This coupon does not exist. Please try another code.']);
        }
        if (isset($coupon->expired_at) && $coupon->expired_at < now()) {
            return redirect()->back()->withErrors(['coupon_code' => 'This coupon is expired. Please try another code.']);
        }
        if ($coupon->type == 'percentage') {
            $coupon_discount = ($session_offering['total_amount'] ?? 0) * ($coupon->value / 100);
        } elseif ($coupon->type == 'amount') {
            $coupon_discount = $coupon->value;
        }
        $session_offering['coupon_code'] = $coupon->code;
        $session_offering['coupon_discount'] = ceil($coupon_discount);

        $request->session()->put('offering', $session_offering);

        return redirect()->back()->with('success', 'Coupon applied successfully!');
    }






}
