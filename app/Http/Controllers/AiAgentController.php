<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiAgentController extends Controller
{
    public function chat(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'product_id' => ['required', 'integer'],
        ]);

        $product = Product::with(['color', 'size', 'category'])
            ->findOrFail($data['product_id']);

        $productInfo = [
            'name' => $product->name,
            'regular_price' => $product->regular_price,
            'discount_price' => $product->discount_price,
            'stock' => (bool) $product->in_stock,
            'colors' => $product->color->pluck('color_name')->values(),
            'sizes' => $product->size->pluck('size_name')->values(),
            'description' => strip_tags($product->short_description ?? ''),
        ];

        $response = Http::withToken(config('services.openai.key'))
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model'),
                'temperature' => 0.4,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'তুমি একটি ই-কমার্স শপের সহায়ক AI Agent। বাংলায় সংক্ষিপ্ত ও ভদ্রভাবে উত্তর দেবে। শুধুমাত্র দেওয়া product তথ্যের ভিত্তিতে উত্তর দেবে। কোনো তথ্য জানা না থাকলে বলবে যে customer care-এ যোগাযোগ করতে হবে।',
                    ],
                    [
                        'role' => 'system',
                        'content' => 'Product তথ্য: ' . json_encode(
                            $productInfo,
                            JSON_UNESCAPED_UNICODE
                        ),
                    ],
                    [
                        'role' => 'user',
                        'content' => $data['message'],
                    ],
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'এই মুহূর্তে AI Agent ব্যবহার করা যাচ্ছে না।',
            ], 500);
        }

        return response()->json([
            'message' => data_get(
                $response->json(),
                'choices.0.message.content',
                'দুঃখিত, কোনো উত্তর পাওয়া যায়নি।'
            ),
        ]);
    }
}
