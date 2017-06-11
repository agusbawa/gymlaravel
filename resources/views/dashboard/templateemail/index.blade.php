@extends('dashboard._layout.dashboard')


@section('help-title', 'Template Email')
@section('title', 'Template Email')
@section('page-title', 'Template Email')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('templateemail')!!}
@endsection
@section('table')
@section('content')
    <div class="row">
      <div class="panel panel-default">

<table class="table">

    <thead>
        <tr>
            <th>Title</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    </thead>
<tbody>
@foreach($template as $row)
<tr>
    <td>
        {{$row->title}}
    </td>
    <td class="text-right" width="200">
                
                <a @if(\App\Permission::EditPer('224',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/templateemail/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
</tr>
@endforeach
<tbody>
</table>
    </div>
@endsection