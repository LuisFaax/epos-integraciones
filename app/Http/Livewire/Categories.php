<?php

namespace App\Http\Livewire;

use App\Models\Image;
use Livewire\Component;
use App\Models\Category;
use App\Traits\CategoryTrait;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Categories extends Component
{
    use WithPagination;
    use WithFileUploads;
    use CategoryTrait;


    public Category $category;
    public $upload, $savedImg, $editing, $search, $records;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'category.name' => "required|min:2|max:50|unique:categories,name",
    ];

    public function mount()
    {
        $this->category = new Category();
        $this->editing = false;
        //dd($this->getCategories());
    }


    protected $listeners = [
        'search' => 'searching',
        'Destroy'
    ];


    public function searching($searchText)
    {
        $this->search = $searchText;
    }


    public function render()
    {
        return view('livewire.categories.categories', [
            'categories' => $this->loadCategories()
        ]);
    }

    public function loadCategories()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Category::where('name', 'like', "%{$this->search}%")
                ->orderBy('name', 'asc');
        } else {
            $query = Category::orderBy('name', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate(2);
    }

    public function Add()
    {
        $this->resetValidation();
        $this->resetExcept('category');
        $this->category = new Category();
    }

    public function Edit(Category $category)
    {
        $this->resetValidation();
        $this->category = $category;
        $this->upload = null;
        $this->savedImg = $category->picture;
        $this->editing = true;
    }

    public function cancelEdit()
    {
        $this->resetValidation();
        $this->category = new Category();
        $this->editing = false;
    }

    public function Store()
    {
        sleep(2);

        $this->rules['category.name'] = $this->category->id > 0 ? "required|min:2|max:50|unique:categories,name,{$this->category->id}" : 'required|min:2|max:50|unique:categories,name';

        $this->validate($this->rules);


        $tempImg = null;
        if ($this->category->id > 0) {
            $tempImg = $this->category->image;
        }


        $this->category->save();

        if (!empty($this->upload)) {
            //$tempImg = $this->category->image->file;
            if ($tempImg != null && file_exists('storage/categories/' . $tempImg->file)) {
                unlink('storage/categories/' . $tempImg->file);
            }

            $this->category->image()->delete();

            $fileName = uniqid() . '_.' . $this->upload->extension();
            $this->upload->storeAs('public/categories', $fileName);

            $img = Image::create([
                'model_id' => $this->category->id,
                'model_type' => 'App\Models\Category',
                'file' => $fileName
            ]);

            $this->category->image()->save($img);
        }

        // sync (solo al crear)
        if (!$this->editing) {
            $idwc = $this->createCategory($this->category->name);
            $this->category->platform_id = $idwc;
            $this->category->save();
        } else {
            $this->updateCategory($this->category);
        }


        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
        $this->resetExcept('category');
        $this->category = new Category();
    }

    public function Destroy(Category $category)
    {

        $tempImg = $category->image;
        if ($tempImg != null && file_exists('storage/categories/' . $tempImg->file)) {
            unlink('storage/categories/' . $tempImg->file);
        }

        $category->image()->delete();

        $category->delete();

        $this->resetPage();

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION EXITOSA']);
        $this->dispatchBrowserEvent('stop-loader');
    }

    public function Sync(Category $category)
    {
        $this->findOrCreateCategoryByName($category);
    }
}
