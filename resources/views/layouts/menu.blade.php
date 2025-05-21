<!-- Dashboards -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
                
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item active">
                  <a href="{{ url('/') }}" target="_blank" class="menu-link">
                    <div data-i18n="Visit Site">Visit Site</div>
                  </a>
                </li>
              </ul>
            </li>
            <!-- Activity Logs -->
            <li class="menu-item {{ $activePage == 'activitylogs' ? ' active' : '' }}">
              <a href="{{ route('activity_logs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-activity"></i>
                <div data-i18n="Activity Logs">Activity Logs</div>
              </a>
            </li>

            <!-- Roles -->
            <li class="menu-item {{ $activePage == 'roles' || $activePage == 'roles.create' || $activePage == 'roles.edit' || $activePage == 'roles.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-user-cog"></i>
                <div data-i18n="Roles">Roles</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'roles' ? ' active' : '' }}">
                  <a href="{{ route('roles.index') }}" class="menu-link">
                    <div data-i18n="Roles List">Roles List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'roles.create' ? ' active' : '' }}">
                  <a href="{{ route('roles.create') }}" class="menu-link">
                    <div data-i18n="Add Role">Add Role</div>
                  </a>
                </li>
                
              </ul>
            </li>

             <!-- Admin User -->
            <li class="menu-item {{ $activePage == 'accounts' || $activePage == 'accounts.create' || $activePage == 'accounts.edit' || $activePage == 'accounts.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users-group"></i>
                <div data-i18n="Users">Users</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'accounts' ? ' active' : '' }}">
                  <a href="{{ route('accounts.index') }}" class="menu-link">
                    <div data-i18n="Users List">Users List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'accounts.create' ? ' active' : '' }}">
                  <a href="{{ route('accounts.create') }}" class="menu-link">
                    <div data-i18n="Add User">Add User</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <li class="menu-item {{ $activePage == 'pages' || $activePage == 'pages.create' || $activePage == 'pages.edit' || $activePage == 'pages.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-page-break"></i>
                <div data-i18n="Pages">Pages</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'pages' ? ' active' : '' }}">
                  <a href="{{ route('pages.index') }}" class="menu-link">
                    <div data-i18n="Pages List">Pages List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'pages.create' ? ' active' : '' }}">
                  <a href="{{ route('pages.create') }}" class="menu-link">
                    <div data-i18n="Add Page">Add Page</div>
                  </a>
                </li>
                
              </ul>
            </li>
            
            <!-- Layouts -->
            <li class="menu-item {{ $activePage == 'posts' || $activePage == 'posts.create' || $activePage == 'posts.edit' || $activePage == 'posts.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-article"></i>
                <div data-i18n="Posts">Posts</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'posts' ? ' active' : '' }}">
                  <a href="{{ route('posts.index') }}" class="menu-link">
                    <div data-i18n="Posts List">Posts List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'posts.create' ? ' active' : '' }}">
                  <a href="{{ route('posts.create') }}" class="menu-link">
                    <div data-i18n="Add Post">Add Post</div>
                  </a>
                </li>
                
              </ul>
            </li>

             <li class="menu-item {{ $activePage == 'post_categories' || $activePage == 'post_categories.create' || $activePage == 'post_categories.edit' || $activePage == 'post_categories.show' ? ' active' : '' }}">
              <a href="{{ route('post_categories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-category"></i>
                <div data-i18n="Post Categories">Post Categories</div>
              </a>
            </li>

            <li class="menu-item {{ $activePage == 'services' || $activePage == 'services.create' || $activePage == 'services.edit' || $activePage == 'services.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-section"></i>
                <div data-i18n="Services">Services</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'services' ? ' active' : '' }}">
                  <a href="{{ route('services.index') }}" class="menu-link">
                    <div data-i18n="Services List">Services List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'services.create' ? ' active' : '' }}">
                  <a href="{{ route('services.create') }}" class="menu-link">
                    <div data-i18n="Add Service">Add Service</div>
                  </a>
                </li>

              </ul>
            </li>
            
            <li class="menu-item {{ $activePage == 'faqs' || $activePage == 'faqs.create' || $activePage == 'faqs.edit' || $activePage == 'faqs.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-help"></i>
                <div data-i18n="FAQs">FAQs</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'faqs' ? ' active' : '' }}">
                  <a href="{{ route('faqs.index') }}" class="menu-link">
                    <div data-i18n="FAQs List">FAQs List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'faqs.create' ? ' active' : '' }}">
                  <a href="{{ route('faqs.create') }}" class="menu-link">
                    <div data-i18n="Add FAQ">Add FAQ</div>
                  </a>
                </li>

              </ul>
            </li>

            <!-- Project -->
            <li class="menu-item {{ $activePage == 'projects' || $activePage == 'projects.create' || $activePage == 'projects.edit' || $activePage == 'projects.show' || $activePage == 'project_categories' || $activePage == 'project_categories.create' || $activePage == 'project_categories.edit' || $activePage == 'project_categories.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-brand-4chan"></i>
                <div data-i18n="Projects">Projects</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'projects' ? ' active' : '' }}">
                  <a href="{{ route('projects.index') }}" class="menu-link">
                    <div data-i18n="Projects List">Projects List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'projects.create' ? ' active' : '' }}">
                  <a href="{{ route('projects.create') }}" class="menu-link">
                    <div data-i18n="Add Project">Add Project</div>
                  </a>
                </li>
                 <li class="menu-item {{ $activePage == 'project_categories' ? ' active' : '' }}">
                  <a href="{{ route('project_categories.index') }}" class="menu-link">
                    <div data-i18n="Projects Categories">Categories</div>
                  </a>
                </li>
              </ul>
            </li> 

            <!-- Slider -->
            <li class="menu-item {{ $activePage == 'sliders' || $activePage == 'sliders.create' || $activePage == 'sliders.edit' || $activePage == 'sliders.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-slideshow"></i>
                <div data-i18n="Sliders">Sliders</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'sliders' ? ' active' : '' }}">
                  <a href="{{ route('sliders.index') }}" class="menu-link">
                    <div data-i18n="Sliders List">Sliders List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'sliders.create' ? ' active' : '' }}">
                  <a href="{{ route('sliders.create') }}" class="menu-link">
                    <div data-i18n="Add Slider">Add Slider</div>
                  </a>
                </li>
              </ul>
            </li> 


            <!-- Partner -->
            <li class="menu-item {{ $activePage == 'partners' || $activePage == 'partners.create' || $activePage == 'partners.edit' || $activePage == 'partners.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users-plus"></i>
                <div data-i18n="Partners">Partners</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'partners' ? ' active' : '' }}">
                  <a href="{{ route('partners.index') }}" class="menu-link">
                    <div data-i18n="Partners List">Partners List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'partners.create' ? ' active' : '' }}">
                  <a href="{{ route('partners.create') }}" class="menu-link">
                    <div data-i18n="Add Partner">Add Partner</div>
                  </a>
                </li>
              </ul>
            </li> 

            <li class="menu-item {{ $activePage == 'clients' || $activePage == 'clients.create' || $activePage == 'clients.edit' || $activePage == 'clients.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users-plus"></i>
                <div data-i18n="Clients">Clients</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'clients' ? ' active' : '' }}">
                  <a href="{{ route('clients.index') }}" class="menu-link">
                    <div data-i18n="Clients List">Clients List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'clients.create' ? ' active' : '' }}">
                  <a href="{{ route('clients.create') }}" class="menu-link">
                    <div data-i18n="Add Client">Add Client</div>
                  </a>
                </li>
              </ul>
            </li> 

            <li class="menu-item {{ $activePage == 'subscribers' || $activePage == 'subscribers.create' || $activePage == 'subscribers.edit' || $activePage == 'subscribers.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-user-heart"></i>
                <div data-i18n="Subscribers">Subscribers</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'accounts' ? ' active' : '' }}">
                  <a href="{{ route('subscribers.index') }}" class="menu-link">
                    <div data-i18n="Subscribers List">Subscribers List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'accounts.create' ? ' active' : '' }}">
                  <a href="{{ route('subscribers.create') }}" class="menu-link">
                    <div data-i18n="Add Subscriber">Add Subscribers</div>
                  </a>
                </li>
                
              </ul>
            </li>
            
            <li class="menu-item {{ $activePage == 'inbox' || $activePage == 'inbox.edit' || $activePage == 'inbox.show' ? ' active' : '' }}">
              <a href="{{ route('contacts.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div data-i18n="Inbox">Email</div>
              </a>
            </li>

          {{-- Settings --}}
            <li class="menu-item {{ $activePage == 'setting' ? ' active' : '' }}">
              <a href="{{ route('config_settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Config Settings">Config Settings</div>
              </a>
            </li>

            <li class="menu-item {{ $activePage == 'seo' || $activePage == 'seo.create' || $activePage == 'seo.edit' || $activePage == 'seo.show' ? ' active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-user-heart"></i>
                <div data-i18n="SEO">SEO</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'seo' ? ' active' : '' }}">
                  <a href="{{ route('seo.index') }}" class="menu-link">
                    <div data-i18n="SEO List">SEO List</div>
                  </a>
                </li>
                <li class="menu-item {{ $activePage == 'seo.create' ? ' active' : '' }}">
                  <a href="{{ route('seo.create') }}" class="menu-link">
                    <div data-i18n="Add SEO">Add SEO</div>
                  </a>
                </li>
                
              </ul>
            </li>
            

            
            

            

            