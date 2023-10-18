@extends('admin.layouts.main')
@section('content')
@include('admin.includes.messages')
    @php
    //   dd($row->reviews[0]->customer );
    @endphp







     <!-- BEGIN: Content -->
     <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ __('Wallet Settings') }}
            </h2>
        </div>
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="intro-y col-span-12 lg:col-span-8">
                        <div class="grid grid-cols-12 gap-5 mt-5">
                    @foreach ($countries as $item)


                    <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box bg-primary p-5 cursor-pointer zoom-in">
                        <div class="font-medium text-base text-white">{{$item->name}}</div>
                        <div class="text-white text-opacity-80 dark:text-slate-500">{{$item->fees_percentage}}  %</div>
                    </div>

                    @endforeach
                </div>
                </div>


                    <div class="font-medium text-center lg:text-left lg:mt-3">{{__('Fees percentage')}}</div>
                    {{-- <div class="flex flex-col justify-center items-center lg:items-start mt-4"> --}}
                        <form method="post" action="{{url('admin/settings/wallet/updateFees')}}">
                            @csrf
                            <div class="mt-3">

                                {{-- <label class="form-label">{{__('Fees Percentage')}}</label> --}}
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input-group">
                                    <input type="text" name='fees_percentage' value="{{old('fees_percentage')}}" placeholder="{{__('Fees Percentage')}}" aria-describedby="input-group-3" class="form-control" required>
                                    </div>
                                    <div class="input-group">
                                        <select class="select2 form-control" aria-describedby="input-group-5"   name="country_id">
                                            @foreach ($countries as $item)
                                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
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
                        <h4 class="card-title mb-0">Fees percentage for One Provider</h4>
                      </div>



                    {{-- <div class="font-medium text-center lg:text-left lg:mt-3">{{__('Fees percentage')}}</div> --}}
                    {{-- <div class="flex flex-col justify-center items-center lg:items-start mt-4"> --}}
                        <form method="post" action="{{url('admin/settings/wallet/updateFees')}}">
                            @csrf

                            <div class="mt-3">

                                {{-- <label class="form-label">{{__('Fees Percentage')}}</label> --}}
                                <div class="sm:grid grid-cols-3 gap-2">
                                    <div class="input-group">
                                    <input type="text" name='fees_percentage' value="{{old('fees_percentage')}}" placeholder="{{__('Fees Percentage')}}" aria-describedby="input-group-3" class="form-control" required>
                                    </div>
                                    <div class="input-group">
                                        <select class="select2 form-control" aria-describedby="input-group-5"   name="provider_id">
                                            @foreach ($providers as $item)
                                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                     </div>

                                     <div class="input-group">
                                         <button class="btn btn-primary" >save</button>
                                     </div>
                                </div>
                                </div>
                            </form>

                            <div class="intro-y col-span-12 lg:col-span-8">
                                <div class="grid grid-cols-12 gap-5 mt-5">
                                    @foreach ($provider_with_special_fees as $item)


                            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box bg-warning p-5 cursor-pointer zoom-in">
                                <div class="font-medium text-base text-white">{{$item->name}}</div>
                                <div class="text-white text-opacity-80 dark:text-slate-500">{{$item->fees_percentage}}  %</div>
                            </div>

                            @endforeach
                        </div>
                        </div>


                </div>





                </div>







    </div>


    <!-- BEGIN: for one provider -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">

                <div class="card-header mb-5">
                    <h4 class="card-title mb-0">Add Wallet limit For Providers</h4>
                  </div>



                  <div class="intro-y col-span-12 lg:col-span-8">
                    <div class="grid grid-cols-12 gap-5 mt-5">
                @foreach ($countries as $item)


                <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box bg-primary p-5 cursor-pointer zoom-in">
                    <div class="font-medium text-base text-white">{{$item->name}}</div>
                    <span class="text-white text-opacity-80 dark:text-slate-500">{{$item->wallet_limit}} {{$item->currency->iso3}}</span>
                </div>

                @endforeach
            </div>
            </div>



                {{-- <div class="flex flex-col justify-center items-center lg:items-start mt-4"> --}}
                    <form method="post" action="{{url('admin/settings/wallet/updateLimit')}}">
                        @csrf

                        <div class="mt-3">

                            {{-- <label class="form-label">{{__('Fees Percentage')}}</label> --}}
                            <div class="sm:grid grid-cols-3 gap-2">
                                <div class="input-group">
                                <input type="text" name='wallet_limit' value="{{old('wallet_limit')}}" placeholder="{{__('wallet limit')}}" aria-describedby="input-group-3" class="form-control" required>
                                </div>
                                <div class="input-group">
                                    <select class="select2 form-control" aria-describedby="input-group-5"   name="country_id">
                                        @foreach ($countries as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                 </div>

                                 <div class="input-group">
                                     <button class="btn btn-primary" >save</button>
                                 </div>
                            </div>
                            </div>
                        </form>



            </div>





            </div>






        </div>















            </div>




    </div>
    <!-- END: Content -->









@stop



