<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\PurchaseDetail;
use App\PurchaseHeader;
use Illuminate\Http\Request;

class PurchaseHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PurchaseHeader::orderBy('is_done', 'asc')->orderBy('created_at', 'desc')->orderBy('due_date', 'desc')->paginate(10);
        return view('purchase.index')->with(['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('purchase.insert')->with(['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request);
//        create Purchase header
        $purchaseHeader = new PurchaseHeader();
        $purchaseHeader->is_done = $request->paymentStatus == "Lunas" ? true : false;
        if ($request->paymentStatus == "Hutang"){
            $purchaseHeader->due_date = $request->dueDate;
            $purchaseHeader->needs = $request->need;
        }
        $purchaseHeader->save();

        $form_data = json_decode($request->formData);
//        dd($form_data);
//        Manage new Product
        foreach ($form_data as $data){
            if (!empty($data->id)) {
                $prod = Product::where('id', '=', $data->id)->first();
                $prod->stock += $data->stock;
                $prod->save();

                $detailPurchase = new PurchaseDetail();
                $detailPurchase->id = $purchaseHeader->fresh()->id;
                $detailPurchase->product_id = $data->id;
                $detailPurchase->quantity = $data->stock;
                $detailPurchase->price = $data->buyPrice;
                $detailPurchase->save();

            }
            else {
                $prod = new Product();
                $format_name = [
                    'code' => $data->code,
                    'name' => $data->name,
                    'type' => $data->type,
                    'brand' => $data->brand,
                    'unit' => $data->unit,
                    'description' => $data->description,
                ];
//                dd($format_name);
                $prod->name = json_encode($format_name);
                $prod->stock = $data->stock;
                $prod->category_id = $data->category;
                $prod->min_stock = $data->minStock;
                $prod->buy_price = $data->buyPrice;
                $prod->sell_price = $data->sellPrice;
                $prod->save();

                $detailPurchase = new PurchaseDetail();
                $detailPurchase->id = $purchaseHeader->fresh()->id;
                $detailPurchase->product_id = $prod->fresh()->id;
                $detailPurchase->quantity = $data->stock;
                $detailPurchase->price = $data->buyPrice;
                $detailPurchase->save();
            }
        }

        return redirect()->route('purchase-view')->with(['msg' => "Purchase transaction has been recorded"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseHeader  $purchaseHeader
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PurchaseHeader::where('id', '=', $id)->first();
        $total = 0;
        foreach ($data->details as $d) {
            $total += $d->quantity * $d->price;
        }
        return view('purchase.detail')->with(['data'=>$data, "total"=>$total]);
    }


    public function paid($id)
    {
        $purchase = PurchaseHeader::where('id', '=', $id)->first();
        $purchase->is_done = true;
        $purchase->needs = 0;
        $purchase->due_date = null;
        $purchase->save();

        return redirect()->route('purchase-view')->with(['msg' => "Purchase transaction has been paid"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseHeader  $purchaseHeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseHeader $purchaseHeader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseHeader  $purchaseHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
//        dd($request->id);
//        decrease inserted stock
        $data = PurchaseHeader::where('id', '=', $request->id)->first();
        $detail = $data->details;

        foreach ($detail as $d) {
            $prod = Product::where('id', '=', $d->product_id)->first();
            $prod->stock = $prod->stock - $d->quantity;
            $prod->save();
        }
//        soft delete header and detail
        $data->delete();

        return redirect()->route('purchase-view')->with(['msg' => "Purchase transaction has been deleted"]);
    }

}
