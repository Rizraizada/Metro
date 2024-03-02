<section id="container">
     <header class="header fixed-top clearfix">
         <div class="brand">

            <a href="index.html" class="logo">
                <img src="Admin/images/ .png" alt="">
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>


        <div class="top-nav clearfix">
             <ul class="nav pull-right top-menu">
                <li>
                    <input type="text" class="form-control search" placeholder=" Search">
                </li>
                 <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="" src="images/avatar1_small.jpg">
                        <span class="username">Admin</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                        <li><a href="{{ route('login') }}"><i class="fa fa-key"></i> Log Out</a></li>
                    </ul>
                </li>

            </ul>
         </div>
    </header>
      <aside>
        <div id="sidebar" class="nav-collapse">
             <ul class="sidebar-menu" id="nav-accordion">
             <li>
                  <a class="active" href="{{ route('admin.accounts') }}">
                       <span>Dashboard</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.bankbook') }}">
                       <span>BankBook</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.company') }}">
                      <span>Company</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.project') }}">
                      <span>Projects</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.item') }}">
                       <span>Items</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.customer') }}">
                       <span>Customers</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.flatsell') }}">
                       <span>Flat Sell</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.addsell') }}">
                       <span>Expense Voucher</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('admin.voucher.index') }}">
                       <span>Voucher Generator</span>
                  </a>
              </li>
            </ul>

         </div>
    </aside>
