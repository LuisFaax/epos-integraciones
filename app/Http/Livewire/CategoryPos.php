<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryPos extends Component
{
    public $search;



    protected $listeners = ['refresh' => '$refresh'];


    public function render()
    {
        return view('livewire.category-pos', [
            'categories' => $this->listCategories()
        ]);
    }

    function listCategories()
    {

        if (!empty($this->search)) {

            $data = Category::with('image')->where('name', 'like', "%{$this->search}%")
                ->orderBy('name', 'asc')->get()->take(5);

            $this->search = null;

            //si la categoria buscada solo trae un resultado, buscamos los productos de esa categoria al mismo tiempo
            if ($data->count() == 1) $this->emit('categorySelected', $data[0]->id);

            return $data;

            //
        } else {
            return  Category::with('image')->orderBy('name', 'asc')->get()->take(5);
        }
    }

    function selectCategory($categoryId)
    {
        $this->emit('categorySelected', $categoryId);
    }
}
