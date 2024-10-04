<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $data;
    public $labelText;
    public $colClass;
    public $name;
    public $email;
    public $required;
    public $value;

    public function __construct($data = null, $labelText = '', $colClass = 'col-lg-12', $name = null,$email =null, $id = null, $type='text', $required=false , $value=null)
    {
        $this->data = $data;
        $this->labelText = $labelText;
        $this->colClass = $colClass;
        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $this->id = $id;
        $this->required = $required;
        $this->value = $value;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-component',with([
            'data'=>$this->data,
            'labelText'=>$this->labelText,
            'colClass'=>$this->colClass,
            'name'=>$this->name,
            'email'=>$this->email,
            'type'=>$this->type,
            'id'=>$this->id,
            'value'=>$this->value,
            'required'=>$this->required
        ]));
    }
}
