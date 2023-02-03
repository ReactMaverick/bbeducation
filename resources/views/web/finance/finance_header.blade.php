<div class="finance-topbar-Section">
    <div class="finance-topbar">
        <div class="topbar-finance-list-page @if ($title['pageTitle'] == 'Finance Timesheets') topbar-active @endif">
            <a href="{{ URL::to('/finance-timesheets') }}">
                <i class="fa-solid fa-address-book">
                    <span class="finance-topbar-text">Timesheets</span>
                </i>
            </a>
        </div>

        <div class="topbar-finance-list-page @if ($title['pageTitle'] == 'Finance Invoices') topbar-active @endif">
            <a href="{{ URL::to('/finance-invoices') }}">
                <i class="fa-solid fa-money-bills">
                    <span class="finance-topbar-text">Invoices</span>
                </i>
            </a>
        </div>

        <div class="topbar-finance-list-page @if ($title['pageTitle'] == 'Finance Payroll') topbar-active @endif">
            <a href="{{ URL::to('/finance-payroll') }}">
                <i class="fa-solid fa-user">
                    <span class="finance-topbar-text">Payroll</span>
                </i>
            </a>
        </div>

        <div class="topbar-finance-list-page @if ($title['pageTitle'] == 'Finance Remittance') topbar-active @endif">
            <a href="{{ URL::to('/finance-remittance?include=&method=') }}">
                <i class="fa-solid fa-piggy-bank">
                    <span class="finance-topbar-text">Remittance</span>
                </i>
            </a>
        </div>
    </div>

    <div class="bills-icon-section">
        <img src="{{ asset('web/company_logo/money.png') }}" alt="">
    </div>
</div>
