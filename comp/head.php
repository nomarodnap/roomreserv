<link rel="stylesheet" href="./assets/lib/jquery.fancybox.css" type="text/css" media="screen" />
<!-- fullcalendar -->
<link href='./assets/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='./assets/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<!-- jQuery -->
<script src="./assets/lib/jquery/dist/jquery.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src='./assets/lib/moment.min.js'></script>
<script src='./assets/fullcalendar/fullcalendar.min.js'></script>
<script src='./assets/lib/lang/th.js'></script>
<script src="./assets/lib/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            eventLimit: true,
            defaultDate: new Date(),
            timezone: 'Asia/Bangkok',
            events: {
                url: './dataEvents.php',
            },
            loading: function(bool) {
                $('#loading').toggle(bool);
            },

            eventClick: function(event) {
                if (event.url) {
                    $.fancybox({
                        'href': event.url,
                        'type': 'iframe',
                        'autoScale': false,
                        'openEffect': 'elastic',
                        'openSpeed': 'fast',
                        'closeEffect': 'elastic',
                        'closeSpeed': 'fast',
                        'closeBtn': true,
                        onClosed: function() {
                            parent.location.reload(true);
                        },
                        helpers: {
                            thumbs: {
                                width: 50,
                                height: 50
                            },

                            overlay: {
                                css: {
                                    'background': 'rgba(49, 176, 213, 0.7)'
                                }
                            }
                        }
                    });
                    return false;
                }
            },
        });
    });
</script>