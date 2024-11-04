<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;
    #[Url()]
    public string $sort = 'desc';
    #[Url()]
    public string $search = '';


    public function setSort(string $sort):void
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }
    #[On('search')]
    public function updateSearch(string $search):void
    {
        $this->search = $search;
    }

    #[Computed]
    public function posts()
    {
        return Post::published()->featured()->latest()->take(3)
            ->where('title', 'like', "%{$this->search}%")
            ->orderBy('published_at', $this->sort)
            ->simplePaginate(3);
    }
    public function render()
    {
        return view('livewire.post-list',get_defined_vars());
    }
}
