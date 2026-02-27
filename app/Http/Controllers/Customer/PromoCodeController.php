<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyPromoCodeRequest;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function apply(ApplyPromoCodeRequest $request)
    {
        $promo = PromoCode::where('code', strtoupper($request->code))->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Promo code not found.'], 422);
        }

        if (!$promo->isValid()) {
            return response()->json(['success' => false, 'message' => 'This promo code is no longer valid.'], 422);
        }

        $orderAmount = (float) $request->order_amount;

        if ($orderAmount < $promo->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order amount of \${$promo->min_order_amount} required for this promo code.",
            ], 422);
        }

        $discount = $promo->calculateDiscount($orderAmount);

        session([
            'promo_code' => $promo->code,
            'promo_discount' => $discount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Promo code applied successfully!',
            'discount' => $discount,
            'code' => $promo->code,
        ]);
    }

    public function remove(Request $request)
    {
        session()->forget(['promo_code', 'promo_discount']);

        return response()->json([
            'success' => true,
            'message' => 'Promo code removed.',
        ]);
    }
}
