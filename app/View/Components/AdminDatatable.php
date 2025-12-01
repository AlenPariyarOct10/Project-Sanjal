<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminDatatable extends Component
{
    public $table_id;
    public $ajax_url;
    public $columns;
    public $folder_name;
    public $search;
    public $module;
    public $sub_heading;

    public function __construct($table_id = '', $module = '',$ajax_url = '',$sub_heading = '', $columns = '', $folder_name = '', $search = false)
    {
        $this->table_id = $table_id;
        $this->ajax_url = $ajax_url;
        $this->columns = $columns;
        $this->folder_name = $folder_name;
        $this->search = $search;
        $this->module = $module;
        $this->sub_heading = $sub_heading;
    }

    public function render(): View|Closure|string
    {
        return view('components.admin-datatable');
    }
}
