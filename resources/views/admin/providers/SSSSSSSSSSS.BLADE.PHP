@extends('admin.layouts.main')
@section('content')
@include('admin.includes.messages')

{{-- @dd(session()->get('country')->id) --}}
<!-- Body: Body -->
<div class="body d-flex py-3">
    <div class="container-xxl">
<div class="row align-items-center">
<div class="border-0 mb-4">
<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
    <h3 class="fw-bold mb-0">{{__('Orders')}} </h3>
</div>
</div>
</div> <!-- Row end  -->
<div class="row g-3 mb-3">
<div class="col-md-12">

    <form method="get" action="{{url('administration/orders')}}">
        @csrf
        <div class="row mb-5">
        <div class="form-group col-md-4">
          <label for="user-filter">{{__('Providers')}} :</label>
          <select name='provider' class="form-control" id="provider-filter">
            <option value="">{{__('All')}}</option>
            @foreach($providers as $p)
            <option value="{{$p->id}}">{{$p->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="status-filter">{{__('Status')}}:</label>
          <select name='status' class="form-control" id="status-filter">
            <option value="">All</option>
            @foreach($status as $s)
            <option value="{{$s->id}}">{{$s->title}}</option>
            @endforeach
          </select>
        </div>


        <div class="form-group col-md-2">
          <label for="status-filter">{{__('Gov')}}:</label>
          <select name='gov' class="form-control" id="gov-select">
            <option value="">{{__('All')}}</option>
            @foreach($all_gov as $g)
            <option value="{{$g->id}}">{{$g->title}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="status-filter">{{__("Zone")}}:</label>
          <select name='zone' class="form-control" id="zone-select">
            <option value="">{{__("All")}}</option>
            {{-- @foreach($all_zones as $z)
            <option value="{{$z->id}}">{{$z->name}}</option>
            @endforeach --}}
          </select>
        </div>
        <div class="form-group col-md-4 mt-3">
        <button type='submit' class="btn btn-primary  add-todo-item ml-1">{{__("search")}}</button>
        </div>
    </div>
      </form>

<div class="card">
    <div class="card-body">
        <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
            <thead>
                <tr>
                    <th>{{__('#')}}</th>
                    <th>{{__("Provider")}}</th>
                    {{-- <th>{{__('Order Number')}}</th> --}}
                    <th>{{__('Type')}}</th>

                    <th>{{__('phone')}}</th>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $index=>$r)
                <tr>

                    <td><strong>#{{$index+1}}</strong></td>
               <td>
                <a href="{{url('administration/orders/view',$r->id)}}" target="_blank">  <img class="w120 rounded img-fluid" src="{{$r->provider->profile_img}}" alt=""> </a>
                        <h6 class="mb-3 fw-bold">{{$r->provider->name}} <span class="text-muted small fw-light d-block">{{$r->order_num}}</span></h6>

                    </td>
                    <td>@if($r->order_type_id == 1)<span class="badge bg-info">{{__('Delivery')}}</span> @else<span class="badge bg-danger"> {{__("Pickup")}}@endif</span></td>

                    <td>{{$r->provider->mobile}}</td>
                    <td>{{$r->created_at}} </td>
                    <td>{{$r->status->title}}</td>
                    <td>{{$r->total_amount}}</td>

                    <td>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{url('administration/orders/view',$r->id)}}" target="_blank"><i class="icofont-eye text-success"></i></a>
                            {{-- <form action="{{ route('category.destroy', $r->id) }}" method="post" id='delform' style="display: inline-block">
                                @csrf
                                @method('delete')
                            <button type="submit" class="btn btn-outline-secondary deleterow" onclick="return confirm('Are you sure?')"><i class="icofont-ui-delete text-danger"></i></button>
                             </form> --}}

                        </div>
                    </td>
                </tr>
              @endforeach
            </tbody>
        </table>

    </div>

</div>
<div class="col-12 d-flex justify-content-center">
    {{ $rows->links('pagination::bootstrap-4') }}
</div>

</div>
</div>
</div>
</div>







@stop
