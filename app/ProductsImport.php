<?php

namespace App;

use Auth;
use File;
use App\User;
use App\Product;
use Combinations;
use App\ProductStock;
use App\ProductTranslation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

//class ProductsImport implements ToModel, WithHeadingRow, WithValidation
class ProductsImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;
    
    public function collection(Collection $rows) {
        $canImport = true;
        if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && 
                \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){
            if(Auth::user()->user_type == 'seller' && count($rows) > Auth::user()->seller->remaining_uploads) {
                $canImport = false;
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
            }
        }       
        if($canImport) {
            foreach ($rows as $row) {
                $choice = array();
                unset($choice);
                $final_choices_id = array();
                unset($final_choices_id);
                $final_choices = array();
                unset($final_choices);

                $choice[1] = explode(",",$row['size']);
                $choice[2] = explode(",",$row['fabric']);
                $choice[4] = explode(",",$row['bangles']);
                $choice[5] = explode(",",$row['dress_size_international']);
                $choice[8] = explode(",",$row['shoe_size']);
                foreach($choice as $key => $val)
                {
                    if($val != [""]){
                        $final_choices_id[] = $key;
                        $final_choices[] = [
                                                "attribute_id" => $key,
                                                "values" => $val,
                                            ] ;
                    }
                }
				
				if($row['colors'] == null){
                    $json_colors = json_encode([]);
                }else{
                    $json_colors = json_encode($this->getColorCode(explode(",",$row['colors'])));
                }
				
                $refundable = (strtolower($row['refundable'])) == 'yes' ? 1:0;
                $photos_ids = [];
                $photos_links = explode(',',$row['photos']);
                foreach($photos_links as $photo_link){
                    array_push($photos_ids, $this->downloadThumbnail($photo_link));
                }
                $photos_ids = implode(",",$photos_ids);
                // dd($photos_ids);


                $productId = Product::create([
                            'name' => $row['name'],
                            'added_by' => Auth::user()->user_type == 'seller' ? 'seller' : 'admin',
                            'user_id' => Auth::user()->user_type == 'seller' ? Auth::user()->id : User::where('user_type', 'admin')->first()->id,
                            'category_id' => $row['category_id'],
                            'brand_id' => $row['brand_id'],
                            'unit_price' => $row['unit_price'],
							'purchase_price' => $row['unit_price'],
                            'unit' => $row['unit'],
                            'min_qty' => $row['min_qty'],
                            'current_stock' => $row['current_stock'],
                            'discount_type' => $row['discount_type'],
                            'discount' => $row['discount'],
							'specification' => $this->specificationTag($row['specification']),
                            'description' => $row['description'],                            
                            'discount_start_date' => strtotime($row['discount_start_date']),
                            'discount_end_date' => strtotime($row['discount_end_date']),
                            'tags' => $row['tags'],
							'meta_title' => $row['meta_title'],
                            'meta_description' => $row['meta_description'],                           
                            'refundable' => $refundable,
							'colors' => $json_colors,							
                            'attributes' => json_encode($final_choices_id ?? []),
                            'choice_options' => json_encode($final_choices ?? []),
                            'slug' => Str::slug($row['name']). '-' . Str::random(3),
							'thumbnail_img' => $this->downloadThumbnail($row['thumbnail_img']),
							'photos' => $photos_ids,
							'published ' => 0,
							'approved ' => 0,
                ]);
                $options = array();
                unset($options);
                $options[] = $colours = $this->getColorCode(explode(",",$row['colors']) ?? []);
                $options[] = explode(",",$row['size']);
                $options[] = explode(",",$row['fabric']);
                $options[] = explode(",",$row['dress_size_international']);
                $options[] = explode(",",$row['bangles']);
                $options[] = explode(",",$row['shoe_size']);                
                $combinations = Combinations::makeCombinations($options);
                if(count($combinations[0]) > 0){
                    $productId->variant_product = 1;
                    foreach ($combinations as $key => $combination){
                        $str = '';
                        foreach ($combination as $key => $item){
                            if($key > 0 && !empty($item)){
                                $str .= '-'.str_replace(' ', '', $item);
                            }
                            elseif(!empty($item)){
                                if(!empty($colours) && count($colours) > 0){
                                    $color_name = \App\Color::where('code', $item)->first()->name;
                                    $str .= $color_name;
                                }
                                else{
                                    $str .= str_replace(' ', '', $item);
                                }
                            }
                        }
                        $product_stock = ProductStock::where('product_id', $productId->id)->where('variant', $str)->first();
                        if($product_stock == null){
                            $product_stock = new ProductStock;
                            $product_stock->product_id = $productId->id;
                        }
                        $product_stock->variant = $str;
                        $product_stock->price = $row['unit_price'];
                        $product_stock->sku = $row['sku'];
                        $product_stock->qty = $row['current_stock'];
                        $product_stock->image = $productId->thumbnail_img;
                        $product_stock->save();
                    }
                }
                else{
                    $product_stock              = new ProductStock;
                    $product_stock->product_id  = $productId->id;
                    $product_stock->variant     = '';
                    $product_stock->price       = $row['unit_price'];
                    $product_stock->sku         = $row['sku'];
                    $product_stock->qty         = $row['current_stock'];
                    $product_stock->save();
                }
              	ProductTranslation::create([
                    'product_id' => $productId->id,
                    'name' => $row['name'],
                    'unit' => $row['unit'],
                    'specification' => $row['specification'],
                    'description' => $row['description'],
                ]);
            }
            
            flash(translate('Products imported successfully'))->success();
        }        
        
    }
    
    public function model(array $row)
    {
        ++$this->rows;
    }
    
    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
             'unit_price' => function($attribute, $value, $onFailure) {
                  if (!is_numeric($value)) {
                       $onFailure('Unit price is not numeric');
                  }
              }
        ];
    }

    public function downloadThumbnail($url){
        try {
           
            if(strpos($url, '?') > 0){
                $url = substr($url, 0, strpos($url, '?'));    
            }
            $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
            if(strpos($url, 'dropbox') > 0){
                $url = $url.'?raw=1';    
            }
            $filename = 'uploads/all/'.Str::random(5).'.'.$extension;
            $basepart = getFileBaseURL();
            $fullpath = $basepart.$filename;
            $file = file_get_contents($url);
            // dd($filename,$fullpath,$file);
            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put($filename, $file, 'public');
            }
            $upload = new Upload;
            $upload->extension = strtolower($extension);

            $upload->file_original_name = $filename;
            $upload->file_name = $filename;
            $upload->user_id = Auth::user()->id;
            $upload->type = "image";
            $upload->file_size = Storage::size($filename);
            $upload->save();

            // dd($upload);
            return $upload->id;
        } catch (\Exception $e) {
            //dd($e);
        }
        return null;
    }
    
    
    public function colorCode()
  {
      $dd = Color::select('name','code')->get()->toArray();
       return array_combine(array_map('strtolower',array_column($dd,'name')),array_column($dd,'code'));     
    }

   public function getColorCode($data)
   {
        $colorscode = $this->colorCode();
        foreach ($data as $key => $value) {
               $ccode[] = $colorscode[strtolower(trim($value))] ?? $colorscode['black'];
           }   
        return $ccode;
    }

   public function specificationTag($data)
    {
        $data = explode(',',$data);
        $spe_tag = "<ul>";
       foreach ($data as $key => $value) {
           $spe_tag .= "<li>".$value."</li>";
        }
        $spe_tag .= "</ul>";
        return $spe_tag;
    }
}
