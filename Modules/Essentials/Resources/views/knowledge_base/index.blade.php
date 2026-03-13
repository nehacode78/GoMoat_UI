@extends('layouts.app')

@section('title', __('essentials::lang.knowledge_base'))

@section('content')
@include('essentials::layouts.nav_essentials')
	<section class="content">
		<div class="kb-wrapper">
			<div class="kb-header">
                <div class="kb-title">
                    <i class="fa fa-book"></i>
                    @lang('essentials::lang.knowledge_base')
                </div>
				<div class="box-tools pull-right">
					<a href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create'])}}" class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-righ ">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
							class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
							<path stroke="none" d="M0 0h24v24H0z" fill="none" />
							<path d="M12 5l0 14" />
							<path d="M5 12l14 0" />
						</svg> @lang('messages.add')
					</a>
				</div>
			</div>
			<div class="kb-card-body">
				<div class="row">
				@foreach($knowledge_bases as $kb)
					<div class="col-md-6 col-lg-6">
                        <div class="kb-card">
							<div class="kb-card-header">
								<h4 class="box-title">{{$kb->title}}</h4>
								<div class="box-tools pull-right">
                                    <a class="kb-icon view" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'show'], [$kb->id])}}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->can('essentials.edit_knowledge_base'))
                                        <a class="kb-icon edit" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'edit'], [$kb->id])}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                      @endif
								@if(auth()->user()->can('essentials.delete_knowledge_base'))
                                    <a class="kb-icon delete delete-kb" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'destroy'], [$kb->id])}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                   @endif
                                    <a class="kb-icon add" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create'])}}?parent={{$kb->id}}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                   </div>
							</div>
							<div class="kb-card-body">
								{!! $kb->content !!}
								@if(count($kb->children) > 0)
									<div class="box-group" 
										id="accordian_{{$kb->id}}">
										@foreach($kb->children as $section)
											<div class="panel box box-solid">
												<div class="box-header with-border" style="padding: 10px 12px;">

													<h4 class="box-title">
														<a data-toggle="collapse" data-parent="#accordian_{{$kb->id}}" href="#collapse_{{$section->id}}" @if($loop->index == 0 )aria-expanded="true" @endif>{{$section->title}}
														</a>
													</h4>

													<div class="box-tools pull-right">
														<a class="text-info p-5-5" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'show'], [$section->id])}}" title="@lang('messages.view')" data-toggle="tooltip"><i class="fas fa-eye"></i></a>
													@if(auth()->user()->can('essentials.edit_knowledge_base'))
														<a class="text-primary p-5-5" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'edit'], [$section->id])}}" title="@lang('messages.edit')" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
													@endif

													@if(auth()->user()->can('essentials.delete_knowledge_base'))
														<a class="text-danger p-5-5 delete-kb" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'destroy'], [$section->id])}}" title="@lang('messages.delete')" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
													@endif
														<a class="text-success p-5-5" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create'])}}?parent={{$section->id}}" title="@lang('essentials::lang.add_article')" data-toggle="tooltip"><i class="fas fa-plus"></i></a>
													</div>
												</div>
												<div id="collapse_{{$section->id}}" class="panel-collapse collapse @if($loop->index == 0 )in @endif" @if($loop->index == 0 )aria-expanded="true" @endif >
								                    <div class="box-body" style="padding: 10px 12px;">
								                		{!!$section->content!!}
								                		@if(count($section->children) > 0)
								                			<ul class="todo-list">
								                			@foreach($section->children as $article)
								                				<li><a class="text-primary" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'show'], [$article->id])}}">{{$article->title}}
								                				</a>
								                				<div class="tools">
															@if(auth()->user()->can('essentials.edit_knowledge_base'))
								                				<a class="text-primary p-5-5" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'edit'], [$article->id])}}" title="@lang('messages.edit')" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
															@endif
															@if(auth()->user()->can('essentials.edit_knowledge_base'))
																<a class="text-danger p-5-5 delete-kb" href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'destroy'], [$article->id])}}" title="@lang('messages.delete')" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
															@endif
															</div>
								                				</li>
								                			@endforeach
								                			</ul>
								                		@endif
								                    </div>
								                </div>
											</div>
										@endforeach
									</div>
								@endif
							</div>
						</div>
					</div>
					@if($loop->iteration%3 == 0)
						<div class="clearfix"></div>
					@endif
				@endforeach
				</div>
			</div>
		</div>
	</section>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready( function(){
		$('.delete-kb').click(function(e){
			e.preventDefault();
			swal({
	            title: LANG.sure,
	            icon: 'warning',
	            buttons: true,
	            dangerMode: true,
	        }).then(willDelete => {
	            if (willDelete) {
	                var href = $(this).attr('href');
	                var data = $(this).serialize();

	                $.ajax({
	                    method: 'DELETE',
	                    url: href,
	                    dataType: 'json',
	                    data: data,
	                    success: function(result) {
	                        if (result.success == true) {
	                            toastr.success(result.msg);
	                        } else {
	                            toastr.error(result.msg);
	                        }

	                        location.reload();
	                    },
	                });
	            }
	        });
		})
	});
</script>
@endsection

<style>

    /* Page background */
    .content{
    background:#F7F7F7;
    }

    /* Main wrapper */
    .kb-wrapper{
    background:#fff;
    border-radius:8px;
    border:1px solid #E5E7EB;
    padding:20px;
    }

    /* Header */
    .kb-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    }

    .kb-title{
    font-size:16px;
    font-weight:600;
    display:flex;
    gap:8px;
    align-items:center;
    }

    /* Card */
    .kb-card{
    background:#fff;
    border:1px solid #E5E7EB;
    border-radius:10px;
    padding:15px;
    margin-bottom:20px;
    }

    /* Card header */
    .kb-card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
    }

    .kb-card-header h4{
    font-size:14px;
    font-weight:600;
    margin:0;
    }

    /* Card body */
    .kb-card-body{
    font-size:13px;
    color:#6B7280;
    }

    /* Section box */
    .panel.box{
    border-radius:8px;
    border:1px solid #E5E7EB;
    margin-top:10px;
    }

    /* Subsections */
    .todo-list li{
    background:#F9FAFB;
    border-radius:6px;
    padding:8px;
    margin-bottom:6px;
    }

    /* icons spacing */
    .p-5-5{
    margin-left:8px;
    }


.kb-icon{
display:inline-flex;
align-items:center;
justify-content:center;
width:26px;
height:26px;
border-radius:6px;
font-size:12px;
margin-left:6px;
text-decoration:none;
}

/* view */
.kb-icon.view{
background:#E8F5EC;
color:#2E7D32;
}

/* edit */
.kb-icon.edit{
background:#FFF4E5;
color:#F59E0B;
}

/* delete */
.kb-icon.delete{
background:#FDECEC;
color:#EF4444;
}

/* add */
.kb-icon.add{
background:#EEF2FF;
color:#3B82F6;
}

.kb-icon:hover{
opacity:0.85;
}
    </style>