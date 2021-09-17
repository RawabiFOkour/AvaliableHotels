@extends('hotels.master')


@section('body')

    <div class=" container">
        <h3> All Available Hotels</h3>

        <br>
        <br>

        <div class="form-group row ">
            <div class="col col-lg-3 mt-5">
                <label>Select Provider</label>
                <select class="form-control " id="provider">
                    <option value="HotelsForAllProviders">Hotels for all providers</option>
                    @foreach($providers as $provider)
                        <option value="{{$provider['name']}}" @if($provider['name'] == 'BestHotels') selected @endif >{{$provider['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <br>
        <br>

        <div class="align-items-center justify-content-center w-50">
            <table id="example" class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Hotel</th>
                    <th>HotelRate</th>
                    <th>HotelFare</th>
                    <th>RoomAmenities</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {

            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                paginate: false,
                ajax: {
                    url: "{{route('hotels.getAvailableHotels')}}",
                    type: "GET",
                    data: function (data) {

                        var provider = $('#provider').val();

                        data.fromDate = new Date().toISOString();
                        data.toDate = new Date().toISOString();
                        data.city = 'Amm';
                        data.numberOfAdults = 3;
                        data.provider = provider;

                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'hotelName'},
                    {data: 'provider'},
                    {data: 'fare'},
                    {data: 'amenities'},
                ],
            });

            $('#provider').on('keyup change clear', function () {
                var r = $('#example thead tr').each(function () {
                    var provider = $('#provider').val();
                    console.log(provider);
                    provider == "BestHotels" || provider == "CrazyHotels" ? $(this).html('<th>ID</th> <th>Hotel</th> <th>HotelRate</th> <th>HotelFare</th> <th>RoomAmenities</th>') :
                       $(this).html('<th>ID</th>\n' +
                            '                <th>HotelName</th>\n' +
                            '                <th>Provider</th>\n' +
                            '                <th>Fare</th>\n' +
                            '                <th>Amenities</th>')

                });

                $('#example thead').append(r);

                table.draw();
            });

        });

    </script>
@endsection
