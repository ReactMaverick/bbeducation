<div class="topbar-Section new_top_bar">
    <div class="menu_item @if ($title['pageTitle'] == 'Finance Timesheets') topbar-active @endif">
        <a href="{{ URL::to('/finance-timesheets') }}">
            <i class="far fa-file-alt"></i>
            <span class="topbar-text">Timesheets</span>
        </a>
    </div>

    <div class="menu_item @if ($title['pageTitle'] == 'Finance Invoices') topbar-active @endif">
        <a href="{{ URL::to('/finance-invoices') }}">
            <i class="fas fa-file-invoice"></i>
            <span class="topbar-text">Invoices</span>
        </a>
    </div>

    <div class="menu_item @if ($title['pageTitle'] == 'Finance Payroll') topbar-active @endif">
        <a href="{{ URL::to('/finance-payroll') }}">
            <i class="fas fa-user"></i>
            <span class="topbar-text">Payroll</span>
        </a>
    </div>

    <div class="menu_item @if ($title['pageTitle'] == 'Finance Remittance') topbar-active @endif">
        <a href="{{ URL::to('/finance-remittance?include=&method=') }}">
            <i class="fas fa-piggy-bank"></i>
            <span class="topbar-text">Remittance</span>
        </a>
    </div>

    <div class="menu_item">
        <img src="{{ asset('web/company_logo/money.png') }}" alt="" style="width: 25px;">
    </div>
</div>
