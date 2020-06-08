@extends('layouts.master')

@push('css')
    <link type="text/css" href="{{ asset('bootstrap-timepicker/css/timepicker.less') }}" />
@endpush

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Book Your Table</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">My booking</li>
        </ol>
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><i class="fas fa-table mr-1"></i>My booking list</div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#bookModal">New Booking</button>
                    </div>
                </div>
            </div>

            @include('pages.modals.add-booking')
            @include('pages.modals.accept-decline-reschedule')

            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Table Number</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Date</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Time</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Status</div>
                        </div>
                    </div>
                </div>
                <div class="row" v-for="booking in bookings">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ booking.id }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ booking.date }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ booking.time }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">
                                <div class="row">
                                    <div class="col-md-6">@{{ booking.status }}</div>
                                    <div class="col-md-6" v-if="booking.status == 'rescheduled'">
                                        <button type="button" @click="setSelection(booking)" data-toggle="modal" data-target="#acceptDeclineModal" class="btn btn-outline-primary">
                                            <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                              <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                              <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                            </svg>
                                        </button>
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
@push('scripts')
    <script type="text/javascript" src="{{ asset('bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#table').dataTable();

            var $disabledResults = $(".js-example-disabled-results");
            $disabledResults.select2();

            $('#timepicker1').timepicker();

            var date_input=$('input[name="date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
                format: 'mm/dd/yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            };
            date_input.datepicker(options);
        })
    </script>

    <script>
        new Vue({
            el: '#app',
            data: {
                selected: 'accepted',
                booking: {
                    capacity:'',
                    date: '',
                    time: ''
                },
                tables: [],
                bookings: []
            },

            mounted() {

                this.fetchBookings();
            },
            created() {
                this.fetchTables();
            },
            methods: {
                fetchBookings: function () {
                    let _this = this;

                    axios.get('api/booking').then((response) => {
                        let data = response.data.booking;
                        _this.bookings = data;
                        console.log('booking: ', data);
                    })
                },

                fetchTables: function () {
                    let _this = this;

                    axios.get('api/table').then((response) => {
                        let data = response.data.table;

                        _this.tables = data;

                        console.log('data: ', data)
                    })
                },
                setSelection: function(booking) {
                    this.bookingId = booking.id;
                    this.tableId   = booking.table_id;
                },
                updateBooking: function () {
                    let _this = this;

                    let attributes = {
                        status: this.selected,
                        tableId: this.tableId
                    }

                    axios.patch('api/booking/' + this.bookingId, attributes).then(() => {
                        this.fetchBookings();

                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Booking accepted.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })

                    $('#acceptDeclineModal').modal('hide');
                },
                saveBooking: function () {
                    let _this = this;

                    let attributes = {
                        capacity: this.booking.capacity,
                        date: $('#date').val(),
                        time: $('#timepicker1').val(),
                        table: $('#select2').val()
                    }

                    axios.post('api/booking', attributes).then((response) => {
                        let data = response.data.booking;
                        this.fetchBookings();

                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Booking successfully created.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })

                    $('#bookModal').modal('hide');
                }
            }
        })
    </script>
@endpush
