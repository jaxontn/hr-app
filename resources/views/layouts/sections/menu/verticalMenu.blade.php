<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <!-- Hide app brand if navbar-full -->
  <div class="app-brand demo">
      <a href="{{url('/')}}" class="app-brand-link">
          <span class="app-brand-logo demo me-1">
              @include('_partials.macros', ["height"=>20])
          </span>
          <span class="app-brand-text demo menu-text fw-semibold ms-2">{{config('variables.templateName')}}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
          <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
      </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
      @foreach ($menuData[0]->menu as $menu)
          {{-- menu headers --}}
          @if (isset($menu->menuHeader))
              @php
                  $visible = isset($menu->role) && in_array(auth()->user()->therole->permission, $menu->role);
              @endphp

              @if ($visible)
                  <li class="menu-header fw-medium mt-4">
                      <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                  </li>
              @endif
          @else
              {{-- main menu --}}
              @php
                  $visible = isset($menu->role) && in_array(auth()->user()->therole->permission, $menu->role);
              @endphp

              @if ($visible)
                    {{-- Check if the current route name contains $menu->slug --}}
                    @php
                    $str = app('Illuminate\Support\Str');
                    @endphp

                    <li class="menu-item
                          {{ (isset($menu->slug) && $str->contains($menu->slug, Route::currentRouteName())) ? 'active' : '' }}"
                    >

                      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                          @isset($menu->icon)
                              <i class="{{ $menu->icon }}"></i>
                          @endisset
                          <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                          @isset($menu->badge)
                              <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                          @endisset
                      </a>

                      {{-- submenu --}}
                      @isset($menu->submenu)
                          @php
                              $filteredSubmenu = array_filter($menu->submenu, function ($item) {
                                  return empty($item->role) || in_array(auth()->user()->therole->permission, $item->role);
                              });
                          @endphp

                          @if (!empty($filteredSubmenu))
                              @include('layouts.sections.menu.submenu',['menu' => $filteredSubmenu])
                          @endif
                      @endisset
                  </li>
              @endif
          @endif
      @endforeach
  </ul>
</aside>
