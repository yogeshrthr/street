<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="../backend/images/faces/face10.jpg" alt="image" />
                    <span class="online-status online"></span> <!--change class online to offline or busy as needed-->
                </div>
                <div class="profile-name">
                    <p class="name">
                        Marina Michel
                    </p>
                    <p class="designation">
                        Super Admin
                    </p>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('Admin/dashboard') }}">
                <i class="icon-menu menu-icon"></i>
                <span class="menu-title">Dashboard</span>

            </a>
        </li>
        
        
        <li class="nav-item">
            <a class="nav-link" href="{{ route('Admin/banner-list') }}">
                <i class="icon-menu menu-icon"></i>
                <span class="menu-title">Banner Management</span>

            </a>
        </li>
        
         <li class="nav-item">
            <a class="nav-link" href="{{ route('Admin/user-list') }}">
                <i class="icon-box menu-icon"></i>
                <span class="menu-title">User Management</span>

            </a>
        </li>
        
        
         <li class="nav-item">
            <a class="nav-link" href="{{ route('Admin/testimonial-list') }}">
                <i class="icon-box menu-icon"></i>
                <span class="menu-title">Manage Testimonial</span>

            </a>
        </li>
        

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false"
                aria-controls="page-layouts">
                <i class="icon-handbag menu-icon"></i>
                <span class="menu-title">Categories & Subcategories</span>
            </a>
            <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link" href="{{ route('Admin/category-list') }}">Categories</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('Admin/subcategory-list') }}">Subcategories</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin-products') }}">
                <i class="icon-box menu-icon"></i>
                <span class="menu-title">Product Management</span>

            </a>
        </li>
        
        
         <li class="nav-item">
            <a class="nav-link" href="{{ route('Admin/order-list') }}">
                <i class="icon-box menu-icon"></i>
                <span class="menu-title">Order Management</span>

            </a>
        </li>
         <li class="nav-item">
            <a class="nav-link" href="{{ route('Admin/pincode-list') }}">
                <i class="icon-box menu-icon"></i>
                <span class="menu-title">Pincode Management</span>

            </a>
        </li>

        





    </ul>
</nav>
