<!--Header START-->
<div class="app-header header-shadow" style="background-color: rgb(147, 200, 243);">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Ketik untuk mencari">
                    <button class="search-icon"><span></span></button>
                </div>
                <button class="close"></button>
            </div>
            <ul class="header-megamenu nav">
                <li class="btn-group nav-item">
                    <a class="nav-link" data-toggle="dropdown" aria-expanded="false">
                        <span class="badge badge-pill badge-danger ml-0 mr-2">4</span> Pengaturan
                        <i class="fa fa-angle-down ml-2 opacity-5"></i>
                    </a>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-secondary">
                                <div class="menu-header-image opacity-5"
                                    style="background-image: url('../assets/images/dropdown-header/abstract2.jpg');">
                                </div>
                                <div class="menu-header-content">
                                    <h5 class="menu-header-title">Pengaturan</h5>
                                </div>
                            </div>
                        </div>
                        <div class="scroll-area-xs">
                            <div class="scrollbar-container">
                                <h6 tabindex="-1" class="dropdown-header">Menu Pengaturan</h6>
                                <button type="button" tabindex="0" class="dropdown-item">Tampilan</button>
                                <button type="button" tabindex="0" class="dropdown-item">Pertanyaan</button>
                                <button type="button" tabindex="0" class="dropdown-item">Akun</button>
                                <div tabindex="-1" class="dropdown-divider"></div>
                                <button type="button" tabindex="0" class="dropdown-item">Products</button>
                                <button type="button" tabindex="0" class="dropdown-item">Rollup Queries</button>
                            </div>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item-divider nav-item"></li>
                            <li class="nav-item-btn nav-item">
                                <button class="btn-wide btn-shadow btn btn-danger btn-sm">Cancel</button>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-dots">
                <div class="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
                        class="p-0 mr-2 btn btn-link">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-danger"></span>
                            <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                            <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header mb-0">
                            <div class="dropdown-menu-header-inner bg-deep-blue">
                                <div class="menu-header-image opacity-1"
                                    style="background-image: url('../assets/images/dropdown-header/city3.jpg');"></div>
                                <div class="menu-header-content text-dark">
                                    <h5 class="menu-header-title">Notifikasi</h5>
                                    <h6 class="menu-header-subtitle">Kamu memiliki <b>5</b> pesan baru</h6>
                                </div>
                            </div>
                        </div>
                        <ul class="tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered p-3">
                            <li class="nav-item">
                                <a role="tab" class="nav-link active" data-toggle="tab" href="#tab-messages-header">
                                    <span>Pesan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" data-toggle="tab" href="#tab-events-header">
                                    <span>Lomba</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" data-toggle="tab" href="#tab-errors-header">
                                    <span>Verifikasi</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="p-3">
                                            <div class="notifications-box">
                                                <div
                                                    class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                    <div
                                                        class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                        <div><span
                                                                class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">Verifikasi Lomba Menolong Denis</h4><span
                                                                    class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-events-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="p-3">
                                            <div
                                                class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-success">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">All Hands Meeting</h4>
                                                            <p>Lorem ipsum dolor sic amet, today at <a
                                                                    href="javascript:void(0);">12:00 PM</a></p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-warning">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <p>Another meeting today, at <b class="text-danger">12:00
                                                                    PM</b></p>
                                                            <p>Yet another one, at <span class="text-success">15:00
                                                                    PM</span></p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-danger">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">Build the production release</h4>
                                                            <p>Lorem ipsum dolor sit amit,consectetur eiusmdd tempor
                                                                incididunt ut labore et dolore magna elit enim at minim
                                                                veniam quis nostrud</p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-primary">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title text-success">Something not
                                                                important</h4>
                                                            <p>Lorem ipsum dolor sit amit,consectetur elit enim at minim
                                                                veniam quis nostrud</p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-success">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">All Hands Meeting</h4>
                                                            <p>Lorem ipsum dolor sic amet, today at <a
                                                                    href="javascript:void(0);">12:00 PM</a></p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-warning">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <p>Another meeting today, at <b class="text-danger">12:00
                                                                    PM</b></p>
                                                            <p>Yet another one, at <span class="text-success">15:00
                                                                    PM</span></p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-danger">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">Build the production release</h4>
                                                            <p>Lorem ipsum dolor sit amit,consectetur eiusmdd tempor
                                                                incididunt ut labore et dolore magna elit enim at minim
                                                                veniam quis nostrud</p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"><i
                                                                class="badge badge-dot badge-dot-xl badge-primary">
                                                            </i></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title text-success">Something not
                                                                important</h4>
                                                            <p>Lorem ipsum dolor sit amit,consectetur elit enim at minim
                                                                veniam quis nostrud</p><span
                                                                class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-errors-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="no-results pt-3 pb-0">
                                            <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                                <div class="swal2-success-circular-line-left"
                                                    style="background-color: rgb(255, 255, 255);"></div>
                                                <span class="swal2-success-line-tip"></span>
                                                <span class="swal2-success-line-long"></span>
                                                <div class="swal2-success-ring"></div>
                                                <div class="swal2-success-fix"
                                                    style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="swal2-success-circular-line-right"
                                                    style="background-color: rgb(255, 255, 255);"></div>
                                            </div>
                                            <div class="results-subtitle">All caught up!</div>
                                            <div class="results-title">There are no system errors!</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="../assets/images/misel.png" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-info">
                                            <div class="menu-header-image opacity-2"
                                                style="background-image: url('../assets/images/dropdown-header/city3.jpg');">
                                            </div>
                                            <div class="menu-header-content text-left">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <img width="42" class="rounded-circle"
                                                                src="../assets/images/misel.png" alt="">
                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">Michelle Dorani
                                                            </div>
                                                            <div class="widget-subheading opacity-8">TI-2B
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-right mr-2">
                                                            <button
                                                                class="btn-pill btn-shadow btn-shine btn btn-focus">Logout
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll-area-xs" style="height: 150px;">
                                        <div class="scrollbar-container ps">
                                            <ul class="nav flex-column">
                                                <li class="nav-item-header nav-item">Aktivitas
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Pesan
                                                        <div class="ml-auto badge badge-pill badge-info">1
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Lupa Password?
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                Michelle Dorani
                            </div>
                            <div class="widget-subheading">
                                Admin
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Header END-->