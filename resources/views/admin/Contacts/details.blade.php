@extends('admin.layouts.main')
@section('content')
@include('admin.includes.messages')



 <!-- BEGIN: Content -->
 <div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Message Details') }}
        </h2>
    </div>
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">{{__('Message Information')}}</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> {{ $message->name }}</div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="calendar-clock" class="w-4 h-4 mr-2"></i> {{ $message->created_at }}</div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $message->email }} </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $message->mobile }} </div>
                </div>
            </div>




            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">{{__('Message')}}</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">

                    <p><strong>  {!! $message->message   !!} </strong>
                </div>
                </div>
            </div>

            </div>






        </div>




@endsection








