@section('content')
        @yield('analitycs')
        <div class="row">
            <div @yield('status') class="col-md-2">
                <div class="form-group">
                    <a href="@yield('add_url')" @if(\App\Permission::CreatePer('14',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-default"><span class="fa fa-plus"></span> @yield('title')</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
           
                <form action="" class="form-inline" method="GET">
                <div class="form-group" >
                 <!--   <label class="control-label" >Cari</label>
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                            <option value="">Pilih Berdasarkan gym</option>
                            <option value="5">Berdasarakan Gym</option>
                        </select>
                    </div>   -->
                </div>
                    <div class="form-group col-xs-12 col-md-12" >
                        
                        <select name="gyms[]" id="" multiple="multiple" class="select2" placeholder="Gym">
                            @if(\App\Permission::CheckGym(Auth::user()->id)==1)
                                @foreach($gyms as $gym)
                                @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==0)
                                    @continue
                                @endif
                                    <option  @if($selectgym != 0) @foreach($selectgym as $sel) @if($sel == $gym->id) selected @endif @endforeach @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            
                            @else
                                @foreach($gyms as $gym)
                                    <option @if($selectgym != 0) @foreach($selectgym as $sel) @if($sel == $gym->id) selected @endif @endforeach @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            @endif
                        </select>   
                    <div>
            </div>
            <br/>
            </div>

<div class="col-lg-12">
        <div class="form-group  col-xs-3 col-md-3">
            <input name="onlineMember" id="" type="checkbox" @if(!empty($memberonline)) checked="checked" @endif > 
            <label for="checkbox0">
                Online Member Belum Proses
            </label>
        </div>
       
        <div class="form-group  col-xs-2 col-md-2">
           
            <select name="expiredtype" id="" class="form-control">
            <option value=""  selected >Member Expired</option>
            @foreach($expiredtype as $expKey => $expVal)
                <option @if($expKey == $expired) selected @endif value="{{$expKey}}">{{$expVal}}</option>
            @endforeach
            </select>
        </div>
       
       
            <div class="form-group  col-xs-2 col-md-2">
               
                <input class="form-control input-daterange-datepicker" name="expiredRange" placeholder="Tanggal Expired" type="text" value=""/>
            </div>

            <div class="form-group label-floating">
                        
                        <input type="text" class="form-control" placeholder="Keyword Pencarian" name="keyword" value="{{$keyword}}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Cari</button>
                    </div>
                      
        </div>
        </div>
      
        
        
    
                </form>
    </div>
    <br/>
    </div>
    
    <br/>
        <div class="panel panel-default table-responsive">
            @yield('table')
        </div>

        {{ $table->links() }}
        <script type="text/javascript">
    function showDiv(select){
        if(select.value==5){
            //document.getElementById("hidden_zona1").style.display = "block";
            document.getElementById("hidden_zonagym").style.display = "block"; 
       }else{
            //document.getElementById("hidden_zona").style.display = "none"; 
            document.getElementById("hidden_gym").style.display = "none"; 
           
       }
    } 
</script>
        <script>
    $(function(){
    // turn the element to select2 select style
        $('#zonaku').change(function(){
            var countryID = $(this).val();  
            console.log(countryID);  
            if(countryID){
                $.ajax({
                   type:"GET",
                   url:"{{url('gym-zona')}}?zona_id="+countryID,
                   success:function(res){               
                    if(res){
                        $("#gym").empty();
                        $.each(res,function(key,value){
                            $("#gym").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#gym").empty();
                    }
                   }
                });
            }else{
                 $.ajax({
                   type:"GET",
                   url:"{{url('gym-zona')}}?zona_id=",
                   success:function(res){               
                    if(res){
                        $("#gym").empty();
                        $("#gym").append('<option>Select</option>');
                        $.each(res,function(key,value){
                            $("#gym").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#gym").empty();
                    }
                   }
                });
            }      
        });
    });
</script>
   
@endsection