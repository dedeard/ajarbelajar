@extends('layouts.app')

@section('script:before')
<script>
  (function(w,d,s,g,js,fjs){
    g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
    js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
    js.src='https://apis.google.com/js/platform.js';
    fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
  }(window,document,'script'));
</script>
@endsection
@section('script:after')

@php
$client = new \Google_Client();
$client->setApplicationName("Analytics Reporting");
$client->setAuthConfig(config('analytics.service_account_credentials_json'));
$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
$client->fetchAccessTokenWithAssertion();
$token = $client->getAccessToken()['access_token'];
@endphp

<script>
  gapi.analytics.ready(function() {
    gapi.analytics.auth.authorize({
      'serverAuth': {
        'access_token': "{{ $token }}"
      }
    });


    var char1 = new gapi.analytics.googleCharts.DataChart({
      reportType: 'ga',
      query: {
        'ids': "ga:{{ config('analytics.view_id') }}",
        'dimensions': 'ga:date',
        'metrics': 'ga:pageViews,ga:uniquePageViews',
        'start-date': '30daysAgo',
        'end-date': 'today',
      },
      chart: {
        type: 'LINE',
        container: 'timeline-traffic-view',
        options: {
          width: '100%'
        }
      }
    })
    char1.execute()

    var char2 = new gapi.analytics.googleCharts.DataChart({
      query: {
        ids: "ga:{{ config('analytics.view_id') }}",
        metrics: 'ga:sessions',
        dimensions: 'ga:country',
        'start-date': '30daysAgo',
        'end-date': 'today',
        'max-results': 6,
        sort: '-ga:sessions'
      },
      chart: {
        container: 'chart-1-container',
        type: 'COLUMN',
        options: {
          width: '100%'
        }
      }
    })
    char2.execute()

    var char3 = new gapi.analytics.googleCharts.DataChart({
      query: {
        'ids': "ga:{{ config('analytics.view_id') }}",
        'dimensions': 'ga:browser',
        'metrics': 'ga:sessions',
        'sort': '-ga:sessions',
        'max-results': '6'
      },
      chart: {
        type: 'TABLE',
        container: 'chart-2-container',
        options: {
          width: '100%'
        }
      }
    })
    char3.execute()

  });
  </script>
@endsection


@section('content')
<div class="dashboard-header mb-3 mt--10" style="background-image: url({{ asset('img/background/snow.jpg') }})">
  <div class="text-center blue-grey-800 py-30">
    <div class="font-size-40 m-0 blue-grey-800 text-capitalize">Halo, {{ Auth::user()->name }}</div>
    <a href="{{ route('profile.logout') }}" class="btn btn-danger px-30">LOG OUT</a>
  </div>
</div>
<div class="container-fluid">
  <div class="card card-shadow mb-3">
    <div class="card-block pb-0">
      <div class="blue-grey-700">TRAFFIC VIEWS</div>
      <span class="blue-grey-400">Last 30 days</span>
      <div id="timeline-traffic-view"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 d-flex">
      <div class="card card-shadow" style="width: 100%;">
        <div class="card-block pb-0">
          <div class="blue-grey-700">TOP COUNTRIES BY SESSIONS</div>
          <span class="blue-grey-400">Last 30 days</span>
          <div id="chart-1-container"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6 d-flex">
      <div class="card card-shadow" style="width: 100%;">
        <div class="card-block">
          <div class="blue-grey-700">TOP BROWSERS BY SESSIONS</div>
          <span class="blue-grey-400">Last 30 days</span>
          <div id="chart-2-container"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
