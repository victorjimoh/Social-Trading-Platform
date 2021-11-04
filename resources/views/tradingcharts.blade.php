@extends('layouts.dashboard')

@section('contents')
<main role = "main" class = "col-md-9 ml-sm-auto col-lg-12 px-md-4 main-body">
<div id = "chart-container"> 

</div>
</main>

@endsection
@section('test-script')
<script>
var chart;
Promise.all([
  fetch(
    
    "https://s3.eu-central-1.amazonaws.com/fusion.store/ft/data/candlestick-chart-data.json"
  ),
  fetch(
    "https://s3.eu-central-1.amazonaws.com/fusion.store/ft/schema/candlestick-chart-schema.json"
  )
]).then(function(res) {
  Promise.all([
    res[0].json(),
    res[1].json()
  ]).then(function(res) {
    const data = res[0];
    const schema = res[1];

    var fusionTable = new FusionCharts.DataStore().createDataTable(data, schema);

    chart = new FusionCharts({
      type: 'timeseries',
      renderAt: 'chart-container',
      width: "90%",
      height: 600,
      dataSource: {
        data: fusionTable,
        chart: {
          "theme": "fusion"
        },
        caption: {
          "text": "RatioChart"
        },
        yAxis: [{
          "plot": {
            "value": {
              "open": "Open",
              "high": "High",
              "low": "Low",
              "close": "Close"
            },
            "type": "candlestick"
          },
          "format": {
            "prefix": ""
          },
          "title": "Ratio long/short",
          "orientation": "right"
        }]
      }
    }).render();

  });

});

</script>
@endsection

