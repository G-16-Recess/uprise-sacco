<div class="sidebar" data-color="white" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo w-100 bg-white">
            <center>
                <img class="img-fluid" src="{{ asset('light-bootstrap/img/logo/logo-no-background.png') }}" style="width: 50%">
            </center>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>
           
            <li class="nav-item @if($activePage == 'member') active @endif">
                <a class="nav-link" href="{{route('page.index', 'member')}}">
                <i class="nc-icon nc-single-02"></i>
                    <p>{{ __("Members") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'deposit') active @endif">
                <a class="nav-link" href="{{route('page.index', 'deposit')}}">
                    <i class="nc-icon nc-money-coins"></i>
                    <p>{{ __("Deposits") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'request') active @endif">
                <a class="nav-link" href="{{route('page.index', 'request')}}">
                <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Requests") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'request') active @endif">
                <a class="nav-link" href="{{route('page.index', 'request')}}">
                <i class="nc-icon nc-single-copy-04"></i>
                    <p>{{ __("Loan applications") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'request') active @endif">
                <a class="nav-link" href="{{route('page.index', 'request')}}">
                <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Loans") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'request') active @endif">
                <a class="nav-link" href="{{route('page.index', 'request')}}">
                <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Loan repayments") }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
