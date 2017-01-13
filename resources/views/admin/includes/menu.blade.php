                  {{'',$locale = session()->get('locale'),     
                  $manage = session()->get('manage'),
                  $type = $manage === 'admin' ? '0' : '1',   
                  $menu_admin = $menu->where('type',$type),
                  $prefix = $locale.'/'.$manage,            
                  $menu_key = $menu_admin->filter(function($item) use ($locale) {return url($locale.'/'.$item->link) == url()->current();})->first()
                  }}
                  @if($type===0)
                  <li class="nav-item start">
                            <a href="{{url($locale.'/manage')}}">
                                <i class="icon-notebook"></i>
                                            <span class="title">{{trans('menu.manage')}}</span>
                                            <span class="selected"></span>
                        <!--                    <span class="arrow open"></span>-->
                            </a>
                  </li>
                  @endif
                    <li class="nav-item start">
                            <a href="{{url($locale)}}">
                                <i class="icon-screen-desktop"></i>
                                            <span class="title">{{trans('menu.frontend')}}</span>
                                            <span class="selected"></span>
                        <!--                    <span class="arrow open"></span>-->
                            </a>
                        </li>    
                    @foreach($menu_admin->where('parent_id',0) as $m)
                     @if($locale.'/'.$m->link === $prefix.'/index' && url($prefix.'/index') === url()->current() ||$locale.'/'.$m->link ===$prefix.'/index'&& url($prefix) === url()->current())
                        <li class="nav-item start active">
                            <a href="{{url($locale.'/'.$m->link)}}">
                                <i class="{{$m->icon}}"></i>
                                            <span class="title">{{trans('menu.'.$m->code)}}</span>
                                            <span class="selected"></span>
                        <!--                    <span class="arrow open"></span>-->
                            </a>
                        </li>
                     @elseif($locale.'/'.$m->link===$prefix.'/index'&& url($locale.'/'.$m->link) !== url()->current())
                    <li class="start">
                        <a href="{{url($locale.'/'.$m->link)}}">
                            <i class="{{$m->icon}}"></i>
                                        <span class="title">{{trans('menu.'.$m->code)}}</span>
                    <!--                    <span class="arrow"></span>-->
                        </a>
                    </li>   
                     @elseif($m->parent_id === 0)
                        <li class="heading">
                            <h3 class="uppercase">{{trans('menu.'.$m->code)}}</h3>
                        </li>                      
                      @endif                        
                     @foreach($menu_admin->where('parent_id',$m->id) as $m1)
                     @if(!$menu_key)
                     <li class="nav-item">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="{{$m1->icon}}"></i>
                                <span class="title">{{trans('menu.'.$m1->code)}}</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @foreach($menu_admin->where('parent_id',$m1->id) as $m2)
                                <li class="nav-item  ">
                                    <a href="{{url($locale.'/'.$m2->link)}}" class="nav-link ">
                                        <span class="title">{{trans('menu.'.$m2->code)}}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                     </li>                       
                     @elseif($m1->link ==''&& $menu_key->parent_id == $m1->id )
                     <li class="nav-item  active open">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="{{$m1->icon}}"></i>
                                <span class="title">{{trans('menu.'.$m1->code)}}</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @foreach($menu_admin->where('parent_id',$m1->id) as $m2)
                                @if(url($locale.'/'.$m2->link) === url()->current())
                                <li class="nav-item  active">
                                @else
                                <li class="nav-item">
                                @endif
                                    <a href="{{url($locale.'/'.$m2->link)}}" class="nav-link ">
                                        <span class="title">{{trans('menu.'.$m2->code)}}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                     </li>    
                     @elseif($m1->link !==''&&url($locale.'/'.$m1->link) === url()->current())
                     <li class="nav-item active">
                      <a href="{{url($locale.'/'.$m1->link)}}">
                        <i class="{{$m1->icon}}"></i>
                                    <span class="title">{{trans('menu.'.$m1->code)}}</span>
                                    <span class="selected"></span>
                    <!--                    <span class="arrow open"></span>-->
                        </a>
                    </li>
                     @elseif($m1->link !==''&&url($locale.'/'.$m1->link) !== url()->current())
                     <li class="nav-item">
                      <a href="{{url($locale.'/'.$m1->link)}}">
                        <i class="{{$m1->icon}}"></i>
                                    <span class="title">{{trans('menu.'.$m1->code)}}</span>
                                    <span class="selected"></span>
                    <!--                    <span class="arrow open"></span>-->
                        </a>
                    </li>
                    @elseif($m1->link ===''&& $menu_key->parent_id !== $m1->id)
                     <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="{{$m1->icon}}"></i>
                                <span class="title">{{trans('menu.'.$m1->code)}}</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @foreach($menu_admin->where('parent_id',$m1->id) as $m2)
                                <li class="nav-item  ">
                                    <a href="{{url($locale.'/'.$m2->link)}}" class="nav-link ">
                                        <span class="title">{{trans('menu.'.$m2->code)}}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                     </li>  
                     @endif
                     @endforeach
                     @endforeach   
                 </div>
              <!--    END SIDEBAR -->
            </div>
           <!--    END SIDEBAR -->
