<!--
    <div class="post msg-box" style="margin-left: 15px; margin-right: 15px;" data-delivered-at="{{$message->created_at}}">
      	<div class="user-block">
            <span class="username" style="margin-left: 0;">
              <span class="text-primary">{{$message->sender->user_full_name}}</span>
              @if($message->user_id == auth()->user()->id)
              	<a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsMessageController::class, 'destroy'], [$message->id])}}" class="pull-right btn-box-tool chat-delete" title="@lang('messages.delete')"><i class="fa fa-times text-danger"></i></a>
              @endif
            </span>
        	<span class="description" style="margin-left: 0;"><small><i class="fas fa-clock"></i> {{$message->created_at->diffForHumans()}}</small></span>
      	</div>

      	<p>
        	{!! strip_tags($message->message, '<br>') !!}
      	</p>
    </div>
    -->




<div class="msg-box" data-delivered-at="{{$message->created_at}}">

@if($message->user_id == auth()->user()->id)

<!-- RIGHT MESSAGE -->
<div class="chat-row chat-right">

    <div class="chat-info">
        <small>{{$message->created_at->diffForHumans()}}</small>
        <strong>{{$message->sender->user_full_name}}</strong>
    </div>

    <div class="chat-bubble chat-bubble-right">
        {!! strip_tags($message->message, '<br>') !!}
    </div>

    <div class="chat-avatar avatar-green">
        {{ strtoupper(substr($message->sender->user_full_name,0,1)) }}
    </div>

</div>

@else

<!-- LEFT MESSAGE -->
<div class="chat-row chat-left">

    <div class="chat-avatar avatar-yellow">
        {{ strtoupper(substr($message->sender->user_full_name,0,1)) }}
    </div>

    <div class="chat-content">

        <div class="chat-info">
            <strong>{{$message->sender->user_full_name}}</strong>
            <small>{{$message->created_at->diffForHumans()}}</small>
        </div>

        <div class="chat-bubble chat-bubble-left">
            {!! strip_tags($message->message, '<br>') !!}
        </div>

    </div>

</div>

@endif

</div>

<style>
    /* Chat row layout */
    .chat-row{
    display:flex;
    align-items:flex-start;
    margin-bottom:20px;
    }

    .chat-left{
    justify-content:flex-start;
    }

    .chat-right{
    justify-content:flex-end;
    }

    /* Message bubble */
    .chat-bubble{
    background:#f3f4f6;
    padding:10px 14px;
    border-radius:8px;
    font-size:13px;
    max-width:55%;
    }

    .chat-bubble-right{
    background:#ffffff;
    border:1px solid #e5e7eb;
    }

    /* Chat info */
    .chat-info{
    font-size:11px;
    color:#6b7280;
    margin-bottom:5px;
    }

    /* Avatar */
    .chat-avatar{
    width:26px;
    height:26px;
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:12px;
    color:#fff;
    margin:0 8px;
    }

    .avatar-yellow{
    background:#F9D68B;
    }

    .avatar-green{
    background:#8DC79A;
    }

    /* Content wrapper */
    .chat-content{
    display:flex;
    flex-direction:column;
    }
    </style>