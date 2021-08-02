@extends('layouts.app')

@section('script:before')
  <script>
    (function(w, d, s, g, js, fjs) {
      g = w.gapi || (w.gapi = {});
      g.analytics = {
        q: [],
        ready: function(cb) {
          this.q.push(cb)
        }
      };
      js = d.createElement(s);
      fjs = d.getElementsByTagName(s)[0];
      js.src = 'https://apis.google.com/js/platform.js';
      fjs.parentNode.insertBefore(js, fjs);
      js.onload = function() {
        g.load('analytics')
      };
    }(window, document, 'script'));
  </script>
@endsection
@section('script:after')

  @php
  $client = new \Google_Client();
  $client->setApplicationName('Analytics Reporting');
  $client->setAuthConfig([
      'type' => env('GC_TYPE') ?? '',
      'project_id' => env('GC_PROJECT_ID') ?? '',
      'private_key_id' => env('GC_PRIVATE_KEY_ID') ?? '',
      'private_key' => env('GC_PRIVATE_KEY') ?? '',
      'client_email' => env('GC_CLIENT_EMAIL') ?? '',
      'client_id' => env('GC_CLIENT_ID') ?? '',
      'auth_uri' => env('GC_AUTH_URI') ?? '',
      'token_uri' => env('GC_TOKEN_URI') ?? '',
      'auth_provider_x509_cert_url' => env('GC_AUTH_PROVIDER_X509_CERT_URL') ?? '',
      'client_x509_cert_url' => env('GC_CLIENT_X509_CERT_URL') ?? '',
  ]);
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
          'ids': "ga:{{ env('ANALYTICS_VIEW_ID') }}",
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
          ids: "ga:{{ env('ANALYTICS_VIEW_ID') }}",
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
          'ids': "ga:{{ env('ANALYTICS_VIEW_ID') }}",
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


  <div class="container-fluid">
    <div class="card card-shadow mb-3">
      <div class="card-header">
        TRAFFIC VIEWS <br>
        <small>Last 30 days</small>
      </div>
      <div class="card-body p-0">
        <div id="timeline-traffic-view"></div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 d-flex">
        <div class="card card-shadow w-100">
          <div class="card-header">
            TOP COUNTRIES BY SESSIONS <br>
            <small>Last 30 days</small>
          </div>
          <div class="card-block p-0">
            <div id="chart-1-container"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6 d-flex">
        <div class="card card-shadow w-100">
          <div class="card-header">
            TOP BROWSERS BY SESSIONS <br>
            <small>Last 30 days</small>
          </div>
          <div class="card-block">
            <div id="chart-2-container"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
