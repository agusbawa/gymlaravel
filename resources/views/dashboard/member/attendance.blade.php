@extends('dashboard._layout.dashboard')
@section('title', 'Member Check-In / Check-Out')
@section('page-title', 'Member Check-In / Check-Out')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member-attendance')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/members/attendances" @if($checkin != null) method="POST" @else method="GET" @endif>
               @if($checkin != null){{ csrf_field() }} @endif
                <div class="card-box">
                    <div class="form-group label-floating @if($errors->has('gym')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select name="gym" id="" class="form-control select2">
                         @if(\App\Permission::CheckGym(Auth::user()->id)==1)
                                @foreach($gyms as $gym)
                                @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==0)
                                    @continue
                                @endif
                                    <option @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==1) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                        @else
                            @foreach($gyms as $gym)
                                <option @if(request()->get('gym',old('gym'))==$gym->id) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                            @endforeach
                        @endif
                        </select>
                        @if($errors->has('gym')) <p class="help-block">{{ $errors->first('gym') }}</p> @endif
                    </div>

                    <div class="form-group label-floating  @if($errors->has('member')) has-error @endif">
                        <label class="control-label">No Kartu</label>
                        <input type="text" class="form-control" name="member"@if($membercard == null) value="{{old('member')}}"@else @if($membercard->card == 0) value="{{$membercard->slug}}" @else value="{{$membercard->card}}" @endif @endif>
                        @if($errors->has('member')) <p class="help-block">{{ $errors->first('member') }}</p> @endif
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/members/attendances" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button  class="btn btn-pink waves-effect waves-light" type="submit">Checkin/Checkout </button>
                    </div>
                </div>
            
        </div>

                <div id="myModal" class="modal fade bs-example-modal-md in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;padding-right:15px;">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <a href="/u/members/attendances" class="close" aria-hidden="true">×</a>
                                    <h4 class="modal-title" id="mySmallModalLabel">Personal info</h4>
                                </div>
                                <div class="modal-body">
                                @if($checkin == null)

                                @else
                                <div class="col-md-5">@if($member->foto == null) <img src="/images/avatar/default.png" class="img img-responsive" style="width:100%;heigth=auto;"> @else<img src="{{$member->foto}}" class="img img-responsive" style="width:100%;heigth=auto;">@endif</div>
                                <div class="col-md-4">
                                <b>{{$member->name}}</b>
                                 <p>Expire : <b>{{$member->expired_at}}</b></p>
                                 <p>Kartu : <b>@if($member->card){{$member->card}} @else {{$member->slug}} @endif</b></p>
                                
                                  <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($member->card, "C39+") . '" width="220px" alt="barcode"   />'; ?>
                                 </div>
                                 <div class="clearfix"></div>
                                 <br/>
                                <a href="/u/members/attendances" class="btn btn-white btn-custom waves-effect">Batal</a>
                                @if($member->expired_at < \Carbon\Carbon::now())
                                    <a href="/u/members/extend/{{$member->id}}">Perpanjang</button>
                                @else
                                    @if($checkin != null)
                                        @if($checkin == 'checkin')
                                        <button type="submit" class="btn btn-pink">Checkin</button> 
                                        @else
                                        <button type="submit" class="btn btn-default">Checkout</button>
                                        @endif
                                    @elseif($checkin == null) 
                                        
                                    @endif
                                @endif
                                @endif
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>  
                </form>
    </div>
    @if($checkin != null)
    <script>
        $(window).load(function(){
            $('#myModal').modal('show');
        });
    </script>
    @endif
@endsection