@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Target Gym')
@section('title', 'Target Gym')
@section('page-title', 'Target Gym')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('target-gym')!!}
@endsection
@if(\App\Permission::CreatePer('228',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/target/create'))

@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Gym</th>
            <th>Bulan</th>
            
            <th>Target Omzet</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        @if($row->gym == null)
            @continue
    @else
    @endif
        <tr>
            <td>{{$row->gym->title}}</td>
            <td>{{$row->bulan}} {{date('Y',strtotime($row->created_at))}}</td>
            <td>Rp {{number_format($row->target_omset)}}</td>
            <td class="text-right" width="200">
                <form action="/u/target/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('228',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('228',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/target/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection