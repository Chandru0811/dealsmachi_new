<?php

namespace App\Http\Controllers\Api\vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\CategoryGroup;

class ProductController extends Controller
{
    use ApiResponses;

    public function index($shop_id)
    {
        $products = Product::where('shop_id', $shop_id)->orderBy('id', 'desc')->get();

        return $this->success('Products retrieved successfully.', $products);
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);

        if (!$product) {
            return $this->error('Product Not Found.', ['error' => 'Product Not Found']);
        }
        $product->restore();

        return $this->success('Product restored successfully!', $product);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|exists:shops,id',
            'name' => 'required|string',
            'deal_type' => 'required|integer|in:1,2,3',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'description' => 'nullable|string',
            'slug' => 'required|string|unique:products,slug',
            'coupon_code' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'discounted_price' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image2' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image3' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image4' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ], [
            'name.required' => 'The name field is required.',
            'shop_id.required' => 'Please provide the shop for this product.',
            'shop_id.exists' => 'The selected shop does not exist in our records.',

            'deal_type.required' => 'Please specify the deal type for this product.',
            'deal_type.integer' => 'The deal type must be an integer value.',
            'deal_type.in' => 'The deal type must be either 0 (standard) or 1 (special deal).',

            'category_id.required' => 'Please select a category for this product.',
            'category_id.exists' => 'The selected category does not exist in our records.',

            'brand.string' => 'The brand must be a valid string.',

            'description.string' => 'The description must be a valid string.',

            'slug.required' => 'The product slug is required.',
            'slug.string' => 'The slug must be a valid string.',
            'slug.unique' => 'The product slug has already been taken.',

            'coupon_code.required' => 'The product coupon code is required.',
            'coupon_code.string' => 'The coupon code must be a valid string.',

            'original_price.required' => 'Please provide the original price of the product.',
            'original_price.numeric' => 'The original price must be a valid number.',
            'original_price.min' => 'The original price must be at least 0.',

            'discounted_price.required' => 'Please provide the discounted price of the product.',
            'discounted_price.numeric' => 'The discounted price must be a valid number.',
            'discounted_price.min' => 'The discounted price must be at least 0.',

            'discount_percentage.required' => 'Please provide the discount percentage for this product.',
            'discount_percentage.numeric' => 'The discount percentage must be a valid number.',
            'discount_percentage.min' => 'The discount percentage cannot be negative.',
            'discount_percentage.max' => 'The discount percentage cannot exceed 100.',

            'stock.required' => 'Please provide the stock quantity for this product.',
            'stock.integer' => 'The stock must be a valid integer value.',
            'stock.min' => 'The stock cannot be negative.',

            // 'sku.required' => 'Please provide the SKU for this product.',
            'sku.string' => 'The SKU must be a valid string.',
            'sku.unique' => 'The SKU has already been taken.',
            'sku.max' => 'The SKU must not exceed 100 characters.',

            'image1.required' => 'Please upload an image for this product.',
            'image1.image' => 'The uploaded file must be an image.',
            'image1.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image1.max' => 'The image size must not exceed 2MB.',

            'image2.required' => 'Please upload an image for this product.',
            'image2.image' => 'The uploaded file must be an image.',
            'image2.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image2.max' => 'The image size must not exceed 2MB.',

            'image3.required' => 'Please upload an image for this product.',
            'image3.image' => 'The uploaded file must be an image.',
            'image3.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image3.max' => 'The image size must not exceed 2MB.',

            'image4.required' => 'Please upload an image for this product.',
            'image4.image' => 'The uploaded file must be an image.',
            'image4.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image4.max' => 'The image size must not exceed 2MB.',

            'start_date.date' => 'The start date must be a valid date format.',
            'end_date.date' => 'The end date must be a valid date format.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $shopId = $request->input('shop_id');
        $imagePath = 'assets/images/products/' . $shopId;

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        if ($request->hasFile('image1')) {
            $image1 = $request->file('image1');
            $imageName1 = time() . '_1_' . $image1->getClientOriginalName();
            $image1->move($imagePath, $imageName1);
            $validatedData['image_url1'] = $imagePath . "/" . $imageName1;
        }

        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $imageName2 = time() . '_2_' . $image2->getClientOriginalName();
            $image2->move($imagePath, $imageName2);
            $validatedData['image_url2'] = $imagePath . "/" . $imageName2;
        }

        if ($request->hasFile('image3')) {
            $image3 = $request->file('image3');
            $imageName3 = time() . '_3_' . $image3->getClientOriginalName();
            $image3->move($imagePath, $imageName3);
            $validatedData['image_url3'] = $imagePath . "/" . $imageName3;
        }

        if ($request->hasFile('image4')) {
            $image4 = $request->file('image4');
            $imageName4 = time() . '_4_' . $image4->getClientOriginalName();
            $image4->move($imagePath, $imageName4);
            $validatedData['image_url4'] = $imagePath . "/" . $imageName4;
        }

        $validatedData['active'] = 0;
        $product = Product::create($validatedData);

        return $this->success('Product created successfully.', $product);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'category.categoryGroup'])->find($id);

        if (!$product) {
            return $this->error('Product Not Found.', ['error' => 'Product Not Found']);
        }

        $product->categoryName = $product->category ? $product->category->name : null;
        $product->categoryGroupName = $product->category && $product->category->categoryGroup ? $product->category->categoryGroup->name : null;
        $product->categoryGroupId = $product->category && $product->category->categoryGroup ? $product->category->categoryGroup->id : null;

        unset($product->category);

        return $this->success('Product Retrieved Successfully!', $product);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|exists:shops,id',
            'name' => 'required|string',
            'deal_type' => 'required|integer|in:1,2,3',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'description' => 'nullable|string',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'coupon_code' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'discounted_price' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string',
            'image1' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image2' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image3' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image4' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ], [
            'name.required' => 'The name field is required.',

            'shop_id.required' => 'Please provide the shop for this product.',
            'shop_id.exists' => 'The selected shop does not exist in our records.',

            'deal_type.required' => 'Please specify the deal type for this product.',
            'deal_type.integer' => 'The deal type must be an integer value.',
            'deal_type.in' => 'The deal type must be either 0 (standard) or 1 (special deal).',

            'category_id.required' => 'Please select a category for this product.',
            'category_id.exists' => 'The selected category does not exist in our records.',

            'brand.string' => 'The brand must be a valid string.',

            'description.string' => 'The description must be a valid string.',

            'slug.required' => 'The product slug is required.',
            'slug.string' => 'The slug must be a valid string.',
            'slug.unique' => 'The product slug has already been taken.',

            'coupon_code.required' => 'The product coupon code is required.',
            'coupon_code.string' => 'The coupon code must be a valid string.',

            'original_price.required' => 'Please provide the original price of the product.',
            'original_price.numeric' => 'The original price must be a valid number.',

            'discounted_price.required' => 'Please provide the discounted price of the product.',
            'discounted_price.numeric' => 'The discounted price must be a valid number.',

            'discount_percentage.required' => 'Please provide the discount percentage for this product.',
            'discount_percentage.numeric' => 'The discount percentage must be a valid number.',

            'stock.required' => 'Please provide the stock quantity for this product.',
            'stock.integer' => 'The stock must be a valid integer value.',
            'stock.min' => 'The stock cannot be negative.',

            // 'sku.required' => 'Please provide the SKU for this product.',
            'sku.string' => 'The SKU must be a valid string.',
            'sku.unique' => 'The SKU has already been taken.',
            'sku.max' => 'The SKU must not exceed 100 characters.',

            'image1.sometimes' => 'An image is required if you want to update the product image.',
            'image1.image' => 'The uploaded file must be an image.',
            'image1.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image1.max' => 'The image size must not exceed 2MB.',

            'image2.sometimes' => 'An image is required if you want to update the product image.',
            'image2.image' => 'The uploaded file must be an image.',
            'image2.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image2.max' => 'The image size must not exceed 2MB.',

            'image3.sometimes' => 'An image is required if you want to update the product image.',
            'image3.image' => 'The uploaded file must be an image.',
            'image3.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image3.max' => 'The image size must not exceed 2MB.',

            'image4.sometimes' => 'An image is required if you want to update the product image.',
            'image4.image' => 'The uploaded file must be an image.',
            'image4.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, or webp file.',
            'image4.max' => 'The image size must not exceed 2MB.',

            'start_date.date' => 'The start date must be a valid date format.',
            'end_date.date' => 'The end date must be a valid date format.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($id);
        if (!$product) {
            return $this->error('Product Not Found.', ['error' => 'Product Not Found']);
        }

        $validatedData = $validator->validated();
        $shopId = $request->input('shop_id');
        $imagePath = 'assets/images/products/' . $shopId;

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        if ($request->hasFile('image1')) {
            if ($product->image_url1 && file_exists(public_path($product->image_url1))) {
                unlink(public_path($product->image_url1));
            }

            $image1 = $request->file('image1');
            $imageName1 = time() . '_1_' . $image1->getClientOriginalName();
            $image1->move($imagePath, $imageName1);
            $validatedData['image_url1'] = $imagePath . '/' . $imageName1;
        }

        if ($request->hasFile('image2')) {
            if ($product->image_url2 && file_exists(public_path($product->image_url2))) {
                unlink(public_path($product->image_url2));
            }

            $image2 = $request->file('image2');
            $imageName2 = time() . '_2_' . $image2->getClientOriginalName();
            $image2->move($imagePath, $imageName2);
            $validatedData['image_url2'] = $imagePath . '/' . $imageName2;
        }

        if ($request->hasFile('image3')) {
            if ($product->image_url3 && file_exists(public_path($product->image_url3))) {
                unlink(public_path($product->image_url3));
            }

            $image3 = $request->file('image3');
            $imageName3 = time() . '_3_' . $image3->getClientOriginalName();
            $image3->move($imagePath, $imageName3);
            $validatedData['image_url3'] = $imagePath . '/' . $imageName3;
        }

        if ($request->hasFile('image4')) {
            if ($product->image_url4 && file_exists(public_path($product->image_url4))) {
                unlink(public_path($product->image_url4));
            }

            $image4 = $request->file('image4');
            $imageName4 = time() . '_4_' . $image4->getClientOriginalName();
            $image4->move($imagePath, $imageName4);
            $validatedData['image_url4'] = $imagePath . '/' . $imageName4;
        }

        $product->update($validatedData);

        return $this->success('Product updated successfully!', $product);
    }

    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);
        $products->delete();
        return $this->ok('Product Deleted Successfully!');
    }

    public function getAllCategoryGroups()
    {
        $categoryGroups = CategoryGroup::where('active', 1)
            ->select('id', 'name')
            ->orderBy('id', 'desc')
            ->get();

        return $this->success('Active Category Groups Retrieved Successfully!', $categoryGroups);
    }

    public function getAllCategoriesByCategoryGroupId($id)
    {
        $categories = Category::where('category_group_id', $id)
            ->where('active', 1)
            ->select('id', 'name')
            ->orderBy('id', 'desc')
            ->get();
        return $this->success('Active Categories Retrieved Successfully!', $categories);
    }

    public function categoriesCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_group_id' => 'required|exists:category_groups,id',
            'name'              => 'required|string|max:200|unique:categories,name',
            'slug'              => 'required|string|max:200|unique:categories,slug',
            'description'       => 'nullable|string',
            'icon'              => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'category_group_id.required' => 'The category group ID field is required.',
            'category_group_id.exists'   => 'The selected category group ID is invalid.',
            'name.required'              => 'The name field is required.',
            'name.unique'                => 'The name field must be unique.',
            'name.max'                   => 'The name may not be greater than 200 characters.',
            'slug.required'              => 'The slug field is required.',
            'slug.max'                   => 'The slug may not be greater than 200 characters.',
            'slug.unique'                => 'The slug must be unique.',
            'description.string'         => 'The description must be a string.',
            'icon.required'              => 'The icon is required.',
            'icon.image'                 => 'The icon must be an image.',
            'icon.mimes'                 => 'The icon must be a jpeg, png, jpg, gif, svg, or webp file.',
            'icon.max'                   => 'The icon must not be larger than 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imagePath = 'assets/images/categories';

            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0755, true);
            }

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move($imagePath, $imageName);

            $validatedData['icon'] = $imagePath . '/' . $imageName;
            $validatedData['active'] = 0;
        }

        $category = Category::create($validatedData);

        return $this->success('Category created successfully! It will be available once approved by admin. Please try creating a product after some time.', $category);
    }

}
