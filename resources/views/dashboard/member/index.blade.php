    @extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-member')

@section('help-title', 'Member')
@section('title', 'Member')
@section('page-title', 'Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member')!!}
@endsection
@section('add_url', url('u/members/create'))
@section('table')

<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Telp.</th>
            <th>Alamat</th>
            <th>Gym</th>
            <th>Expired Date</th>
            <th>No Kartu</th>
            <th>No Kartu Lama</th>
            <th>Register From</th>
            
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->name}}</td>
            <td>{{$row->phone}}</td>
            <td>{{$row->address_street}}, {{$row->address_region}}, {{$row->address_city}}</td>
            <td><a href="/u/gyms/{{$row->gym->id}}">{{$row->gym->title}}</a></td>
            <td>{{$row->expired_at}}</td>            
            <td>
            @if($row->card==0)

            @else
                {{$row->card}}
            @endif
            </td>
            <td>{{$row->slug}}</td>
            <td>
                @if($row->registerfrom)
                Online Register
                @else
                Offline Register
                @endif
            </td>
            
            <td class="text-right" width="200">
                <form action="/u/members/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('14',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('14',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="{{route('members.edit',$row->id)}}"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                <a href="/u/members/{{$row->id}}"  rel="tooltip" title="Lihat @yield('help-title')" class="btn btn-white btn-simple btn-xs pull-right"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection