<?php

namespace App\Http\Livewire;

use App\Models\Proposal;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProposals extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.show-proposals',[
            'proposals' => Proposal::orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }
}
