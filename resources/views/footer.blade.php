    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script type="text/javascript">
      $(function() {
          var start = end = moment();

          function cb(start, end) {
              $('.reportrange').html(end.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          }
          
          $('.reportrange').daterangepicker({
              startDate: start,
              endDate: end,
              alwaysShowCalendars: true,
              ranges: {
                  'Today': [moment(), moment()],
                  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month': [moment().startOf('month'), moment().endOf('month')],
                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              }
          }, cb);
          cb(start, end);
          
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawTripsChart);
          google.charts.setOnLoadCallback(drawSalesChart);

      });

      function drawTripsChart(trips_data) {
          var data = google.visualization.arrayToDataTable(trips_data);
          var options = {
              is3D: false,
              pieHole: 0.4,
          };
          var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
          chart.draw(data, options);
      }

      function drawSalesChart(sales_data) {
        var data = google.visualization.arrayToDataTable(sales_data);

        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('linechart'));

        chart.draw(data, options);
      }

      function get_trips() {
          var filter_date = $('#filter_date').val();

          var dates = filter_date.split(" - ");
          var start = dates[0];
          var end = dates[1];
          
          var dataString = {
              "_token": "{{ csrf_token() }}",
              "start_date": start,
              "end_date": end
          };

          $.ajax({
              type: "POST",
              url : "{{url('trips_ajax')}}",
              data : dataString,
              success : function(data){
                  if(data.response) {
                      var trips = data.response;
                      var data2 = [ ['Status', 'Count'] ];
                      trips.forEach((trip, i) => {
                          var trip_status = '';
                          switch(trip.trip_status) {
                              case 1:
                                  trip_status = 'Started';
                              break;
                              case 2:
                                  trip_status = 'Completed';
                              break;
                              case 3:
                                  trip_status = 'Rejected';
                              break;
                          }

                          data2[i+1] = [
                              trip_status, trip.status_count
                          ];
                      })
                      drawTripsChart(data2);
                  }
              }
          });
      }

      function get_sales() {
          var filter_by_type = $('#filter_by_type').val();
          if(filter_by_type) {
              var dataString = {
                  "_token": "{{ csrf_token() }}",
                  "filter_by": filter_by_type
              };

              $.ajax({
                  type: "POST",
                  url : "{{url('sales_ajax')}}",
                  data : dataString,
                  success : function(data){
                      if(data.response) {
                          var trips = data.response;
                          var data2 = [ ['Month', 'Sales'] ];
                          trips.forEach((trip, i) => {
                              data2[i+1] = [
                                  trip.month_string, trip.sales
                              ];
                          })
                          drawSalesChart(data2);
                      }
                  }
              });
          }
      }
    </script>
  </body>
</html>