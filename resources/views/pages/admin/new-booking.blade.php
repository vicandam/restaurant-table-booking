@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">New Booking Request</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Manage Booking Request</li>
        </ol>

        @include('pages.modals.update-status')

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Booking request</div>
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
                                    <div class="col-md-6">
                                        <button type="button" @click="setId(booking)" data-toggle="modal" data-target="#statusModal" class="btn btn-outline-primary"><svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
                selected: 'pending',
                tableId: '',
                bookingId: '',
                booking: {
                    date: '',
                    time: ''
                },
                tables: [],
                bookings: [],
                bookingSelected: []
            },

            mounted() {
                this.fetchBookings();
            },
            methods: {
                setId: function(booking) {
                    this.bookingId = booking.id;
                    this.tableId   = booking.table_id;

                    this.bookingSelected = booking;
                },
                updateSelection: function () {
                    if(this.selected == 'rescheduled') {
                        this.booking.date = this.bookingSelected.date;
                        $('#timepicker1').val(this.bookingSelected.time);

                    } else {
                        $('#date').val('');
                        $('#timepicker1').val('');
                    }
                },

                fetchBookings: function () {
                    let _this = this;

                    axios.get('api/pending-booking').then((response) => {
                        let data = response.data.booking;
                        _this.bookings = data;
                        console.log('booking: ', data);
                    })
                },

                updateStatus: function () {
                    let _this = this;

                    let attributes = {
                        status: this.selected,
                        tableId: this.tableId,
                        date: $('#date').val(),
                        time: $('#timepicker1').val()
                    }
                    console.log("Attrbutes: ", attributes);

                    axios.patch('api/booking/' + this.bookingId, attributes).then((response) => {
                        let data = response.data.booking;
                        this.fetchBookings();

                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Booking accepted.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })

                    $('#statusModal').modal('hide');
                }
            }
        })
    </script>
@endpush
