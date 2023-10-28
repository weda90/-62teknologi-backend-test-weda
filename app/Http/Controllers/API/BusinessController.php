<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $business = new Business;

        $business->name = $data['name'];
        $business->alias = $data['alias'];
        $business->image_url = $data['image_url'];
        $business->is_closed = $data['is_closed'];
        $business->url = $data['url'];
        $business->review_count = $data['review_count'];
        $business->rating = $data['rating'];
        $business->price = $data['price'];
        $business->phone = $data['phone'];
        $business->display_phone = $data['display_phone'];
        $business->distance = $data['distance'];

        $business->save();


        // Store the locations
        $location = $business->locations()->make([
            "address1" => $data['location']['address1'],
            "address2" => $data['location']['address2'],
            "address3" => $data['location']['address3'],
            "city" => $data['location']['city'],
            "zip_code" => $data['location']['zip_code'],
            "country" => $data['location']['country'],
            "state" => $data['location']['state']
        ]);
        $location->save();

        // Store the categories
        foreach ($data['categories'] as $category) {
            $categoryModel = $business->categories()->make([
                'alias' => $category['alias'],
                'title' => $category['title'],
            ]);
            $categoryModel->save();
        }

        // Store the coordinates
        $coordinates = $business->coordinates()->make([
            'latitude' => $data['coordinates']['latitude'],
            'longitude' => $data['coordinates']['longitude'],
        ]);
        $coordinates->save();

        // Store the transactions
        foreach ($data['transactions'] as $transaction) {
            $transactionModel = $business->transactions()->make([
                'transaction_type' => $transaction
            ]);
            $transactionModel->save();
        }

        return response()->json(['message' => 'Business stored successfully'], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business = Business::with('locations', 'categories', 'coordinates', 'transactions')->findOrFail($id);
        return response()->json($business);
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
        $business = Business::findOrFail($id);

        $data = $request->all();

        $business->name = $data['name'];
        $business->alias = $data['alias'];
        $business->image_url = $data['image_url'];
        $business->is_closed = $data['is_closed'];
        $business->url = $data['url'];
        $business->review_count = $data['review_count'];
        $business->rating = $data['rating'];
        $business->price = $data['price'];
        $business->phone = $data['phone'];
        $business->display_phone = $data['display_phone'];
        $business->distance = $data['distance'];

        $business->save();

        // Update the location
        $location = $business->locations()->first();
        $location->update([
            "address1" => $data['location']['address1'],
            "address2" => $data['location']['address2'],
            "address3" => $data['location']['address3'],
            "city" => $data['location']['city'],
            "zip_code" => $data['location']['zip_code'],
            "country" => $data['location']['country'],
            "state" => $data['location']['state']
        ]);

        // Update the categories
        $business->categories()->delete();
        foreach ($data['categories'] as $category) {
            $categoryModel = $business->categories()->make([
                'alias' => $category['alias'],
                'title' => $category['title'],
            ]);
            $categoryModel->save();
        }

        // Update the coordinates
        $coordinates = $business->coordinates()->first();
        $coordinates->update([
            'latitude' => $data['coordinates']['latitude'],
            'longitude' => $data['coordinates']['longitude'],
        ]);

        // Update the transactions
        $business->transactions()->delete();
        foreach ($data['transactions'] as $transaction) {
            $transactionModel = $business->transactions()->make([
                'transaction_type' => $transaction
            ]);
            $transactionModel->save();
        }

        return response()->json($business);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();
        return response()->json(null, 204);
    }

    /**
     * Search for businesses.
     * categories, limit, open_now, sort_by, price, radius
     */
    public function search(Request $request)
    {
        $category = $request->input('categories');
        $limit = $request->input('limit');
        $openNow = $request->input('open_now');
        $sortBy = $request->input('sort_by');
        $price = $request->input('price');
        $radius = $request->input('radius');

        // Create an array to map price values to strings
        $priceMap = [
            1 => '$',
            2 => '$$',
            3 => '$$$',
            4 => '$$$$',
        ];

        // Convert $price to "$" signs representation
        $priceRange = '';
        if (isset($priceMap[$price])) {
            $priceRange = $priceMap[$price];
        }

        // Perform the search query
        $business = Business::with('locations', 'categories', 'coordinates', 'transactions')
            ->when($category, function ($query, $category) {
                $categories = explode(',', $category);
                $query->whereHas('categories', function ($query) use ($categories) {
                    $query->whereIn('alias', $categories);
                });
            })
            ->when($priceRange, function ($query) use ($priceRange) {
                $query->where('price', $priceRange);
            })
            ->when($radius, function ($query) use ($radius) {
                $query->where('distance', '<=' ,$radius);
            })
            ->when($openNow, function ($query) use ($openNow) {
                $query->where('is_closed', '!=', $openNow);
            })
            // rating, review_count
            ->when($sortBy, function ($query) use ($sortBy) {
                $query->orderBy($sortBy);
            })
            ->limit($limit)
            ->get();

        // Convert transactions to array of values
        $business->transform(function ($item, $key) {
            $transactions =  $item->transactions->pluck('transaction_type')->toArray();
            $item->setRelation('transactions', $transactions);
            $item->transactions = $transactions;
            return $item;
        });

        $responses = [
            "business" => $business,
            "total" => count($business)
        ];
        // Return the search results as a JSON response
        return response()->json($responses);
    }

}
