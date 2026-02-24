@extends('layouts.app')
@section('title', __('essentials::lang.hrm'))

@section('content')
    @include('essentials::layouts.nav_hrm')
    <!-- Main content -->
   <section class="content content2 tw-bg-[#f6f8fb] tw-min-h-screen tw-px-6 tw-py-4">

       {{-- Dynamic Title --}}
                  @php
                      $page = ucfirst(request()->segment(2) ?? 'dashboard');
                  @endphp


                   {{-- ================= HEADER ================= --}}
                       <div class="tw-flex tw-justify-end tw-items-center tw-gap-4 tw-mb-8">

                           {{-- Date --}}
                           <div class="tw-text-md tw-text-gray-400" style="margin-top:-113px; margin-right: 20px;">
                               {{ \Carbon\Carbon::now()->format('d M, Y') }}
                           </div>

                           {{-- My Payroll Button --}}
                           <a href="{{ action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'getMyPayrolls']) }}"
                              class="tw-bg-[#2B7ADA] hover:tw-bg-[#1f5bd8] tw-text-white tw-px-4 tw-py-2 tw-rounded-md tw-text-sm tw-font-medium tw-shadow-sm" style="margin-top:-113px; background-color: #2B7ADA; margin-right: 20px;">
                               <i class="fas fa-coins tw-mr-2"></i>
                               My Payrolls
                           </a>

                       </div>





       {{-- ================= MY SCOPE ================= --}}
       <div class="tw-text-xs tw-font-semibold tw-text-gray-500 tw-mb-4 tw-tracking-wide">
           MY SCOPE
       </div>


       <div class="row tw-mb-6">

           {{-- My Leaves --}}
           <div class="col-md-4">
               <div class="tw-bg-white tw-border tw-border-[#d9e2f3] tw-rounded-lg tw-p-4" style="background-color:#F4F8FD80">

                   <div class="tw-flex tw-items-center tw-gap-2 tw-mb-4">
                       <i class="fas fa-user-clock tw-text-gray-600"></i>
                       <span class="tw-font-semibold">My Leaves</span>
                   </div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mb-1">TODAY</div>
                   <div class="tw-text-sm tw-mb-4">-</div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mb-1">UPCOMING</div>

                   @forelse($users_leaves as $user_leave)
                       <div class="tw-text-sm">
                           {{ @format_date($user_leave->start_date) }}
                           -
                           {{ @format_date($user_leave->end_date) }}
                       </div>
                   @empty
                       <div class="tw-text-sm tw-text-gray-400">-</div>
                   @endforelse

               </div>
           </div>


           {{-- My Sales Targets --}}
           <div class="col-md-4">
               <div class="tw-bg-white tw-border tw-border-[#d9e2f3] tw-rounded-lg tw-p-4" style="background-color:#F4F8FD80">

                   <div class="tw-flex tw-items-center tw-gap-2 tw-mb-4">
                       <i class="fas fa-dollar-sign tw-text-gray-600"></i>
                       <span class="tw-font-semibold">My Sales Targets</span>
                   </div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mb-2">ACHIEVED</div>

                   <div class="tw-flex tw-justify-between tw-mb-4">

                       <div>
                           <div class="tw-text-xs tw-text-gray-500">Last month</div>
                           <div class="tw-text-green-600 tw-font-semibold" style="color:#41A256">
                               @format_currency($target_achieved_last_month)
                           </div>
                       </div>

                       <div>
                           <div class="tw-text-xs tw-text-gray-500">This month</div>
                           <div class="tw-text-green-600 tw-font-semibold" style="color:#41A256">
                               @format_currency($target_achieved_this_month)
                           </div>
                       </div>
                   </div>

                   <div class="tw-border-t tw-pt-3">
                       <div class="tw-flex tw-justify-between tw-text-sm">
                           <span>Targets</span>
                           <span>Commission %</span>
                       </div>
                   </div>

               </div>
           </div>


           {{-- Birthdays --}}
           <div class="col-md-4">
               <div class="tw-bg-white tw-border tw-border-[#d9e2f3] tw-rounded-lg tw-p-4" style="background-color:#F4F8FD80">

                   <div class="tw-flex tw-items-center tw-gap-2 tw-mb-4">
                       <i class="fas fa-gift tw-text-gray-600"></i>
                       <span class="tw-font-semibold">Birthdays</span>
                   </div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mb-1">TODAY</div>
                   <div class="tw-text-sm tw-mb-4">-</div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mb-1">UPCOMING</div>
                   <div class="tw-text-sm">-</div>

               </div>
           </div>

       </div>
   <hr class="lines">



       {{-- ================= COMPANY UPDATES ================= --}}
       <div class="tw-text-xs tw-font-semibold tw-text-gray-500 tw-mb-4 tw-mt-6 tw-tracking-wide">
           COMPANY UPDATES
       </div>

       <div class="row tw-mb-6">

           {{-- Today's Attendance --}}
           <div class="col-md-4">
               <div class="tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg  tw-p-4" style="background-color:#F4F8FD80">

                   <div class="tw-flex tw-items-center tw-gap-2 tw-mb-4">
                       <i class="fas fa-user-check tw-text-gray-600"></i>
                       <span class="tw-font-semibold">Today's Attendance</span>
                   </div>



                <div class="tw-flex tw-justify-between tw-mb-4">
                                      <div>
                                          <div class="tw-text-sx tw-text-gray-400 tw-mb-2">EMPLOYEE</div>
                                          <div class="tw-text-green-600 tw-font-semibold" style="color:#41A256">

                                          </div>
                                      </div>

                                      <div>
                                          <div class="tw-text-xs tw-text-gray-400 tw-mb-2">CLOCK IN</div>
                                          <div class="tw-text-green-600 tw-font-semibold" style="color:#41A256">

                                          </div>
                                      </div>
                                  <div>
                                      <div class="tw-text-xs tw-text-gray-400 tw-mb-2">CLOCK OUT</div>
                                      <div class="tw-text-green-600 tw-font-semibold" style="color:#41A256">

                                      </div>
                                  </div>
                              </div>

                   @forelse($todays_attendances as $attendance)
                       <div class="tw-text-sm tw-flex tw-justify-between">
                           <span>{{ $attendance->employee->user_full_name }}</span>
                           <span>{{ @format_time($attendance->clock_in_time) }}</span>
                       </div>
                   @empty
                       <div class="tw-text-sm tw-text-gray-400">No data</div>
                   @endforelse

               </div>
           </div>


           {{-- Company Leaves --}}
           <div class="col-md-4">
               <div class="tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-p-4" style="background-color:#F4F8FD80">

                   <div class="tw-flex tw-items-center tw-gap-2 tw-mb-4">
                       <i class="fas fa-user-times tw-text-gray-600"></i>
                       <span class="tw-font-semibold">Company Leaves</span>
                   </div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mb-1">TODAY</div>
                   <div class="tw-text-sm">-</div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mt-4 tw-mb-1">UPCOMING</div>
                   <div class="tw-text-sm">-</div>

               </div>
           </div>


           {{-- Holidays --}}
           <div class="col-md-4">
               <div class="tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg  tw-p-4" style="background-color:#F4F8FD80">

                   <div class="tw-flex tw-items-center tw-gap-2 tw-mb-4">
                       <i class="fas fa-umbrella-beach tw-text-gray-600"></i>
                       <span class="tw-font-semibold">Holidays</span>
                   </div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mb-1">TODAY</div>
                   <div class="tw-text-sm">-</div>

                   <div class="tw-text-xs tw-text-gray-400 tw-mt-4 tw-mb-1">UPCOMING</div>
                   <div class="tw-text-sm">-</div>

               </div>
           </div>

       </div>



       {{-- ================= SALES TARGETS TABLE ================= --}}
       <div class="tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-mt-6 tw-p-4" style="background-color:#F4F8FD80">

           <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
               <div class="tw-flex tw-items-center tw-gap-2">
                   <i class="fas fa-bullseye tw-text-gray-600"></i>
                   <span class="tw-font-semibold">Sales targets</span>
               </div>

               <a href="#" class="tw-text-blue-600 tw-text-sm" style="text-decoration: underline; color:#2B7ADA;" >View All Sales Targets</a>
           </div>

           <table class="table">
               <thead>
                   <tr>
                       <th>User</th>
                       <th>Target achieved last month</th>
                       <th>Target achieved this month</th>
                   </tr>
               </thead>
           </table>

       </div>

   </section>
   <style>
       .content2{
       margin-right: 26px;
           margin-left: 26px;
       }
   .lines{
       border-top: 1px solid #EBEBEB !important;
   }
       </style>

@stop
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            if ($('#sales_targets_table').length) {
                var sales_targets_table = $('#sales_targets_table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    scrollY: "75vh",
                    scrollX: true,
                    scrollCollapse: true,
                    dom: 'Btirp',
                    fixedHeader: false,
                    ajax: "{{ action([\Modules\Essentials\Http\Controllers\DashboardController::class, 'getUserSalesTargets']) }}"
                });
            }
        });
    </script>
@endsection
