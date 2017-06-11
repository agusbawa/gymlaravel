@extends('dashboard._layout.dashboard')

@section('title', 'Lihat Pooling ')
@section('page-title', 'Lihat Pooling')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('poolings-show',$pooling)!!}
@endsection
@section('content')

<div class="m-b-15"></div>




<div class="portlet">
    <div class="portlet-heading">
        <h3 class="portlet-title text-dark">
            Chart Pooling
        </h3>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
     
        <canvas id="bar" style="width:100%;height:100%;"></canvas>
    </div>
</div>    


<script>
    var barData ={
    labels: [
        @foreach($items as $item)
            "{{$item->title}}",

        @endforeach
    ],
    datasets: 
    [
        {
            label: "Report",
            backgroundColor: [
                'rgba(255, 66, 132, 0.2)'
                
            ],
            borderColor: [
                'rgba(255,66,132,1)'
            ],
            borderWidth: 1,
            data: [
              @foreach($items as $item)
                    {{$item->memberVotes()->count()}},
              @endforeach
            ],
        }
    ]
}
         var context = document.getElementById('bar').getContext('2d');
         var skillsChart = new Chart(context).Bar(barData);
</script>
@endsection