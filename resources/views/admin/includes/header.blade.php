  {{'',$max_history_action = $options->where('code','MAX_HISTORY_ACTION')->first()}}
  <div class="add-modal">
  <!-- INFO MODAL -->
                <div class="modal fade" id="info" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Thông tin về EposGroup</h4>
                                </div>
                                <div class="modal-body"> 
                                    <div class="row">
                                        <div class="col-md-offset-5"><img src="{{url('public/global/img/logo-big-blue.png')}}" alt="logo" class="img-responsive"></div>
                                    </div> 
                                    <div class="margin-bottom-10"></div>
                                    <div class="row">
                                        <div class="col-md-1">                                         
                                        </div>
                                        <div class="col-md-11">
                                            <div class="form-group">
                                                <label class="text-warning col-md-4 control-label">Tác giả :</label>
                                                <label class="text-warning col-md-8 control-label">Phan Kim Sơn</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="text-warning col-md-4 control-label">Điện thoại :</label>
                                                <label class="text-warning col-md-8 control-label">01686.692.911</label>
                                            </div>
                                            <div class="form-group">
                                               <label class="text-warning col-md-4 control-label">Email :</label>
                                               <label class="text-warning col-md-8 control-label"><a href="mailto:phankimson1988@gmail.com">phankimson1988@gmail.com</a></label>
                                            </div>     
                                            <div class="form-group">
                                               <label class="text-warning col-md-12 control-label">Bản quyền thuộc về tác giả. Vui lòng không sao chép bất cứ hình thức nào.</label>                                               
                                            </div> 
                                        </div>
                                    </div> 
                                </div>                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                <!-- INFO MODAL -->
                <!-- INFO MODAL -->
                <div class="modal fade" id="config" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content  portlet box purple-studio">
                                <div class="modal-header  portlet-title">
                                   <div id='title' class='caption'>
                                       {{trans('index.config')}}
                                </div>
                                <div class='tools'>                                    
                                </div>
                                    <ul class="nav nav-tabs">
                                    <li class="active"><a href="#infomation" data-toggle="tab">{{trans('employee.info')}}</a></li>
                                    <li><a href="#insurance" data-toggle="tab">{{trans('employee.tax&insurance')}}</a></li>                             
                                    </ul>                               
                                </div>
                                <div class="modal-body portlet-body">
                                     <div class="tab-content"  id="config-form" >
                                    <div class="tab-pane active" id="infomation">
                                    <table  class="table borderless" style="border-style: none">                                               
                                        
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.company')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="company" value="{{$options->where('code','COMPANY')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr> 
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.address')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="address" value="{{$options->where('code','ADDRESS')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr> 
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.phone')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="phone" value="{{$options->where('code','PHONE')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr> 
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.director_company')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="director_company" value="{{$options->where('code','DIRECTOR_COMPANY')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr>  
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.off_day')}}</label></td>
                                                  <td class="col-md-2">                                                 
                                                      <select name="off_day" class="input-medium form-control select2me config" multiple="multiple"  data-placeholder="Select...">    
                                                            <option value=""></option>
                                                            <option {{strpos($options->where('code','OFF_DAY')->implode('value'),'0') !== false ? 'selected' : '' }}  value="0">{{trans('options.sun')}}</option>
                                                            <option {{strpos($options->where('code','OFF_DAY')->implode('value'),'1') !== false ? 'selected' : '' }}  value="1">{{trans('options.mon')}}</option> 
                                                            <option {{strpos($options->where('code','OFF_DAY')->implode('value'),'2') !== false ? 'selected' : '' }}  value="2">{{trans('options.tus')}}</option> 
                                                            <option {{strpos($options->where('code','OFF_DAY')->implode('value'),'3') !== false ? 'selected' : '' }}  value="3">{{trans('options.wed')}}</option>      
                                                            <option {{strpos($options->where('code','OFF_DAY')->implode('value'),'4') !== false ? 'selected' : '' }}  value="4">{{trans('options.thu')}}</option> 
                                                            <option {{strpos($options->where('code','OFF_DAY')->implode('value'),'5') !== false ? 'selected' : '' }}  value="5">{{trans('options.fri')}}</option>  
                                                            <option {{strpos($options->where('code','OFF_DAY')->implode('value'),'6') !== false ? 'selected' : '' }}  value="6">{{trans('options.sat')}}</option>  
                                                    </select>
                                                  </td>     
                                                </tr>
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.calculator_personal_income_tax')}}</label></td>
                                                  <td class="col-md-2"><input type="checkbox" name="calculator_personal_income_tax" class="form-control make-switch config" {{$options->where('code','CALCULATOR_PERSONAL_INCOME_TAX')->implode('value') == '1' ? 'checked' : 'false' }} data-size="small" data-handle-width="25" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>"></td>     
                                                </tr>
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.calculator_insurrance')}}</label></td>
                                                  <td class="col-md-2"><input type="checkbox" name="calculator_insurrance" class="form-control make-switch config" {{$options->where('code','CALCULATOR_INSURRANCE')->implode('value') == '1' ? 'checked' : 'false'}}  data-size="small" data-handle-width="25" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>"></td>     
                                                </tr>
                                                 <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.hour_work_day')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="hour_work_day" value="{{$options->where('code','HOUR_WORK_DAY')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr> 
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_overtime_1')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="percent_overtime_1" value="{{$options->where('code','PERCENT_OVERTIME_1')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr> 
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_overtime_2')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="percent_overtime_2" value="{{$options->where('code','PERCENT_OVERTIME_2')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_overtime_3')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="percent_overtime_3" value="{{$options->where('code','PERCENT_OVERTIME_3')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_night_shift')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="percent_night_shift" value="{{$options->where('code','PERCENT_NIGHT_SHIFT')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                                 <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.day_clear_off')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="day_clear_off" value="{{$options->where('code','DAY_CLEAR_OFF')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                                 <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.min_add_al')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="min_add_al" value="{{$options->where('code','MIN_ADD_AL')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                                <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.hour_work')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-large config" maxlength="100" name="hour_work" value="{{$options->where('code','HOUR_WORK')->implode('value')}}" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                            </table> 
                                      </div>
                                         <div class="tab-pane" id="insurance">
                                    <table  class="table borderless" style="border-style: none"> 
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_social_insur')}}</label></td>
                                                  <td class="col-md-2" colspan="3"><input type="text" class="form-control input-large config" maxlength="100" name="percent_social_insur" value="{{$options->where('code','PERCENT_SOCIAL_INSUR')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"></td> 
                                                  <td class="col-md-2"></td> 
                                            </tr>
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_health_insur')}}</label></td>
                                                  <td class="col-md-2" colspan="3"><input type="text" class="form-control input-large config" maxlength="100" name="percent_health_insur" value="{{$options->where('code','PERCENT_HEALTH_INSUR')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"></td> 
                                                  <td class="col-md-2"></td> 
                                            </tr>
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_unemployee')}}</label></td>
                                                  <td class="col-md-2" colspan="3"><input type="text" class="form-control input-large config" maxlength="100" name="percent_unemployee" value="{{$options->where('code','PERCENT_UNEMPLOYEE')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"></td> 
                                                  <td class="col-md-2"></td> 
                                            </tr>
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.percent_trade_union')}}</label></td>
                                                  <td class="col-md-2" colspan="3"><input type="text" class="form-control input-large config" maxlength="100" name="percent_trade_union" value="{{$options->where('code','PERCENT_TRADE_UNION')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"></td> 
                                                  <td class="col-md-2"></td> 
                                            </tr>
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.price_personal_deduct')}}</label></td>
                                                  <td class="col-md-2" colspan="3"><input type="text" class="form-control input-large config" maxlength="100" name="price_personal_deduct" value="{{$options->where('code','PRICE_PERSION_DEDUCT')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"></td> 
                                                  <td class="col-md-2"></td> 
                                            </tr>
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.price_number_deduct')}}</label></td>
                                                  <td class="col-md-2" colspan="3"><input type="text" class="form-control input-large config" maxlength="100" name="price_number_deduct" value="{{$options->where('code','PRICE_NUMBER_DEDUCT')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"></td> 
                                                  <td class="col-md-2"></td> 
                                            </tr>
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.personal_income_lv1')}}</label></td>
                                                  <td class="col-md-1"><input type="text" class="form-control input-small config" maxlength="100" name="value-personal_income_lv1" value="{{$options->where('code','PERSONAL_INCOME_LV1')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-1"><input type="text" class="form-control input-sm config" maxlength="100" name="value1-personal_income_lv1" value="{{$options->where('code','PERSONAL_INCOME_LV1')->implode('value1')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-1"><input type="text" class="form-control input-small config" maxlength="100" name="value2-personal_income_lv1" value="{{$options->where('code','PERSONAL_INCOME_LV1')->implode('value2')}}" id="maxlength_defaultconfig"></td> 
                                            </tr>
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.personal_income_lv2')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value-personal_income_lv2" value="{{$options->where('code','PERSONAL_INCOME_LV2')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-sm config" maxlength="100" name="value1-personal_income_lv2" value="{{$options->where('code','PERSONAL_INCOME_LV2')->implode('value1')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value2-personal_income_lv2" value="{{$options->where('code','PERSONAL_INCOME_LV2')->implode('value2')}}" id="maxlength_defaultconfig"></td> 
                                            </tr>  
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.personal_income_lv3')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value-personal_income_lv3" value="{{$options->where('code','PERSONAL_INCOME_LV3')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-sm config" maxlength="100" name="value1-personal_income_lv3" value="{{$options->where('code','PERSONAL_INCOME_LV3')->implode('value1')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value2-personal_income_lv3" value="{{$options->where('code','PERSONAL_INCOME_LV3')->implode('value2')}}" id="maxlength_defaultconfig"></td> 
                                            </tr>   
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.personal_income_lv4')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value-personal_income_lv4" value="{{$options->where('code','PERSONAL_INCOME_LV4')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-sm config" maxlength="100" name="value1-personal_income_lv4" value="{{$options->where('code','PERSONAL_INCOME_LV4')->implode('value1')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value2-personal_income_lv4" value="{{$options->where('code','PERSONAL_INCOME_LV4')->implode('value2')}}" id="maxlength_defaultconfig"></td> 
                                            </tr> 
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.personal_income_lv5')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value-personal_income_lv5" value="{{$options->where('code','PERSONAL_INCOME_LV5')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-sm config" maxlength="100" name="value1-personal_income_lv5" value="{{$options->where('code','PERSONAL_INCOME_LV5')->implode('value1')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value2-personal_income_lv5" value="{{$options->where('code','PERSONAL_INCOME_LV5')->implode('value2')}}" id="maxlength_defaultconfig"></td> 
                                            </tr>  
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.personal_income_lv6')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value-personal_income_lv6" value="{{$options->where('code','PERSONAL_INCOME_LV6')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-sm config" maxlength="100" name="value1-personal_income_lv6" value="{{$options->where('code','PERSONAL_INCOME_LV6')->implode('value1')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value2-personal_income_lv6" value="{{$options->where('code','PERSONAL_INCOME_LV6')->implode('value2')}}" id="maxlength_defaultconfig"></td> 
                                            </tr>  
                                            <tr>          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('options.personal_income_lv7')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value-personal_income_lv7" value="{{$options->where('code','PERSONAL_INCOME_LV7')->implode('value')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-sm config" maxlength="100" name="value1-personal_income_lv7" value="{{$options->where('code','PERSONAL_INCOME_LV7')->implode('value1')}}" id="maxlength_defaultconfig"></td> 
                                                  <td class="col-md-2"><input type="text" class="form-control input-small config" maxlength="100" name="value2-personal_income_lv7" value="{{$options->where('code','PERSONAL_INCOME_LV7')->implode('value2')}}" id="maxlength_defaultconfig"></td> 
                                            </tr>   
                                            </table> 
                                      </div>
                                    </div>      
                                </div>
                                <div class="modal-footer"  style=" background-color: #fff;">                                    
                                     <button type="button" class="btn green" id="save-config">{{trans('global.save')}}</button>
                                     <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('global.close')}}</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                <!-- INFO MODAL -->
        </div>             
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index">
                        <img src="{{url('public/global/img/logo-big-white.png')}}" width="60px" height="20px" alt="logo" class="logo-default" /> </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
              
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-bell"></i>
                                <span class="badge badge-default"> 7 </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                     <h3>{{trans('index.history')}}</h3>
                                   <a href="{{url()->current().'/history'}}">{{trans('global.view_all')}}</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                        @foreach($history_action->where('username',session('logined'))->slice(0, $max_history_action->value) as $h)
                                         <li>
                                            <a href="javascript:;">
                                                <span class="time">{{$h->formattedDate()}}</span>
                                                <span class="details">
                                                    @if($h->type == 1)
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span>
                                                    @elseif ($h->type == 2)
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-plus"></i>
                                                    </span>                                                    
                                                    @elseif ($h->type == 3)
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-copy"></i>
                                                    </span>
                                                    
                                                    @elseif ($h->type == 4)
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-edit"></i>
                                                    </span>                                                    
                                                    @elseif ($h->type == 5)                                                    
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                    @elseif ($h->type == 6)
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-database"></i>
                                                    </span> 
                                                    @endif
                                                    {{trans('menu.'.$h->code)}}</span>
                                            </a>
                                        </li>
                                        @endforeach
<!--                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">9 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Storage server failed. </span>
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END NOTIFICATION DROPDOWN -->                        
                       
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="{{ url(session('avatar'))}}" />
                                <span class="username username-hide-on-mobile"> {{session('logined')}} </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="javascript:;" data-toggle="modal" data-target="#config" data-close-others="true">
                                        <i class="icon-settings"></i> {{trans('index.config')}} </a>
                                </li> 
                                <li>
                                    <a href="profile">
                                        <i class="icon-user"></i> {{trans('profile.user_profile')}} </a>
                                </li>                                
                                <li class="divider"> </li>
                                <li>
                                    <a href="lock">
                                        <i class="icon-lock"></i> {{trans('index.lock')}} </a>
                                </li>
                                <li>
                                    <a href="logout">
                                        <i class="icon-key"></i> {{trans('index.logout')}} </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-tasks">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="modal" data-target="#info" data-close-others="true">
                                <i class="icon-info"></i>                                
                            </a>
                            <ul></ul>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
                
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        <li class="sidebar-search-wrapper">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
<!--                            <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                                <a href="javascript:;" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{trans('global.search')}}">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                                </div>
                            </form>-->
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                        </li>