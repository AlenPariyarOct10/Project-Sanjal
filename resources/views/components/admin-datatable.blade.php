<div class="admin-header">
    <div>
        <h2 class="text-2xl font-bold">{{$module}}</h2>
        <p>{{$sub_heading}}</p>
    </div>
    <button class="btn" id="add{{$module}}Btn">Add {{$module}}</button>
</div>

@if(!empty($search))
    <div class="admin-controls">
        <input type="text" id="{{'search'.$table_id}}" placeholder="Search {{$folder_name}}..."
               class="admin-search">
    </div>
@endif

<div class="overflow-x-auto">

<table id="{{ $table_id }}" class="table table-bordered table-striped w-100">
    <thead>
    <tr>
        @foreach ($columns as $col)
            <th>
                {{ $col['name'] == 'DT_RowIndex' ? 'SN' : ucwords(str_replace('_', ' ', $col['name'])) }}
            </th>
        @endforeach
    </tr>
    </thead>
</table>
</div>
