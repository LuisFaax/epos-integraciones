<?php

namespace App\Http\Livewire;

use App\Models\Image;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $records, $search, $action = 1, $gallery, $suppliers, $productSelected, $categoriesList;
    public Product $product;

    protected $paginationTheme = 'bootstrap';

    protected $rules =    [
        'product.name' => "required|min:3|max:60|unique:products,name",
        'product.sku' => "nullable|max:25|unique:products,sku",
        'product.description' => "nullable|max:500",
        'product.type' => "required|in:simple,bundle",
        'product.status' => "required|in:publish,pending,draft",
        'product.visibility' => "required|in:visible,hide",
        'product.price' => "required",
        'product.price2' => "required",
        'product.stock_status' => "required|in:instock,outofstock,onbackorder",
        'product.manage_stock' => "required",
        'product.stock_qty' => "required",
        'product.low_stock' => "required",
        'product.supplier_id' => "required",
    ];



    public function mount()
    {
        $this->product = new Product();
        $this->product->type = 'simple';
        $this->product->status = 'publish';
        $this->product->visibility = 'visible';
        $this->product->stock_status = 'instock';
        $this->product->manage_stock = 1;

        $this->suppliers = Supplier::orderBy('name')->get();

        $this->product->supplier_id = $this->suppliers->first()->id ?? null;
    }

    protected $listeners = [
        'refresh' => '$refresh',
        'search' => 'searching',
        'Destroy'
    ];


    public function render()
    {
        return view('livewire.products.products', [
            'products' => $this->loadProducts()
        ]);
    }

    function loadProducts()
    {

        if (!empty($this->search)) {
            $this->resetPage();

            $query = Product::with('supplier')
                ->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                })
                ->orderBy('name', 'asc')
                ->paginate(5);
        } else {

            $query =  Product::with(['supplier', 'categories'])->orderBy('name', 'asc')->paginate(5);
        }
        $this->records = $query->total();
        return $query;
    }



    public function searching($searchText)
    {
        $this->search = trim($searchText);
    }


    public function Add()
    {
        $this->resetValidation();
        $this->resetExcept('product');
        $this->product = new Product();
        $this->action = 2;
    }

    public function Edit(Product $product)
    {
        $this->resetValidation();
        $this->product = $product;
        $this->categoriesList = implode(", ", $product->categories->pluck('name')->toArray());
        $this->action = 3;
    }

    public function cancelEdit()
    {
        $this->resetValidation();
        $this->product = new Product();
        $this->action = 1;
    }

    function viewProduct(Product $product)
    {
        $this->productSelected = $product;
        $this->dispatchBrowserEvent('view-product');
    }

    function Store()
    {
        sleep(1);

        if ($this->product->id > 0) {
            $this->validate([
                'product.name' => [
                    'required',
                    'min:3',
                    'max:60',
                    Rule::unique('products', 'name')->ignore($this->product->id, 'id')
                ],
                'product.sku' => [
                    'nullable',
                    'max:25',
                    Rule::unique('products', 'sku')->ignore($this->product->id, 'id')
                ],
            ]);
        } else {
            $this->validate($this->rules);
        }

        $this->product->save();

        $listCategories = null;
        if ($this->categoriesList != null)  $listCategories =  explode(",", $this->categoriesList);


        //relacionar categorias        
        if ($this->action > 1) {

            if ($listCategories != null) {

                $listCategories = array_map(function ($item) {
                    $catName = trim($item);
                    // verificar si el elemento no es numérico
                    if (!is_numeric($catName)) {
                        // buscar el ID de la categoría en la tabla correspondiente
                        $categoria = Category::where('name', $catName)->first();
                        // reemplazar el elemento con el ID de la categoría si existe
                        if ($categoria) {
                            return $categoria->id;
                        }
                    }

                    // devolver el elemento sin cambios              
                    return $item;
                }, $listCategories);
            }
            $listCategories !== null ? $this->product->categories()->sync($listCategories) : $this->product->categories()->detach();
        }


        //images
        if (!empty($this->gallery)) {
            // eliminar imagenes del disco
            if ($this->product->id > 0) {
                $this->product->images()->each(function ($img) {
                    unlink('storage/products/' . $img->file);
                });

                // eliminar las relaciones
                $this->product->images()->delete();
            }

            // guardar imagenes nuevas
            foreach ($this->gallery as $photo) {
                $fileName = uniqid() . '_.' . $photo->extension();
                $photo->storeAs('public/products', $fileName);

                // creamos relacion
                $img = Image::create([
                    'model_id' => $this->product->id,
                    'model_type' => 'App\Models\Product',
                    'file' => $fileName
                ]);

                // guardar relacion
                $this->product->images()->save($img);
            }
        }

        //sync con woocommerce


        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
        $this->resetExcept(['product', 'suppliers']);

        $this->product = new Product();
        $this->product->type = 'simple';
        $this->product->status = 'publish';
        $this->product->visibility = 'visible';
        $this->product->stock_status = 'instock';
        $this->product->manage_stock = 1;
    }


    public function Destroy(Product $product)
    {
        // eliminar imagenes del storage
        $product->images()->each(function ($img) {
            unlink('storage/products/' . $img->file);
        });

        // eliminar images de db
        $product->images()->delete();

        // eliminar categorias relacionadas
        $product->categories()->detach();

        //eliminar producto laravel
        $product->delete();

        //eliminar producto tienda
        //$this->deleteProduct($product->platform_id);

        //reset pagination
        $this->resetPage();

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
        $this->dispatchBrowserEvent('stop-loader');
        //

    }
}
