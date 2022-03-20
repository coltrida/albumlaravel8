<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $info;
    public $messaggio;

    /**
     * Create a new component instance.
     *
     * @param $info
     * @param $messaggio
     */
    public function __construct($info, $messaggio)
    {
        $this->info = $info;
        $this->messaggio = $messaggio;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
