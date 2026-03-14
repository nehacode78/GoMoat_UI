@extends('layouts.app')

@section('title', __('essentials::lang.messages'))

@section('content')
@include('essentials::layouts.nav_essentials')
<section class="content">
	<!-- Chat box -->

        <!--
         <div class="box-header">
        	  <i class="fa fa-comments-o"></i>
        	  <h3 class="box-title">@lang('essentials::lang.messages')</h3>
        	 </div>
        -->

          <div class="box-header msg-header">

              <!-- RIGHT SIDE -->
              <div class="msg-actions">

                  <!-- LEFT SIDE -->
                <div class="msg-title">
                     <span class="msg-icon">
                            <i class="fas fa-comments"></i>
                        </span>
                    <span class="title-text">@lang('essentials::lang.messages')</span>
                </div>

                  {!! Form::select('location_id',$business_locations,null,
                  ['class' => 'form-control msg-location', 'style' => ' margin-left:32rem;',
                  'placeholder' => __('lang_v1.select_location')]) !!}

                  <button class="btn add-location-btn" >
                      <i class="fa fa-plus-circle"></i> Add location chat
                  </button>

              </div>

          </div>



  <div class="msg-tabs">

  <div class="msg-tab active">
  <span class="avatar yellow">N</span>
  NAMAH - HO (HEAD OFFICE)
  <span class="close">×</span>
  </div>

  <div class="msg-tab">
  <span class="avatar green">S</span>
  SNN Durga - LCL BLR (Godrej 24 Sarjapur)
  <span class="close">×</span>
  </div>

  <div class="msg-tab">
  <span class="avatar red">C</span>
  Chaitra Enterprises - LCL BLR
  <span class="close">×</span>
  </div>

  </div>

	<div class="box-body" id="chat-box" style="height: 70vh; overflow-y: scroll;">
		@can('essentials.view_message')
		  @foreach($messages as $message)
		  	@include('essentials::messages.message_div')
		  @endforeach
	  	@endcan
	</div>
	<!-- /.chat -->
	@can('essentials.create_message')
	<div class="box-footer">
		{!! Form::open(['url' => action([\Modules\Essentials\Http\Controllers\EssentialsMessageController::class, 'store']), 'method' => 'post', 'id' => 'add_essentials_msg_form']) !!}
			<!--

			<div class="input-group">
            		  		{!! Form::textarea('message', null, ['class' => 'form-control', 'required', 'id' => 'chat-msg', 'placeholder' => __('essentials::lang.type_message'), 'rows' => 1]); !!}


                <div class="input-group-addon"
                                		  		style="width: 132px;padding: 0;border: none;">
                                		  			{!! Form::select('location_id',$business_locations,  null, ['class' => 'form-control', 'placeholder' => __('lang_v1.select_location'), 'style' => 'width: 100%; margin-left:5px; border-radius:8px;' ]); !!}
                                </div>




            		  		<div class="input-group-btn">
            		  			<button type="submit" class="btn btn-success pull-right ladda-button" data-style="expand-right">
            		  				<span class="ladda-label">Save</span>
            		  			</button>
            		  		</div>
            			</div>
			-->

        <div class="chat-input-container">

            {!! Form::textarea('message', null, [
                'class' => 'chat-input',
                'required',
                'id' => 'chat-msg',
                'placeholder' => 'Type In ..',
                'rows' => 1
            ]) !!}

            <button type="submit" class="chat-send-btn ladda-button">
                <i class="fas fa-paper-plane"></i> Send
            </button>

        </div>



		  {!! Form::close() !!}
	</div>
	@endcan
	</div>
	<!-- /.box (chat box) -->
</section>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function(){
		scroll_down_chat_div();
		$('#chat-msg').focus();
		$('form#add_essentials_msg_form').submit(function(e) {
			e.preventDefault();
			var msg = $('#chat-msg').val().trim();
			if(msg) {
				var data = $(this).serialize();
				var ladda = Ladda.create(document.querySelector('.ladda-button'));
				ladda.start();
				$.ajax({
					url: "{{action([\Modules\Essentials\Http\Controllers\EssentialsMessageController::class, 'store'])}}",
					data: data,
					method: 'post',
					dataType: "json",
					success: function(result){
						ladda.stop();
						if(result.html) {
							$('div#chat-box').append(result.html);
							scroll_down_chat_div();
							$('#chat-msg').val('').focus();
						}
					}
				});
			}
		});

		$(document).on('click', 'a.chat-delete', function(e) {
			e.preventDefault();
			swal({
	          title: LANG.sure,
	          icon: "warning",
	          buttons: true,
	          dangerMode: true,
	        }).then((willDelete) => {
	            if (willDelete) {
	            	var chat_item = $(this).closest('.post');
					$.ajax({
						url: $(this).attr('href'),
						method: 'DELETE',
						dataType: "json",
						success: function(result){
							if(result.success == true){
								toastr.success(result.msg);
								chat_item.remove();
							} else {
								toastr.error(result.msg);
							}
						}
					});
	            }
	        });
		});
		var chat_refresh_interval = "{{config('essentials::config.chat_refresh_interval', 20)}}";
		chat_refresh_interval = parseInt(chat_refresh_interval) * 1000;
		setInterval(function(){ getNewMessages() }, chat_refresh_interval);
	});

	function scroll_down_chat_div() {
		var chat_box    = $('#chat-box');
		var height = chat_box[0].scrollHeight;
		chat_box.scrollTop(height);
	}

	function getNewMessages() {
		var last_chat_time =  $('div.msg-box').length ? $('div.msg-box:last').data('delivered-at') : '';
		$.ajax({
            url: "{{action([\Modules\Essentials\Http\Controllers\EssentialsMessageController::class, 'getNewMessages'])}}?last_chat_time=" + last_chat_time,
            dataType: 'html',
            global: false,
            success: function(result) {
            	if(result.trim() != ''){
            		$('div#chat-box').append(result);
					scroll_down_chat_div();
            	}
            },
        });
	}
</script>
@endsection

<style>
    .btn-success{
    background-color:#2B7ADA !important;
    }
.btn{
border-radius:10px !important;
}



</style>

<style>
    /* Page background */
    .content{
    background:#F7F7F7;
    }

    /* Chat container */
    .box.box-solid{
    border:1px solid #E5E7EB;
    border-radius:8px;
    }

    /* Header */
  .msg-header{
  display:flex;
  align-items:center;
  padding:10px 16px;
  border-bottom:1px solid #E5E7EB;
  background:#F7F7F7;
  }

.msg-title{
display:flex;
align-items:center;
gap:10px;
font-weight:600;
font-size:16px;
}

  .msg-icon{
  width:25px;
  height:25px;
  background:#F3F4F6;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#6B7280;
  font-size:14px;
  }

  .msg-actions{
  display:flex;
  align-items:center;
  gap:10px;
  margin-left:auto;
  margin-bottom:20px;
  }

  /* override bootstrap full width */
  .msg-location{
  width:160px !important;
  min-width:250px;
  height:32px;
  border-radius:6px;
  border:1px solid #D1D5DB;
  font-size:12px;
  padding:4px 8px;
  display:inline-block;
  }
    .add-location-btn{
    background:#2B7ADA;
    color:#fff;
    border:none;
    border-radius:6px;
    padding:6px 14px;
    font-size:12px;
    display:flex;
    align-items:center;
    gap:6px;
    }

/* ensure button stays same line */
.add-location-btn{
white-space:nowrap;
}

    /* Tabs */
    .msg-tabs{
    display:flex;
    gap:10px;
    padding:12px 15px;
    border-bottom:2px solid #2B7ADA;
    background:#fff;
    }

    .msg-tab{
    display:flex;
    align-items:center;
    gap:8px;
    background:#F3F4F6;
    padding:6px 10px;
    border-radius:6px;
    font-size:13px;
    }

    .msg-tab.active{
    background:#EEF2FF;
    }

    /* Avatar */
    .avatar{
    width:22px;
    height:22px;
    border-radius:4px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:12px;
    color:#fff;
    }

    .avatar.yellow{background:#F9D68B;}
    .avatar.green{background:#8DC79A;}
    .avatar.red{background:#EB949D;}

    /* Chat body */
    .box-body{
    background:#F7F7F7;
    padding:20px;
    }

    /* Footer */
    .box-footer{
    border-top:1px solid #E5E7EB;
    padding:18px;
    background:#fff;
    }

    /* Input */
    .input-group{
    border:1px solid #D1D5DB;
    border-radius:8px;
    padding:6px;
    }

    #chat-msg{
    border:none !important;
    resize:none;
    box-shadow:none !important;
    }


.box-header{
padding:0 !important;
margin-bottom:10px !important;
}

    /* Send button */
    .btn-success{
    background:#2B7ADA !important;
    border-radius:6px;
    }




.chat-input-container{
display:flex;
align-items:center;
border:1px solid #D1D5DB;
border-radius:8px;
padding:6px 10px;
background:#fff;
}

.chat-input{
flex:1;
border:none !important;
resize:none;
outline:none;
font-size:13px;
padding:8px;
background:transparent;
}

.chat-send-btn{
background:#2B7ADA;
color:#fff;
border:none;
border-radius:6px;
padding:6px 14px;
font-size:12px;
display:flex;
align-items:center;
gap:6px;
margin-left:10px;
}

.chat-send-btn:hover{
background:#1f63b8;
}
    </style>