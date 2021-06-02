    @include('header')
    
    <div class="container-fluid">
      <div class="row">
        <main role="main" class="col-md-12 col-lg-12 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Reports Dashboard</h1>
            </div>

            <div class="row col-md-12">
                <div class="row">
                    <div class="col-md-6" style="border-right: 1px solid #dee2e6"> 
                        <h5 class="">Trips Report</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="" class="form-control reportrange" value="" data-date-format="MMMM D, YYYY" id="filter_date" onchange="get_trips()">
                            </div>
                        </div>
                        <div id="donutchart" style="width: 600px; height: 400px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="">Sales Report</h5>
                                <select class="form-control" id="filter_by_type" onchange="get_sales()">
                                    <option value=""> --- Select date filter type ---  </option>
                                    <option value="trip_date"> Travel Date </option>
                                    <option value="booking_date"> Booking Date </option>
                                </select>
                            </div>
                        </div>
                        <div id="linechart" style="width: 600px; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </main>
      </div>
    </div>
    
    @include('footer')

