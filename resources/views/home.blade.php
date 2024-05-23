@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Count", { role: "style" } ],
        ["Main Assets", {{$asset_data['main_asset_followup']}}, "red"],
        ["Dongles", {{$asset_data['dongle_asset_followup']}}, "orange"],
        ["Other Assets", {{$asset_data['other_asset_followup']}}, "green"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Monthly Asset Allocation Summery",
        width: 600,
        height: 400,
        bar: {groupWidth: "50%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Dongle', 'Week Summery'],
          ['HNBA',     {{$asset_data['dongle_week_followup_hnba']}}],
          ['HNBGI',      {{$asset_data['dongle_week_followup_hnbgi']}}],
        ]);

        var options = {
          title: 'Dongle Weekly Activities',
          width: 720,
          height: 480,
          pieHole: 0.4,
          colors: ['red', 'green'],
          legend: {
            position: 'labeled',
            alignment: 'center'
          },
          fontSize: 17,
          pieSliceText: 'value',
          sliceVisibilityThreshold :0,
        };

        var chart = new google.visualization.PieChart(document.getElementById('dongle_week_piechart'));

        chart.draw(data, options);
      }
    </script>


<div class="container">
    <div class="row justify-content-center ml-3 mr-3">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
              
                    <center>
                        <h4>
                            <b>Monthly Asset Summery</b>
                        </h4>
                    </center>

                    <div class="col">
                        <div class="card border-primary">
                          <div class="card-body">
                       
                            <center>
                            
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                  <div class="carousel-item active">
                                  <div id="columnchart_values" style="width: 680px; height: 400px;"></div>
                                  </div>
                                  <div class="carousel-item">
                                  <div id="dongle_week_piechart" style="width: 680px; height: 400px;"></div>
                                  </div>
                                  
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Next</span>
                                </a>
                              </div>
                            
                            
                            
                            </center>

                            
                       
                            
                          </div>
                       
                         </div>
                       </div>






                    <center>
                        <h4 class="mt-3">
                            <b>Unallocated Summery</b>
                        </h4>
                    </center>
                   
                    <div class="row">

                    <div class="col">
                        <div class="card border-primary">
                          <div class="card-body">
                       
                            <center>
                              <a href="{{route('unallocated_asset')}}" class="text-primary" style="text-decoration: none;">
                              <p class="text-primary"><b>Unallocated Asset</b></p>
                       
                              <h1 class="text-primary">{{$unallocated_data['total_unallocated_asset']}}</h1>
                              <p>Total Count</p>
                            </a>
                            </center>
                       
                            <div class="card-footer bg-transparent border-primary"
                                <center>
                                    <table class="text-primary">
                                        <tr>
                                          <td style="width: 60%">{{$unallocated_data['good_unallocated_asset']}}</td>
                                          <td></td>
                                          <td><center>Good</center></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%">{{$unallocated_data['medium_unallocated_asset']}}</td>
                                            <td></td>
                                            <td><center>Medium</center></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%">{{$unallocated_data['poor_unallocated_asset']}}</td>
                                            <td></td>
                                            <td><center>Poor</center></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%">{{$unallocated_data['none_unallocated_asset']}}</td>
                                            <td></td>
                                            <td><center>None</center></td>
                                        </tr>
                                      </table>
                                </center>
                       
                       
                            </div>
                       
                            
                          </div>
                       
                         </div>
                       </div>


                       <div class="col">
                        <div class="card border-success">
                          <div class="card-body">
                       
                            <center>
                              <a href="{{route('unallocated_dongle')}}" class="text-success" style="text-decoration: none;">
                              <p class="text-success"><b>Unallocated Dongle</b></p>
                       
                              <h1 class="text-success">{{$unallocated_data['total_unallocated_dongle']}}</h1>
                              <p>Total Count</p>
                            </a>
                            </center>
                       
                            <div class="card-footer bg-transparent border-success">
                       
                              <center>
                                <table class="text-success">
                                    <tr>
                                      <td style="width: 60%">{{$unallocated_data['good_unallocated_dongle']}}</td>
                                      <td></td>
                                      <td><center>Good</center></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 60%">{{$unallocated_data['medium_unallocated_dongle']}}</td>
                                        <td></td>
                                        <td><center>Medium</center></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 60%">{{$unallocated_data['poor_unallocated_dongle']}}</td>
                                        <td></td>
                                        <td><center>Poor</center></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 60%">{{$unallocated_data['none_unallocated_dongle']}}</td>
                                        <td></td>
                                        <td><center>None</center></td>
                                    </tr>
                                  </table> 
                              </center>
                       
                       
                            </div>
                       
                            
                          </div>
                       
                         </div>
                       </div>

                          
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
