@extends('admin.layouts.main')
@section('content')
@include('admin.includes.messages')


<!-- Body: Body -->
<div class="body d-flex py-3">
    <div class="container-xxl">
<div class="row align-items-center">
<div class="border-0 mb-4">
<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
    <h3 class="fw-bold mb-0">{{__('Contacts')}} </h3>
    {{-- <a href="{{route('category.create')}}" class="btn btn-primary py-2 px-5 btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i> Add Categories</a> --}}
</div>
</div>
</div> <!-- Row end  -->
<div class="row g-3 mb-3">
<div class="col-md-12">
<div class="card">
    <div class="card-body">
        <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
            <thead>
                <tr>
                    <th>{{__('#')}}</th>
                    <th>{{__("Name")}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('mobile')}}</th>
                    <th>{{__('type')}}</th>
                    <th>{{__('Message')}}</th>
                    <th>{{__('Created At')}}</th>
                    <th>{{__('Action')}}</th>

                    {{-- <th>{{__('Action')}}</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $index=>$r)
                <tr>

                    <td><strong>#{{$index+1}}</strong></td>

                    <td>{{$r->name}}</td>
                    <td>{{$r->email}}</td>
                    <td>{{$r->mobile}}</td>
                    <td>{{$r->type}}</td>
                    <td>{!! $r->message !!}</td>
                    <td>{!! $r->created_at !!}</td>



                     <td>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{route('contacts.show',$r->id)}}" class="btn btn-outline-secondary"><i class="icofont-eye text-success"></i></a>
                            <form action="{{ route('contacts.destroy', $r->id) }}" method="post" id='delform' style="display: inline-block">
                                @csrf
                                @method('delete')
                            <button type="submit" class="btn btn-outline-secondary deleterow" onclick="return confirm('Are you sure?')"><i class="icofont-ui-delete text-danger"></i></button>
                             </form>

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
