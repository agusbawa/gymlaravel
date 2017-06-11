    @extends('dashboard._layout.dashboard')

@section('help-title', 'Filter')
@section('title', 'Filter')
@section('page-title', 'Filter')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('filter')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
               <form action="/u/report/searchusia" class="form-inline" method="POST">
                {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label class="control-label">Lokasi</label>
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                            <option value="">Pilih Lokasi</option>
                            <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                            <option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>
                            <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                            <option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>
                            <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                            <option @if($nama_gym==5) selected @endif value="5">Gym Dalam Zona Tertentu</option>
                        </select>
                    </div>   
                    <div class="form-group">
                    <label class="control-label">Periode</label>
                        <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range')}}{{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}">
                    </div>
                    <div class="form-group checkbox">
                        <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                        <label for="checkbox0">
                            Tampilkan %
                        </label>
                    </div>
                    <div id="hidden_gym" style="display: none;">
                        <div style="margin-top: 10px;">
                            <label for="">Nama Gym</label>
                                <select name="gyms[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Gym">
                                    @foreach($gym as $gymku)
                                        <option @if(in_array($gymku->id, $tertentugym) == $tertentugym)) selected @endif value="{{$gymku->id}}">{{$gymku->title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div id="hidden_zona" style="display: none;">
                        <div style="margin-top: 10px;">
                            <label for="">Nama Zona</label>
                                <select name="zonasku[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Zona">
                                    @foreach($zona as $zonaku)
                                        <option @if(in_array($zonaku->id, $tertentuzona) == $tertentuzona)) selected @endif value="{{$zonaku->id}}">{{$zonaku->title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div id="hidden_zona1" style="display: none;">
                        <div style="margin-top: 10px;">
                            <label for="">Nama Zona</label>
                                <select name="zonas[]" id="zonaku" class="select2 form-control" placeholder="Silakan Pilih Nama Zona">
                                    <option value="0" selected>Pilih Zona</option>
                                    @foreach($zona as $zona)
                                        <option @if(in_array($zona->id, $tertentuzona) == $tertentuzona)) selected @endif value="{{$zona->id}}">{{$zona->title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="form-group label-floating" id="hidden_zonagym" style="display: none;">
                        <label class="control-label">Nama Gym</label>
                            <select name="gymku[]" multiple="multiple" class="select2" id="gym">     
                            </select>
                    </div>
                     
                    <div class="" style="margin-top: 10px;">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
                    </div>
                    
                </form>
                
            </div>
        </div>
        <br>
        <?php
        $date_awal = Carbon\Carbon::parse($backdate)->format('d-m-Y');
        $date_akhir = Carbon\Carbon::parse($currentdate)->format('d-m-Y');
        ?>
<div class="panel panel-default">
        @foreach($zonas as $zona)
       <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            @if($nama_gym==2) 
                        <a href="/u/report/link_zonausia/{{$zona->id}}?range={{$date_awal}}++-++{{$date_akhir}}">
                      @else
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$zona->id}}" aria-expanded="true" aria-controls="collapseOne">
                         @endif
              {{$zona->title}}
            </a>
          </h4>
        </div>
        <div id="{{$zona->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
                        <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$all=$zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                            <p class="text-muted"><span id="hidden_persen1{{$zona->id}}" style="visibility: hidden;">{{number_format(($all/App\Member::get()->count())*100,0,',','')}}%</span><br>All Member</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$eight = $zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen2{{$zona->id}}" style="visibility: hidden;"></span><br> > 18 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$twenty = $zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-18))
            ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-24))
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3{{$zona->id}}" style="visibility: hidden;"></span><br>18 - 24 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$thirty = $zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-25))
            ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-34))
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen4{{$zona->id}}" style="visibility: hidden;"></span><br>25 - 34 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$fourty = $zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-35))
            ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-44))
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen5{{$zona->id}}" style="visibility: hidden;"></span><br>35 - 44 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$fifty = $zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-45))
            ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-54))
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen6{{$zona->id}}" style="visibility: hidden;"></span><br>45 - 54 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$sixty = $zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-55))
            ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-64))
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen7{{$zona->id}}" style="visibility: hidden;"></span><br>55 - 64 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-time text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$seventy = $zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','extends')
            ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
            ->where('zonas.id',$zona->id)
            ->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen8{{$zona->id}}" style="visibility: hidden;"></span><br>65+</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                  </div>
                </div>
                <script type="text/javascript">
    var checkbox = $(".checkboxId");
    checkbox.change(function(event) {
        var checkbox = event.target;
        if (checkbox.checked) {
            document.getElementById("hidden_persen1{{$zona->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen2{{$zona->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen3{{$zona->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen4{{$zona->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen5{{$zona->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen6{{$zona->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen7{{$zona->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen8{{$zona->id}}").style.visibility = "visible";  
        } else {
            document.getElementById("hidden_persen1{{$zona->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2{{$zona->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen3{{$zona->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen4{{$zona->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen5{{$zona->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen6{{$zona->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen7{{$zona->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen8{{$zona->id}}").style.visibility = "hidden"; 
        }
    });
</script>
        @endforeach
    </div>
<div class="col-lg-6">
	<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Pie Chart</b></h4>
									
				<ul class="list-inline chart-detail-list text-center">
                                		
                            		</ul>
                                    <canvas id="skills" width="300" height="300"></canvas>
								</div>
							</div>
<div class="col-lg-6">
	<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Bar Chart</b></h4>
									
				<ul class="list-inline chart-detail-list text-center">
                                	
                            		</ul>
                                    <canvas id="bar" width="300" height="300"></canvas>
								</div>
							</div>

<script>
 var pieData = [
     @foreach ($zonas as $zona)
   {
       
      value: {{number_format(($zona
            ->join('gyms','gyms.zona_id','=','zonas.id')
            ->join('members','members.gym_id','=','gyms.id')
            ->where('members.type','New')
            ->where('zonas.id',$zona->id)
            ->count()/App\Member::get()->count())*100,0,',','')}},
      label: '{{$zona->title}}',
      color: '#811BD6'
   },
  @endforeach
];
var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }

var context = document.getElementById('skills').getContext('2d');
var skillsChart = new Chart(context).Pie(pieData,options);
var barData ={
    labels: ["All Member"],
    datasets: 
    [
        {
            label: "Report",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
                
            ],
            borderColor: [
                'rgba(255,99,132,1)'
               
            ],
            borderWidth: 1,
            data: [100],
        }
    ]
}
         var context = document.getElementById('bar').getContext('2d');
         var skillsChart = new Chart(context).Bar(barData);
</script>
<script type="text/javascript">
    function showDiv(select){
        if(select.value==3){
            document.getElementById("hidden_gym").style.display = "block"; 
            document.getElementById("hidden_zona").style.display = "none"; 
            document.getElementById("hidden_zona1").style.display = "none";
            document.getElementById("hidden_zonagym").style.display = "none";
       }else if(select.value==4){ 
            document.getElementById("hidden_zona").style.display = "block";
            document.getElementById("hidden_gym").style.display = "none"; 
            document.getElementById("hidden_zona1").style.display = "none";
            document.getElementById("hidden_zonagym").style.display = "none"; 
       }else if(select.value==5){
            document.getElementById("hidden_zona1").style.display = "block";
            document.getElementById("hidden_zonagym").style.display = "block"; 
            document.getElementById("hidden_gym").style.display = "none"; 
            document.getElementById("hidden_zona").style.display = "none"; 
       }else{
            document.getElementById("hidden_zona").style.display = "none"; 
            document.getElementById("hidden_gym").style.display = "none"; 
            document.getElementById("hidden_zona1").style.display = "none";
            document.getElementById("hidden_zonagym").style.display = "none";
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