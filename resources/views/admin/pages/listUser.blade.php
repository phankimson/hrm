<!DOCTYPE html>
@extends('admin.layouts.default')   
@section('title')        
<title>EPOS HRM | {{trans('index.title')}}</title>
@stop
@section('extra_css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('public/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->        
@stop    
@section('content')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <div id="add_modal" >    
    <!-- /.modal-content -->
                <div id="context-menu">
                         <ul class="dropdown-menu pull-left" role="menu">
                                  <li>
                                        <a href="#" name="add" data-id="1">
                                            <i class="fa fa-plus"></i> {{trans('global.add')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="copy" data-id="2">
                                            <i class="fa fa-copy"></i> {{trans('global.copy')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="edit" data-id="3">
                                            <i class="fa fa-edit"></i> {{trans('global.edit')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="delete" data-id="4">
                                            <i class="fa fa-times"></i> {{trans('global.delete')}}</a>
				  </li>
				  
			</ul>
		</div>
                <div id="table-menu">
                         <ul class="dropdown-menu pull-left" role="menu">
                                  <li>
                                        <a href="#" name="save" data-id="1">
                                            <i class="fa fa-save"></i> {{trans('global.save')}}</a>
				  </li>
                                  <li>
                                        <a href="#" name="cancel" data-id="2">
                                            <i class="fa fa-ban"></i> {{trans('global.cancel')}}</a>
				  </li>				  
			</ul>
		</div>             
       <div id='action' class='modal fade resizable table-menu' data-backdrop="false" data-focus-on='input:first'>
                    <div class='modal-dialog modal-full'>
                        <div class='modal-content portlet box blue-hoki'>
                            <div class='modal-header portlet-title'>
                                <div id='title' class='caption'>
                                </div>
                                <div class='tools'>
                                    <a class='fullscreen' href='javascript:;' data-original-title='' title=''> </a>
                                    <a class='collapse' href='javascript:;' data-original-title='' title=''> </a>
                                    <a class='config' data-toggle='modal' href='#portlet-config' data-original-title='' title=''> </a>
                                    <a class='reload' href='javascript:;' data-original-title='' title=''> </a>
                                    <button type='button' class='close-big cancel' aria-hidden='true'></button>
                                </div>                                                                                      
                            </div>
                            <div class="modal-body portlet-body" id="form-action">
                                            <table  class="table borderless" style="border-style: none">
                                                <tr>

                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.username')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="1" maxlength="70" name="username" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                                
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.password')}}</label></td>
                                                  <td class="col-md-2"><input type="password" class="form-control input-xlarge" position="2" maxlength="30" name="password" id="maxlength_defaultconfig"></td>     
                                                </tr>  
                                                
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.fullname')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="3" maxlength="50" name="fullname" id="maxlength_defaultconfig"></td>     
                                                </tr>   
                                              
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.firstname')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="4" maxlength="50" name="firstname" id="maxlength_defaultconfig"></td>     
                                                </tr>   
                                                
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.lastname')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="5" maxlength="50" name="lastname" id="maxlength_defaultconfig"></td>     
                                                </tr>   
                                    
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.identity_card')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="6" maxlength="50" name="identity_card" id="maxlength_defaultconfig"></td>     
                                                </tr>  
                                     
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.birthday')}}</label></td>
                                                  <td class="col-md-2">
                                                     <input class="form-control input-medium date-picker date" name='birthday' position="7" size="10" data-date-format="dd/mm/yyyy" type="text" value="">
                                                </tr>
                                     
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.mobile')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="8" maxlength="50" name="phone" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                           
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.address')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="9" maxlength="50" name="address" id="maxlength_defaultconfig"></td>     
                                                </tr>
                            
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.city')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="10" maxlength="50" name="city" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                         
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.jobs')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="11" maxlength="50" name="jobs" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                   
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.country')}}</label></td>
                                                  <td class="col-md-2">
                                                      <select name="country" id="country"  position="12" class="form-control input-medium select2me">                                                                             
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="AD">Andorra</option>
                                                            <option value="AO">Angola</option>
                                                            <option value="AI">Anguilla</option>
                                                            <option value="AQ">Antarctica</option>
                                                            <option value="AR">Argentina</option>
                                                            <option value="AM">Armenia</option>
                                                            <option value="AW">Aruba</option>
                                                            <option value="AU">Australia</option>
                                                            <option value="AT">Austria</option>
                                                            <option value="AZ">Azerbaijan</option>
                                                            <option value="BS">Bahamas</option>
                                                            <option value="BH">Bahrain</option>
                                                            <option value="BD">Bangladesh</option>
                                                            <option value="BB">Barbados</option>
                                                            <option value="BY">Belarus</option>
                                                            <option value="BE">Belgium</option>
                                                            <option value="BZ">Belize</option>
                                                            <option value="BJ">Benin</option>
                                                            <option value="BM">Bermuda</option>
                                                            <option value="BT">Bhutan</option>
                                                            <option value="BO">Bolivia</option>
                                                            <option value="BA">Bosnia and Herzegowina</option>
                                                            <option value="BW">Botswana</option>
                                                            <option value="BV">Bouvet Island</option>
                                                            <option value="BR">Brazil</option>
                                                            <option value="IO">British Indian Ocean Territory</option>
                                                            <option value="BN">Brunei Darussalam</option>
                                                            <option value="BG">Bulgaria</option>
                                                            <option value="BF">Burkina Faso</option>
                                                            <option value="BI">Burundi</option>
                                                            <option value="KH">Cambodia</option>
                                                            <option value="CM">Cameroon</option>
                                                            <option value="CA">Canada</option>
                                                            <option value="CV">Cape Verde</option>
                                                            <option value="KY">Cayman Islands</option>
                                                            <option value="CF">Central African Republic</option>
                                                            <option value="TD">Chad</option>
                                                            <option value="CL">Chile</option>
                                                            <option value="CN">China</option>
                                                            <option value="CX">Christmas Island</option>
                                                            <option value="CC">Cocos (Keeling) Islands</option>
                                                            <option value="CO">Colombia</option>
                                                            <option value="KM">Comoros</option>
                                                            <option value="CG">Congo</option>
                                                            <option value="CD">Congo, the Democratic Republic of the</option>
                                                            <option value="CK">Cook Islands</option>
                                                            <option value="CR">Costa Rica</option>
                                                            <option value="CI">Cote d'Ivoire</option>
                                                            <option value="HR">Croatia (Hrvatska)</option>
                                                            <option value="CU">Cuba</option>
                                                            <option value="CY">Cyprus</option>
                                                            <option value="CZ">Czech Republic</option>
                                                            <option value="DK">Denmark</option>
                                                            <option value="DJ">Djibouti</option>
                                                            <option value="DM">Dominica</option>
                                                            <option value="DO">Dominican Republic</option>
                                                            <option value="EC">Ecuador</option>
                                                            <option value="EG">Egypt</option>
                                                            <option value="SV">El Salvador</option>
                                                            <option value="GQ">Equatorial Guinea</option>
                                                            <option value="ER">Eritrea</option>
                                                            <option value="EE">Estonia</option>
                                                            <option value="ET">Ethiopia</option>
                                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                                            <option value="FO">Faroe Islands</option>
                                                            <option value="FJ">Fiji</option>
                                                            <option value="FI">Finland</option>
                                                            <option value="FR">France</option>
                                                            <option value="GF">French Guiana</option>
                                                            <option value="PF">French Polynesia</option>
                                                            <option value="TF">French Southern Territories</option>
                                                            <option value="GA">Gabon</option>
                                                            <option value="GM">Gambia</option>
                                                            <option value="GE">Georgia</option>
                                                            <option value="DE">Germany</option>
                                                            <option value="GH">Ghana</option>
                                                            <option value="GI">Gibraltar</option>
                                                            <option value="GR">Greece</option>
                                                            <option value="GL">Greenland</option>
                                                            <option value="GD">Grenada</option>
                                                            <option value="GP">Guadeloupe</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="GT">Guatemala</option>
                                                            <option value="GN">Guinea</option>
                                                            <option value="GW">Guinea-Bissau</option>
                                                            <option value="GY">Guyana</option>
                                                            <option value="HT">Haiti</option>
                                                            <option value="HM">Heard and Mc Donald Islands</option>
                                                            <option value="VA">Holy See (Vatican City State)</option>
                                                            <option value="HN">Honduras</option>
                                                            <option value="HK">Hong Kong</option>
                                                            <option value="HU">Hungary</option>
                                                            <option value="IS">Iceland</option>
                                                            <option value="IN">India</option>
                                                            <option value="ID">Indonesia</option>
                                                            <option value="IR">Iran (Islamic Republic of)</option>
                                                            <option value="IQ">Iraq</option>
                                                            <option value="IE">Ireland</option>
                                                            <option value="IL">Israel</option>
                                                            <option value="IT">Italy</option>
                                                            <option value="JM">Jamaica</option>
                                                            <option value="JP">Japan</option>
                                                            <option value="JO">Jordan</option>
                                                            <option value="KZ">Kazakhstan</option>
                                                            <option value="KE">Kenya</option>
                                                            <option value="KI">Kiribati</option>
                                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                                            <option value="KR">Korea, Republic of</option>
                                                            <option value="KW">Kuwait</option>
                                                            <option value="KG">Kyrgyzstan</option>
                                                            <option value="LA">Lao People's Democratic Republic</option>
                                                            <option value="LV">Latvia</option>
                                                            <option value="LB">Lebanon</option>
                                                            <option value="LS">Lesotho</option>
                                                            <option value="LR">Liberia</option>
                                                            <option value="LY">Libyan Arab Jamahiriya</option>
                                                            <option value="LI">Liechtenstein</option>
                                                            <option value="LT">Lithuania</option>
                                                            <option value="LU">Luxembourg</option>
                                                            <option value="MO">Macau</option>
                                                            <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                                            <option value="MG">Madagascar</option>
                                                            <option value="MW">Malawi</option>
                                                            <option value="MY">Malaysia</option>
                                                            <option value="MV">Maldives</option>
                                                            <option value="ML">Mali</option>
                                                            <option value="MT">Malta</option>
                                                            <option value="MH">Marshall Islands</option>
                                                            <option value="MQ">Martinique</option>
                                                            <option value="MR">Mauritania</option>
                                                            <option value="MU">Mauritius</option>
                                                            <option value="YT">Mayotte</option>
                                                            <option value="MX">Mexico</option>
                                                            <option value="FM">Micronesia, Federated States of</option>
                                                            <option value="MD">Moldova, Republic of</option>
                                                            <option value="MC">Monaco</option>
                                                            <option value="MN">Mongolia</option>
                                                            <option value="MS">Montserrat</option>
                                                            <option value="MA">Morocco</option>
                                                            <option value="MZ">Mozambique</option>
                                                            <option value="MM">Myanmar</option>
                                                            <option value="NA">Namibia</option>
                                                            <option value="NR">Nauru</option>
                                                            <option value="NP">Nepal</option>
                                                            <option value="NL">Netherlands</option>
                                                            <option value="AN">Netherlands Antilles</option>
                                                            <option value="NC">New Caledonia</option>
                                                            <option value="NZ">New Zealand</option>
                                                            <option value="NI">Nicaragua</option>
                                                            <option value="NE">Niger</option>
                                                            <option value="NG">Nigeria</option>
                                                            <option value="NU">Niue</option>
                                                            <option value="NF">Norfolk Island</option>
                                                            <option value="MP">Northern Mariana Islands</option>
                                                            <option value="NO">Norway</option>
                                                            <option value="OM">Oman</option>
                                                            <option value="PK">Pakistan</option>
                                                            <option value="PW">Palau</option>
                                                            <option value="PA">Panama</option>
                                                            <option value="PG">Papua New Guinea</option>
                                                            <option value="PY">Paraguay</option>
                                                            <option value="PE">Peru</option>
                                                            <option value="PH">Philippines</option>
                                                            <option value="PN">Pitcairn</option>
                                                            <option value="PL">Poland</option>
                                                            <option value="PT">Portugal</option>
                                                            <option value="PR">Puerto Rico</option>
                                                            <option value="QA">Qatar</option>
                                                            <option value="RE">Reunion</option>
                                                            <option value="RO">Romania</option>
                                                            <option value="RU">Russian Federation</option>
                                                            <option value="RW">Rwanda</option>
                                                            <option value="KN">Saint Kitts and Nevis</option>
                                                            <option value="LC">Saint LUCIA</option>
                                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                                            <option value="WS">Samoa</option>
                                                            <option value="SM">San Marino</option>
                                                            <option value="ST">Sao Tome and Principe</option>
                                                            <option value="SA">Saudi Arabia</option>
                                                            <option value="SN">Senegal</option>
                                                            <option value="SC">Seychelles</option>
                                                            <option value="SL">Sierra Leone</option>
                                                            <option value="SG">Singapore</option>
                                                            <option value="SK">Slovakia (Slovak Republic)</option>
                                                            <option value="SI">Slovenia</option>
                                                            <option value="SB">Solomon Islands</option>
                                                            <option value="SO">Somalia</option>
                                                            <option value="ZA">South Africa</option>
                                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                            <option value="ES">Spain</option>
                                                            <option value="LK">Sri Lanka</option>
                                                            <option value="SH">St. Helena</option>
                                                            <option value="PM">St. Pierre and Miquelon</option>
                                                            <option value="SD">Sudan</option>
                                                            <option value="SR">Suriname</option>
                                                            <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                            <option value="SZ">Swaziland</option>
                                                            <option value="SE">Sweden</option>
                                                            <option value="CH">Switzerland</option>
                                                            <option value="SY">Syrian Arab Republic</option>
                                                            <option value="TW">Taiwan, Province of China</option>
                                                            <option value="TJ">Tajikistan</option>
                                                            <option value="TZ">Tanzania, United Republic of</option>
                                                            <option value="TH">Thailand</option>
                                                            <option value="TG">Togo</option>
                                                            <option value="TK">Tokelau</option>
                                                            <option value="TO">Tonga</option>
                                                            <option value="TT">Trinidad and Tobago</option>
                                                            <option value="TN">Tunisia</option>
                                                            <option value="TR">Turkey</option>
                                                            <option value="TM">Turkmenistan</option>
                                                            <option value="TC">Turks and Caicos Islands</option>
                                                            <option value="TV">Tuvalu</option>
                                                            <option value="UG">Uganda</option>
                                                            <option value="UA">Ukraine</option>
                                                            <option value="AE">United Arab Emirates</option>
                                                            <option value="GB">United Kingdom</option>
                                                            <option value="US">United States</option>
                                                            <option value="UM">United States Minor Outlying Islands</option>
                                                            <option value="UY">Uruguay</option>
                                                            <option value="UZ">Uzbekistan</option>
                                                            <option value="VU">Vanuatu</option>
                                                            <option value="VE">Venezuela</option>
                                                            <option value="VN">Viet Nam</option>
                                                            <option value="VG">Virgin Islands (British)</option>
                                                            <option value="VI">Virgin Islands (U.S.)</option>
                                                            <option value="WF">Wallis and Futuna Islands</option>
                                                            <option value="EH">Western Sahara</option>
                                                            <option value="YE">Yemen</option>
                                                            <option value="ZM">Zambia</option>
                                                            <option value="ZW">Zimbabwe</option>
                                                    </select></td>     
                                                </tr>
                              
                                                <tr>
          
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.email')}}</label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge" position="13" maxlength="50" name="email" id="maxlength_defaultconfig"></td>     
                                                </tr>
                            
                                                <tr>                                      
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.about')}}</label></td>
                                                  <td class="col-md-2"><textarea name="about" position="14" class="ckeditor"></textarea></td>     
                                                </tr> 
                                
                                                <tr>
                                                  <td class="col-xs-1"><label class="control-label">{{trans('menu.active')}}</label></td>
                                                  <td class="col-md-2"><input type="checkbox" name="active" position="15" class="form-control make-switch" checked data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>"> </td>     
                                                </tr> 
                                
                                                <tr>
                                                  <td class="col-xs-1"><label class="control-label">{{trans('user.manage')}}</label></td>
                                                  <td class="col-md-2">
                                                  <select class="form-control input-medium select2me" name="manage" id="manage" position="16" data-placeholder="{{trans('global.all')}}">
                                                        <option value="0">{{trans('global.all')}}</option>
                                                        <option value="1">{{trans('global.admin')}}</option>
                                                        <option value="2">{{trans('global.manage')}}</option>
                                                        <option value="3">{{trans('global.frontend')}}</option>
                                                </select>     
                                                  </td>     
                                                </tr>
                                                 <tr class="hidden">          
                                                  <td class="col-xs-1"><label class="control-label"></label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge hidden" position="17" maxlength="50" name="created_at" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                                <tr class="hidden">          
                                                  <td class="col-xs-1"><label class="control-label"></label></td>
                                                  <td class="col-md-2"><input type="text" class="form-control input-xlarge hidden" position="18" maxlength="50" name="updated_at" id="maxlength_defaultconfig"></td>     
                                                </tr>
                                            </table>	          
                            </div> 
                            <div class="modal-footer" style=" background-color: #fff;">
                                    <a class="btn default green-stripe save tooltips" data-original-title="Ctrl+S" data-placement="top" data-container="body"><i class="fa fa-save" ></i> {{Lang::get('global.save')}} </a>
                                    <a class="btn default purple-stripe cancel tooltips" data-original-title="Ctrl+C" data-placement="top" data-container="body"><i class="fa fa-ban " ></i> {{Lang::get('global.cancel')}} </a>
                             </div>
                         </div>
                    </div>                   
                </div>
    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">{{trans('global.import')}}</h4>
                                    </div>
                                    <div class="modal-body">                                       
                                            <div class="form-group">
                                                 <form class="import" enctype="multipart/form-data" role="form" method="post">
                                                    <label class="control-label col-md-4">{{trans('global.file')}}</label>
                                                    <div class="col-md-5">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="input-group input-large">
                                                                            <div class="form-control uneditable-input" data-trigger="fileinput">
                                                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
                                                                                    </span>
                                                                            </div>
                                                                            <span class="input-group-addon btn default btn-file">
                                                                            <span class="fileinput-new">
                                                                            {{trans('global.choose')}} </span>
                                                                            <span class="fileinput-exists">
                                                                            {{trans('global.change')}} </span>
                                                                            <input id="file" type="file" name="file">
                                                                            </span>
                                                                            <a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                                                            {{trans('global.cancel')}}</a>
                                                                    </div>                                                                 
                                                            </div>                                                        
                                                    </div>
                                                 </form>
                                            </div>                                        
                                        <div class="tr-space"></div>
                                        <div class="tr-space"></div>
                                            <div class="form-group">
                                                    <label class="control-label col-md-4">{{trans('global.template')}}</label>
                                                    <div class="col-md-5">
                                                        <a class="btn default" href="{{url(session()->get('locale').'/'.session()->get('manage').'/export/user')}}" >{{trans('global.download')}}</a>
                                                    </div>
                                            </div>
                                        <div class="tr-space"></div>
                                        <div class="tr-space"></div>
                                    </div>
                                    <div class="modal-footer">
                                            <div id="progress"></div>
                                            <a type="button" class="btn blue saveimport">{{trans('global.start')}}</a>
                                            <a type="button" class="btn default" data-dismiss="modal">{{trans('global.close')}}</a>
                                    </div>
                            </div>
                            <!-- /.modal-content -->
                    </div>
       </div>
</div>                
                  <div class="portlet light bordered">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-tag font-purple"></i>
                                        <span class="caption-subject font-purple bold uppercase">{{trans('menu.user')}}</span>
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn default blue-stripe add tooltips" data-original-title="Ctrl+Alt+A" data-placement="top" data-container="body"><i class="fa fa-plus"></i> {{trans('global.add')}} </a>
                                        <a class="btn default yellow-stripe copy tooltips" data-original-title="Ctrl+Alt+X" data-placement="top" data-container="body"><i class="fa fa-copy"></i> {{trans('global.copy')}} </a>
                                        <a class="btn default red-stripe edit tooltips" data-original-title="Ctrl+Alt+E" data-placement="top" data-container="body"><i class="fa fa-edit" ></i> {{trans('global.edit')}} </a>
                                        <a class="btn default dark-stripe delete tooltips" data-original-title="Ctrl+Alt+D" data-placement="top" data-container="body"> <i class="fa fa-times"></i> {{trans('global.delete')}} </a>  
                                         <a class="btn default blue-stripe import tooltips" data-original-title="Ctrl+Alt+I" data-placement="top" data-container="body"> <i class="fa fa-database"></i> {{trans('global.import')}} </a>                                         
                                         <div class="btn-group">
                                        <a class="btn purple" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-cogs"></i> {{trans('global.tools')}} 
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu" id="datatable_ajax_tools">
                                           <li>
                                                    <a href="javascript:;" data-action="0" class="tool-action">
                                                        <i class="icon-printer"></i> {{trans('global.print')}} </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="1" class="tool-action">
                                                        <i class="icon-check"></i> {{trans('global.copy')}} </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="2" class="tool-action">
                                                        <i class="icon-doc"></i> {{trans('global.export_pdf')}} </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="3" class="tool-action">
                                                        <i class="icon-paper-clip"></i> {{trans('global.export_excel')}}</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="4" class="tool-action">
                                                        <i class="icon-cloud-upload"></i> {{trans('global.export_csv')}}</a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="javascript:;" data-action="5" class="tool-action">
                                                        <i class="icon-refresh"></i> {{trans('global.view')}}</a>
                                                </li>
                                                </li>
                                        </ul>
                                        </div>                                       
                                      </div>
                                </div>
                                <div class="portlet-body">                                   
                                    <div class="row">
                                    <div class="col-md-12">
                                            <div class="portlet">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class='icon-pin'></i>{{trans('global.list')}}                                                             
                                                    </div>                                                    
                                                    <div class="tools">
                                                        <a href="javascript:;" class="collapse"></a>
                                                        <a href="javascript:;" class="reload"></a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body col-md-12">                                                        
                                                        <table class="table table-striped table-bordered table-hover order-column context-menu" style="border:none" id="grid">
                                                            <thead>
                                                                <tr>
                                                                <th>{{trans('user.no')}}</th>
                                                                <th>{{trans('user.username')}}</th>  
                                                                <th>{{trans('user.password')}}</th>     
                                                                <th>{{trans('user.fullname')}}</th>
                                                                <th>{{trans('user.firstname')}}</th>
                                                                <th>{{trans('user.lastname')}}</th>
                                                                <th>{{trans('user.identity_card')}}</th>
                                                                <th>{{trans('user.birthday')}}</th>
                                                                <th>{{trans('user.mobile')}}</th> 
                                                                <th>{{trans('user.address')}}</th>                                                                                                                                                                                     
                                                                <th>{{trans('user.city')}}</th>
                                                                <th>{{trans('user.jobs')}}</th>
                                                                <th>{{trans('user.country')}}</th>
                                                                <th>{{trans('user.email')}}</th> 
                                                                <th>{{trans('user.about')}}</th>
                                                                <th>{{trans('menu.active')}}</th>
                                                                <th>{{trans('user.manage')}}</th>
                                                                <th>{{trans('user.created_at')}}</th>
                                                                <th>{{trans('user.updated_at')}}</th>
                                                                </tr>
                                                            </thead> 
                                                            <tbody>                                                                                                                            
                                                            </tbody>
                                                       </table>                                                     
                                                </div>
                                            </div>                                        
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                    </div>
                  
                    
            </div>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        @stop           
        @section('extra_javascript')          
         <script>
        jQuery(document).ready(function() {   
           EposAdminModal.permission = <?= json_encode(session()->get('permission'));?>;    
           EposAdminModal.data= <?= json_encode($data->toArray());?>;
           EposAdminModal.url = <?= json_encode(['save_url'=>'add/user','delete_url'=>'update/user','import_url'=>'import/user']);?>;
        });   
        </script>
               
        <script src="{{ url('public/addon/admin/scripts/epos-admin-modal.js')}}"></script>
         <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('public/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>

        <script src="{{url('public/global/scripts/datatable.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
        <script src="{{url('public/global/plugins/datatables/plugins/bootstrap/page.jumpToData().js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/shortcuts.js')}}" type="text/javascript"></script>

        <script src="{{ url('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>     
        <script src="{{ url('public/global/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/bootstrap-contextmenu/bootstrap-contextmenu.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/pages/scripts/components-date-time-pickers.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->       
          @stop      