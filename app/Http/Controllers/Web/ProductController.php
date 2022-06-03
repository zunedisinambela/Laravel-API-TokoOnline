<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ImagesProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Storage;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate();

        return view('admin.master.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.master.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            //todo: menyimpan data product
            $product = Product::create([
                'product' => $request->product,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
            ]);
            //todo: untuk menyimpan image
            if ($request->hasFile('images')) {
                $arrayImages = [];
                foreach ($request->images as $value) {
                    $path = $value->store('product');

                    $columnsImage = [
                        'product_id' => $product->id,
                        'image' => $path,
                    ];
                    array_push($arrayImages,$columnsImage);
                }
                ImagesProduct::insert($arrayImages);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(['imageRelation'])->findOrFail($id);
        return view('admin.master.product.detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.master.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldImage = ImagesProduct::where('product_id',$id)->get();

        DB::beginTransaction();

        try {
            //todo: mengubah data product
            $product->update([
                'product' => $request->product,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
            ]);
            //todo: untuk menyimpan image
            if ($request->hasFile('images')) {
                if (count($oldImage) >= 0) {
                    foreach ($oldImage as $old) {
                        Storage::delete($old->image);
                    }
                    ImagesProduct::where('product_id',$id)->delete();
                }
                $arrayImages = [];
                foreach ($request->images as $value) {
                    $path = $value->store('product');

                    $columnsImage = [
                        'product_id' => $product->id,
                        'image' => $path,
                    ];
                    array_push($arrayImages,$columnsImage);
                }
                ImagesProduct::insert($arrayImages);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ( !$product) {
            abort(404);
        }

        $oldImages = ImagesProduct::where('product_id',$id)->get();

        if (count($oldImages) >= 0) {
            foreach ($oldImages as $old) {
                Storage::delete($old->image);
            }

            ImagesProduct::where('product_id',$id)->delete();
        }

        $product->delete();

        return redirect()->route('product.index');
    }
}
