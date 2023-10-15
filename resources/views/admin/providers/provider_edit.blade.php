@extends('admin.layouts.main')

@section('content')

    <h2 class="intro-y text-lg font-medium mt-10">
        Productive Family
    </h2>
    <div class="intro-y col-span-12 lg:col-span-6 mt-5">
        <!-- BEGIN: Vertical Form -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Edit Family
                </h2>

                <form class="todo-modal needs-validation" method="post" action="{{ url('admin/providers/edit/'.$provider->id) }}" id="upload_form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

            </div>
            {{--@dd($errors->has('title'));--}}
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="media mb-2">
                                <img src="{{@$provider->images[0]->image_name}}" alt="{{__('users avatar')}}" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer img-container img-thumbnail" height="90" width="200" />
                                <div class="media-body mt-50">
                                    <div class="col-12 d-flex mt-1 px-0">
                                        <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                            <span class="d-none d-sm-block">{{__('Add Extra image')}}</span>
                                            <input class="form-control" type="file" name="profile_img" multiple  id="change-picture" hidden accept="image/png, image/jpeg, image/jpg"  />
                                            <span class="d-block d-sm-none">
                                                <i class="mr-0" data-feather="plus-square"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if($provider->images)
                            <div class="row">
                                @foreach($provider->images as $key=>$value)
                                @php
                                $suffix="";
                                    $suffix.='<div class="col-xs-4 col-sm-4 col-md-3">';
                                    $suffix.='<p class="image_preview">';
                                    $suffix.='<img class="cropped_preview" src="'.$value->image_name.'" width="80">';
                        //                    $suffix.='<p><a class="btn btn-danger" href="https://productivefamiliesservices.alefsoftware.com/administration/products/delete-image/' . $value->id . '" ><i class="fa fa-trash-o"></i> </a></p>';
                                    $suffix.='<p><a class="delete_image btn btn-danger" href="https://productivefamiliesservices.alefsoftware.com/administration/products/delete-image/' . $value->id . '"><i class="fa fa-trash-o"></i></a></p>';
                                    $suffix.='</p>';
                                    $suffix.='</div>';
                                    echo $suffix;
                                @endphp
                                @endforeach
                            </div>
                            @endif


                            <div class="row d-flex align-items-end">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="title" class="form-label">{{__('Family Name')}}</label>
                                        <input type="text" id="title" name="name" class="new-todo-item-title form-control" placeholder="{{__('Title')}}" value="{{$provider->name}}" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="title_ar" class="form-label">{{__('Mobile')}}</label>
                                        <input type="text" id="title_ar" name="mobile" class="new-todo-item-title form-control" placeholder="{{__('Title')}}" value="{{$provider->mobile}}" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group position-relative">
                                        @php
                                        $countries = \App\Models\Countries::get();
                                        @endphp
                                        <label for="category_id" class="form-label d-block">{{__('Country')}}</label>
                                        <select class="select2 form-control" id="country" name="country">
                                            {{-- <option hidden>{{ __('Choose Category') }}</option> --}}
                                            @foreach ($countries as $item)
                                            <option data-img="" value="{{ $item->id }}" {{ $item->id == $provider->country ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="row d-flex align-items-end">

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="prepare_time" class="form-label">{{__('High KM price')}}</label>
                                        <input type="text" id="prepare_time" name="highKMPrice" class="new-todo-item-title form-control" placeholder="20" value="{{$provider->highKMPrice}}" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="prepare_time" class="form-label">{{__('Low KM price')}}</label>
                                        <input type="text" id="prepare_time" name="lowKMPrice" class="new-todo-item-title form-control" placeholder="10" value="{{$provider->lowKMPrice}}" />
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                        <button class="btn btn-primary mt-5">{{__('Submit')}}</button>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-vertical-form" class="copy-code btn py-1 px-2 btn-outline-secondary"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file" data-lucide="file" class="lucide lucide-file w-4 h-4 mr-2"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline></svg> Copy example code </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                                            <pre id="copy-vertical-form" class="source-preview"> <code class="html hljs xml"> <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">for</span>=<span class="hljs-string">"vertical-form-1"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-label"</span>&gt;</span>Email<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"vertical-form-1"</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"text"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-control"</span> <span class="hljs-attr">placeholder</span>=<span class="hljs-string">"example@gmail.com"</span>&gt;</span> <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>
 <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mt-3"</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">for</span>=<span class="hljs-string">"vertical-form-2"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-label"</span>&gt;</span>Password<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"vertical-form-2"</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"text"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-control"</span> <span class="hljs-attr">placeholder</span>=<span class="hljs-string">"secret"</span>&gt;</span> <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>
 <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-check mt-5"</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"vertical-form-3"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-check-input"</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"checkbox"</span> <span class="hljs-attr">value</span>=<span class="hljs-string">""</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-check-label"</span> <span class="hljs-attr">for</span>=<span class="hljs-string">"vertical-form-3"</span>&gt;</span>Remember me<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span> <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">button</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"btn btn-primary mt-5"</span>&gt;</span>Login<span class="hljs-tag">&lt;/<span class="hljs-name">button</span>&gt;</span></code> <textarea class="absolute w-0 h-0 p-0"></textarea></pre>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Vertical Form -->




        </div>



@endsection

