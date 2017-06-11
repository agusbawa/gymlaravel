@section('content')
        @yield('analitycs')
    <div class="row">
        <div class="col-md-4">
        
       
            <div @yield('status') class="form-group">
                <a href="@yield('add_url')"  class="btn btn-default"><span class="fa fa-plus"></span> @yield('title')</a>
            </div>
        </div>
            <div class="col-md-8 text-right">
                <form action="" class="form-inline" method="GET">
                    <div class="form-group label-floating">
                        <label class="control-label">Keyword Pencarian</label>
                        <input type="text" class="form-control" name="keyword" value="{{$keyword}}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Cari</button>
                    </div>  
                </form>
            </div>
        </div>
        <div class="panel panel-default table-responsive">
            @yield('table')
        </div>
        {{ $table->links() }}
    </div>
@endsection