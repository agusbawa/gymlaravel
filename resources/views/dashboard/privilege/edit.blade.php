@extends('dashboard._layout.dashboard')
@section('title', 'Edit Role')
@section('page-title', 'Edit Role')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('privilege-edit',$role)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="/u/privileges/{{$role->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Jabatan</label>
                        <input type="text" class="form-control" name="title" value="{{old('title', $role->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>
                     <div class="form-group label-floating @if($errors->has('permission')) has-error @endif">
                        <label class="control-label">Menu</label>
                        <select name="permission[]" id="" class="select2 form-control" onchange="showDiv(this)">
                            <option value="">Silakan Pilih</option>
                            @foreach($permissions as $permission)
                                 <option value="{{$permission->id}}" @if(in_array($permission->id, old('permissions',[]))) selected @endif>{{$permission->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table" id="hidden_dash" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_dash as $dash)
                            <tr>
                            <?php $dash1 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$dash->id)->value('permission_id'); 
                                $create_1 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$dash->id)->value('create'); 
                                $update_1 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$dash->id)->value('update'); 
                                $delete_1 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$dash->id)->value('delete'); 
                            ?>
                                <td>{{$dash->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$dash->id}}" onclick="calc();" value="{{$dash->id}}" @if($dash1==$dash->id) checked @endif></td>
                                <td><input type="checkbox" name="dash[{{$dash->id}}][create]" id="hidden_persen1{{$dash->id}}" value="1" @if($create_1==1) checked @elseif($dash1==$dash->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$dash->id}}][update]" id="hidden_persen2{{$dash->id}}" value="1" @if($update_1==1) checked @elseif($dash1==$dash->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$dash->id}}][delete]" id="hidden_persen3{{$dash->id}}" value="1" @if($delete_1==1) checked @elseif($dash1==$dash->id) @else disabled @endif></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" id="hidden_trans" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_trans as $trans)
                            <tr>
                            <?php $dash2 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$trans->id)->value('permission_id'); 
                                $create_2 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$trans->id)->value('create'); 
                                $update_2 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$trans->id)->value('update'); 
                                $delete_2 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$trans->id)->value('delete'); 
                            ?>
                                <td>{{$trans->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$trans->id}}" onclick="calc();" value="{{$trans->id}}" @if($dash2==$trans->id) checked @endif></td>
                                <td><input type="checkbox" name="dash[{{$trans->id}}][create]" id="hidden_persen1{{$trans->id}}" value="1" @if($create_2==1) checked @elseif($dash2==$trans->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$trans->id}}][update]" id="hidden_persen2{{$trans->id}}" value="1" @if($update_2==1) checked @elseif($dash2==$trans->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$trans->id}}][delete]" id="hidden_persen3{{$trans->id}}" value="1" @if($delete_2==1) checked @elseif($dash2==$trans->id) @else disabled @endif></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" id="hidden_member" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_member as $member)
                            <tr>
                            <?php $dash3 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$member->id)->value('permission_id'); 
                                $create_3 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$member->id)->value('create'); 
                                $update_3 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$member->id)->value('update'); 
                                $delete_3 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$member->id)->value('delete'); 
                            ?>
                                <td>{{$member->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$member->id}}" onclick="calc();" value="{{$member->id}}" @if($dash3==$member->id) checked @endif></td>
                                @if($member->name == "Data Kartu")
                                 <td><input type="checkbox" name="dash[{{$member->id}}][create]" id="hidden_persen1{{$member->id}}" value="1" @if($create_3==1) checked @elseif($dash3==$member->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$member->id}}][update]" value="1"  disabled></td>
                                <td><input type="checkbox" name="dash[{{$member->id}}][delete]" value="1" disabled ></td>
                                @elseif($member->name=='Perpanjangan Member'||$member->name=='Aktifasi Member'||$member->name=='Check In/Check Out'||$member->name=='Upload Member'||$member->name=='Upload Perpanjangan Member'||$member->name=='Upload Check In/Check Out')
                                <td><input type="checkbox" name="dash[{{$member->id}}][create]" id="hidden_persen1{{$member->id}}" value="1"  disabled></td>
                                <td><input type="checkbox" name="dash[{{$member->id}}][update]" id="hidden_persen2{{$member->id}}" value="1" disabled ></td>
                                <td><input type="checkbox" name="dash[{{$member->id}}][delete]" id="hidden_persen3{{$member->id}}" value="1"  disabled></td>
                                @else
                                <td><input type="checkbox" name="dash[{{$member->id}}][create]" id="hidden_persen1{{$member->id}}" value="1" @if($create_3==1) checked @elseif($dash3==$member->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$member->id}}][update]" id="hidden_persen2{{$member->id}}" value="1" @if($update_3==1) checked @elseif($dash3==$member->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$member->id}}][delete]" id="hidden_persen3{{$member->id}}" value="1" @if($delete_3==1) checked @elseif($dash3==$member->id) @else disabled @endif></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" id="hidden_gym" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_gym as $gym)
                            <tr>
                            <?php $dash4 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$gym->id)->value('permission_id'); 
                                $create_4 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$gym->id)->value('create'); 
                                $update_4 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$gym->id)->value('update'); 
                                $delete_4 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$gym->id)->value('delete'); 
                            ?>
                                <td>{{$gym->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$gym->id}}" onclick="calc();" value="{{$gym->id}}" @if($dash4==$gym->id) checked @endif></td>
                                <td><input type="checkbox" name="dash[{{$gym->id}}][create]" id="hidden_persen1{{$gym->id}}" value="1" @if($create_4==1) checked @elseif($dash4==$gym->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$gym->id}}][update]" id="hidden_persen2{{$gym->id}}" value="1" @if($update_4==1) checked @elseif($dash4==$gym->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$gym->id}}][delete]" id="hidden_persen3{{$gym->id}}" value="1" @if($delete_4==1) checked @elseif($dash4==$gym->id) @else disabled @endif></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" id="hidden_kom" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_kom as $kom)
                            <tr>
                            <?php $dash5 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$kom->id)->value('permission_id'); 
                                $create_5 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$kom->id)->value('create'); 
                                $update_5 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$kom->id)->value('update'); 
                                $delete_5 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$kom->id)->value('delete'); 
                            ?>
                                <td>{{$kom->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$kom->id}}" onclick="calc();" value="{{$kom->id}}" @if($dash5==$kom->id) checked @endif></td>
                                <td><input type="checkbox" name="dash[{{$kom->id}}][create]" id="hidden_persen1{{$kom->id}}" value="1" @if($create_5==1) checked @elseif($dash5==$kom->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$kom->id}}][update]" id="hidden_persen2{{$kom->id}}" value="1" @if($update_5==1) checked @elseif($dash5==$kom->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$kom->id}}][delete]" id="hidden_persen3{{$kom->id}}" value="1" @if($delete_5==1) checked @elseif($dash5==$kom->id) @else disabled @endif></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" id="hidden_aku" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_aku as $aku)
                            <tr>
                            <?php $dash6 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$aku->id)->value('permission_id'); 
                                $create_6 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$aku->id)->value('create'); 
                                $update_6 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$aku->id)->value('update'); 
                                $delete_6 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$aku->id)->value('delete'); 
                            ?>
                                <td>{{$aku->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$aku->id}}" onclick="calc();" value="{{$aku->id}}" @if($dash6==$aku->id) checked @endif></td>
                                <td><input type="checkbox" name="dash[{{$aku->id}}][create]" id="hidden_persen1{{$aku->id}}" value="1" @if($create_6==1) checked @elseif($dash6==$aku->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$aku->id}}][update]" id="hidden_persen2{{$aku->id}}" value="1" @if($update_6==1) checked @elseif($dash6==$aku->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$aku->id}}][delete]" id="hidden_persen3{{$aku->id}}" value="1" @if($delete_6==1) checked @elseif($dash6==$aku->id) @else disabled @endif></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" id="hidden_lap" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_lap as $lap)
                            <tr>
                            <?php $dash7 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$lap->id)->value('permission_id'); 
                                $create_7 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$lap->id)->value('create'); 
                                $update_7 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$lap->id)->value('update'); 
                                $delete_7 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$lap->id)->value('delete'); 
                            ?>
                                <td>{{$lap->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$lap->id}}" onclick="calc();" value="{{$lap->id}}" @if($dash7==$lap->id) checked @endif></td>
                                <td><input type="checkbox" name="dash[{{$lap->id}}][create]" id="hidden_persen1{{$lap->id}}" value="1" @if($create_7==1) checked @elseif($dash7==$lap->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$lap->id}}][update]" id="hidden_persen2{{$lap->id}}" value="1" @if($update_7==1) checked @elseif($dash7==$lap->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$lap->id}}][delete]" id="hidden_persen3{{$lap->id}}" value="1" @if($delete_7==1) checked @elseif($dash7==$lap->id) @else disabled @endif></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" id="hidden_pen" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lihat</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permiss_pen as $pen)
                            <tr>
                            <?php $dash8 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$pen->id)->value('permission_id'); 
                                $create_8 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$pen->id)->value('create'); 
                                $update_8 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$pen->id)->value('update'); 
                                $delete_8 = DB::table('permission_role')->where('role_id',$role->id)->where('permission_id',$pen->id)->value('delete'); 
                            ?>
                                <td>{{$pen->name}}</td>
                                <td><input type="checkbox" name="dashku[]" class="checkboxId{{$pen->id}}" onclick="calc();" value="{{$pen->id}}" @if($dash8==$pen->id) checked @endif></td>
                                <td><input type="checkbox" name="dash[{{$pen->id}}][create]" id="hidden_persen1{{$pen->id}}" value="1" @if($create_8==1) checked @elseif($dash8==$pen->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$pen->id}}][update]" id="hidden_persen2{{$pen->id}}" value="1" @if($update_8==1) checked @elseif($dash8==$pen->id) @else disabled @endif></td>
                                <td><input type="checkbox" name="dash[{{$pen->id}}][delete]" id="hidden_persen3{{$pen->id}}" value="1" @if($delete_8==1) checked @elseif($dash8==$pen->id) @else disabled @endif></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="form-group text-right">
                        <a href="/u/privileges" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function showDiv(select){
           if(select.value==1){
                document.getElementById("hidden_dash").style.display = "inline-table"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "none"; 
           }else if(select.value==2){
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "inline-table"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "none"; 
           }else if(select.value==3){
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "inline-table"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "none"; 
           }else if(select.value==4){
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "inline-table"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "none";  
           }else if(select.value==5){
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "inline-table"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "none";
           }else if(select.value==6){
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "inline-table"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "none";
           }else if(select.value==7){
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "inline-table"; 
                document.getElementById("hidden_pen").style.display = "none";
           }else if(select.value==8){
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "inline-table";
           }else{ 
                document.getElementById("hidden_dash").style.display = "none"; 
                document.getElementById("hidden_trans").style.display = "none"; 
                document.getElementById("hidden_member").style.display = "none"; 
                document.getElementById("hidden_gym").style.display = "none"; 
                document.getElementById("hidden_kom").style.display = "none"; 
                document.getElementById("hidden_aku").style.display = "none"; 
                document.getElementById("hidden_lap").style.display = "none"; 
                document.getElementById("hidden_pen").style.display = "none";
           }
        } 
    </script>
    @foreach($permiss_dash as $dash)
    <script type="text/javascript">
        var checkbox = $(".checkboxId{{$dash->id}}");
        checkbox.change(function(event) {
            var checkbox = event.target;
            if (checkbox.checked) {
                $("#hidden_persen1{{$dash->id}}").attr('disabled',false);
                $("#hidden_persen2{{$dash->id}}").attr('disabled',false);
                $("#hidden_persen3{{$dash->id}}").attr('disabled',false);
            } else {
                $("#hidden_persen1{{$dash->id}}").attr('disabled',true); 
                $("#hidden_persen2{{$dash->id}}").attr('disabled',true); 
                $("#hidden_persen3{{$dash->id}}").attr('disabled',true); 
            }
        });
    </script>
    @endforeach
    @foreach($permiss_trans as $trans)
    <script type="text/javascript">
        var checkbox = $(".checkboxId{{$trans->id}}");
        checkbox.change(function(event) {
            var checkbox = event.target;
            if (checkbox.checked) {
                $("#hidden_persen1{{$trans->id}}").attr('disabled',false);
                $("#hidden_persen2{{$trans->id}}").attr('disabled',false);
                $("#hidden_persen3{{$trans->id}}").attr('disabled',false);
            } else {
                $("#hidden_persen1{{$trans->id}}").attr('disabled',true); 
                $("#hidden_persen2{{$trans->id}}").attr('disabled',true); 
                $("#hidden_persen3{{$trans->id}}").attr('disabled',true); 
            }
        });
    </script>
    @endforeach
    @foreach($permiss_member as $member)
    <script type="text/javascript">
        var checkbox = $(".checkboxId{{$member->id}}");
        checkbox.change(function(event) {
            var checkbox = event.target;
            if (checkbox.checked) {
                $("#hidden_persen1{{$member->id}}").attr('disabled',false);
                $("#hidden_persen2{{$member->id}}").attr('disabled',false);
                $("#hidden_persen3{{$member->id}}").attr('disabled',false);
            } else {
                $("#hidden_persen1{{$member->id}}").attr('disabled',true); 
                $("#hidden_persen2{{$member->id}}").attr('disabled',true); 
                $("#hidden_persen3{{$member->id}}").attr('disabled',true); 
            }
        });
    </script>
    @endforeach
    @foreach($permiss_gym as $gym)
    <script type="text/javascript">
        var checkbox = $(".checkboxId{{$gym->id}}");
        checkbox.change(function(event) {
            var checkbox = event.target;
            if (checkbox.checked) {
                $("#hidden_persen1{{$gym->id}}").attr('disabled',false);
                $("#hidden_persen2{{$gym->id}}").attr('disabled',false);
                $("#hidden_persen3{{$gym->id}}").attr('disabled',false);
            } else {
                $("#hidden_persen1{{$gym->id}}").attr('disabled',true); 
                $("#hidden_persen2{{$gym->id}}").attr('disabled',true); 
                $("#hidden_persen3{{$gym->id}}").attr('disabled',true); 
            }
        });
    </script>
    @endforeach
    @foreach($permiss_kom as $kom)
    <script type="text/javascript">
        var checkbox = $(".checkboxId{{$kom->id}}");
        checkbox.change(function(event) {
            var checkbox = event.target;
            if (checkbox.checked) {
                $("#hidden_persen1{{$kom->id}}").attr('disabled',false);
                $("#hidden_persen2{{$kom->id}}").attr('disabled',false);
                $("#hidden_persen3{{$kom->id}}").attr('disabled',false);
            } else {
                $("#hidden_persen1{{$kom->id}}").attr('disabled',true); 
                $("#hidden_persen2{{$kom->id}}").attr('disabled',true); 
                $("#hidden_persen3{{$kom->id}}").attr('disabled',true); 
            }
        });
    </script>
    @endforeach
    @foreach($permiss_aku as $lap)
    <script type="text/javascript">
        var checkbox = $(".checkboxId{{$kom->id}}");
        checkbox.change(function(event) {
            var checkbox = event.target;
            if (checkbox.checked) {
                $("#hidden_persen1{{$lap->id}}").attr('disabled',false);
                $("#hidden_persen2{{$lap->id}}").attr('disabled',false);
                $("#hidden_persen3{{$lap->id}}").attr('disabled',false);
            } else {
                $("#hidden_persen1{{$lap->id}}").attr('disabled',true); 
                $("#hidden_persen2{{$lap->id}}").attr('disabled',true); 
                $("#hidden_persen3{{$lap->id}}").attr('disabled',true); 
            }
        });
    </script>
    @endforeach
    @foreach($permiss_pen as $pen)
    <script type="text/javascript">
        var checkbox = $(".checkboxId{{$pen->id}}");
        checkbox.change(function(event) {
            var checkbox = event.target;
            if (checkbox.checked) {
                $("#hidden_persen1{{$pen->id}}").attr('disabled',false);
                $("#hidden_persen2{{$pen->id}}").attr('disabled',false);
                $("#hidden_persen3{{$pen->id}}").attr('disabled',false);
            } else {
                $("#hidden_persen1{{$pen->id}}").attr('disabled',true); 
                $("#hidden_persen2{{$pen->id}}").attr('disabled',true); 
                $("#hidden_persen3{{$pen->id}}").attr('disabled',true); 
            }
        });
    </script>
    @endforeach
@endsection
