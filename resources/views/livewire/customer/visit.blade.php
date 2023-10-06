<div class="row">
    
<!-- Customer Check-in Timeline -->

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title mb-2">Recent Checkins</h4>
    </div>
    <div class="card-body">
      @if (count($checkins) > 0)
        <ul class="timeline">
          @php
            $iteration = 0;
          @endphp
          @foreach ($checkins as $checkin)
            <li class="timeline-item">
              <span class="timeline-point
                @if ($iteration === 0)
                  timeline-point-info
                @else
                  timeline-point-warning
                @endif
                timeline-point-indicator"
              ></span>
              @php
                $iteration++;
              @endphp
              <div class="timeline-event">
                @if (!is_null($checkin->stop_time))
                @php
                    $startTime = new DateTime($checkin->start_time);
                    $stopTime = new DateTime($checkin->stop_time);
                    $interval = $startTime->diff($stopTime);

                    $duration = '';

                    if ($interval->h > 0) {
                        $duration .= $interval->h . 'hrs';
                    } elseif ($interval->i > 0) {
                        $duration .= $interval->i . 'mins';
                    } elseif ($interval->s > 0) {
                        $duration .= $interval->s . 'secs';
                    }
                @endphp


                  <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                    <h6>{{ $checkin->code }}</h6>
                    <span class="timeline-event-time"> {{ $duration }}</span>
                  </div>
                  <p>Started at {{ $checkin->start_time }} to {{ $checkin->stop_time }} </p>
                @else
                  <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                    <h6>{{ $checkin->code }}</h6>
                    <span class="timeline-event-time"> calculating ... </span>
                  </div>
                  <p>Started at {{ $checkin->start_time }}</p>
                @endif
                <div class="media align-items-center">
                  <div class="avatar">
                    <img src="{{asset('images/no-image.png')}}" alt="avatar" height="38" width="38" />
                  </div>
                  <div class="media-body ml-50">
                    <h6 class="mb-0">{{ $checkin->user?->name }}</h6>
                    <span>  {{ $checkin->ip }} </span>
                  </div>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <div class="table-responsive">
          <table class="table table-striped table-bordered">

            <tbody>
              <tr>
                <td colspan="2" class="text-center">No Checkin found</td>

              </tr>
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
<!-- /Customer Check-in Timeline -->


    </div>