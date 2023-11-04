@php
    $parent = $menu['childs'];
@endphp
@foreach ($menu['childs'] as $menu)
    @if($menu['menu'] == 1)
        <li class="m-menu__item {{count($menu['childs']) ? 'm-menu__item--submenu' : ''}}" aria-haspopup="true" {{ count($menu['childs']) ? 'm-menu-submenu-toggle=hover' : '' }}>
            <a href="{{ count($menu['childs']) ? 'javascript:;' : menu_urlFunction($menu) }}" class="m-menu__link {{ count($menu['childs']) ? 'm-menu__toggle' : '' }}">
                @if($menu['parent'] == -1)
                <i class="m-menu__link-icon {{$menu['icon']}}"></i>
                @endif
                @if($menu['parent'] != -1)
                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                    <span></span>
                </i>
                @endif
                <span class="m-menu__link-text">
                    {{$menu['title']}}
                </span>
                @if(count($menu['childs']))
                    <i class="m-menu__ver-arrow la la-angle-right"></i> 
                @endif
                
            </a>
            @if(count($menu['childs']))
            <div class="m-menu__submenu">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                        <span class="m-menu__link">
                            <span class="m-menu__item-here"></span>
                            <span class="m-menu__link-text">{{$menu['title']}}</span>
                        </span>
                    </li>
                    @include('partial.menu_partial')   
                </ul>
            </div>
            @endif
        </li>
        @endif
        @if($menu['menu'] == 0 && menu_sectionAllowed($parent, $loop->index, $loop->last))
        <li class="m-menu__section">
            <h4 class="m-menu__section-text">
                {{$menu['title']}}
            </h4>
            <i class="m-menu__section-icon flaticon-more-v2"></i>
        </li>
    @endif
@endforeach