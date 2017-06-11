@extends('dashboard._layout.dashboard')
@section('title', 'Edit Harga Paket')
@section('page-title', 'Edit Harga Paket')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('packagelist-edit', $packagePrice)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/packageprices/{{$packagePrice->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="">Category harga</label>
                        <select name="package_id" id="" class="select2 form-control">
                            @foreach($packages as $package)
                                <option @if($package->id == old('package_id',$packagePrice->package_id)) selected @endif value="{{$package->id}}">{{$package->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Nama</label>
                        <input type="text" class="form-control" name="title" value="{{old('title',$packagePrice->title)}}" placeholder="Mis. 3 Bulan">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>

                    <div class="form-group @if($errors->has('day')) has-error @endif">
                        <label class="control-label">Lama (Bulan)</label>
                        <input type="number" class="form-control" name="day" value="{{old('day',$packagePrice->day)}}">
                        @if($errors->has('day')) <p class="help-block">{{ $errors->first('day') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('price')) has-error @endif">
                        <label class="control-label">Harga</label>
                        <input type="text" id="total" class="form-control" name="price" value="{{old('price',$packagePrice->price)}}">
                        @if($errors->has('price')) <p class="help-block">{{ $errors->first('price') }}</p> @endif
                    </div>
                    
                    <div class="form-group checkbox">
                        <input name="enable_front" value="1" id="checkbox0" type="checkbox" @if((old('enable_front',$packagePrice->enable_front))) checked @endif>
                        <label for="checkbox0">
                            Tampilkan di front page
                        </label>
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/packageprices" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
var format = function(num){
	var str = num.toString().replace("",""), parts = false, output = [], i = 1, formatted = null;
	if(str.indexOf(".") > 0) {
		parts = str.split(".");
		str = parts[0];
	}
	str = str.split("").reverse();
	for(var j = 0, len = str.length; j < len; j++) {
		if(str[j] != ",") {
			output.push(str[j]);
			if(i%3 == 0 && j < (len - 1)) {
				output.push(",");
			}
			i++;
		}
	}
	formatted = output.reverse().join("");
	return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};
$(function(){
    $("#total").keyup(function(e){
    
        $(this).val(format($(this).val()));
    });
});
</script>
@endsection