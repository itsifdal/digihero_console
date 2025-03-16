<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Carbon\Carbon;

class Calendar extends Component
{
    public $selectedDate;

    protected $listeners = ['dateClicked' => 'handleDateClicked'];

    public function handleDateClicked($date)
    {
        $carbonDate = Carbon::parse($date);
        $this->selectedDate = $carbonDate->format('Y-m-d');

        if ($carbonDate->isWeekend()) {
            session()->flash('message', 'Tanggal yang dipilih adalah weekend! 🎉');
        } else {
            session()->flash('message', 'Tanggal yang dipilih bukan weekend! 🎉');
        }
    }

    public function render()
    {
        return view('livewire.forms.calendar');
    }
}
