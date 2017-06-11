@extends('dashboard._layout.dashboard')
@section('title', 'Edit News')
@section('page-title', 'Edit News')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('news-edit', $news)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/news/{{$news->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Judul</label>
                        <input type="text" class="form-control" name="title" value="{{old('title',$news->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('description')) has-error @endif">
                        <textarea name="description" id="" cols="30" rows="10" class="summernote">{{old('description',$news->description)}}</textarea>
                        @if($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="DRAFT" @if(old('status',$news->status)=="DRAFT") selected @endif>Draft</option>
                            <option value="PUBLISHED" @if(old('status',$news->status)=="PUBLISHED") selected @endif>Published</option>
                        </select>
                    </div>
                    
                    <div class="form-group text-right">
                        <a href="/u/news" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection