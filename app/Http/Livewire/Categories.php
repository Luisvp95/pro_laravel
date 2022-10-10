<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Categories extends Component
{   
    use WithPagination;
    public $q;

    public $sortBy = 'id';
    public $sortAsc = true;

    public $category;

    public $confirmingCategoryDeletion = false;
    public $confirmingCategoryAdd = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'category_id' => 'required',
        'category.name' => 'required|string|min:2'
    ];

    public function render()
    {   
        $categories = Category::where('user_id', auth()->user()->id)
        ->when( $this->q, function($query) {
            return $query->where(function ($query) {
                $query->where('name', 'like', '%'.$this->q . '%');
            });
        })
        ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        $categories = $categories->paginate(10);
            
        return view('livewire.categories', [
            'categories' => $categories,
        ]);
        
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy ($field)
    {
        if($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmCategoryDeletion ( $id)
    {
        //$article->delete();
        $this->confirmingCategoryDeletion = $id;
    }

    public function deleteCategory (Category $category)
    {
        $category->delete();
        $this->confirmingCategoryDeletion = false;
        session()->flash('message', 'Categoria eliminado exitosamente');
    }

    public function confirmCategoryAdd ()
    {
        $this->reset(['category']);
        $this->confirmingCategoryAdd = true;
    }

    public function saveCategory()
    {
        $this->validate();

        if (isset ($this->category->id )) {
            $this->category->save();
            session()->flash('message', 'Categoria actualizado exitosamente');
        }else {
            auth()->user()->categories()->create([
                'name' => $this->category['name']
               
            ]);
            session()->flash('message', 'Categoria creado exitosamente');

        }
        $this->confirmingCategoryAdd = false;
    }

    public function confirmCategoryEdit (Category $category)
    {
        $this->category = $category;
        $this->confirmingCategoryAdd = true;
    }

}

