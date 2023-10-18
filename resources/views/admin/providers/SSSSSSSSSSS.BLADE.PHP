@extends('admin.layouts.main')

@section('content')
@include('admin.includes.messages')

<!-- Body: Body -->
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <form class="todo-modal needs-validation" id='notify_form' method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">{{__('Send')}} {{__('Notification')}}</h3>
                        <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase">{{__('Send')}}</button>
                    </div>
                </form>
            </div>
        </div> <!-- Row end  -->
        <div class="row g-3 mb-3">
            <div class="col-xl-12 col-lg-12">
                <div class="card mb-3">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold">{{__('Notification information')}}</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">{{__('Title')}} {{__('En')}}</label>
                                    <input type="text" name='title' value="{{old('title')}}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('Title')}} {{__('Ar')}}</label>
                                    <input type="text" name='title_ar' value="{{old('title_ar')}}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('Notify')}} {{__("En")}}</label>
                                    <textarea class="form-control" name="message" required>{{old('message')}}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('Notify')}} {{__("Ar")}}</label>
                                    <textarea class="form-control" name="message_ar" required>{{old('message_ar')}}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('TO')}}</label>
                                    <select class="js-example-basic-single form-control" id="type" name="type" required>
                                        <option hidden>{{__('Choose Users Type')}}</option>
                                        <option value="all providers">{{__('All Providers')}}</option>
                                        <option value="all customers">{{__('All Customers')}}</option>
                                        <option value="provider">{{__('Select Provider')}}</option>
                                        <option value="customer">{{__('Select Customer')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('Link')}}</label>
                                    <input type="text" name='link' class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" id='providers_list' style="display:none;">
                        <div class="card">
                            <table class="table table-hover align-middle mb-0" style="width: 100%;">
                                @foreach($providers as $index => $g)
                                <tr id='gov-select{{$index}}' data-id='{{$g->id}}'>
                                    <td>{{$g->name}}</td>
                                    <td><input class="form-check-input" type="checkbox" id="" name="providers_ids[]" value="{{$g->id}}"></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 " id='customers_list' style="display:none;">
                        <div class="card">
                            <table class="table table-hover align-middle mb-0" style="width: 100%;">
                                @foreach($customers as $index => $g)
                                <tr id='gov-select{{$index}}' data-id='{{$g->id}}'>
                                    <td>{{$g->name}}</td>
                                    <td><input class="form-check-input" type="checkbox" id="" name="customers_ids[]" value="{{$g->id}}"></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row end  -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#providers_list').hide();
        $('#customers_list').hide();
        $('#type').on('change', function(e) {
            var type = e.target.value;
            if (type == 'all providers') {
                $('#providers_list').hide();
                $('#customers_list').hide();
                $('#notify_form').attr('action', '{{url("/administration/notifications/all-provider")}}');
            } else if (type == 'all customers') {
                $('#providers_list').hide();
                $('#customers_list').hide();
                $('#notify_form').attr('action', '{{url("/administration/notifications/all-customer")}}');
            } else if (type == 'provider') {
                $('#providers_list').show();
                $('#customers_list').hide();
                $('#notify_form').attr('action', '{{url("/administration/notifications/provider")}}');
            } else if (type == 'customer') {
                $('#customers_list').show();
                $('#providers_list').hide();
                $('#notify_form').attr('action', '{{url("/administration/notifications/customer")}}');
            }
        });
    });
</script>
<script>
    $('#row1').hide();
    $('#row2').hide();
    var c = 0;
    $('#morePrices').click(function() {
        c += 1;
        if (c <= 2) {
            $('#row' + c).show();
        }
    });
</script>
<script>
    var counter = 0

    function add_more_field() {
        counter += 3;
        html = '<div class="row" id="row' + counter + '">\
                <div class="col-3">\
                    <label>{{__("Title")}}</label>\
                    <input type="text" class="form-control" name="prices[' + counter + '][title]" placeholder="{{__("Title")}}">\
                </div>\
                <div class="col-3">\
                    <label>{{__("Title")}} {{__("Ar")}}</label>\
                    <input type="text" class="form-control" name="prices[' + counter + '][title_ar]" placeholder="{{__("Title")}} {{__("Ar")}}">\
                </div>\
                <div class="col-3">\
                    <label>{{__("Price")}}</label>\
                    <input type="text" class="form-control" name="prices[' + counter + '][price]" placeholder="{{__("L.E.")}}">\
                </div>\
</div>';
        $('#price_field').append(html);
    }
</script>

{{-- select 2 --}}
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
{{-- end select 2 --}}

@endsection
