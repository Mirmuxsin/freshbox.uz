<?php

namespace App\Http\Controllers;

use App\Product;
use App\Categories;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        
        $product = new Product();
        $categories = Categories::all();
        return view('admin.products.create', compact('product'))->with(compact('categories'));

    }

    public function store(Request $request) {

        // Validate the form
        $request->validate([
           'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'image|required',
        ]);

        // Upload the image
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image->move('uploads', $image->getClientOriginalName());
        }

        // Save the data into database
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => editimg($request->image, $request->text1,$request->text2,$request->text3),

        ]);

        // Sessions Message
        $request->session()->flash('msg','Your product has been added');

        // Redirect

        return redirect('admin/products/create');

    }

    public function edit($id) {
        $product = Product::find($id);
        $categories = Categories::all();
        return view('admin.products.edit', compact('product'))->with(compact('categories'));
    }

    public function update(Request $request, $id) {

        // Find the product
        $product = Product::find($id);

        // Validate The form
        $request->validate([
           'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        // Check if there is any image
        if ($request->hasFile('image')) {
            // Check if the old image exists inside folder
            if (file_exists(public_path('uploads/') . $product->image)) {
                unlink(public_path('uploads/') . $product->image);
            }

            // Upload the new image
            $image = $request->image;
            $image->move('uploads', $image->getClientOriginalName());
            
            $product->image = editimg($image, $request->text1,$request->text2,$request->text3);
        }

        // Updating the product
        $product->update([
           'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $product->image
        ]);

        // Store a message in session
        $request->session()->flash('msg', 'Product has been updated');

        // Redirect
        return redirect('admin/products');

    }

    public function show($id) {
        $product = Product::find($id);
        return view('admin.products.details', compact('product'));
    }

    public function destroy($id) {
        // Delete the product
        Product::destroy($id);

        // Store a message
        session()->flash('msg','Product has been deleted');

        // Redirect back
        return redirect('admin/products');
    }
}



function editimg($img, $text1, $text2, $text3) {

    //time().'.'.$image->getClientOriginalExtension();

    $png = imagecreatefrompng('/home/profe193/domains/freshbox.uz/private_html/img/mask1.png');
    $png2 = imagecreatefrompng('/home/profe193/domains/freshbox.uz/private_html/img/mask2.png');
    if($img->getClientOriginalExtension() == "png"){
        $jpeg = imagecreatefrompng('/home/profe193/domains/freshbox.uz/private_html/uploads/'.$img->getClientOriginalName());
    }elseif($img->getClientOriginalExtension() == "jpg"){
        $jpeg = imagecreatefromjpeg('/home/profe193/domains/freshbox.uz/private_html/uploads/'.$img->getClientOriginalName());
    }
    
    list($width, $height) = getimagesize('/home/profe193/domains/freshbox.uz/private_html/uploads/'.$img->getClientOriginalName());
    list($newwidth, $newheight) = getimagesize('/home/profe193/domains/freshbox.uz/private_html/img/mask1.png');
    $out = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
    imagecopyresampled($out, $jpeg, 420, 200, 0, 0, 550, 700, $width, $height);
    imagecopyresampled($out, $png2, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);

    // Allocate A Color For The Text
    $white = imagecolorallocate($out, 0, 0, 0);

    // Set Path to Font File
    $font = '/home/profe193/domains/freshbox.uz/private_html/img/font.otf';

    // Set Text to Be Printed On Image

    // Print Text On Image
    imagettftext($out, 30, 0, 110, 420, $white, $font, $text1);
    imagettftext($out, 30, 0, 110, 580, $white, $font, $text2);
    imagettftext($out, 30, 0, 110, 730, $white, $font, $text3);


    $name = time().'.jpg';
    imagejpeg($out, '/home/profe193/domains/freshbox.uz/private_html/uploads/'.$name, 100);
    unlink('/home/profe193/domains/freshbox.uz/private_html/uploads/'.$img->getClientOriginalName());
    return $name;

}
