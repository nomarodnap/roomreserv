<?php
session_start();
$pagename = 'หน้าแรก';
require 'header.php';
require 'Sidebar.php';
?>
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
        url: './dataEvents_2.php',
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
<main id="main" class="main">
  <div class="pagetitle d-none">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="card">
        <div class="card-body">
          <h3 class="card-body text-center" style="color:#0C356A;font-weight: bold;">จองห้องอบรม ศทส.</h3>
          <div id='calendar'></div>
        </div>
      </div>
    </div>
    </div>
  </section>
</main><!-- End #main -->

<?php require 'footer.php' ?>

</html>