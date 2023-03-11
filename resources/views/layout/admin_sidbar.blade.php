    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <!--<li class=" nav-item"><a href="#"><i class="la la-bolt"></i><span class="menu-title" data-i18n="nav.flot_charts.main">الرئيسية</span></a>-->
        <!--  <ul class="menu-content">            -->
        <!--    <li  class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"> -->
        <!--        <a class="menu-item" href="{{url('admin/dashboard')}}" data-i18n="nav.flot_charts.flot_pie_charts">الرئيسية</a>-->
        <!--    </li>-->
        <!--  </ul>-->
        <!--</li>-->
        <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{url('admin/dashboard')}}"><i class="la la-envelope"></i><span class="menu-title" data-i18n="">الرئيسية</span></a>
        </li>
        <li class="nav-item {{ Request::is('admin/readers') ? 'active' : '' }}">
            <a href="{{url('admin/readers')}}"><i class="la la-envelope"></i><span class="menu-title" data-i18n="">القراء</span></a>
        </li>
        <!--<li class=" nav-item"><a href="#"><i class="la la-bolt"></i><span class="menu-title" data-i18n="nav.flot_charts.main">الإعدادات</span></a>-->
        <!--  <ul class="menu-content">-->
        <!--    <li  class="{{ Request::is('admin/settings') ? 'active' : '' }}"> -->
        <!--        <a class="menu-item" href="{{ url('admin/settings') }}" data-i18n="nav.flot_charts.flot_line_charts">الاعدادات</a>-->
        <!--    </li>-->
           
        <!--    <li  class="{{ Request::is('admin/privacy') ? 'active' : '' }}"> -->
        <!--        <a class="menu-item" href="{{url('admin/privacy')}}" data-i18n="nav.flot_charts.flot_bar_charts">سياسية الخصوصية</a>-->
        <!--    </li>-->
        <!--    <li  class="{{ Request::is('admin/contact') ? 'active' : '' }}"> -->
        <!--        <a class="menu-item" href="{{url('admin/contact')}}" data-i18n="nav.flot_charts.flot_pie_charts">معلومات التواصل</a>-->
        <!--    </li>-->
        <!--    <li  class="{{ Request::is('admin/terms') ? 'active' : '' }}"> -->
        <!--        <a class="menu-item" href="{{url('admin/terms')}}" data-i18n="nav.flot_charts.flot_pie_charts">الشروط والتعليمات</a>-->
        <!--    </li>-->
           
        <!--  </ul>-->
        <!--</li>-->
        
        
        <!--<li class="nav-item {{ Request::is('admin/cities') ? 'active' : '' }}">-->
        <!--    <a href="{{url('admin/cities')}}"><i class="la la-envelope"></i><span class="menu-title" data-i18n="">المدينة</span></a>-->
        <!--</li>-->

        <!--<li class="nav-item {{ Request::is('admin/countries') ? 'active' : '' }}">-->
        <!--    <a href="{{url('admin/countries')}}"><i class="la la-envelope"></i><span class="menu-title" data-i18n="">الدولة</span></a>-->
        <!--</li>-->

        <li class="nav-item {{ Request::is('admin/profile') ? 'active' : '' }}">
            <a href="{{url('admin/profile')}}"><i class="la la-envelope"></i><span class="menu-title" data-i18n="">حسابي</span></a>
        </li>
        
        <!-- <li class="nav-item {{ Request::is('admin/users') ? 'active' : '' }}">-->
        <!--    <a href="{{url('admin/users')}}">-->
        <!--        <i class="la la-envelope"></i><span class="menu-title" data-i18n="">المستخدمين</span>-->
        <!--    </a>-->
        <!--</li>-->
        

      </ul>
    </div>
  </div>