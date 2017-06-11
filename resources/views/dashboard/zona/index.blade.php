@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Zona Gym')
@section('title', 'Zona Gym')
@section('page-title', 'Zona Gym')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('zona')!!}
@endsection
@if(\App\Permission::CreatePer('24',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/zonas/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Nama Zona</th>
            <th>Jumlah Gym</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td><a href="/u/showgym/{{$row->id}}"  class="showdata-listGym">{{$row->gyms()->count()}}</a></td>
            <td class="text-right" width="200">
                <form action="/u/zonas/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('24',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('24',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/zonas/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade" id="modallistgym" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">List Gym</h4>
      </div>
      <div class="modal-body">
          <ul id="dataListgym-place">
              
          </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

