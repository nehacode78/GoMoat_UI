@extends('layouts.app')

@section('title', __('essentials::lang.reminders'))

@section('content')
@include('essentials::layouts.nav_essentials')
<section class="content">
    <div class="container-fluid" style="background-color:#F7F7F7; padding-top:10px;">

        <!-- Page Header -->
       <div class="row mb-4 align-items-center" style="margin-bottom:20px;" >

         <div class="col-md-6 reminder-header">

             <div class="reminder-title">
                 <span class="reminder-icon">
                     <i class="fa fa-calendar"></i>
                 </span>

                 <span class="reminder-text">
                     Reminders
                 </span>
             </div>
         </div>

           <div class="col-md-6 text-right">
               <button class="add_reminder btn btn-primary">
                   <i class="fa fa-plus"></i> Add Reminder
               </button>
           </div>

       </div>

        <!-- Calendar Card -->
       <div class="calendar-wrapper">
           <div id="calendar"></div>
       </div>

    </div>

    @include('essentials::reminder.create')

</section>
<!-- show reminder modal -->
<div class="modal fade view_reminder" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>
@endsection

@section('javascript')
@php
    $fullcalendar_lang_file = session()->get('user.language', config('app.locale') ) . '.js';
@endphp
<!-- TODO -->
@if(file_exists(public_path() . '/plugins/fullcalendar/locale/' . $fullcalendar_lang_file))
    <!-- <script src="{{ asset('plugins/fullcalendar/locale/' . $fullcalendar_lang_file . '?v=' . $asset_v) }}"></script> -->
@endif
<script type="text/javascript">
	$(document).ready(function(){

		//on button click show modal
		$('button.add_reminder').click( function(){
            $('div.reminder').modal('show');
        });

		//call function when modal opened
		$(".reminder").on('shown.bs.modal', function(){
			//reminder_form validate
			reminder_form_validator = $("form#reminder_form").validate();

			//date-picker
			$('form#reminder_form .datepicker').datepicker({
	                autoclose: true,
	                format:datepicker_date_format,
	        });

	    	//time
			$('form#reminder_form input#time').datetimepicker({
					format: moment_time_format,
	                ignoreReadonly: true,
	        });

	        $('form#reminder_form input#end_time').datetimepicker({
					format: moment_time_format,
	                ignoreReadonly: true,
	        });
		});

		//on hide reset reminder_form
		$('.reminder').on('hidden.bs.modal', function(){
			reminder_form_validator.destroy();
			$("form#reminder_form")[0].reset();
		});

		//saving reminder
		$(document).on("submit", "form#reminder_form", function(e){
			e.preventDefault();
			var data = $("form#reminder_form").serialize();
			var url = $("form#reminder_form").attr("action");
			$.ajax({
				method: "POST",
				url: url,
				data: data,
				dataType: "json",
				success: function(result){
					if(result.success == true){
						$('.reminder').modal("hide");
						reload_calendar();
						toastr.success(result.msg);
					} else {
						toastr.error(result.msg);
					}
				}
			});
		});

		//full calender
		clickCount = 0;
		$("#calendar").fullCalendar({
            header:{
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },

            buttonText:{
                today:'Today',
                month:'Month',
                week:'Week',
                day:'Day'
            },

            height:650,

            events:'/essentials/reminder',

            eventRender:function(event, element){
                element.find('.fc-title').html(event.name);
                element.attr('data-href', event.url);
                element.attr('data-container', '.view_reminder');
                element.addClass('btn-modal');
            }
        });

		//reload_calendar
		function reload_calendar()
		{
			$('#calendar').fullCalendar( 'refetchEvents' );
		}

		//on click show reminder
		$(document).on('click', '.btn-modal', function(){
		});

		//call function when modal opened
		$(".view_reminder").on('shown.bs.modal', function(){
			$("form#update_reminder_repeat").validate();
		});

		//delete reminder
		$(document).on('click', '#delete_reminder', function(){
			var url = $(this).data("href");
			swal({
		      title: LANG.sure,
		      icon: "warning",
		      buttons: true,
		      dangerMode: true,
		    }).then((confirmed) => {
		        if (confirmed) {
		        	$.ajax({
		        		method: "DELETE",
		        		url: url,
		        		dataType: "json",
		        		success: function(result){
		        			if(result.success == true){
		        				$('.view_reminder').modal('hide');
		        				reload_calendar();
		        				toastr.success(result.msg);
		        			} else {
		        				toastr.error(result.msg);
		        			}
		        		}
		        	});
		        }
		    });
		});

		//update reminder_repeat
		$(document).on('submit', 'form#update_reminder_repeat', function(e){
			e.preventDefault();
			var url = $("form#update_reminder_repeat").attr("action");
			var data = $("form#update_reminder_repeat").serialize();
			$.ajax({
				method: "PUT",
				url: url,
				data: data,
				dataType: "json",
				success: function(result){
					if(result.success == true){
        				$('.view_reminder').modal('hide');
        				reload_calendar();
        				toastr.success(result.msg);
        			} else {
        				toastr.error(result.msg);
        			}
				}
			});
		});
	});
</script>
@endsection



<style>

    .calendar-wrapper{
        background:#ffffff;
        border:1px solid #E5E7EB;
        border-radius:8px;
        padding:20px;
    }

    /* remove default fullcalendar border */
    .fc{
        background:#ffffff;
    }

.fc-daygrid-day{
    border:1px solid #E5E7EB !important;
}

.fc-scrollgrid{
    border:1px solid #E5E7EB !important;
}
    .calendar-card{
        border-radius:10px;
        border:none;
        box-shadow:0 3px 15px rgba(0,0,0,0.08);
        padding:10px;
    }

    /* Add Reminder Button */
   .add_reminder{
       background:#3b82f6;
       border:none;
       color:white;
       padding:8px 18px;
       border-radius:6px;
       font-weight:600;
   }

   .add_reminder i{
       margin-right:6px;
   }

    /* Calendar header */
    .fc-toolbar{
        margin-bottom:20px;
    }
.btn-primary{
background-color:#2B7ADA !important;
border-radius:10px !important;
}

    .fc-button{
        background:#f3f4f6 !important;
        border:none !important;
        color:#374151 !important;
        padding:6px 12px !important;
        border-radius:6px !important;
    }


    .fc-button-primary:not(:disabled).fc-button-active{
        background:#2563eb !important;
        color:white !important;
    }

    /* Calendar grid */
    .fc-daygrid-day{
        background:#ffffff;
    }

    .fc-event{
        background:#22c55e !important;
        border:none !important;
        border-radius:5px;
        font-size:12px;
        padding:2px 6px;
    }

    /* Month title */
    .fc-toolbar-title{
        font-size:18px;
        font-weight:600;
    }


.reminder-title{
    display:flex;
    align-items:center;
    gap:10px;
}

.reminder-icon{
    width:32px;
    height:32px;
    border:1px solid #e5e7eb;
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.reminder-icon i{
    font-size:14px;
    color:#333333;
}

.reminder-text{
    font-size:16px;
    font-weight:600;
    color:#333333;
    line-height:1;
}
    </style>