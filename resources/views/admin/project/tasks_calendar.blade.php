<style>
    .username {
        font-size: 12px;
        padding-block: 3px;
    }

    .tooltip {
        position: absolute;
        display: none;
        background-color: rgba(0, 0, 0, 0.7);
        color: #FFF;
        padding: 5px;
        border-radius: 3px;
        font-size: 12px;
    }
</style>

@php
    $events = $tasks->map(function ($event) {
        $start = $event->date;
        $color = '#FF5733';

        switch ($event->status) {
            case 'pending':
                $color = '#4e73df';
                break;
            case 'canceled':
                $color = '#e74a3b';
                break;
            case 'completed':
                $color = '#32a37a';
                break;
        }

        return [
            'id' => $event->id,
            'title' => $event->detail,
            'color' => $color,
            'start' => $start,
        ];
    });
@endphp

{{-- Tasks Calender --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script>
    var events = @json($events);

    $(document).ready(function() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            // defaultDate: '2023-08-01',
            navLinks: true,
            editable: true,
            eventLimit: true,
            timeFormat: 'h:mm A',
            events: events,
            eventTextColor: '#FFFFFF',
            eventRender: function(event, element) {
                element.css('font-size', '14px');
            },
            handleWindowResize: true,
            aspectRatio: 1.35,
            theme: 'bootstrap4',
            eventMouseover: function(calEvent, jsEvent) {
                var tooltip = '<div class="tooltip">' + calEvent.title + '</div>';
                $('body').append(tooltip);
                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $('.tooltip').fadeIn(100);
                    $('.tooltip').fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $('.tooltip').css('top', e.pageY + 10);
                    $('.tooltip').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.tooltip').remove();
            }
        });
    });
</script>
