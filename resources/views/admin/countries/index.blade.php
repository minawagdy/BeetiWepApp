@extends('admin.layouts.main')
@section('content')
@include('admin.includes.messages')
            <!-- Body: Body -->
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                {{-- <h3 class="fw-bold mb-0">{{__('Providers Information')}}</h3> --}}
                                <h2 class="intro-y text-lg font-medium mt-10">
                                    {{__('Zones')}}
                                </h2>
                                <div class="col-auto d-flex w-sm-100">
                                   <!-- <button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#expadd"><i class="icofont-plus-circle me-2 fs-6"></i>{{__('Add Provider')}}</button> !-->
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row clearfix g-3">
                        <div class="col-lg-12">

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class='intro-y col-span-12 overflow-auto lg:overflow-visible'>
                                    <table id="myDataTable"class="table table-report -mt-2" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>{{__('#')}}</th>
                                                <th>{{__("ISO")}}</th>
                                                <th>{{__('NAME')}}</th>
                                                <th>{{__('NAME Ar')}}</th>
                                                <th>{{__('PHONE CODE')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $index=>$r)
                                            <tr>

                                                <td><strong>#{{$index+1}}</strong></td>
                                                <td>{{$r->iso}}</td>
                                                <td>{{$r->nicename}}</td>
                                                <td>{{$r->name_ar}}</td>
                                                <td>{{$r->phonecode}}</td>
                                                <td>@if($r->is_active == 1)<span class="">{{__('Published')}}</span> @else<span class=""> {{__("Unpublished")}}@endif</span></td>

                                                <td>
                                                    <form id="myForm{{$r->id}}" method="get" action="{{ url('admin/countries/active',[$r->id]) }}">
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

                                            </tr>

                                            <tr  id='gov{{$index}}'>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                </div>
                            </div>


                        </div>


                    </div><!-- Row End -->
                </div>
            </div>







 <!-- END: Profile Info -->
 <div class="tab-content mt-5">
    <div id="profile" class="tab-pane active" role="tabpanel" aria-labelledby="profile-tab">
        <div class="grid grid-cols-12 gap-6">






            <!-- BEGIN: Latest Uploads -->
            <div class="intro-y box col-span-12 lg:col-span-6">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        {{__('City')}}
                    </h2>

                </div>
                <div class="p-5">
                    <div class="flex items-center mt-4">
                        <table id="myDataTable"class="table table-report -mt-2" style="width: 100%;">

                            <tbody>
                                @foreach($govs  as $index=> $g)
                                <tr id='gov-select{{$index}}' data-id='{{$g->id}}'>
                                    <td>{{$g->title}}</td>
                                    <td><input class="form-check-input" name='is_active' @if($g->published == 1) checked @endif type="checkbox" id="goveSwitch{{$g->id}}" name="govSwitch" value="1"></td>
                                </tr>
                                <script>
                                    //get zones according to govs
                                        $(document).ready(function() {


                                          $('#gov-select{{$index}}').click(function() {
                                            var id = $(this).data('id');
                                            $.ajax({
                                              url: '/get-data/'+ id ,
                                              type: 'GET',

                                              dataType: 'json',
                                              success: function(data) {
                                                var rows = '';
                                                $.each(data, function(index, value) {
                                                    if(value.status == 1){
                                                        rows += '<tr id="'+value.id+'" data-id="'+value.id+'"><td>' + value.name   + '</td>'+
                                                    '<td><input class="form-check-input" name="status" id="Zone'+value.id+'"  type="checkbox" checked  name="zoneSwitch" value="1"></td></tr>';
                                                    }else{
                                                        rows += '<tr id="'+value.id+'" data-id="'+value.id+'"><td>' + value.name   + '</td>'+
                                                    '<td><input class="form-check-input" name="status" type="checkbox" id="Zone'+value.id+'"   name="zoneSwitch" value="1"></td></tr>';
                                                    }

                                                });
                                                // alert(rows);
                                                $('#zoneList').html(rows);

                                              },
                                              error: function(jqXHR, textStatus, errorThrown) {
                                                console.error(textStatus, errorThrown);
                                              }
                                            });
                                          });

                                        //   change status of GOV
                                        $("#goveSwitch{{$g->id}}").change(function(){

                                            var id={{$g->id}};
                                            type='gov';
                                            $.ajax({
                                              url: '/changeStatus/'+ type +'/' + id ,
                                              type: 'GET',

                                              dataType: 'json',
                                              success: function(data) {

                                              },
                                              error: function(jqXHR, textStatus, errorThrown) {
                                                console.error(textStatus, errorThrown);
                                              }
                                            });


                                        });



                                        });

                                      </script>

                              @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- END: Latest Uploads -->
            <!-- BEGIN: Latest Uploads -->
            <div class="intro-y box col-span-12 lg:col-span-6">

                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        {{__('Zone')}}
                    </h2>

                </div>
                <div class="p-5">
                    <div class="flex items-center mt-4">
                        <table id="myDataTable"class="table table-report -mt-2" style="width: 100%;">
                            <tbody id='zoneList' >
                            </tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- END: Latest Uploads -->


        </div>
    </div>
</div>












            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card">
                            <div class='intro-y col-span-12 overflow-auto lg:overflow-visible'>


                        </div>
                        </div>


                    </div>



                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class='intro-y col-span-12 overflow-auto lg:overflow-visible'>


                    </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-center">
                {{ $rows->links('pagination::bootstrap-4') }}
            </div>

        </div>

    </div>
    <script>

        //   change status of zone
        $('#zoneTable').on( 'click', 'tr', function () {
         var id = $(this).data('id');
                           type='zone';
                           // alert(id);
                           $.ajax({
                             url: '/changeStatus/'+ type +'/' + id ,
                             type: 'GET',

                             dataType: 'json',
                             success: function(data) {

                             },
                             error: function(jqXHR, textStatus, errorThrown) {
                               console.error(textStatus, errorThrown);
                             }
                           });
                       });
                           // end change zone status

   </script>

  @stop
