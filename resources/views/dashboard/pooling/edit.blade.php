@extends('dashboard._layout.dashboard')
@section('title', 'Edit Pooling')
@section('page-title', 'Edit Pooling')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('poolings-edit', $vote)!!}
@endsection
@section('content')
    <div class="row">
        <form action="/u/poolings/{{$vote->id}}" method="POST">
        <div class="col-lg-6">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Judul</label>
                        <input type="text" class="form-control" name="title" value="{{old('title',$vote->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('description')) has-error @endif">
                        <label class="control-label">Description</label>
                        <input type="text" class="form-control" name="description" value="{{old('description',$vote->description)}}">
                        @if($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('enableregister')) has-error @endif">
                        <label class="control-label">Tampilkan pada register member</label>
                        <select name="enableregister" id="" class="form-control">
                            <option value="1" @if(old('enableregister',$vote->enableregister)=="1") selected @endif>Aktif</option>
                            <option value="0" @if(old('enableregister',$vote->enableregister)=="0") selected @endif>Tidak Aktif</option>
                        </select>
                        @if($errors->has('enableregister')) <p class="help-block">{{ $errors->first('enableregister') }}</p> @endif
                    </div>
                    
                    <div class="form-group text-right">
                        <a href="/u/poolings" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
        </div>
        <div class="col-lg-6">
            <div class="card-box">
                <button type="button" id="addVoteItem" class="btn btn-danger">Add Vote Item</button>
                <div id="addItemdata">
                    @foreach($vote->voteItems()->get() as $item)
                    <div class="form-group label-floating"><input type="text" class="form-control" name="item_before[{{$item->id}}]" value="{{$item->title}}"> <button type="button" class="btn btn-danger remove-item">X</button></div>
                    @endforeach
                    
                </div>
            </div>
        </div>
            </form>
    </div>
@endsection