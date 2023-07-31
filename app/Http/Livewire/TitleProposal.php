<?php

namespace App\Http\Livewire;

use App\Models\Proposal;
use Livewire\Component;
use Illuminate\Support\Str;

class TitleProposal extends Component
{
    public $widgetId;
    public $shortId;
    public $origName; // initial widget name state
    public $newName; // dirty widget name state
    public $isName;
    public $title;
    public $key;

    protected $rules = [
        'newTitle' => 'required|string',
    ];

    public function editTitle()
    {
        // $this->editing = true;
        // $this->saved = false;
        $this->dispatchBrowserEvent('focus-title-input');
    }
    
    public function mount(Proposal $proposal, $title)
    {

        // $this->title = $title;
        // $this->newTitle = $title;
        // $this->origName = $proposal->title;
        $this->widgetId = $proposal->user_id;
        $this->shortId = $proposal->short_id;
        $this->title = $title;

        $this->init($proposal);
    }
    public function save()
    {
        $proposal = Proposal::findOrFail($this->widgetId);
        $newName = (string)Str::of($this->newName)->trim()->substr(0, 100); // trim whitespace & more than 100 characters
        $newName = $newName === $this->shortId ? null : $newName; // don't save it as widget name it if it's identical to the short_id

        $proposal->title = $newName ?? null;
        $proposal->save();

        $this->init($proposal); // re-initialize the component state with fresh data after saving
    }
    private function init(Proposal $proposal)
    {
        $this->origName = $proposal->name ?: $this->shortId;
        $this->newName = $this->origName;
        $this->isName = $proposal->name ?? false;
    }

    // public function saveTitle()
    // {
    //     if ($this->newTitle !== $this->title) {
    //         // Update the title in the database using the Proposal model and the passed id
    //         Proposal::where('id', $this->_id)->update(['title' => $this->newTitle]);

    //         // After saving, mark the title as saved and exit editing mode
    //         $this->saved = true;
    //         $this->editing = false;
    //     } else {
    //         $this->saved = true;
    //         $this->editing = false;
    //     }
    // }

    public function render()
    {
        return view('livewire.title-proposal');
    }
}
