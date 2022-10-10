<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Courses extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $q;

    public $sortBy = 'id';
    public $sortAsc = true;

    public $image;

    public $url_clean;

    public $course;

    public $confirmingCourseDeletion = false;
    public $confirmingCourseAdd = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'course.category_id' => 'required',
        'course.name' => 'required',
        'course.slug' => 'required',
        'image' => 'image|max:2048',
        'course.description' => 'required'
    ];

    public function render()
    {   
        $courses = Course::where('user_id', auth()->user()->id)
        ->when( $this->q, function($query) {
            return $query->where(function ($query) {
                $query->where('name', 'like', '%'.$this->q . '%')
                    ->orwhere('slug', 'like', '%'.$this->q . '%')
                    ->orwhere('image', 'like', '%'.$this->q . '%')
                    ->orwhere('description', 'like', '%'.$this->q . '%');
            });
        })
        ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        $courses = $courses->paginate(10);
            
        return view('livewire.courses', [
            'courses' => $courses,
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

    public function confirmCourseDeletion ( $id)
    {
        //$article->delete();
        $this->confirmingCourseDeletion = $id;
    }

    public function deleteCourse (Course $course)
    {
        $course->delete();
        $this->confirmingCourseDeletion = false;
        session()->flash('message', 'Curso eliminado exitosamente');
    }

    public function confirmCourseAdd ()
    {
        $this->reset(['course']);
        $this->confirmingCourseAdd = true;
    }

    public function saveCourse()
    {
        $this->validate();

        $filename = "";
        if ($this->image) {
            $filename = $this->image->store('storage/courses', 'public_uploads');
            $this->image=$filename;
        } else {
            $filename = Null;
        }

        if (isset ($this->course->id )) {
            $this->course->save();
            session()->flash('message', 'Curso actualizado exitosamente');
        }else {
            auth()->user()->courses()->create([
                'category_id' => $this->course['category_id'],
                'name' => $this->course['name'],
                'slug' => $this->course['slug'],
                'image' =>$this->image,
                'description' => $this->course['description']
               
            ]);
            session()->flash('message', 'Curso creado exitosamente');

        }
        $this->confirmingCourseAdd = false;
    }

    public function confirmCourseEdit (Course $course)
    {
        $this->course = $course;
        $this->confirmingCourseAdd = true;
    }

}
