@section('content')
        @yield('analitycs')
        <div class="row">
           
            <div class="col-md-10 text-right">
                <form action="" class="form-inline" method="GET">
                    <div class="form-group">
                        <select name="gyms[]" id="" multiple="multiple" class="select2" placeholder="Gym">
                            <option value="">all Gym</option>
                            @foreach($gyms as $gym)
                                <option @if(in_array($gym->id, $gym_id) == $gym_id)) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Member Expired</label>
                        <select name="expiredtype" id="" class="form-control">
                            <option value="">all</option>
                            @foreach($expiredtype as $expKey => $expVal)
                                <option @if($expKey == $expired) selected @endif value="{{$expKey}}">{{$expVal}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group checkbox">
                        <input name="onlineMember" id="" type="checkbox" @if(!empty($memberonline)) checked="checked" @endif > 
                        <label for="checkbox0">
                            online member belum process
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="">Expired Date by Range</label>
                            <input class="form-control input-daterange-datepicker" name="expiredRange" type="text" value=""/>
                    </div>
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
        
@endsection