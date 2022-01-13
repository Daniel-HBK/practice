@extends('layout.app')

@section('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="center">
        <form class="row g-3 mb-4" method="post" action="{{route('customers.filter')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="col-md-3">
                    <select class="form-select form-control" name="sel_country" aria-label="Select country"  @if(\Session::has('sel_country')) disabled @endif>
                        @if(!\Session::has('sel_country'))
                            <option selected disabled>Select country</option>
                        @else
                            <option selected disabled>{{\Session::get('sel_country')}}</option>
                        @endif
                        @foreach ($customers->unique('country') as $customer)
                            <option value="{{$customer->country}} @if(\Session::get('sel_country') === $customer->country) selected @endif">{{$customer->country}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select form-control" name="sel_state" aria-label="Valid phone numbers">
                        @if(!\Session::has('sel_state'))
                            <option selected disabled>Valid phone numbers</option>
                        @endif
                        <option value="OK" @if(\Session::get('sel_state') == 'OK') selected @endif>Valid</option>
                        <option value="NOK" @if(\Session::get('sel_state') == 'NOK') selected @endif>Invalid</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='{{route('customers.reset')}}'">Reset</button>
                </div>
        </form>

        <div class="row g-3">
            <table class="table table-bordered customers">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>State</th>
                        <th>Country Code</th>
                        <th>Phone num.</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>  
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
  $(function () {
      var customersTable = $('.customers').DataTable({
          processing     : true,
          serverSide     : true,
          autoWidth      : true,
          deferRender    : true,
          paging         : true,
          lengthMenu     : [[5,10,15,25,50,100,200], [5,10,15,25,50,100,200]],
          lengthChange   : true,
          pageLength     : 5,
          pagingTypeSince: 'numbers',
          ajax           : "{{ route('customers.index') }}",
          columns: [
              {data: 'country', name: 'country'},
              {data: 'state', name: 'state'},
              {data: 'country_code', name: 'country_code'},
              {data: 'phone_num', name: 'phone_num'},
          ]
        });
    });
  </script>
@endsection