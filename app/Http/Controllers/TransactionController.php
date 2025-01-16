<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreated;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $validated['created_by_id'] = Auth::id();
            $transaction = Transaction::create($validated);

            foreach ($validated['items'] as $item) {
                // Lock the product
                $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();

                // Check for stock availability
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                // Update product quantity
                $quantityBefore = $product->quantity;
                $quantityAfter = $quantityBefore - $item['quantity'];
                $product->update(['quantity' => $quantityAfter]);

                // Create transaction item
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'total_amount' => $product->price * $item['quantity'],
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $quantityAfter,
                    'created_by_id' => Auth::id(),
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Transaction created successfully', 'transaction' => $transaction], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
