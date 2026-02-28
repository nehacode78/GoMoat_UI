<div class="pos-tab-content">
    <div class="row">
       <div class="col-md-12">
           <div class="form-group tw-mb-0">
               <label style="white-space:nowrap; font-weight:500;">
                   {!! Form::checkbox(
                       'calculate_sales_target_commission_without_tax',
                       1,
                       !empty($settings['calculate_sales_target_commission_without_tax']),
                       ['class' => 'input-icheck']
                   ) !!}
                   Calculate Sales Target Commission without Tax
               </label>

               @show_tooltip(__('essentials::lang.calculate_sales_target_commission_without_tax_help'))
           </div>
       </div>
    </div>
</div>

