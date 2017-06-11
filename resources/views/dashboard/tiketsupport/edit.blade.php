@extends('dashboard._layout.dashboard')
@section("title", "Reply Tiket Support")
@section('page-title', $tiketsupport->title)
@section('page-breadcrumb')
    {!!Breadcrumbs::render('edit-support',$tiketsupport)!!}
@endsection
@section('content')
     <div class="row">
         <div class="col-md-12">
            <section id="cd-timeline" class="cd-container">
                @foreach($messages as $message)
                    <div class="cd-timeline-block">
                    @if($message->author == 1)
                        <div class="cd-timeline-img cd-success">
                            <i class="fa fa-user"></i>
                        </div> <!-- cd-timeline-img -->
                    @else
                         <div class="cd-timeline-img cd-info">
                            <i class="fa fa-user"></i>
                        </div> <!-- cd-timeline-img -->
                    @endif
                    <div class="cd-timeline-content">
                                            
                        <p>{{$message->pesan}}</p>
                    <span class="cd-date">{{$message->created_at}}</span>
                </div> <!-- cd-timeline-content -->
            </div> <!-- cd-timeline-block -->
        @endforeach
    </section> <!-- cd-timeline -->
</div>
</div><!-- Row -->
<div class="col-md-12">
    <form method="POST" action="/u/tiketmsg/reply/{{$tiketsupport->id}}">
     {{ method_field('PATCH') }}
    {{ csrf_field() }}
        <div class="form-group">
            <textarea name="pesan" id="" cols="30" rows="10" class="form-control">{{old('description')}}</textarea>
        </div>
    <button class="btn btn-info btn-large" type="submit">Reply</button>
    </form>
</div>
@endsection