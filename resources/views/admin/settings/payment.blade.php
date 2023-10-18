@extends('admin.layouts.main')
@section('content')
@include('admin.includes.messages')



     <!-- BEGIN: Content -->
     <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ __('Payment Settings') }}
            </h2>
        </div>
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">



                    <div class="font-medium text-center lg:text-left lg:mt-3">{{__('Add Payment')}}</div>
                    {{-- <div class="flex flex-col justify-center items-center lg:items-start mt-4"> --}}
                        <form method="post" action="{{url('admin/settings/payment/store')}}">
                            @csrf
                            <div class="mt-3">

                                {{-- <label class="form-label">{{__('Fees Percentage')}}</label> --}}
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input-group">
                                    <input type="text"name='title' value="{{old('title')}}" placeholder="{{__('Title')}}" aria-describedby="input-group-3" class="form-control" required>
                                    </div>
                                    <div class="input-group">
                                        <input type="text"name='title_ar' value="{{old('title_ar')}}" placeholder="{{__('Title AR')}}" aria-describedby="input-group-3" class="form-control" required>
                                        </div>
                                    <div class="input-group">
                                            @foreach ($countries as $c)
                                            <input class="form-check-input" value="{{$c->id}}" name='country[]' type="checkbox">
                                            <label class="form-check-label" for="Eaten-switch2">{{$c->name}}</label>
                                            @endforeach
                                     </div>

                                     <div class="input-group">
                                         <button class="btn btn-primary" >save</button>
                                     </div>
                                </div>
                                </div>
                            </form>

                    {{-- </div> --}}
                </div>





                </div>






            </div>
        <!-- BEGIN: for one provider -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">

                    <div class="card-header mb-5">
                        <h4 class="card-title mb-0">Payments</h4>
                      </div>



                      <table id="myDataTable"class="table table-report -mt-2" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>{{__('#')}}</th>
                                <th>{{__('NAME')}}</th>
                                <th>{{__('NAME Ar')}}</th>
                                <th>{{__('Status')}}</th>
                                <th class="text-lg">{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $index=>$r)
                            <tr>

                                <td><strong>#{{$index+1}}</strong></td>
                                <td>{{$r->title}}</td>
                                <td>{{$r->title_ar}}</td>
                                <td>@if($r->is_active == 1)<span class="">{{__('Published')}}</span> @else<span class=""> {{__("Unpublished")}}@endif</span></td>

                                <td>
                                    <form id="myForm{{$r->id}}" method="get" action="{{ url('admin/settings/payment/active',[$r->id]) }}">
                                        @csrf
                                        <div class="form-check form-switch">
                                          <input class="form-check-input" name='is_active' @if($r->is_active == 1) checked @endif type="checkbox" id="toggleSwitch{{$r->id}}" name="mySwitch" value="1">
                                          <label class="form-check-label" for="toggleSwitch">{{__('OFF')}} / {{__('ON')}} </label>
                                        </div>

                                      </form>
                                      <script>
                                        $(document).ready(function() {
                                          $('#toggleSwitch{{$r->id}}').change(function() {
                                            $('#myForm{{$r->id}}').submit();
                                          });
                                        });
                                      </script>

                                </td>
                                <td>
                                    <form action="{{ route('payment.destroy', $r->id) }}" method="post" id='delform' style="display: inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-outline-secondary deleterow" onclick="return confirm('Are you sure?')"><i data-lucide="trash-2" class="w-4 h-4 mr-1"></i></button>
                                    </form>
                                </td>

                            </tr>


                          @endforeach
                        </tbody>
                    </table>
                    <div class="col-12 d-flex justify-content-center">
                        {{ $rows->links('pagination::bootstrap-4') }}
                    </div>







                </div>





                </div>







    </div>











@stop



