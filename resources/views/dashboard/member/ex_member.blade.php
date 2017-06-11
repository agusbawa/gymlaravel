@extends('dashboard._layout.dashboard')
@section('title', 'Upload Member')
@section('page-title', 'Upload Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member-upload')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/members/post_exmember" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="card-box">
                    <div class="form-group label-floating">
                        <label class="control-label">Upload File CSV</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/members" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection